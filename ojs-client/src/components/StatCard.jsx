import { TrendingUp, TrendingDown } from 'lucide-react';

export default function StatCard({ title, value, subtitle, icon: Icon, trend, color = 'blue' }) {
  const colorMap = {
    blue: { bg: 'from-blue-500/20 to-blue-600/5', border: 'border-blue-500/30', text: 'text-blue-400', icon: 'text-blue-400' },
    green: { bg: 'from-emerald-500/20 to-emerald-600/5', border: 'border-emerald-500/30', text: 'text-emerald-400', icon: 'text-emerald-400' },
    purple: { bg: 'from-purple-500/20 to-purple-600/5', border: 'border-purple-500/30', text: 'text-purple-400', icon: 'text-purple-400' },
    amber: { bg: 'from-amber-500/20 to-amber-600/5', border: 'border-amber-500/30', text: 'text-amber-400', icon: 'text-amber-400' },
  };

  const c = colorMap[color] || colorMap.blue;

  return (
    <div className={`relative overflow-hidden rounded-2xl border ${c.border} bg-gradient-to-br ${c.bg} backdrop-blur-sm p-5 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-black/20`}>
      <div className="flex items-start justify-between">
        <div className="space-y-1">
          <p className="text-xs font-medium uppercase tracking-wider text-slate-400">{title}</p>
          <p className="text-3xl font-bold text-white">{typeof value === 'number' ? value.toLocaleString() : value}</p>
          {subtitle && <p className="text-sm text-slate-400">{subtitle}</p>}
        </div>
        {Icon && (
          <div className={`rounded-xl bg-slate-800/50 p-2.5 ${c.icon}`}>
            <Icon size={22} />
          </div>
        )}
      </div>
      {trend !== undefined && (
        <div className={`mt-3 flex items-center gap-1 text-xs font-medium ${trend >= 0 ? 'text-emerald-400' : 'text-red-400'}`}>
          {trend >= 0 ? <TrendingUp size={14} /> : <TrendingDown size={14} />}
          <span>{Math.abs(trend)}% from last month</span>
        </div>
      )}
    </div>
  );
}
