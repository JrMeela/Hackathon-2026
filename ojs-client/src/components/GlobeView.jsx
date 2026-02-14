import { useEffect, useRef, useState, useCallback } from 'react';
import Globe from 'react-globe.gl';

const SAMPLE_POINTS = [
  { lat: -6.7924, lng: 39.2083, city: 'Dar es Salaam', country: 'Tanzania', size: 0.8, color: '#3b82f6' },
  { lat: -1.2921, lng: 36.8219, city: 'Nairobi', country: 'Kenya', size: 0.5, color: '#10b981' },
  { lat: 0.3476, lng: 32.5825, city: 'Kampala', country: 'Uganda', size: 0.4, color: '#8b5cf6' },
  { lat: -15.3875, lng: 28.3228, city: 'Lusaka', country: 'Zambia', size: 0.35, color: '#f59e0b' },
  { lat: -25.7479, lng: 28.2293, city: 'Pretoria', country: 'South Africa', size: 0.6, color: '#ef4444' },
  { lat: 51.5074, lng: -0.1278, city: 'London', country: 'UK', size: 0.45, color: '#06b6d4' },
  { lat: 40.7128, lng: -74.006, city: 'New York', country: 'USA', size: 0.55, color: '#ec4899' },
  { lat: 35.6762, lng: 139.6503, city: 'Tokyo', country: 'Japan', size: 0.3, color: '#14b8a6' },
  { lat: 1.3521, lng: 103.8198, city: 'Singapore', country: 'Singapore', size: 0.25, color: '#a855f7' },
  { lat: 48.8566, lng: 2.3522, city: 'Paris', country: 'France', size: 0.35, color: '#f97316' },
  { lat: -33.8688, lng: 151.2093, city: 'Sydney', country: 'Australia', size: 0.3, color: '#22d3ee' },
  { lat: 55.7558, lng: 37.6173, city: 'Moscow', country: 'Russia', size: 0.25, color: '#e879f9' },
  { lat: 28.6139, lng: 77.209, city: 'New Delhi', country: 'India', size: 0.5, color: '#fbbf24' },
  { lat: 6.5244, lng: 3.3792, city: 'Lagos', country: 'Nigeria', size: 0.55, color: '#34d399' },
  { lat: 30.0444, lng: 31.2357, city: 'Cairo', country: 'Egypt', size: 0.4, color: '#fb923c' },
  { lat: -3.3869, lng: 36.6830, city: 'Arusha', country: 'Tanzania', size: 0.3, color: '#3b82f6' },
  { lat: -8.9094, lng: 33.4608, city: 'Mbeya', country: 'Tanzania', size: 0.2, color: '#3b82f6' },
  { lat: -2.5164, lng: 32.9175, city: 'Mwanza', country: 'Tanzania', size: 0.25, color: '#3b82f6' },
];

const ARCS_DATA = [
  { startLat: -6.7924, startLng: 39.2083, endLat: 51.5074, endLng: -0.1278, color: ['#3b82f680', '#06b6d480'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: 40.7128, endLng: -74.006, color: ['#3b82f680', '#ec489980'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: -1.2921, endLng: 36.8219, color: ['#3b82f680', '#10b98180'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: 28.6139, endLng: 77.209, color: ['#3b82f680', '#fbbf2480'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: 6.5244, endLng: 3.3792, color: ['#3b82f680', '#34d39980'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: 35.6762, endLng: 139.6503, color: ['#3b82f680', '#14b8a680'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: -25.7479, endLng: 28.2293, color: ['#3b82f680', '#ef444480'] },
  { startLat: -6.7924, startLng: 39.2083, endLat: 30.0444, endLng: 31.2357, color: ['#3b82f680', '#fb923c80'] },
];

export default function GlobeView() {
  const globeRef = useRef();
  const containerRef = useRef();
  const [dimensions, setDimensions] = useState({ width: 0, height: 0 });

  const updateDimensions = useCallback(() => {
    if (containerRef.current) {
      const { width, height } = containerRef.current.getBoundingClientRect();
      setDimensions({ width, height: Math.max(height, 500) });
    }
  }, []);

  useEffect(() => {
    updateDimensions();
    window.addEventListener('resize', updateDimensions);
    return () => window.removeEventListener('resize', updateDimensions);
  }, [updateDimensions]);

  useEffect(() => {
    if (globeRef.current) {
      const controls = globeRef.current.controls();
      controls.autoRotate = true;
      controls.autoRotateSpeed = 0.5;
      controls.enableZoom = true;
      controls.minDistance = 200;
      controls.maxDistance = 500;

      globeRef.current.pointOfView({ lat: -6.7924, lng: 39.2083, altitude: 2.2 }, 1000);
    }
  }, [dimensions]);

  return (
    <div ref={containerRef} className="relative w-full h-full min-h-[500px] flex items-center justify-center">
      {dimensions.width > 0 && (
        <Globe
          ref={globeRef}
          width={dimensions.width}
          height={dimensions.height}
          globeImageUrl="//unpkg.com/three-globe/example/img/earth-blue-marble.jpg"
          bumpImageUrl="//unpkg.com/three-globe/example/img/earth-topology.png"
          backgroundImageUrl="//unpkg.com/three-globe/example/img/night-sky.png"
          pointsData={SAMPLE_POINTS}
          pointLat="lat"
          pointLng="lng"
          pointAltitude={(d) => d.size * 0.05}
          pointRadius={(d) => d.size * 0.5}
          pointColor="color"
          pointLabel={(d) => `
            <div style="background: rgba(15,23,42,0.9); padding: 8px 12px; border-radius: 8px; border: 1px solid rgba(59,130,246,0.3); font-size: 12px; color: #e2e8f0;">
              <div style="font-weight: 600; color: ${d.color};">${d.city}, ${d.country}</div>
              <div style="margin-top: 2px; color: #94a3b8;">Active readers</div>
            </div>
          `}
          arcsData={ARCS_DATA}
          arcColor="color"
          arcDashLength={0.4}
          arcDashGap={0.2}
          arcDashAnimateTime={2000}
          arcStroke={0.5}
          atmosphereColor="#3b82f6"
          atmosphereAltitude={0.2}
          animateIn={true}
        />
      )}
      <div className="absolute bottom-4 left-4 rounded-xl bg-slate-900/80 backdrop-blur-sm border border-slate-700/50 px-4 py-2.5 text-xs text-slate-400">
        <span className="inline-block w-2 h-2 rounded-full bg-blue-500 animate-pulse mr-2"></span>
        Live reader connections from Dar es Salaam
      </div>
    </div>
  );
}
