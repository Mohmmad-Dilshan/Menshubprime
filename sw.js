const CACHE_NAME = 'menshub-v3';
const ASSETS = [
  '/assets/css/main_v2.css',
  '/assets/js/home.js',
  '/favicon/site.webmanifest'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(ASSETS);
    }).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  // Skip cross-origin or non-GET requests for now to prevent errors
  if (event.request.method !== 'GET') return;

  // Strategy: Stale-while-revalidate for assets
  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      const url = new URL(event.request.url);
      const isHttp = url.protocol === 'http:' || url.protocol === 'https:';

      const networkFetch = fetch(event.request).then(response => {
        // Only cache valid basic or cors responses from http/https protocols
        if (isHttp && response && response.status === 200 && (response.type === 'basic' || response.type === 'cors')) {
          const responseToCache = response.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseToCache);
          });
        }
        return response;
      }).catch(() => {
        return cachedResponse;
      });

      return cachedResponse || networkFetch;
    })
  );
});
