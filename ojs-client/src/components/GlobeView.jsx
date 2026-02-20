import { useEffect, useRef, useState, useCallback } from 'react';
import Globe from 'react-globe.gl';

const API_BASE = 'http://localhost:3001';

// Country code to lat/lng mapping
const COUNTRY_COORDS = {
  TZ: { lat: -6.7924, lng: 39.2083, name: 'Tanzania' },
  KE: { lat: -1.2921, lng: 36.8219, name: 'Kenya' },
  UG: { lat: 0.3476, lng: 32.5825, name: 'Uganda' },
  ZM: { lat: -15.3875, lng: 28.3228, name: 'Zambia' },
  ZA: { lat: -25.7479, lng: 28.2293, name: 'South Africa' },
  GB: { lat: 51.5074, lng: -0.1278, name: 'United Kingdom' },
  US: { lat: 40.7128, lng: -74.006, name: 'United States' },
  JP: { lat: 35.6762, lng: 139.6503, name: 'Japan' },
  SG: { lat: 1.3521, lng: 103.8198, name: 'Singapore' },
  FR: { lat: 48.8566, lng: 2.3522, name: 'France' },
  AU: { lat: -33.8688, lng: 151.2093, name: 'Australia' },
  RU: { lat: 55.7558, lng: 37.6173, name: 'Russia' },
  IN: { lat: 28.6139, lng: 77.209, name: 'India' },
  NG: { lat: 6.5244, lng: 3.3792, name: 'Nigeria' },
  EG: { lat: 30.0444, lng: 31.2357, name: 'Egypt' },
  DE: { lat: 52.52, lng: 13.405, name: 'Germany' },
  CN: { lat: 39.9042, lng: 116.4074, name: 'China' },
  BR: { lat: -23.5505, lng: -46.6333, name: 'Brazil' },
  CA: { lat: 45.4215, lng: -75.6972, name: 'Canada' },
  RW: { lat: -1.9403, lng: 29.8739, name: 'Rwanda' },
  ET: { lat: 9.0320, lng: 38.7469, name: 'Ethiopia' },
  GH: { lat: 5.6037, lng: -0.1870, name: 'Ghana' },
  BW: { lat: -24.6282, lng: 25.9231, name: 'Botswana' },
  MW: { lat: -13.9626, lng: 33.7741, name: 'Malawi' },
  MZ: { lat: -25.9692, lng: 32.5732, name: 'Mozambique' },
  ZW: { lat: -17.8252, lng: 31.0335, name: 'Zimbabwe' },
  NA: { lat: -22.5609, lng: 17.0658, name: 'Namibia' },
  AO: { lat: -8.8390, lng: 13.2894, name: 'Angola' },
  CD: { lat: -4.4419, lng: 15.2663, name: 'DR Congo' },
  SD: { lat: 15.5007, lng: 32.5599, name: 'Sudan' },
  MA: { lat: 33.9716, lng: -6.8498, name: 'Morocco' },
  DZ: { lat: 36.7538, lng: 3.0588, name: 'Algeria' },
  TN: { lat: 36.8065, lng: 10.1815, name: 'Tunisia' },
  LY: { lat: 32.8872, lng: 13.1913, name: 'Libya' },
  PK: { lat: 33.6844, lng: 73.0479, name: 'Pakistan' },
  BD: { lat: 23.8103, lng: 90.4125, name: 'Bangladesh' },
  ID: { lat: -6.2088, lng: 106.8456, name: 'Indonesia' },
  MY: { lat: 3.1390, lng: 101.6869, name: 'Malaysia' },
  PH: { lat: 14.5995, lng: 120.9842, name: 'Philippines' },
  TH: { lat: 13.7563, lng: 100.5018, name: 'Thailand' },
  VN: { lat: 21.0285, lng: 105.8542, name: 'Vietnam' },
  KR: { lat: 37.5665, lng: 126.9780, name: 'South Korea' },
  NL: { lat: 52.3676, lng: 4.9041, name: 'Netherlands' },
  BE: { lat: 50.8503, lng: 4.3517, name: 'Belgium' },
  IT: { lat: 41.9028, lng: 12.4964, name: 'Italy' },
  ES: { lat: 40.4168, lng: -3.7038, name: 'Spain' },
  PT: { lat: 38.7223, lng: -9.1393, name: 'Portugal' },
  SE: { lat: 59.3293, lng: 18.0686, name: 'Sweden' },
  NO: { lat: 59.9139, lng: 10.7522, name: 'Norway' },
  FI: { lat: 60.1699, lng: 24.9384, name: 'Finland' },
  DK: { lat: 55.6761, lng: 12.5683, name: 'Denmark' },
  PL: { lat: 52.2297, lng: 21.0122, name: 'Poland' },
  AT: { lat: 48.2082, lng: 16.3738, name: 'Austria' },
  CH: { lat: 46.9480, lng: 7.4474, name: 'Switzerland' },
  IE: { lat: 53.3498, lng: -6.2603, name: 'Ireland' },
  NZ: { lat: -41.2865, lng: 174.7762, name: 'New Zealand' },
  MX: { lat: 19.4326, lng: -99.1332, name: 'Mexico' },
  AR: { lat: -34.6037, lng: -58.3816, name: 'Argentina' },
  CL: { lat: -33.4489, lng: -70.6693, name: 'Chile' },
  CO: { lat: 4.7110, lng: -74.0721, name: 'Colombia' },
  PE: { lat: -12.0464, lng: -77.0428, name: 'Peru' },
  SA: { lat: 24.7136, lng: 46.6753, name: 'Saudi Arabia' },
  AE: { lat: 25.2048, lng: 55.2708, name: 'UAE' },
  IL: { lat: 31.7683, lng: 35.2137, name: 'Israel' },
  TR: { lat: 41.0082, lng: 28.9784, name: 'Turkey' },
  GR: { lat: 37.9838, lng: 23.7275, name: 'Greece' },
  UA: { lat: 50.4501, lng: 30.5234, name: 'Ukraine' },
  CZ: { lat: 50.0755, lng: 14.4378, name: 'Czech Republic' },
  HU: { lat: 47.4979, lng: 19.0402, name: 'Hungary' },
  RO: { lat: 44.4268, lng: 26.1025, name: 'Romania' },
};

