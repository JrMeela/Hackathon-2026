import { useEffect, useState } from 'react';
import { Activity } from 'lucide-react';

const FLAG_API = 'https://flagcdn.com/24x18';

const ACTIVITY_POOL = [
  { country: 'Tanzania', code: 'tz', city: 'Dar es Salaam', action: 'Viewed article' },
  { country: 'Tanzania', code: 'tz', city: 'Dodoma', action: 'Downloaded PDF' },
  { country: 'Tanzania', code: 'tz', city: 'Arusha', action: 'Viewed article' },
  { country: 'Tanzania', code: 'tz', city: 'Mwanza', action: 'Cited article' },
  { country: 'Kenya', code: 'ke', city: 'Nairobi', action: 'Viewed article' },
  { country: 'Kenya', code: 'ke', city: 'Mombasa', action: 'Downloaded PDF' },
  { country: 'Uganda', code: 'ug', city: 'Kampala', action: 'Viewed article' },
  { country: 'South Africa', code: 'za', city: 'Cape Town', action: 'Downloaded PDF' },
  { country: 'South Africa', code: 'za', city: 'Johannesburg', action: 'Cited article' },
  { country: 'Nigeria', code: 'ng', city: 'Lagos', action: 'Viewed article' },
  { country: 'Nigeria', code: 'ng', city: 'Abuja', action: 'Downloaded PDF' },
  { country: 'Egypt', code: 'eg', city: 'Cairo', action: 'Viewed article' },
  { country: 'USA', code: 'us', city: 'New York', action: 'Downloaded PDF' },
  { country: 'USA', code: 'us', city: 'Seattle', action: 'Viewed article' },
  { country: 'UK', code: 'gb', city: 'London', action: 'Cited article' },
  { country: 'UK', code: 'gb', city: 'Manchester', action: 'Viewed article' },
  { country: 'India', code: 'in', city: 'Mumbai', action: 'Viewed article' },
  { country: 'India', code: 'in', city: 'New Delhi', action: 'Downloaded PDF' },
  { country: 'Japan', code: 'jp', city: 'Tokyo', action: 'Viewed article' },
  { country: 'France', code: 'fr', city: 'Paris', action: 'Downloaded PDF' },
  { country: 'Germany', code: 'de', city: 'Berlin', action: 'Viewed article' },
  { country: 'Australia', code: 'au', city: 'Sydney', action: 'Cited article' },
  { country: 'Zambia', code: 'zm', city: 'Lusaka', action: 'Viewed article' },
  { country: 'Rwanda', code: 'rw', city: 'Kigali', action: 'Downloaded PDF' },
  { country: 'Ethiopia', code: 'et', city: 'Addis Ababa', action: 'Viewed article' },
  { country: 'Ghana', code: 'gh', city: 'Accra', action: 'Downloaded PDF' },
  { country: 'Botswana', code: 'bw', city: 'Gaborone', action: 'Viewed article' },
];

function getTimeAgo() {
  const seconds = Math.floor(Math.random() * 300) + 1;
  if (seconds < 60) return `${seconds}s ago`;
  return `${Math.floor(seconds / 60)}m ago`;
}

function generateActivity() {
  const item = ACTIVITY_POOL[Math.floor(Math.random() * ACTIVITY_POOL.length)];
  return {
    ...item,
    id: Date.now() + Math.random(),
    time: getTimeAgo(),
  };
}

export default function LiveActivity() {
  const [activities, setActivities] = useState(() =>
    Array.from({ length: 6 }, () => generateActivity())
  );

  useEffect(() => {
    const interval = setInterval(() => {
      setActivities((prev) => {
        const newActivity = generateActivity();
        newActivity.time = 'Just now';
        return [newActivity, ...prev.slice(0, 5)];
      });
    }, 4000);
    return () => clearInterval(interval);
  }, []);

  const actionColor = {
    'Viewed article': 'text-blue-400',
    'Downloaded PDF': 'text-emerald-400',
    'Cited article': 'text-purple-400',
  };

  return (
    <div className="rounded-2xl border border-slate-700/50 bg-slate-800/30 backdrop-blur-sm p-5">
      <div className="flex items-center gap-2 mb-4">
        <Activity size={18} className="text-emerald-400" />
        <h3 className="text-sm font-semibold text-white uppercase tracking-wider">Live Activity</h3>
        <span className="ml-auto inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
      </div>
      <div className="space-y-3">
        {activities.map((item, i) => (
          <div
            key={item.id}
            className={`flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-500 ${
              i === 0 ? 'bg-slate-700/40 border border-slate-600/30' : 'hover:bg-slate-700/20'
            }`}
          >
            <img
              src={`${FLAG_API}/${item.code}.png`}
              alt={item.country}
              className="w-6 h-[18px] rounded-sm object-cover shadow-sm"
              onError={(e) => { e.target.style.display = 'none'; }}
            />
            <div className="flex-1 min-w-0">
              <p className="text-sm text-slate-200 truncate">
                <span className={`font-medium ${actionColor[item.action] || 'text-slate-300'}`}>
                  {item.action}
                </span>
              </p>
              <p className="text-xs text-slate-500 truncate">
                {item.city}, {item.country}
              </p>
            </div>
            <span className="text-[10px] text-slate-500 whitespace-nowrap">{item.time}</span>
          </div>
        ))}
      </div>
    </div>
  );
}
