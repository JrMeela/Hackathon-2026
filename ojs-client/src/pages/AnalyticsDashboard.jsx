import { useEffect, useState } from 'react';
import { Eye, Download, FileText, BookOpen, Sun, Moon, Quote } from 'lucide-react';
import StatCard from '../components/StatCard';
import GlobeView from '../components/GlobeView';
import LiveActivity from '../components/LiveActivity';
import AnalyticsPanel from '../components/AnalyticsPanel';
import { fetchDashboardStats, fetchIssues } from '../services/ojsApi';

const API_BASE = 'http://localhost:3001';

export default function AnalyticsDashboard() {
  const [darkMode, setDarkMode] = useState(() => {
    const saved = localStorage.getItem('analytics-theme');
    return saved ? saved === 'dark' : true; // Default to dark
  });

  useEffect(() => {
    localStorage.setItem('analytics-theme', darkMode ? 'dark' : 'light');
  }, [darkMode]);

  const [stats, setStats] = useState({
    totalViews: 0,
    totalDownloads: 0,
    totalArticles: 0,
    totalIssues: 0,
    currentMonthViews: 0,
    currentMonthDownloads: 0,
    viewsTrend: 0,
    downloadsTrend: 0,
  });
  const [citations, setCitations] = useState({ total: 0, source: 'CrossRef' });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadData() {
      setLoading(true);
      try {
        const [dashStats, issuesData] = await Promise.all([
          fetchDashboardStats(),
          fetchIssues(),
        ]);

        if (dashStats) {
          setStats({
            totalViews: dashStats.totalViews,
            totalDownloads: dashStats.totalDownloads,
            totalArticles: dashStats.totalArticles,
            totalIssues: dashStats.totalIssues,
            currentMonthViews: dashStats.currentMonthViews,
            currentMonthDownloads: dashStats.currentMonthDownloads,
            viewsTrend: dashStats.viewsTrend,
            downloadsTrend: dashStats.downloadsTrend,
          });
        }

        // Fetch citations from CrossRef API
        try {
          const citRes = await fetch(`${API_BASE}/api/citations`);
          const citData = await citRes.json();
          setCitations({ total: citData.totalCitations || 0, source: citData.source || 'CrossRef' });
        } catch (citErr) {
          console.warn('Citations API not available:', citErr);
        }
      } catch (err) {
        console.error('Error loading analytics:', err);
      } finally {
        setLoading(false);
      }
    }
    loadData();
  }, []);

  // Theme classes
  const theme = {
    bg: darkMode ? 'bg-[#0a0e1a]' : 'bg-gray-50',
    card: darkMode ? 'bg-white/[0.02] border-white/[0.08]' : 'bg-white border-gray-200 shadow-sm',
    text: darkMode ? 'text-white/80' : 'text-gray-800',
    textMuted: darkMode ? 'text-slate-500/70' : 'text-gray-500',
    textSubtle: darkMode ? 'text-slate-600/50' : 'text-gray-400',
  };

  return (
    <div className={`min-h-screen ${theme.bg} relative overflow-hidden transition-colors duration-300`}>
      {/* Theme Toggle Button */}
      <button
        onClick={() => setDarkMode(!darkMode)}
        className={`fixed top-4 right-4 z-50 p-3 rounded-2xl backdrop-blur-xl border transition-all duration-300 ${
          darkMode 
            ? 'bg-white/[0.05] border-white/[0.1] hover:bg-white/[0.1] text-yellow-400' 
            : 'bg-white border-gray-200 hover:bg-gray-100 text-gray-700 shadow-lg'
        }`}
        title={darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'}
      >
        {darkMode ? <Sun size={20} /> : <Moon size={20} />}
      </button>

      {/* Ambient background blurs — Apple-style depth */}
      {darkMode && (
        <div className="pointer-events-none fixed inset-0 z-0">
          <div className="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-blue-600/[0.07] blur-[120px]"></div>
          <div className="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-purple-600/[0.05] blur-[100px]"></div>
          <div className="absolute top-[40%] right-[20%] w-[300px] h-[300px] rounded-full bg-emerald-600/[0.04] blur-[80px]"></div>
        </div>
      )}

      <main className="relative z-10 max-w-[1600px] mx-auto px-5 sm:px-8 py-6">
        {/* Stat Cards Row */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
          <StatCard
            title="Article Views"
            value={stats.totalViews}
            subtitle={`${stats.currentMonthViews.toLocaleString()} this month`}
            icon={Eye}
            trend={stats.viewsTrend}
            color="blue"
            darkMode={darkMode}
          />
          <StatCard
            title="PDF Downloads"
            value={stats.totalDownloads}
            subtitle={`${stats.currentMonthDownloads.toLocaleString()} this month`}
            icon={Download}
            trend={stats.downloadsTrend}
            color="green"
            darkMode={darkMode}
          />
          <StatCard
            title="Citations"
            value={citations.total}
            subtitle={`Source: ${citations.source}`}
            icon={Quote}
            color="pink"
            darkMode={darkMode}
          />
          <StatCard
            title="Published Articles"
            value={stats.totalArticles}
            subtitle="Peer-reviewed publications"
            icon={FileText}
            color="purple"
            darkMode={darkMode}
          />
          <StatCard
            title="Published Issues"
            value={stats.totalIssues}
            subtitle="Journal volumes & issues"
            icon={BookOpen}
            color="amber"
            darkMode={darkMode}
          />
        </div>

        {/* Globe + Live Activity Row */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
          {/* 3D Globe - takes 2/3 */}
          <div className={`lg:col-span-2 rounded-3xl border backdrop-blur-2xl overflow-hidden transition-colors duration-300 ${
            darkMode ? 'border-white/[0.08] bg-white/[0.02]' : 'border-gray-200 bg-white shadow-sm'
          }`} style={{ minHeight: '520px' }}>
            <div className="px-6 pt-5 pb-2 flex items-center justify-between">
              <div>
                <h2 className={`text-[11px] font-semibold uppercase tracking-widest ${darkMode ? 'text-white/80' : 'text-gray-700'}`}>Global Readership Map</h2>
                <p className={`text-xs mt-1 ${darkMode ? 'text-slate-500/70' : 'text-gray-500'}`}>Real-time reader distribution across the world</p>
              </div>
              <div className={`flex items-center gap-3 text-[10px] ${darkMode ? 'text-slate-500/70' : 'text-gray-500'}`}>
                <span className="flex items-center gap-1.5"><span className="w-1.5 h-1.5 rounded-full bg-blue-400"></span>Views</span>
                <span className="flex items-center gap-1.5"><span className="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Downloads</span>
                <span className="flex items-center gap-1.5"><span className="w-1.5 h-1.5 rounded-full bg-purple-400"></span>Citations</span>
              </div>
            </div>
            <GlobeView darkMode={darkMode} />
          </div>

          {/* Live Activity - takes 1/3 */}
          <div className="lg:col-span-1">
            <LiveActivity darkMode={darkMode} />
          </div>
        </div>

        {/* Analytics Panel with Dropdown */}
        <div className="mt-4">
          <AnalyticsPanel darkMode={darkMode} />
        </div>

        {/* Footer attribution */}
        <div className={`mt-8 text-center text-[11px] ${darkMode ? 'text-slate-600/50' : 'text-gray-400'}`}>
          <p>Powered by OJS REST API &middot; University of Dar es Salaam &middot; TJPSD Analytics Dashboard</p>
        </div>
      </main>
    </div>
  );
}
