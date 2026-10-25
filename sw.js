/* ServaCibum site-wide PWA service worker.
 * Deliberately does NOT cache authenticated PHP portals or API responses.
 * This avoids stale donor/charity/volunteer pages and stale account data.
 */
const CACHE_NAME = 'servacibum-pwa-shell-v1-20261018';
const SHELL_FILES = [
  '/offline.html',
  '/manifest.webmanifest',
  '/pwa/icon-192.png',
  '/pwa/icon-512.png',
  '/pwa/apple-touch-icon.png'
];

self.addEventListener('install', event => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(SHELL_FILES))
      .catch(() => {})
  );
});

self.addEventListener('activate', event => {
  event.waitUntil((async () => {
    const keys = await caches.keys();
    await Promise.all(
      keys
        .filter(key =>
          (key.startsWith('servacibum-pwa-') ||
           key.startsWith('servacibum-volunteer-')) &&
          key !== CACHE_NAME
        )
        .map(key => caches.delete(key))
    );

    if (self.registration.navigationPreload) {
      try {
        await self.registration.navigationPreload.enable();
      } catch (_) {}
    }

    await self.clients.claim();
  })());
});

self.addEventListener('fetch', event => {
  const request = event.request;

  if (request.method !== 'GET') return;

  const url = new URL(request.url);
  if (url.origin !== self.location.origin) return;

  /* Never intercept dynamic/authenticated areas. Browser handles them normally. */
  const dynamicPrefixes = [
    '/admin/',
    '/api/',
    '/donor/',
    '/charity/',
    '/volunteer/'
  ];

  if (
    dynamicPrefixes.some(prefix => url.pathname.startsWith(prefix)) ||
    url.pathname.endsWith('.php')
  ) {
    return;
  }

  /* Always try the network first for the public homepage. */
  if (request.mode === 'navigate') {
    event.respondWith((async () => {
      try {
        const preload = await event.preloadResponse;
        if (preload) return preload;

        return await fetch(request, { cache: 'no-store' });
      } catch (_) {
        return (await caches.match('/offline.html')) || Response.error();
      }
    })());
    return;
  }

  /* Only cache the small PWA shell. Public JS/CSS remain browser/network managed. */
  if (
    url.pathname === '/manifest.webmanifest' ||
    url.pathname === '/offline.html' ||
    url.pathname.startsWith('/pwa/')
  ) {
    event.respondWith((async () => {
      const cached = await caches.match(request);
      if (cached) return cached;

      const response = await fetch(request);
      if (response && response.ok) {
        const copy = response.clone();
        caches.open(CACHE_NAME).then(cache => cache.put(request, copy));
      }
      return response;
    })());
  }
});

self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
