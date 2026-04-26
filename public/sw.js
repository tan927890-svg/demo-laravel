const CACHE_NAME = 'autox-v1';

const CACHE_URLS = [
  '/',
  '/admin/attendance',
  '/admin/staff/orders',
  '/admin/kpi/me',
];

// Các URL không được cache (API, chấm công)
const NO_CACHE_PATHS = [
  '/admin/attendance/checkin',
  '/admin/attendance/checkout',
  '/api/',
];

self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(CACHE_URLS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.filter(key => key !== CACHE_NAME)
            .map(key => caches.delete(key))
      )
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', e => {
  if (e.request.method !== 'GET') return;

  // Không can thiệp các URL nhạy cảm — để browser tự xử lý
  const url = new URL(e.request.url);
  const noCache = NO_CACHE_PATHS.some(path => url.pathname.startsWith(path));
  if (noCache) return;

  e.respondWith(
    fetch(e.request)
      .then(response => {
        const clone = response.clone();
        caches.open(CACHE_NAME).then(cache => cache.put(e.request, clone));
        return response;
      })
      .catch(() => caches.match(e.request))
  );
});