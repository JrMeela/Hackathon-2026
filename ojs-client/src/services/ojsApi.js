import axios from 'axios';

const OJS_BASE_URL = 'http://localhost:8000';
const API_SERVER = 'http://localhost:3001';
const JOURNAL_PATH = 'tjpsd';

const api = axios.create({
  baseURL: API_SERVER,
  headers: { 'Content-Type': 'application/json' },
});

export async function fetchDashboardStats() {
  try {
    const res = await api.get('/api/stats');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch dashboard stats:', err.message);
    return null;
  }
}

export async function fetchSubmissions() {
  try {
    const res = await api.get('/api/submissions', { params: { limit: 20 } });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch submissions:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export async function fetchIssues() {
  try {
    const res = await api.get('/api/issues');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch issues:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export async function fetchTimeline() {
  try {
    const res = await api.get('/api/metrics/timeline');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch timeline:', err.message);
    return { views: [], downloads: [] };
  }
}

export async function fetchCountries() {
  try {
    const res = await api.get('/api/metrics/countries');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch countries:', err.message);
    return [];
  }
}

export async function fetchTopArticles() {
  try {
    const res = await api.get('/api/top-articles');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch top articles:', err.message);
    return [];
  }
}

export async function fetchAuthors() {
  try {
    const res = await api.get('/api/authors');
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch authors:', err.message);
    return { total: 0 };
  }
}

export { OJS_BASE_URL, JOURNAL_PATH };
