import axios from 'axios';

const OJS_BASE_URL = 'http://localhost:8000';
const API_BASE = `${OJS_BASE_URL}/api/v1`;
const JOURNAL_PATH = 'tjpsd';

const api = axios.create({
  baseURL: `${OJS_BASE_URL}/${JOURNAL_PATH}`,
  headers: {
    'Content-Type': 'application/json',
  },
});

export async function fetchSubmissions() {
  try {
    const res = await api.get('/api/v1/submissions', {
      params: { count: 100, status: 3 },
    });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch submissions:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export async function fetchIssues() {
  try {
    const res = await api.get('/api/v1/issues', {
      params: { count: 100 },
    });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch issues:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export async function fetchStats() {
  try {
    const res = await api.get('/api/v1/stats/publications', {
      params: { count: 100 },
    });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch stats:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export async function fetchStatsTimeline(params = {}) {
  try {
    const res = await api.get('/api/v1/stats/publications/timeline', {
      params: {
        timelineInterval: 'month',
        ...params,
      },
    });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch stats timeline:', err.message);
    return [];
  }
}

export async function fetchContextStats() {
  try {
    const res = await api.get('/api/v1/stats/publications', {
      params: { count: 100, orderBy: 'views', orderDirection: 'DESC' },
    });
    return res.data;
  } catch (err) {
    console.warn('Failed to fetch context stats:', err.message);
    return { items: [], itemsMax: 0 };
  }
}

export { OJS_BASE_URL, JOURNAL_PATH };
