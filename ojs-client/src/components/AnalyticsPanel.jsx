import { useState, useEffect } from 'react';
import { ChevronDown, BarChart3, PieChart, TrendingUp, Globe, Award, Flame, Calendar } from 'lucide-react';

const API_BASE = 'http://localhost:3001';

const TABS = [
  { id: 'top-cited', label: 'All-Time Top Cited', icon: Award },
  { id: 'monthly-top', label: 'Monthly Top 10', icon: Calendar },
  { id: 'visual', label: 'Visual Analytics', icon: BarChart3 },
  { id: 'growth', label: 'Citation Growth', icon: TrendingUp },
  { id: 'countries', label: 'Readers by Country', icon: Globe },
  { id: 'trending', label: 'Trending Articles', icon: Flame },
];

function formatMonth(monthStr) {
  if (!monthStr || monthStr.length !== 6) return monthStr;
  const year = monthStr.substring(0, 4);
  const month = parseInt(monthStr.substring(4, 6), 10);
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  return `${months[month - 1]} ${year}`;
}

function truncate(str, len = 50) {
  if (!str) return '';
  return str.length > len ? str.substring(0, len) + '...' : str;
}

export default function AnalyticsPanel({ darkMode = true }) {
  // Check URL hash for initial tab
  const getInitialTab = () => {
    const hash = window.location.hash.replace('#', '');
    const validTabs = ['top-cited', 'monthly-top', 'visual', 'growth', 'countries', 'trending'];
    return validTabs.includes(hash) ? hash : 'top-cited';
  };
  
  const [isOpen, setIsOpen] = useState(() => {
    // Auto-open if URL has a valid hash
    const hash = window.location.hash.replace('#', '');
    return ['top-cited', 'monthly-top', 'visual', 'growth', 'countries', 'trending'].includes(hash);
  });
  const [activeTab, setActiveTab] = useState(getInitialTab);
  const [topArticles, setTopArticles] = useState([]);
  const [trendingArticles, setTrendingArticles] = useState([]);
  const [countries, setCountries] = useState([]);
  const [monthlyData, setMonthlyData] = useState({ views: [], downloads: [] });
  const [metricsByType, setMetricsByType] = useState({});
  const [loading, setLoading] = useState(false);

  // Listen for hash changes
  useEffect(() => {
    const handleHashChange = () => {
      const hash = window.location.hash.replace('#', '');
      const validTabs = ['top-cited', 'monthly-top', 'visual', 'growth', 'countries', 'trending'];
      if (validTabs.includes(hash)) {
        setActiveTab(hash);
        setIsOpen(true);
      }
    };
    window.addEventListener('hashchange', handleHashChange);
    return () => window.removeEventListener('hashchange', handleHashChange);
  }, []);

  // Fetch data when tab changes
  useEffect(() => {
    setLoading(true);
    const fetchData = async () => {
      try {
        if (activeTab === 'top-cited' || activeTab === 'monthly-top') {
          const res = await fetch(`${API_BASE}/api/top-articles`);
          setTopArticles(await res.json());
        }
        if (activeTab === 'trending') {
          const res = await fetch(`${API_BASE}/api/trending-articles`);
          setTrendingArticles(await res.json());
        }
        if (activeTab === 'countries') {
          const res = await fetch(`${API_BASE}/api/metrics/countries`);
          const data = await res.json();
          const viewsByCountry = data.viewsByCountry || data.countries || [];
          const downloadsByCountry = data.downloadsByCountry || [];
          // Merge views and downloads into a single list per country
          const countryMap = {};
          viewsByCountry.forEach(c => {
            countryMap[c.country_id] = { country_id: c.country_id, views: c.total, downloads: 0, total: c.total };
          });
          downloadsByCountry.forEach(c => {
            if (countryMap[c.country_id]) {
              countryMap[c.country_id].downloads = c.total;
              countryMap[c.country_id].total += c.total;
            } else {
              countryMap[c.country_id] = { country_id: c.country_id, views: 0, downloads: c.total, total: c.total };
            }
          });
          const merged = Object.values(countryMap).sort((a, b) => b.total - a.total);
          setCountries(merged);
        }
        if (activeTab === 'visual' || activeTab === 'growth') {
          const [monthlyRes, typeRes] = await Promise.all([
            fetch(`${API_BASE}/api/metrics/monthly`),
            fetch(`${API_BASE}/api/metrics/by-type`),
          ]);
          setMonthlyData(await monthlyRes.json());
          setMetricsByType(await typeRes.json());
        }
      } catch (err) {
        console.error('Error fetching analytics:', err);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [activeTab]);

  const renderContent = () => {
    if (loading) {
      return (
        <div className="flex items-center justify-center py-12">
          <div className="w-6 h-6 border-2 border-blue-400/30 border-t-blue-400 rounded-full animate-spin"></div>
        </div>
      );
    }

    switch (activeTab) {
      case 'top-cited':
        return (
          <div className="space-y-2">
            <h4 className={`text-xs mb-3 ${darkMode ? 'text-slate-400' : 'text-gray-500'}`}>All-Time Most Viewed Articles</h4>
            {topArticles.map((article, i) => (
              <div key={article.submission_id} className={`flex items-start gap-3 p-3 rounded-xl transition-colors ${darkMode ? 'bg-white/[0.03] hover:bg-white/[0.06]' : 'bg-gray-50 hover:bg-gray-100'}`}>
                <span className="w-6 h-6 rounded-lg bg-gradient-to-br from-amber-500/20 to-orange-500/20 flex items-center justify-center text-xs font-bold text-amber-500 flex-shrink-0 mt-0.5">
                  {i + 1}
                </span>
                <div className="flex-1 min-w-0">
                  <p className={`text-sm ${darkMode ? 'text-white/90' : 'text-gray-800'}`}>{article.title}</p>
                  <p className={`text-[11px] mt-1 ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>{article.authors || 'Unknown Author'}</p>
                </div>
                <span className="text-xs text-emerald-500 font-medium flex-shrink-0">{article.views?.toLocaleString()} views</span>
              </div>
            ))}
          </div>
        );

      case 'monthly-top':
        return (
          <div className="space-y-2">
            <h4 className={`text-xs mb-3 ${darkMode ? 'text-slate-400' : 'text-gray-500'}`}>Top 10 Articles This Month</h4>
            {topArticles.slice(0, 10).map((article, i) => (
              <div key={article.submission_id} className={`flex items-start gap-3 p-3 rounded-xl transition-colors ${darkMode ? 'bg-white/[0.03] hover:bg-white/[0.06]' : 'bg-gray-50 hover:bg-gray-100'}`}>
                <span className="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center text-xs font-bold text-blue-500 flex-shrink-0 mt-0.5">
                  {i + 1}
                </span>
                <div className="flex-1 min-w-0">
                  <p className={`text-sm ${darkMode ? 'text-white/90' : 'text-gray-800'}`}>{article.title}</p>
                  <p className={`text-[11px] mt-1 ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>{article.authors || 'Unknown Author'}</p>
                </div>
                <span className="text-xs text-blue-500 font-medium flex-shrink-0">{article.views?.toLocaleString()} views</span>
              </div>
            ))}
          </div>
        );

      case 'visual':
        const maxViews = Math.max(...monthlyData.views.map(v => v.total), 1);
        const maxDownloads = Math.max(...monthlyData.downloads.map(d => d.total), 1);
        const pieTotal = Number(metricsByType.articleViews || 0) + Number(metricsByType.pdfDownloads || 0) + Number(metricsByType.homepageViews || 0) + Number(metricsByType.issueViews || 0);
        const pieData = [
          { label: 'Article Views', value: Number(metricsByType.articleViews) || 0, color: '#3b82f6' },
          { label: 'PDF Downloads', value: Number(metricsByType.pdfDownloads) || 0, color: '#10b981' },
          { label: 'Homepage Views', value: Number(metricsByType.homepageViews) || 0, color: '#8b5cf6' },
          { label: 'Issue Views', value: Number(metricsByType.issueViews) || 0, color: '#f59e0b' },
        ];
        return (
          <div className="space-y-8">
            {/* Bar Chart - Simple and Clear */}
            <div className={`p-5 rounded-xl ${darkMode ? 'bg-slate-800/50 border border-slate-700' : 'bg-white border border-gray-200 shadow-sm'}`}>
              <h4 className={`text-sm font-semibold mb-6 flex items-center gap-2 ${darkMode ? 'text-white' : 'text-gray-800'}`}>
                <BarChart3 size={18} className="text-blue-500" /> Monthly Views & Downloads
              </h4>
              <div className="flex items-end gap-3 h-48 px-2">
                {monthlyData.views.map((v, i) => {
                  const downloads = monthlyData.downloads[i]?.total || 0;
                  return (
                    <div key={v.month} className="flex-1 flex flex-col items-center">
                      {/* Values on top */}
                      <div className="flex gap-1 mb-1 text-[10px] font-medium">
                        <span className={darkMode ? 'text-blue-400' : 'text-blue-600'}>{v.total.toLocaleString()}</span>
                        <span className={darkMode ? 'text-slate-600' : 'text-gray-300'}>/</span>
                        <span className={darkMode ? 'text-emerald-400' : 'text-emerald-600'}>{downloads.toLocaleString()}</span>
                      </div>
                      {/* Bars */}
                      <div className="w-full flex gap-1 items-end justify-center h-32">
                        <div
                          className="flex-1 max-w-5 bg-blue-500 rounded-t"
                          style={{ height: `${Math.max(8, (v.total / maxViews) * 100)}%` }}
                        ></div>
                        <div
                          className="flex-1 max-w-5 bg-emerald-500 rounded-t"
                          style={{ height: `${Math.max(8, (downloads / maxDownloads) * 100)}%` }}
                        ></div>
                      </div>
                      {/* Month label */}
                      <span className={`text-[10px] mt-2 font-medium ${darkMode ? 'text-slate-400' : 'text-gray-600'}`}>
                        {formatMonth(v.month)}
                      </span>
                    </div>
                  );
                })}
              </div>
              <div className={`flex items-center justify-center gap-6 mt-4 pt-4 border-t ${darkMode ? 'border-slate-700 text-slate-300' : 'border-gray-100 text-gray-600'}`}>
                <span className="flex items-center gap-2 text-sm"><span className="w-4 h-4 rounded bg-blue-500"></span> Views</span>
                <span className="flex items-center gap-2 text-sm"><span className="w-4 h-4 rounded bg-emerald-500"></span> Downloads</span>
              </div>
            </div>

            {/* Pie Chart - Simple and Clear */}
            <div className={`p-5 rounded-xl ${darkMode ? 'bg-slate-800/50 border border-slate-700' : 'bg-white border border-gray-200 shadow-sm'}`}>
              <h4 className={`text-sm font-semibold mb-6 flex items-center gap-2 ${darkMode ? 'text-white' : 'text-gray-800'}`}>
                <PieChart size={18} className="text-purple-500" /> Traffic Distribution
              </h4>
              <div className="flex items-center justify-between gap-8">
                {/* Pie Chart */}
                <div className="relative w-40 h-40 flex-shrink-0">
                  <svg viewBox="0 0 42 42" className="w-full h-full -rotate-90">
                    <circle cx="21" cy="21" r="15.9" fill="none" stroke={darkMode ? '#334155' : '#e5e7eb'} strokeWidth="6" />
                    {pieData.reduce((acc, item) => {
                      const pct = pieTotal > 0 ? (item.value / pieTotal) * 100 : 0;
                      acc.elements.push(
                        <circle
                          key={item.label}
                          cx="21" cy="21" r="15.9"
                          fill="none"
                          stroke={item.color}
                          strokeWidth="6"
                          strokeDasharray={`${pct} ${100 - pct}`}
                          strokeDashoffset={-acc.offset}
                          strokeLinecap="round"
                        />
                      );
                      acc.offset += pct;
                      return acc;
                    }, { elements: [], offset: 0 }).elements}
                  </svg>
                  <div className="absolute inset-0 flex flex-col items-center justify-center">
                    <span className={`text-2xl font-bold ${darkMode ? 'text-white' : 'text-gray-800'}`}>{pieTotal.toLocaleString()}</span>
                    <span className={`text-xs ${darkMode ? 'text-slate-400' : 'text-gray-500'}`}>Total</span>
                  </div>
                </div>
                {/* Legend with values */}
                <div className="flex-1 space-y-4">
                  {pieData.map(item => {
                    const pct = pieTotal > 0 ? ((item.value / pieTotal) * 100).toFixed(1) : 0;
                    return (
                      <div key={item.label} className="flex items-center justify-between">
                        <div className="flex items-center gap-3">
                          <span className="w-4 h-4 rounded" style={{ backgroundColor: item.color }}></span>
                          <span className={`text-sm ${darkMode ? 'text-slate-300' : 'text-gray-700'}`}>{item.label}</span>
                        </div>
                        <div className="text-right">
                          <span className={`text-sm font-semibold ${darkMode ? 'text-white' : 'text-gray-800'}`}>{item.value.toLocaleString()}</span>
                          <span className={`text-xs ml-2 ${darkMode ? 'text-slate-500' : 'text-gray-400'}`}>({pct}%)</span>
                        </div>
                      </div>
                    );
                  })}
                </div>
              </div>
            </div>
          </div>
        );

      case 'growth':
        const growthMax = Math.max(...monthlyData.views.map(v => v.total), 1);
        return (
          <div>
            <h4 className={`text-xs mb-3 flex items-center gap-2 ${darkMode ? 'text-slate-400' : 'text-gray-600'}`}>
              <TrendingUp size={14} /> Citation & View Growth Over Time
            </h4>
            <div className={`relative h-40 border-l border-b ${darkMode ? 'border-white/10' : 'border-gray-200'}`}>
              <svg className="w-full h-full" preserveAspectRatio="none">
                <defs>
                  <linearGradient id="growthGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stopColor="#3b82f6" stopOpacity="0.3" />
                    <stop offset="100%" stopColor="#3b82f6" stopOpacity="0" />
                  </linearGradient>
                </defs>
                {monthlyData.views.length > 1 && (
                  <>
                    <path
                      d={`M 0 ${140 - (monthlyData.views[0]?.total / growthMax) * 130} ` +
                        monthlyData.views.map((v, i) => 
                          `L ${(i / (monthlyData.views.length - 1)) * 100}% ${140 - (v.total / growthMax) * 130}`
                        ).join(' ') + ` L 100% 140 L 0 140 Z`}
                      fill="url(#growthGrad)"
                    />
                    <polyline
                      points={monthlyData.views.map((v, i) => 
                        `${(i / (monthlyData.views.length - 1)) * 100}%,${140 - (v.total / growthMax) * 130}`
                      ).join(' ')}
                      fill="none"
                      stroke="#3b82f6"
                      strokeWidth="2"
                    />
                  </>
                )}
              </svg>
            </div>
            <div className={`flex justify-between text-[9px] mt-1 px-1 ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>
              {monthlyData.views.slice(0, 6).map(v => (
                <span key={v.month}>{formatMonth(v.month)}</span>
              ))}
            </div>
          </div>
        );

      case 'countries':
        const maxCountry = countries[0]?.total || 1;
        return (
          <div className="space-y-2">
            <h4 className={`text-xs mb-3 flex items-center gap-2 ${darkMode ? 'text-slate-400' : 'text-gray-600'}`}>
              <Globe size={14} /> Readers by Country
            </h4>
            {countries.length === 0 && (
              <p className={`text-xs ${darkMode ? 'text-slate-500' : 'text-gray-400'}`}>No country data available</p>
            )}
            {countries.slice(0, 15).map((c, i) => (
              <div key={c.country_id} className="flex items-center gap-3">
                <img
                  src={`https://flagcdn.com/24x18/${c.country_id?.toLowerCase()}.png`}
                  alt={c.country_id}
                  className="w-6 h-[18px] rounded-sm object-cover"
                  onError={(e) => { e.target.style.display = 'none'; }}
                />
                <span className={`text-xs w-8 uppercase font-medium ${darkMode ? 'text-white/70' : 'text-gray-700'}`}>{c.country_id}</span>
                <div className={`flex-1 h-2.5 rounded-full overflow-hidden ${darkMode ? 'bg-white/[0.05]' : 'bg-gray-100'}`}>
                  <div
                    className="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full transition-all duration-500"
                    style={{ width: `${(c.total / maxCountry) * 100}%` }}
                  ></div>
                </div>
                <span className={`text-xs w-20 text-right tabular-nums ${darkMode ? 'text-slate-400' : 'text-gray-600'}`}>{c.total.toLocaleString()}</span>
              </div>
            ))}
          </div>
        );

      case 'trending':
        return (
          <div className="space-y-2">
            <h4 className={`text-xs mb-3 flex items-center gap-2 ${darkMode ? 'text-slate-400' : 'text-gray-600'}`}>
              <Flame size={14} /> Trending Articles (Last 3 Months)
            </h4>
            {trendingArticles.map((article, i) => (
              <div key={article.submission_id} className={`flex items-start gap-3 p-3 rounded-xl transition-colors ${darkMode ? 'bg-white/[0.03] hover:bg-white/[0.06]' : 'bg-gray-50 hover:bg-gray-100'}`}>
                <span className="w-6 h-6 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-500/20 flex items-center justify-center text-xs font-bold text-orange-500 flex-shrink-0 mt-0.5">
                  {i + 1}
                </span>
                <div className="flex-1 min-w-0">
                  <p className={`text-sm ${darkMode ? 'text-white/90' : 'text-gray-800'}`}>{article.title}</p>
                  <p className={`text-[11px] mt-1 ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>{article.authors || 'Unknown Author'}</p>
                </div>
                <span className="text-xs text-orange-500 font-medium flex-shrink-0">{article.views?.toLocaleString()} views</span>
              </div>
            ))}
            {trendingArticles.length === 0 && (
              <p className={`text-xs text-center py-4 ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>No trending data available</p>
            )}
          </div>
        );

      default:
        return null;
    }
  };

  return (
    <div className={`rounded-3xl border backdrop-blur-2xl overflow-hidden transition-colors duration-300 ${
      darkMode ? 'border-white/[0.08] bg-white/[0.02]' : 'border-gray-200 bg-white shadow-sm'
    }`}>
      {/* Header with dropdown */}
      <button
        onClick={() => setIsOpen(!isOpen)}
        className={`w-full px-6 py-4 flex items-center justify-between transition-colors ${
          darkMode ? 'hover:bg-white/[0.02]' : 'hover:bg-gray-50'
        }`}
      >
        <div className="flex items-center gap-3">
          <div className="rounded-xl bg-purple-500/10 p-2">
            <BarChart3 size={18} className="text-purple-400" />
          </div>
          <div className="text-left">
            <h2 className={`text-sm font-semibold ${darkMode ? 'text-white/90' : 'text-gray-800'}`}>Analytics</h2>
            <p className={`text-[10px] ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>Detailed metrics & insights</p>
          </div>
        </div>
        <ChevronDown
          size={18}
          className={`transition-transform duration-300 ${isOpen ? 'rotate-180' : ''} ${darkMode ? 'text-slate-400' : 'text-gray-400'}`}
        />
      </button>

      {/* Expandable content */}
      <div className={`transition-all duration-300 ease-in-out overflow-hidden ${isOpen ? 'max-h-[800px] opacity-100' : 'max-h-0 opacity-0'}`}>
        {/* Tab buttons */}
        <div className="px-4 pb-2 flex flex-wrap gap-1.5">
          {TABS.map(tab => {
            const Icon = tab.icon;
            return (
              <button
                key={tab.id}
                onClick={() => setActiveTab(tab.id)}
                className={`flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[11px] font-medium transition-all ${
                  activeTab === tab.id
                    ? (darkMode ? 'bg-white/[0.1] text-white border border-white/[0.1]' : 'bg-blue-50 text-blue-600 border border-blue-200')
                    : (darkMode ? 'text-slate-400 hover:text-white/70 hover:bg-white/[0.04]' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100')
                }`}
              >
                <Icon size={12} />
                {tab.label}
              </button>
            );
          })}
        </div>

        {/* Tab content */}
        <div className={`px-6 py-4 border-t ${darkMode ? 'border-white/[0.05]' : 'border-gray-100'}`}>
          {renderContent()}
        </div>
      </div>
    </div>
  );
}
