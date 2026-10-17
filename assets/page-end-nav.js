/* ServaCibum public-page end navigation. */
(function () {
  "use strict";
  function initialize() {
    if (document.getElementById("servacibum-page-end-nav")) return;
    var container = document.createElement("nav");
    container.id = "servacibum-page-end-nav";
    container.setAttribute("aria-label", "End of page navigation");
    container.style.cssText = "display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:12px;max-width:1100px;margin:28px auto 24px;padding:16px;box-sizing:border-box;";
    var home = document.createElement("a");
    home.href = "/";
    home.textContent = "← ServaCibum Home";
    home.style.cssText = "display:inline-flex;justify-content:center;align-items:center;min-height:44px;padding:10px 18px;border-radius:10px;background:#123f2b;color:#fff;text-decoration:none;font:700 15px/1.3 system-ui,sans-serif;";
    var top = document.createElement("button");
    top.type = "button";
    top.textContent = "↑ Back to Top";
    top.setAttribute("aria-label", "Back to top of page");
    top.style.cssText = "display:inline-flex;justify-content:center;align-items:center;min-height:44px;padding:10px 18px;border:1px solid #123f2b;border-radius:10px;background:#fff;color:#123f2b;cursor:pointer;font:700 15px/1.3 system-ui,sans-serif;";
    top.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "instant" : "smooth" });
    });
    container.appendChild(home);
    container.appendChild(top);
    var footer = document.querySelector("footer:last-of-type");
    if (footer && footer.parentNode) footer.parentNode.insertBefore(container, footer);
    else document.body.appendChild(container);
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", initialize);
  else initialize();
})();
