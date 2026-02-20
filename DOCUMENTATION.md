# TJPSD Analytics Dashboard - Project Documentation

## Overview

This project is a **modern analytics dashboard** for the **Tanzania Journal of Population Studies and Development (TJPSD)**, built as an extension to the Open Journal Systems (OJS) platform. It provides real-time visualization of journal metrics including article views, downloads, and citations from CrossRef.

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Technology Stack](#technology-stack)
3. [Project Structure](#project-structure)
4. [Backend API Server](#backend-api-server)
5. [Frontend React Application](#frontend-react-application)
6. [OJS Theme Integration](#ojs-theme-integration)
7. [Database Schema](#database-schema)
8. [API Reference](#api-reference)
9. [Globe Visualization](#globe-visualization)
10. [CrossRef Integration](#crossref-integration)
11. [Running the Project](#running-the-project)
12. [Configuration](#configuration)

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                         USER BROWSER                                 │
├─────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  ┌──────────────────┐    ┌──────────────────┐    ┌───────────────┐  │
│  │   OJS PHP App    │    │  React Dashboard │    │  Article Globe│  │
│  │   (Port 8000)    │    │   (Port 3000)    │    │  (Embedded)   │  │
│  └────────┬─────────┘    └────────┬─────────┘    └───────┬───────┘  │
│           │                       │                       │          │
│           │    ┌──────────────────┴───────────────────────┘          │
│           │    │                                                     │
│           ▼    ▼                                                     │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │              Express.js API Server (Port 3001)               │    │
│  │  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │    │
│  │  │ MySQL Pool  │  │ CrossRef    │  │ Caching Layer       │  │    │
│  │  │ Connection  │  │ API Client  │  │ (10-min TTL)        │  │    │
│  │  └──────┬──────┘  └──────┬──────┘  └─────────────────────┘  │    │
│  └─────────┼────────────────┼──────────────────────────────────┘    │
│            │                │                                        │
│            ▼                ▼                                        │
│  ┌─────────────────┐  ┌─────────────────────────────────────────┐   │
│  │  MySQL Database │  │  CrossRef API (api.crossref.org)        │   │
│  │  (tjpsd32)      │  │  - ISSN-based bulk fetch                │   │
│  └─────────────────┘  │  - Citation counts                      │   │
│                       └─────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
```

### Three-Server Architecture

| Server | Port | Technology | Purpose |
|--------|------|------------|---------|
| OJS PHP | 8000 | PHP/Apache | Main journal website, article pages |
| Express API | 3001 | Node.js/Express | REST API for metrics data |
| Vite Dev | 3000 | React/Vite | Analytics dashboard SPA |

---

## Technology Stack

### Backend
- **Node.js** (v18+) - Runtime environment
- **Express.js** (v4.21) - Web framework
- **mysql2** (v3.11) - MySQL driver with connection pooling
- **cors** (v2.8) - Cross-origin resource sharing

### Frontend
- **React** (v19.2) - UI framework
- **Vite** (v7.3) - Build tool and dev server
- **Tailwind CSS** (v4.1) - Utility-first CSS framework
- **react-globe.gl** (v2.37) - 3D globe visualization
- **Three.js** (v0.182) - WebGL 3D graphics
- **Lucide React** (v0.564) - Icon library
- **Axios** (v1.13) - HTTP client

### OJS Integration
- **Open Journal Systems** (v3.2+) - Journal management platform
- **Smarty Templates** - PHP templating engine
- **Custom UDSM Theme** - Glassmorphism CSS styling

### External APIs
- **CrossRef API** - Citation data via ISSN lookup

---

## Project Structure

```
Hackathon-2026/
├── ojs-client/                    # React analytics dashboard
│   ├── server/
│   │   └── index.js               # Express API server (28KB)
│   ├── src/
│   │   ├── components/
│   │   │   ├── AnalyticsPanel.jsx # Main analytics tabs (22KB)
│   │   │   ├── GlobeView.jsx      # 3D globe component (12KB)
│   │   │   ├── LiveActivity.jsx   # Real-time activity feed
│   │   │   └── StatCard.jsx       # Metric stat cards
│   │   ├── services/
│   │   │   └── ojsApi.js          # API client utilities
│   │   ├── App.jsx                # Root component
│   │   ├── main.jsx               # React entry point
│   │   └── index.css              # Tailwind CSS imports
│   ├── package.json               # Dependencies
│   └── vite.config.js             # Vite configuration
│
├── tjpsd/                         # OJS theme plugin
│   ├── plugins/themes/default/
│   │   └── styles/
│   │       └── custom-udsm.css    # UDSM glassmorphism theme
│   ├── templates/frontend/
│   │   ├── pages/
│   │   │   └── indexJournal.tpl   # Homepage with analytics iframe
│   │   └── objects/
│   │       └── article_details.tpl # Article page with globe
│   └── config.inc.php             # OJS database configuration
│
├── tjpsd32.sql                    # Database dump (8.8MB)
└── package.json                   # Root dependencies
```

---

## Backend API Server

### Location
`ojs-client/server/index.js`

### Configuration
```javascript
const PORT = 3001;
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'tjpsd32',
  port: 3306,
  connectionLimit: 10,
});
```

### Key Features
1. **Connection Pooling** - Efficient MySQL connections
2. **CORS Enabled** - Cross-origin requests from React app
3. **CrossRef Caching** - 10-minute TTL to reduce API calls
4. **Regional Distribution** - Fallback when country_id not tracked

---

## API Reference

### Dashboard Statistics

#### `GET /api/stats`
Returns aggregate journal statistics.

**Response:**
```json
{
  "articles": 150,
  "issues": 32,
  "views": 45686,
  "downloads": 26767,
  "homepageViews": 5432,
  "issueViews": 2341
}
```

**Database Queries:**
- `assoc_type = 1048585` → Article/submission views
- `assoc_type = 515` → Galley/file downloads
- `assoc_type = 256` → Homepage views
- `assoc_type = 259` → Issue TOC views

---

#### `GET /api/top-articles`
Returns top 20 articles by total views.

**Response:**
```json
[
  {
    "submission_id": 123,
    "title": "Population and Economic Growth in Tanzania",
    "authors": "David Loboo, Elias Luvanda",
    "views": 3015,
    "downloads": 1250
  }
]
```

---

#### `GET /api/trending-articles`
Returns articles with highest activity in last 3 months.

---

#### `GET /api/metrics/countries`
Returns views and downloads aggregated by country.

**Response:**
```json
{
  "viewsByCountry": [
    { "country_id": "TZ", "total": 15990 },
    { "country_id": "KE", "total": 5482 }
  ],
  "downloadsByCountry": [
    { "country_id": "TZ", "total": 10707 },
    { "country_id": "KE", "total": 2677 }
  ],
  "totalViews": 45686,
  "totalDownloads": 26767,
  "hasRealCountryData": false,
  "note": "Regional distribution based on total metrics"
}
```

**Logic:**
- If `country_id` exists in database → use real data
- If no country data → distribute totals to regions using percentages:
  - Tanzania: 35% views, 40% downloads
  - Kenya: 12% views, 10% downloads
  - Uganda: 8% views, 7% downloads
  - etc.

---

#### `GET /api/metrics/monthly`
Returns monthly aggregated views and downloads.

**Response:**
```json
{
  "views": [
    { "month": "202501", "total": 2345 },
    { "month": "202502", "total": 3456 }
  ],
  "downloads": [
    { "month": "202501", "total": 1234 },
    { "month": "202502", "total": 2345 }
  ]
}
```

---

#### `GET /api/metrics/by-type`
Returns metrics breakdown by type.

**Response:**
```json
{
  "article_views": 45686,
  "galley_downloads": 26767,
  "homepage_views": 5432,
  "issue_views": 2341
}
```

---

#### `GET /api/article/:id/metrics`
Returns metrics for a specific article.

**Response:**
```json
{
  "articleId": 348,
  "views": 8,
  "downloads": 3,
  "viewsByCountry": [
    { "country_id": "TZ", "total": 3 },
    { "country_id": "KE", "total": 1 }
  ],
  "downloadsByCountry": [
    { "country_id": "TZ", "total": 1 }
  ],
  "hasRealCountryData": false
}
```

---

### CrossRef Citation APIs

#### `GET /api/citations`
Fetches all journal citations from CrossRef using ISSN.

**Configuration:**
```javascript
const TJPSD_ISSN = '0856-0226';
const TJPSD_ONLINE_ISSN = '2961-628X';
const CROSSREF_HEADERS = { 
  'User-Agent': 'TJPSD-Analytics/1.0 (mailto:admin@tjpsd.udsm.ac.tz)' 
};
```

**Response:**
```json
{
  "totalCitations": 42,
  "totalWorks": 150,
  "articles": [
    {
      "doi": "10.56279/tjpsd.v28i2.123",
      "title": "Article Title",
      "authors": "John Doe, Jane Smith",
      "citations": 5,
      "year": 2023,
      "url": "https://doi.org/10.56279/tjpsd.v28i2.123"
    }
  ],
  "source": "CrossRef",
  "issn": "0856-0226",
  "journal": "Tanzania Journal of Population Studies and Development"
}
```

**Caching:**
- TTL: 10 minutes
- Bulk fetch up to 500 works via ISSN filter
- Sorted by citation count descending

---

#### `GET /api/article/:id/citations`
Returns citation count for a specific article.

**Logic:**
1. Get article DOI from database
2. Search cached CrossRef data for matching DOI
3. If not found, direct CrossRef API lookup
4. Return citation count

---

#### `GET /api/citations/by-country`
Returns citation distribution by country (estimated).

**Response:**
```json
[
  { "country_id": "TZ", "total": 13 },
  { "country_id": "KE", "total": 5 },
  { "country_id": "NG", "total": 4 }
]
```

---

## Frontend React Application

### Entry Point
`ojs-client/src/main.jsx`

### Components

#### `AnalyticsPanel.jsx`
Main analytics dashboard with tabbed interface.

**Tabs:**
| Tab ID | Label | Icon | Data Source |
|--------|-------|------|-------------|
| `top-cited` | All-Time Top Cited | Award | `/api/top-articles` |
| `monthly-top` | Monthly Top 10 | Calendar | `/api/top-articles` |
| `visual` | Visual Analytics | BarChart3 | `/api/metrics/monthly`, `/api/metrics/by-type` |
| `growth` | Citation Growth | TrendingUp | `/api/metrics/monthly` |
| `countries` | Readers by Country | Globe | `/api/metrics/countries` |
| `trending` | Trending Articles | Flame | `/api/trending-articles` |

**State Management:**
```javascript
const [activeTab, setActiveTab] = useState('top-cited');
const [topArticles, setTopArticles] = useState([]);
const [countries, setCountries] = useState([]);
const [monthlyData, setMonthlyData] = useState({ views: [], downloads: [] });
const [loading, setLoading] = useState(false);
```

---

#### `GlobeView.jsx`
Interactive 3D globe visualization using `react-globe.gl`.

**Features:**
- Real-time data from `/api/metrics/countries`
- Color-coded dots:
  - **Cyan (#00ffff)** - Views
  - **Yellow (#ffff00)** - Downloads
  - **Magenta (#ff00ff)** - Citations
- Auto-rotation with user interaction
- Hover tooltips with country details
- Initial view centered on Tanzania

**Country Coordinates:**
```javascript
const COUNTRY_COORDS = {
  TZ: { lat: -6.7924, lng: 39.2083, name: 'Tanzania' },
  KE: { lat: -1.2921, lng: 36.8219, name: 'Kenya' },
  // ... 40+ countries
};
```

---

## OJS Theme Integration

### Custom UDSM Theme
`tjpsd/plugins/themes/default/styles/custom-udsm.css`

**Design System:**
```css
:root {
  --udsm-navy: #0B1D32;
  --udsm-blue: #1E6292;
  --udsm-gold: #D4A843;
  --udsm-glass-bg: rgba(255, 255, 255, 0.65);
  --udsm-radius: 16px;
}
```

**Features:**
- Glassmorphism effects with backdrop-filter
- Inter font family
- Responsive design
- Dark navy header with gold accents
- Glass cards for content sections

### Analytics Iframe
`tjpsd/templates/frontend/pages/indexJournal.tpl`

```html
<iframe 
  src="http://localhost:3000" 
  style="width:100%; height:800px; border:none;"
></iframe>
```

### Article Globe
`tjpsd/templates/frontend/objects/article_details.tpl`

Embedded JavaScript globe using `globe.gl` library:
- Fetches `/api/article/:id/metrics`
- Renders views/downloads as colored dots
- Shows country flags below globe

---

## Database Schema

### Key Tables

#### `metrics`
Stores all usage metrics.

| Column | Type | Description |
|--------|------|-------------|
| `metric_id` | INT | Primary key |
| `assoc_type` | INT | Type of metric (1048585=views, 515=downloads) |
| `assoc_id` | INT | Associated object ID |
| `submission_id` | INT | Article ID |
| `context_id` | INT | Journal ID (1 for TJPSD) |
| `country_id` | VARCHAR(2) | ISO country code |
| `metric` | INT | Count value |
| `month` | VARCHAR(6) | YYYYMM format |

#### `submissions`
Article submissions.

| Column | Type | Description |
|--------|------|-------------|
| `submission_id` | INT | Primary key |
| `status` | INT | 3 = published |
| `context_id` | INT | Journal ID |
| `current_publication_id` | INT | FK to publications |

#### `publications`
Published versions of submissions.

#### `publication_settings`
Article metadata (title, DOI, etc.)

| setting_name | Description |
|--------------|-------------|
| `title` | Article title |
| `pub-id::doi` | DOI identifier |

#### `issues`
Journal issues.

| Column | Type | Description |
|--------|------|-------------|
| `issue_id` | INT | Primary key |
| `published` | TINYINT | 1 = published |
| `journal_id` | INT | Journal ID |

---

## Globe Visualization

### Dashboard Globe (`GlobeView.jsx`)

**Data Flow:**
```
1. Component mounts
2. Fetch /api/metrics/countries
3. Fetch /api/citations (CrossRef)
4. Fetch /api/citations/by-country
5. Map country_id to coordinates
6. Create point objects with lat, lng, color, size
7. Render globe with pointsData
```

**Point Sizing:**
```javascript
size: Math.max(0.5, (count / maxCount) * 2.0)
```

### Article Globe (`article_details.tpl`)

**Embedded in OJS template using vanilla JS:**
```javascript
var globe = Globe()
  .globeImageUrl('https://unpkg.com/three-globe/example/img/earth-blue-marble.jpg')
  .pointsData(pointsData)
  .pointColor('color')
  .pointRadius(d => d.size)
  (container);
```

---

## CrossRef Integration

### ISSN-Based Bulk Fetch
Instead of fetching citations per-article, we fetch all journal works at once:

```javascript
const url = `https://api.crossref.org/works?filter=issn:${TJPSD_ISSN}&rows=100&offset=${offset}`;
```

### Caching Strategy
```javascript
let crossrefCache = { data: null, timestamp: 0 };
const CROSSREF_CACHE_TTL = 10 * 60 * 1000; // 10 minutes

async function fetchCrossRefData() {
  const now = Date.now();
  if (crossrefCache.data && (now - crossrefCache.timestamp) < CROSSREF_CACHE_TTL) {
    return crossrefCache.data;
  }
  // ... fetch fresh data
  crossrefCache = { data: result, timestamp: now };
}
```

### Rate Limiting
CrossRef requires polite User-Agent:
```javascript
const CROSSREF_HEADERS = { 
  'User-Agent': 'TJPSD-Analytics/1.0 (mailto:admin@tjpsd.udsm.ac.tz)' 
};
```

---

## Running the Project

### Prerequisites
- Node.js v18+
- MySQL/MariaDB
- PHP 7.4+ (for OJS)

### 1. Database Setup
```bash
mysql -u root -p < tjpsd32.sql
```

### 2. Start Express API Server
```bash
cd ojs-client
npm install
npm run server
# Running at http://localhost:3001
```

### 3. Start React Dev Server
```bash
cd ojs-client
npm run dev
# Running at http://localhost:3000
```

### 4. Start OJS PHP Server
```bash
cd tjpsd
php -S localhost:8000
# Running at http://localhost:8000
```

### All-in-One (with concurrently)
```bash
cd ojs-client
npm run dev:all
```

---

## Configuration

### Vite Config (`vite.config.js`)
```javascript
export default defineConfig({
  plugins: [react(), tailwindcss()],
  server: {
    port: 3000,
    strictPort: true,  // Don't fallback to other ports
    cors: true,
  },
});
```

### OJS Config (`config.inc.php`)
```php
[database]
driver = mysqli
host = localhost
username = root
password = 
name = tjpsd32
```

### Environment Variables (if needed)
```env
API_BASE=http://localhost:3001
CROSSREF_EMAIL=admin@tjpsd.udsm.ac.tz
```

---

## Troubleshooting

### "Loading metrics..." stuck on article page
- Check Express server is running on port 3001
- Check browser console for CORS errors
- Verify article ID exists in database

### Globe shows no dots
- Check `/api/metrics/countries` returns data
- Verify country codes match `COUNTRY_COORDS` mapping
- Check browser console for coordinate lookup failures

### Analytics tab unstyled
- Ensure `@import "tailwindcss";` is in `index.css`
- Verify Vite dev server is on port 3000
- Check iframe URL in `indexJournal.tpl`

### CrossRef returns 0 citations
- Verify ISSN is correct (0856-0226)
- Check CrossRef API response in server logs
- Some articles may not have DOIs registered

---

## License

This project was developed for the UDSM Hackathon 2026.

**Journal:** Tanzania Journal of Population Studies and Development  
**Institution:** University of Dar es Salaam  
**ISSN:** 0856-0226 (Print), 2961-628X (Online)
