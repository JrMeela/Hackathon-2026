/**
 * Link local TJPSD articles to real PDFs on the live site.
 * 
 * This script:
 * 1. Queries the local tjpsd32 DB for all articles with galleys
 * 2. Scrapes the live UDSM journals site to find matching articles by title
 * 3. Updates publication_galleys.remote_url to point to the real PDF on the live site
 * 
 * Run: node generate-pdfs.js
 */

import mysql from 'mysql2/promise';
import https from 'https';

const LIVE_BASE = 'https://journals.udsm.ac.tz/index.php/tjpsd';

// Live site issue IDs mapped to local volume/number/year
// Gathered from https://journals.udsm.ac.tz/index.php/tjpsd/issue/archive
const LIVE_ISSUE_MAP = [
  { vol: 32, num: '2', year: 2025, liveId: 796 },
  { vol: 32, num: '1', year: 2025, liveId: 795 },
  { vol: 31, num: '2', year: 2024, liveId: 664 },
  { vol: 31, num: '1', year: 2024, liveId: 793 },
  { vol: 30, num: '2', year: 2023, liveId: 794 },
  { vol: 30, num: '1', year: 2023, liveId: 766 },
  { vol: 29, num: '2', year: 2022, liveId: 792 },
  { vol: 29, num: '1', year: 2022, liveId: 563 },
  { vol: 28, num: '2', year: 2021, liveId: 550 },
  { vol: 28, num: '1', year: 2021, liveId: 519 },
  { vol: 27, num: '2', year: 2020, liveId: 517 },
  { vol: 27, num: '1', year: 2020, liveId: 480 },
  { vol: 26, num: '2', year: 2019, liveId: 479 },
  { vol: 26, num: '1', year: 2019, liveId: 444 },
  { vol: 25, num: '1-2', year: 2018, liveId: 421 },
  { vol: 24, num: '1-2', year: 2017, liveId: 400 },
  { vol: 23, num: '1-2', year: 2016, liveId: 399 },
  { vol: 22, num: '1-2', year: 2015, liveId: 214 },
  { vol: 21, num: '2', year: 2014, liveId: 213 },
  { vol: 21, num: '1', year: 2014, liveId: 212 },
  { vol: 20, num: '1-2', year: 2013, liveId: 210 },
  { vol: 19, num: '1-2', year: 2012, liveId: 208 },
  { vol: 18, num: '1-2', year: 2011, liveId: 206 },
  { vol: 17, num: '1-2', year: 2010, liveId: 204 },
  { vol: 16, num: '2', year: 2009, liveId: 203 },
  { vol: 16, num: '1', year: 2009, liveId: 202 },
  { vol: 15, num: '1-2', year: 2008, liveId: 200 },
  { vol: 14, num: '1-2', year: 2007, liveId: 198 },
];

function fetchPage(url) {
  return new Promise((resolve, reject) => {
    const req = https.get(url, { timeout: 15000 }, (res) => {
      if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
        return fetchPage(res.headers.location).then(resolve).catch(reject);
      }
      let data = '';
      res.on('data', (chunk) => (data += chunk));
      res.on('end', () => resolve(data));
    });
    req.on('error', reject);
    req.on('timeout', () => { req.destroy(); reject(new Error('Timeout')); });
  });
}

// Extract article links from an issue page
function extractArticleLinks(html) {
  const links = [];
  // Match article/view/ID links with their title text
  const regex = /<a[^>]*href="[^"]*\/article\/view\/(\d+)"[^>]*>\s*([\s\S]*?)\s*<\/a>/gi;
  let match;
  while ((match = regex.exec(html)) !== null) {
    const id = match[1];
    let title = match[2].replace(/<[^>]+>/g, '').trim();
    if (title.length > 5 && !links.find(l => l.id === id)) {
      links.push({ id, title });
    }
  }
  return links;
}

// Extract PDF galley URL from an article page
function extractPdfUrl(html, articleId) {
  // Look for galley PDF link: article/view/ID/galleyId
  const regex = new RegExp(`href="([^"]*\\/article\\/view\\/${articleId}\\/(\\d+))"`, 'i');
  const match = html.match(regex);
  if (match) return match[1];
  // Fallback: look for any PDF download link
  const pdfRegex = /href="([^"]*\/article\/download\/[^"]+)"/i;
  const pdfMatch = html.match(pdfRegex);
  if (pdfMatch) return pdfMatch[1];
  return null;
}

// Normalize title for fuzzy matching
function normalize(str) {
  return (str || '')
    .toLowerCase()
    .replace(/[^a-z0-9\s]/g, '')
    .replace(/\s+/g, ' ')
    .trim();
}

function similarity(a, b) {
  const na = normalize(a);
  const nb = normalize(b);
  if (na === nb) return 1;
  // Check if one contains the other
  if (na.includes(nb) || nb.includes(na)) return 0.9;
  // Word overlap
  const wordsA = new Set(na.split(' '));
  const wordsB = new Set(nb.split(' '));
  const intersection = [...wordsA].filter(w => wordsB.has(w));
  const union = new Set([...wordsA, ...wordsB]);
  return intersection.length / union.size;
}

function sleep(ms) {
  return new Promise(r => setTimeout(r, ms));
}

