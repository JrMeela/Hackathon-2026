import { useEffect, useState } from 'react';
import { Activity } from 'lucide-react';

const FLAG_API = 'https://flagcdn.com/24x18';
const API_BASE = 'http://localhost:3001';

const LOCATION_POOL = [
  { country: 'Tanzania', code: 'tz', city: 'Dar es Salaam' },
  { country: 'Tanzania', code: 'tz', city: 'Dodoma' },
  { country: 'Tanzania', code: 'tz', city: 'Arusha' },
  { country: 'Tanzania', code: 'tz', city: 'Mwanza' },
  { country: 'Kenya', code: 'ke', city: 'Nairobi' },
  { country: 'Kenya', code: 'ke', city: 'Mombasa' },
  { country: 'Uganda', code: 'ug', city: 'Kampala' },
  { country: 'South Africa', code: 'za', city: 'Cape Town' },
  { country: 'South Africa', code: 'za', city: 'Johannesburg' },
  { country: 'Nigeria', code: 'ng', city: 'Lagos' },
  { country: 'Nigeria', code: 'ng', city: 'Abuja' },
  { country: 'Egypt', code: 'eg', city: 'Cairo' },
  { country: 'USA', code: 'us', city: 'New York' },
  { country: 'USA', code: 'us', city: 'Seattle' },
  { country: 'UK', code: 'gb', city: 'London' },
  { country: 'UK', code: 'gb', city: 'Manchester' },
  { country: 'India', code: 'in', city: 'Mumbai' },
  { country: 'India', code: 'in', city: 'New Delhi' },
  { country: 'Japan', code: 'jp', city: 'Tokyo' },
  { country: 'France', code: 'fr', city: 'Paris' },
  { country: 'Germany', code: 'de', city: 'Berlin' },
  { country: 'Australia', code: 'au', city: 'Sydney' },
  { country: 'Zambia', code: 'zm', city: 'Lusaka' },
  { country: 'Rwanda', code: 'rw', city: 'Kigali' },
  { country: 'Ethiopia', code: 'et', city: 'Addis Ababa' },
  { country: 'Ghana', code: 'gh', city: 'Accra' },
  { country: 'Botswana', code: 'bw', city: 'Gaborone' },
];

const ACTIONS = ['Viewed article', 'Downloaded PDF', 'Cited article'];

function getTimeAgo() {
  const seconds = Math.floor(Math.random() * 300) + 1;
  if (seconds < 60) return `${seconds}s ago`;
  return `${Math.floor(seconds / 60)}m ago`;
}

function truncateTitle(title, maxLen = 45) {
  if (!title) return 'Untitled Article';
  return title.length > maxLen ? title.substring(0, maxLen) + '...' : title;
}

function generateActivity(articlesPool) {
  const location = LOCATION_POOL[Math.floor(Math.random() * LOCATION_POOL.length)];
  const action = ACTIONS[Math.floor(Math.random() * ACTIONS.length)];
  const article = articlesPool[Math.floor(Math.random() * articlesPool.length)] || {};
  return {
    ...location,
    action,
    articleTitle: article.title || 'Research Article',
    authors: article.authors || 'Unknown Author',
    id: Date.now() + Math.random(),
    time: getTimeAgo(),
  };
}

export default function LiveActivity({ darkMode = true }) {
  const [articles, setArticles] = useState([]);
  const [activities, setActivities] = useState([]);

  // Fetch articles with authors on mount
  useEffect(() => {
    fetch(`${API_BASE}/api/articles-with-authors?limit=50`)
      .then(r => r.json())
      .then(data => {
        setArticles(data);
        // Initialize activities with real articles
        setActivities(Array.from({ length: 6 }, () => generateActivity(data)));
      })
      .catch(() => {
        // Fallback to empty pool
        setActivities(Array.from({ length: 6 }, () => generateActivity([])));
      });
  }, []);

  // Rotate activities every 4 seconds
  useEffect(() => {
    if (articles.length === 0) return;
    const interval = setInterval(() => {
      setActivities((prev) => {
        const newActivity = generateActivity(articles);
        newActivity.time = 'Just now';
        return [newActivity, ...prev.slice(0, 5)];
      });
    }, 4000);
    return () => clearInterval(interval);
  }, [articles]);

  const actionColor = {
    'Viewed article': 'text-blue-400',
    'Downloaded PDF': 'text-emerald-400',
    'Cited article': 'text-purple-400',
  };

  return (
    <div className={`rounded-3xl border backdrop-blur-2xl p-5 h-full transition-colors duration-300 ${
      darkMode ? 'border-white/[0.08] bg-white/[0.03]' : 'border-gray-200 bg-white shadow-sm'
    }`}>
      <div className="flex items-center gap-2 mb-4">
        <div className="rounded-xl bg-emerald-500/10 p-1.5">
          <Activity size={16} className="text-emerald-400" />
        </div>
        <h3 className={`text-[11px] font-semibold uppercase tracking-widest ${darkMode ? 'text-white/80' : 'text-gray-700'}`}>Live Activity</h3>
        <span className="ml-auto inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
      </div>
      <div className="space-y-2">
        {activities.map((item, i) => (
          <div
            key={item.id}
            className={`flex items-start gap-3 rounded-2xl px-3.5 py-3 transition-all duration-500 ${
              darkMode
                ? (i === 0 ? 'bg-white/[0.06] border border-white/[0.08] shadow-lg shadow-black/5' : 'hover:bg-white/[0.04]')
                : (i === 0 ? 'bg-gray-50 border border-gray-200 shadow-sm' : 'hover:bg-gray-50')
            }`}
          >
            <img
              src={`${FLAG_API}/${item.code}.png`}
              alt={item.country}
              className="w-6 h-[18px] rounded-sm object-cover shadow-sm mt-0.5 flex-shrink-0"
              onError={(e) => { e.target.style.display = 'none'; }}
            />
            <div className="flex-1 min-w-0">
              <p className={`text-sm ${darkMode ? 'text-white/80' : 'text-gray-700'}`}>
                <span className={`font-medium ${actionColor[item.action] || 'text-slate-300'}`}>
                  {item.action}
                </span>
              </p>
              <p className={`text-[11px] truncate mt-0.5 ${darkMode ? 'text-white' : 'text-gray-800'}`} title={item.articleTitle}>
                "{truncateTitle(item.articleTitle, 38)}"
              </p>
              <p className={`text-[10px] truncate ${darkMode ? 'text-slate-500/70' : 'text-gray-500'}`}>
                {item.authors} · {item.city}, {item.country}
              </p>
            </div>
            <span className={`text-[10px] whitespace-nowrap flex-shrink-0 ${darkMode ? 'text-slate-500/70' : 'text-gray-400'}`}>{item.time}</span>
          </div>
        ))}
      </div>
    </div>
  );
}