// Metric type colors - BRIGHT and visible from afar
const METRIC_COLORS = {
  views: '#00ffff',      // Cyan - very bright
  downloads: '#ffff00',  // Yellow - very bright
  citations: '#ff00ff',  // Magenta - very bright
};

export default function GlobeView() {
  const globeRef = useRef();
  const containerRef = useRef();
  const [dimensions, setDimensions] = useState({ width: 600, height: 500 });
  const [ready, setReady] = useState(false);
  const [points, setPoints] = useState([]);
  const [totalViews, setTotalViews] = useState(0);
  const [totalDownloads, setTotalDownloads] = useState(0);
  const [totalCitations, setTotalCitations] = useState(0);

  // Fetch metrics data from API
  useEffect(() => {
    const fetchMetrics = async () => {
      try {
        const res = await fetch(`${API_BASE}/api/metrics/countries`);
        const data = await res.json();
        
        console.log('Globe API response:', data);
        
        const globePoints = [];
        
        // Process viewsByCountry data
        const viewsByCountry = data.viewsByCountry || [];
        const downloadsByCountry = data.downloadsByCountry || [];
        
        setTotalViews(data.totalViews || 0);
        setTotalDownloads(data.totalDownloads || 0);
        
        console.log('Views by country:', viewsByCountry.length, 'Downloads by country:', downloadsByCountry.length);
        
        // Add view points (cyan)
        if (viewsByCountry.length > 0) {
          const maxViews = Math.max(...viewsByCountry.map(x => x.total), 1);
          viewsByCountry.forEach(c => {
            const code = c.country_id?.toUpperCase();
            const coords = COUNTRY_COORDS[code];
            console.log('Processing view:', code, coords ? 'found' : 'NOT FOUND', c.total);
            if (coords && c.total > 0) {
              globePoints.push({
                lat: coords.lat,
                lng: coords.lng,
                country: coords.name,
                code: code,
                count: c.total,
                type: 'views',
                size: Math.max(0.5, (c.total / maxViews) * 2.0),
                color: METRIC_COLORS.views,
              });
            }
          });
        }
        
        // Add download points (yellow) - offset slightly
        if (downloadsByCountry.length > 0) {
          const maxDownloads = Math.max(...downloadsByCountry.map(x => x.total), 1);
          downloadsByCountry.forEach(c => {
            const code = c.country_id?.toUpperCase();
            const coords = COUNTRY_COORDS[code];
            if (coords && c.total > 0) {
              globePoints.push({
                lat: coords.lat + 2,
                lng: coords.lng + 2,
                country: coords.name,
                code: code,
                count: c.total,
                type: 'downloads',
                size: Math.max(0.4, (c.total / maxDownloads) * 1.8),
                color: METRIC_COLORS.downloads,
              });
            }
          });
        }
        
        console.log('Total globe points:', globePoints.length);

        // Fetch citations from CrossRef API
        try {
          const citationsRes = await fetch(`${API_BASE}/api/citations`);
          const citationsData = await citationsRes.json();
          setTotalCitations(citationsData.totalCitations || 0);
          
          if (citationsData.totalCitations > 0) {
            const citationCountries = await fetch(`${API_BASE}/api/citations/by-country`);
            const citationCountryData = await citationCountries.json();
            
            if (Array.isArray(citationCountryData) && citationCountryData.length > 0) {
              const maxCitations = Math.max(...citationCountryData.map(x => x.total));
              citationCountryData.forEach(c => {
                const code = c.country_id?.toUpperCase();
                const coords = COUNTRY_COORDS[code];
                if (coords && c.total > 0) {
                  globePoints.push({
                    lat: coords.lat - 1.5,
                    lng: coords.lng - 1.5,
                    country: coords.name,
                    code: code,
                    count: c.total,
                    type: 'citations',
                    size: Math.max(0.3, (c.total / maxCitations) * 1.5),
                    color: METRIC_COLORS.citations,
                  });
                }
              });
            }
          }
        } catch (citErr) {
          console.warn('Citations API not available:', citErr.message);
        }

        setPoints(globePoints);
      } catch (err) {
        console.error('Error fetching globe metrics:', err);
      }
    };
    
    fetchMetrics();
  }, []);

  const updateDimensions = useCallback(() => {
    if (containerRef.current) {
      const rect = containerRef.current.getBoundingClientRect();
      const w = Math.max(rect.width, 300);
      const h = Math.max(rect.height, 460);
      setDimensions({ width: w, height: h });
    }
  }, []);

  useEffect(() => {
    const timer = setTimeout(() => {
      updateDimensions();
      setReady(true);
    }, 300);
    window.addEventListener('resize', updateDimensions);
    return () => {
      clearTimeout(timer);
      window.removeEventListener('resize', updateDimensions);
    };
  }, [updateDimensions]);

  useEffect(() => {
    if (globeRef.current && ready) {
      const controls = globeRef.current.controls();
      controls.autoRotate = true;
      controls.autoRotateSpeed = 0.4;
      controls.enableZoom = true;
      controls.minDistance = 200;
      controls.maxDistance = 500;

      globeRef.current.pointOfView({ lat: -6.7924, lng: 39.2083, altitude: 2.2 }, 1000);
    }
  }, [ready, dimensions]);

  return (
    <div ref={containerRef} className="relative w-full flex items-center justify-center" style={{ height: '460px' }}>
      {ready && (
        <Globe
          ref={globeRef}
          width={dimensions.width}
          height={dimensions.height}
          globeImageUrl="//unpkg.com/three-globe/example/img/earth-blue-marble.jpg"
          bumpImageUrl="//unpkg.com/three-globe/example/img/earth-topology.png"
          backgroundImageUrl="//unpkg.com/three-globe/example/img/night-sky.png"
          pointsData={points}
          pointLat="lat"
          pointLng="lng"
          pointAltitude={0.01}
          pointRadius={(d) => d.size * 1.2}
          pointColor="color"
          pointLabel={(d) => `
            <div style="background: rgba(15,23,42,0.9); backdrop-filter: blur(12px); padding: 10px 14px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); font-size: 12px; color: #e2e8f0; box-shadow: 0 8px 32px rgba(0,0,0,0.4);">
              <div style="font-weight: 600; color: ${d.color};">${d.country}</div>
              <div style="margin-top: 4px; color: #94a3b8;">
                ${d.type === 'views' ? '👁 Views' : d.type === 'downloads' ? '📥 Downloads' : '📚 Citations'}: <strong style="color: ${d.color};">${d.count.toLocaleString()}</strong>
              </div>
            </div>
          `}
          atmosphereColor="#3b82f6"
          atmosphereAltitude={0.18}
          animateIn={true}
        />
      )}
      {/* Legend */}
      <div className="absolute bottom-4 left-4 rounded-2xl bg-white/[0.04] backdrop-blur-xl border border-white/[0.08] px-4 py-3 text-xs shadow-lg shadow-black/10">
        <div className="flex items-center gap-4 mb-2">
          <span className="flex items-center gap-1.5">
            <span className="w-3.5 h-3.5 rounded-full" style={{ backgroundColor: METRIC_COLORS.views, boxShadow: `0 0 10px ${METRIC_COLORS.views}` }}></span>
            <span className="text-slate-300 font-medium">Views</span>
          </span>
          <span className="flex items-center gap-1.5">
            <span className="w-3.5 h-3.5 rounded-full" style={{ backgroundColor: METRIC_COLORS.downloads, boxShadow: `0 0 10px ${METRIC_COLORS.downloads}` }}></span>
            <span className="text-slate-300 font-medium">Downloads</span>
          </span>
          <span className="flex items-center gap-1.5">
            <span className="w-3.5 h-3.5 rounded-full" style={{ backgroundColor: METRIC_COLORS.citations, boxShadow: `0 0 10px ${METRIC_COLORS.citations}` }}></span>
            <span className="text-slate-300 font-medium">Citations</span>
          </span>
        </div>
        <div className="text-slate-500 text-[10px]">
          {totalViews.toLocaleString()} views, {totalDownloads.toLocaleString()} downloads across {points.length} regions
        </div>
      </div>
    </div>
  );
}
