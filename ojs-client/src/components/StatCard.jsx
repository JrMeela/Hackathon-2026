import { TrendingUp, TrendingDown } from 'lucide-react';

export default function StatCard({ title, value, subtitle, icon: Icon, trend, color = 'blue', darkMode = true }) {
  const colorMap = {
    blue: { glow: 'shadow-blue-500/10', icon: 'text-blue-400', iconBg: 'bg-blue-500/10', accent: 'from-blue-500/10' },
    green: { glow: 'shadow-emerald-500/10', icon: 'text-emerald-400', iconBg: 'bg-emerald-500/10', accent: 'from-emerald-500/10' },
    purple: { glow: 'shadow-purple-500/10', icon: 'text-purple-400', iconBg: 'bg-purple-500/10', accent: 'from-purple-500/10' },
    amber: { glow: 'shadow-amber-500/10', icon: 'text-amber-400', iconBg: 'bg-amber-500/10', accent: 'from-amber-500/10' },
    pink: { glow: 'shadow-pink-500/10', icon: 'text-pink-400', iconBg: 'bg-pink-500/10', accent: 'from-pink-500/10' },
  };

  const c = colorMap[color] || colorMap.blue;

  return (
    <div className={`group relative overflow-hidden rounded-3xl border backdrop-blur-2xl p-6 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl ${c.glow} ${
      darkMode 
        ? 'border-white/[0.08] bg-white/[0.03] hover:bg-white/[0.06] hover:border-white/[0.12]' 
        : 'border-gray-200 bg-white hover:bg-gray-50 hover:border-gray-300 shadow-sm'
    }`}>
      {/* Subtle gradient accent */}
      <div className={`absolute inset-0 bg-gradient-to-br ${c.accent} to-transparent opacity-50 pointer-events-none`}></div>
      <div className="relative z-10">
        <div className="flex items-start justify-between">
          <div className="space-y-1.5">
            <p className={`text-[11px] font-semibold uppercase tracking-widest ${darkMode ? 'text-slate-500' : 'text-gray-500'}`}>{title}</p>
            <p className={`text-3xl font-bold tracking-tight ${darkMode ? 'text-white/90' : 'text-gray-800'}`}>{typeof value === 'number' ? value.toLocaleString() : value}</p>
            {subtitle && <p className={`text-[13px] ${darkMode ? 'text-slate-400/80' : 'text-gray-500'}`}>{subtitle}</p>}
          </div>
          {Icon && (
            <div className={`rounded-2xl ${c.iconBg} backdrop-blur-sm p-3 ${c.icon} transition-transform duration-500 group-hover:scale-110`}>
              <Icon size={20} strokeWidth={1.5} />
            </div>
          )}
        </div>
        {trend !== undefined && (
          <div className={`mt-4 flex items-center gap-1.5 text-xs font-medium ${trend >= 0 ? 'text-emerald-400/90' : 'text-red-400/90'}`}>
            {trend >= 0 ? <TrendingUp size={13} /> : <TrendingDown size={13} />}
            <span>{Math.abs(trend)}% from last month</span>
          </div>
        )}
      </div>
    </div>
  );
}
