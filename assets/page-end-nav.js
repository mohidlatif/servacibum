/* Simple end-of-page links for public ServaCibum pages. */
(function () {
  "use strict";

  function initialize() {
    if (document.getElementById("servacibum-page-end-nav")) return;

    const nav = document.createElement("nav");
    nav.id = "servacibum-page-end-nav";
    nav.setAttribute("aria-label", "Page navigation");
    nav.style.cssText = "display:flex;flex-wrap:wrap;justify-content:center;gap:20px;margin:24px auto;padding:12px 16px;text-align:center;font:500 14px/1.5 system-ui,sans-serif;";

    const back = document.createElement("a");
    back.href = "/";
    back.textContent = "← Back to Previous Page";
    back.style.cssText = "color:#123f2b;text-decoration:underline;text-underline-offset:3px;";
    back.addEventListener("click", function (event) {
      // Use history only when a same-origin previous page can be verified.
      let sameSitePreviousPage = false;
      try {
        sameSitePreviousPage = !!document.referrer &&
          new URL(document.referrer).origin === window.location.origin;
      } catch (_) {}

      if (sameSitePreviousPage && window.history.length > 1) {
        event.preventDefault();
        window.history.back();
      }
      // Otherwise the link goes to the homepage.
    });

    const top = document.createElement("a");
    top.href = "#";
    top.textContent = "↑ Back to Top";
    top.style.cssText = "color:#123f2b;text-decoration:underline;text-underline-offset:3px;";
    top.addEventListener("click", function (event) {
      event.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches
          ? "auto" : "smooth"
      });
    });

    nav.appendChild(back);
    nav.appendChild(top);
    const footer = document.querySelector("footer:last-of-type");
    if (footer && footer.parentNode) footer.parentNode.insertBefore(nav, footer);
    else document.body.appendChild(nav);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initialize);
  } else {
    initialize();
  }
})();
