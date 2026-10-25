(function () {
  "use strict";

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  var style = document.createElement("style");
  style.textContent =
    ".sc-scrollnav{position:fixed;right:16px;bottom:16px;bottom:calc(16px + env(safe-area-inset-bottom));" +
    "z-index:999;display:flex;align-items:stretch;border-radius:999px;overflow:hidden;" +
    "background:#123f2b;box-shadow:0 6px 20px rgba(18,63,43,.32);" +
    "opacity:0;transform:translateY(10px);pointer-events:none;transition:opacity .2s ease,transform .2s ease}" +
    ".sc-scrollnav.sc-show{opacity:1;transform:translateY(0);pointer-events:auto}" +
    ".sc-scrollnav button{border:0;background:transparent;color:#fff;display:flex;align-items:center;" +
    "gap:7px;padding:0 16px;height:48px;font:700 12px/1 system-ui,-apple-system,sans-serif;cursor:pointer;" +
    "white-space:nowrap}" +
    ".sc-scrollnav button:active{background:rgba(255,255,255,.14)}" +
    ".sc-scrollnav .sc-divider{width:1px;background:rgba(255,255,255,.22);align-self:stretch;margin:8px 0}" +
    ".sc-scrollnav svg{width:18px;height:18px;flex:0 0 auto}" +
    ".sc-scrollnav .sc-label{display:none}" +
    "@media (min-width:480px){.sc-scrollnav .sc-label{display:inline}}";
  document.head.appendChild(style);

  var nav = document.createElement("div");
  nav.className = "sc-scrollnav";
  nav.innerHTML =
    '<button type="button" class="sc-nav-back" aria-label="Go back">' +
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>' +
      '<span class="sc-label">Back</span>' +
    "</button>" +
    '<span class="sc-divider" aria-hidden="true"></span>' +
    '<button type="button" class="sc-nav-top" aria-label="Back to top">' +
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg>' +
      '<span class="sc-label">Top</span>' +
    "</button>";
  document.body.appendChild(nav);

  function toggle() {
    if (window.scrollY > 400) {
      nav.classList.add("sc-show");
    } else {
      nav.classList.remove("sc-show");
    }
  }
  window.addEventListener("scroll", toggle, { passive: true });
  toggle();

  nav.querySelector(".sc-nav-top").addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: reduceMotion ? "auto" : "smooth" });
  });

  nav.querySelector(".sc-nav-back").addEventListener("click", function () {
    var cameFromSite = false;
    try {
      cameFromSite =
        !!document.referrer &&
        new URL(document.referrer).origin === window.location.origin;
    } catch (_) {}

    if (cameFromSite && window.history.length > 1) {
      window.history.back();
    } else {
      window.location.href = "/";
    }
  });
})();