async function main() {
  console.log('Connecting to MySQL...');
  const pool = await mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'tjpsd32',
    port: 3306,
  });

  // Get local articles with galleys, linked to issues via publication_settings.issueId
  const [localArticles] = await pool.execute(`
    SELECT 
      pg.galley_id,
      pg.publication_id,
      pg.remote_url,
      p.submission_id,
      p.date_published,
      ps_title.setting_value AS title,
      i.volume,
      i.number AS issue_number,
      i.year
    FROM publication_galleys pg
    JOIN publications p ON p.publication_id = pg.publication_id
    LEFT JOIN publication_settings ps_title 
      ON ps_title.publication_id = p.publication_id 
      AND ps_title.setting_name = 'title' 
      AND ps_title.locale = 'en_US'
    LEFT JOIN publication_settings ps_issue
      ON ps_issue.publication_id = p.publication_id
      AND ps_issue.setting_name = 'issueId'
    LEFT JOIN issues i ON i.issue_id = CAST(ps_issue.setting_value AS UNSIGNED)
    JOIN submissions s ON s.submission_id = p.submission_id
    WHERE s.status = 3 AND pg.label = 'PDF'
    ORDER BY p.date_published DESC
  `);

  console.log(`Found ${localArticles.length} local galley entries.`);

  let updated = 0;
  let failed = 0;
  const processedIssues = new Set();

  // Cache of live issue articles: liveIssueId -> [{id, title, pdfUrl}]
  const liveArticleCache = {};

  for (const article of localArticles) {
    if (!article.title) {
      console.log(`  Skipping galley ${article.galley_id}: no title`);
      failed++;
      continue;
    }

    // Find the matching live issue using volume/number/year from the query
    let liveIssue = null;

    if (article.volume && article.year) {
      liveIssue = LIVE_ISSUE_MAP.find(li => {
        const volMatch = li.vol === article.volume;
        const yearMatch = li.year === article.year;
        const numNorm = (s) => (s || '').replace(/[&\s]/g, '-').toLowerCase();
        const numMatch = numNorm(li.num) === numNorm(article.issue_number);
        return volMatch && yearMatch && numMatch;
      });
      // If exact num didn't match, try just vol+year
      if (!liveIssue) {
        liveIssue = LIVE_ISSUE_MAP.find(li => li.vol === article.volume && li.year === article.year);
      }
    }

    if (!liveIssue) {
      // Try matching by year from date_published
      const pubYear = article.date_published ? new Date(article.date_published).getFullYear() : null;
      if (pubYear) {
        const candidates = LIVE_ISSUE_MAP.filter(li => li.year === pubYear);
        if (candidates.length === 1) liveIssue = candidates[0];
      }
    }

    if (!liveIssue) {
      console.log(`  No live issue match for galley ${article.galley_id}: "${article.title?.substring(0, 50)}..."`);
      failed++;
      continue;
    }

    // Fetch and cache live issue articles
    if (!liveArticleCache[liveIssue.liveId]) {
      console.log(`\nFetching live issue ${liveIssue.vol}.${liveIssue.num} (${liveIssue.year}) [ID: ${liveIssue.liveId}]...`);
      try {
        const issueHtml = await fetchPage(`${LIVE_BASE}/issue/view/${liveIssue.liveId}`);
        const liveLinks = extractArticleLinks(issueHtml);
        console.log(`  Found ${liveLinks.length} articles on live site`);

        // For each article, fetch its page to get the PDF URL
        const articlesWithPdf = [];
        for (const link of liveLinks) {
          await sleep(300); // Be polite
          try {
            const artHtml = await fetchPage(`${LIVE_BASE}/article/view/${link.id}`);
            const pdfUrl = extractPdfUrl(artHtml, link.id);
            articlesWithPdf.push({ ...link, pdfUrl });
            if (pdfUrl) {
              console.log(`    ✓ Article ${link.id}: PDF found`);
            } else {
              console.log(`    ✗ Article ${link.id}: no PDF link`);
            }
          } catch (err) {
            console.log(`    ✗ Article ${link.id}: fetch error - ${err.message}`);
            articlesWithPdf.push({ ...link, pdfUrl: null });
          }
        }

        liveArticleCache[liveIssue.liveId] = articlesWithPdf;
      } catch (err) {
        console.log(`  Error fetching issue: ${err.message}`);
        liveArticleCache[liveIssue.liveId] = [];
      }
      await sleep(500);
    }

    const liveArticles = liveArticleCache[liveIssue.liveId] || [];

    // Match by title similarity
    let bestMatch = null;
    let bestScore = 0;
    for (const la of liveArticles) {
      const score = similarity(article.title, la.title);
      if (score > bestScore) {
        bestScore = score;
        bestMatch = la;
      }
    }

    if (bestMatch && bestScore >= 0.5 && bestMatch.pdfUrl) {
      // Update the galley remote_url
      await pool.execute(
        `UPDATE publication_galleys SET remote_url = ? WHERE galley_id = ?`,
        [bestMatch.pdfUrl, article.galley_id]
      );
      updated++;
      console.log(`  ✓ Linked galley ${article.galley_id} -> ${bestMatch.pdfUrl}`);
    } else if (bestMatch && bestScore >= 0.5) {
      // Matched but no PDF — link to article view page instead
      const viewUrl = `${LIVE_BASE}/article/view/${bestMatch.id}`;
      await pool.execute(
        `UPDATE publication_galleys SET remote_url = ? WHERE galley_id = ?`,
        [viewUrl, article.galley_id]
      );
      updated++;
      console.log(`  ~ Linked galley ${article.galley_id} -> article page (no PDF): ${viewUrl}`);
    } else {
      console.log(`  ✗ No match for: "${article.title?.substring(0, 60)}..." (best score: ${bestScore.toFixed(2)})`);
      failed++;
    }
  }

  console.log(`\n========================================`);
  console.log(`Done! Updated: ${updated}, Failed: ${failed}`);
  console.log(`Total galleys processed: ${localArticles.length}`);

  await pool.end();
}

main().catch((err) => {
  console.error('Error:', err.message);
  process.exit(1);
});
