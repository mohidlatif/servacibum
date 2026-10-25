(function () {
  "use strict";

  const app = document.getElementById("app");

  if (!app) {
    return;
  }

  const settings = {
    siteName: "ServaCibum",
    tagline: "Community food rescue platform.",
    slogan: "Good for People. Better for the Planet.",
    description:
      "Connecting food donors, volunteers, and charities to reduce food waste and help communities across Sugar Land."
  };

  const navigation = [
    "Dashboard",
    "Donate Food",
    "Request Food",
    "Map",
    "Volunteer Network",
    "About Us",
    "Terms of Use",
    "Privacy"
  ];

  let liveData = null;

  function escapeHtml(value) {
    return String(value ?? "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }


  /*
   * Impact panel
   * ------------------------------------------------------------------
   * Public homepage shows totals only. No donor, charity, or volunteer
   * names are ever requested or displayed here.
   */

  /*
   * Icons use the same style as the rest of the site (About Us page):
   * green outline strokes, 2px, rounded ends, no fill.
   * Food Donors, Partner Charities, Volunteers and Completed Donations
   * reuse the exact drawings from about-us.php so the theme matches.
   */
  const impactIcons = {
    // Package outline
    box:
      '<svg viewBox="0 0 24 24">' +
        '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"/>' +
        '<path d="M4 7.5l8 4.5 8-4.5"/>' +
        '<path d="M12 12v9"/>' +
      '</svg>',
    // Check circle (same as "The handoff is verified" on About Us)
    check:
      '<svg viewBox="0 0 24 24">' +
        '<circle cx="12" cy="12" r="9"/>' +
        '<path d="M8 12l2.5 2.5L16.5 8.5"/>' +
      '</svg>',
    // Hand holding out a heart (Completed Donations): solid shapes,
    // hand in the site green, heart in red. Drawn for ServaCibum.
    handHeart:
      '<svg class="impact-icon-lg" viewBox="1.6 2.3 20.6 19.4">' +
        '<path fill="#e5484d" stroke="none" d="M13 11.4C9.3 8.9 8.1 7 8.1 5.2C8.1 3.7 9.3 2.6 10.7 2.6C11.7 2.6 12.5 3.2 13 4.1C13.5 3.2 14.3 2.6 15.3 2.6C16.7 2.6 17.9 3.7 17.9 5.2C17.9 7 16.7 8.9 13 11.4Z"/>' +
        '<path fill="#158447" stroke="none" d="M6.9 14.7C8.9 13.4 11 12.9 13.1 13.2L16.3 13.6C17.6 13.8 17.7 15.5 16.4 15.7L13.2 15.9C15.6 16.1 17.9 15.3 20 13.9C21.1 13.2 22.1 14.4 21.2 15.3C18.9 17.7 16 19 12.7 19H9.4L8.9 19.1Z"/>' +
        '<path fill="none" stroke="#ffffff" stroke-width="0.55" stroke-linecap="round" d="M11.4 15.95L16.3 15.72"/>' +
        '<path fill="#158447" stroke="none" d="M2.3 16.6L5.1 14.8C5.4 14.6 5.8 14.7 6 15L8 18.6C8.2 18.9 8.1 19.3 7.8 19.5L5 21.3C4.7 21.5 4.3 21.4 4.1 21.1L2.1 17.5C1.9 17.2 2 16.8 2.3 16.6Z"/>' +
      '</svg>',
    // Storefront (same as "Food Donors" on About Us)
    store:
      '<svg viewBox="0 0 24 24">' +
        '<path d="M3 10h18"/><path d="M5 10V5h14v5"/><path d="M6 10v9h12v-9"/><path d="M9 19v-5h6v5"/>' +
        '<path d="M4 10c0 2 3 2 3 0"/><path d="M7 10c0 2 3 2 3 0"/><path d="M10 10c0 2 4 2 4 0"/>' +
        '<path d="M14 10c0 2 3 2 3 0"/><path d="M17 10c0 2 3 2 3 0"/>' +
      '</svg>',
    // Building with columns (same as "Charity Partners" on About Us)
    charity:
      '<svg viewBox="0 0 24 24">' +
        '<path d="M3 9h18"/><path d="M5 9v8"/><path d="M9 9v8"/><path d="M15 9v8"/><path d="M19 9v8"/>' +
        '<path d="M3 17h18"/><path d="M2 20h20"/><path d="M12 3l9 4H3l9-4z"/>' +
      '</svg>',
    // Group of people (same as "Volunteers" on About Us)
    people:
      '<svg viewBox="0 0 24 24">' +
        '<circle cx="12" cy="8" r="3"/><path d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/>' +
        '<path d="M5 11a2.5 2.5 0 1 1 0-5"/><path d="M19 11a2.5 2.5 0 1 0 0-5"/>' +
        '<path d="M2 19c0-2.4 1.7-4.4 4-4.9"/><path d="M22 19c0-2.4-1.7-4.4-4-4.9"/>' +
      '</svg>',
    // Leaf outline with centre vein
    leaf:
      '<svg viewBox="0 0 24 24">' +
        '<path d="M5 19c0-8.2 5.6-13.6 15-14 .3 9.4-5.3 15-14 15"/>' +
        '<path d="M5 19l8-8"/>' +
      '</svg>'
  };

  function countOrDash(value) {
    if (value === null || value === undefined || value === "") {
      return "—";
    }

    const number = Number(value);

    return Number.isFinite(number)
      ? number.toLocaleString("en-US")
      : "—";
  }

  function impactMetrics() {
    if (!liveData) {
      return {
        loaded: false,
        wasteTracked: false,
        items: [
          ["—", "Available Donations", "box"],
          ["—", "Completed Donations", "handHeart"],
          ["—", "Food Donors", "store"],
          ["—", "Partner Charities", "charity"],
          ["—", "Volunteers", "people"],
          ["—", "Bio Waste Avoided / Month", "leaf"]
        ]
      };
    }

    const impact = liveData.impact || {};

    /*
     * Fallback for older bootstrap.php responses without "impact":
     * count the anonymous placeholder arrays instead.
     */
    const arrayLength = key =>
      Array.isArray(liveData[key]) ? liveData[key].length : null;

    const available =
      impact.available_donations ?? arrayLength("foodListings");

    const donors =
      impact.food_donors ?? arrayLength("restaurants");

    const charities =
      impact.partner_charities ?? arrayLength("charities");

    /*
     * Food rescued this month, shown in pounds (US unit).
     * Newer bootstrap.php sends waste_lbs_month; an older one sent
     * waste_kg_month, which is converted here so either version works.
     */
    let waste = impact.waste_lbs_month;

    if (
      (waste === null || waste === undefined) &&
      impact.waste_kg_month !== null &&
      impact.waste_kg_month !== undefined
    ) {
      waste = Math.round(Number(impact.waste_kg_month) * 2.20462 * 10) / 10;
    }

    const wasteTracked =
      waste !== null &&
      waste !== undefined &&
      Number.isFinite(Number(waste));

    const wasteValue = wasteTracked ? Number(waste) : 0;

    return {
      loaded: true,
      wasteTracked,
      items: [
        [countOrDash(available), "Available Donations", "box"],
        [countOrDash(impact.completed_donations), "Completed Donations", "handHeart"],
        [countOrDash(donors), "Food Donors", "store"],
        [countOrDash(charities), "Partner Charities", "charity"],
        [countOrDash(impact.volunteers), "Volunteers", "people"],
        [
          // Always show the unit. No weighed rescue yet this month = 0 lbs.
          wasteValue.toLocaleString("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }) + " lbs",
          "Bio Waste Avoided / Month",
          "leaf"
        ]
      ]
    };
  }

  function renderImpactPanel() {
    const metrics = impactMetrics();

    return `
      <article
        class="panel impact-panel"
        aria-labelledby="impactTitle"
      >

        <div class="panel-header">
          <strong id="impactTitle">Impact</strong>
        </div>

        <div class="impact-grid">

          ${metrics.items
            .map(
              ([value, label, icon]) => `
                <div class="impact-item">

                  <span
                    class="impact-icon"
                    aria-hidden="true"
                  >
                    ${impactIcons[icon] || ""}
                  </span>

                  <div class="impact-copy">
                    <span class="impact-value">
                      ${escapeHtml(value)}
                    </span>
                    <span class="impact-label">
                      ${escapeHtml(label)}
                    </span>
                  </div>

                </div>
              `
            )
            .join("")}

        </div>

      </article>
    `;
  }

  function renderDashboard() {
    return `
      <section id="dashboard">

        <section class="hero">

          <div class="hero-content">

            <div class="hero-copy">

              <h1>
                ${escapeHtml(
                  settings.slogan
                )}
              </h1>

              <p>
                ${escapeHtml(
                  settings.description
                )}
              </p>

            </div>

          </div>

        </section>

        <section
          class="
            dashboard-grid
            public-dashboard-grid
          "
        >

          ${renderImpactPanel()}

          <article
            class="panel map-panel"
          >

            <div class="panel-header">

              <strong>
                ServaCibum Service Area
              </strong>

              <a
                href="
                  https://www.google.com/maps/search/?api=1&query=Sugar+Land+TX
                "
                target="_blank"
                rel="noopener"
              >
                View Full Map
              </a>

            </div>

            <iframe
              class="map-frame"
              title="
                Sugar Land pickup
                and delivery map
              "
              loading="lazy"
              referrerpolicy="
                no-referrer-when-downgrade
              "
              src="
                https://www.google.com/maps?q=Sugar+Land,+TX&output=embed
              "
            ></iframe>

            <div class="route-footer">

              <div>

                <strong>
                  Serving Sugar Land
                </strong>

                <br>

                <span>
                  Pickup and delivery routes
                  are provided after a rescue
                  is assigned.
                </span>

              </div>

              <button
                class="route-button"
                id="routeButton"
              >
                Open Area Map
              </button>

            </div>

          </article>

        </section>

      </section>
    `;
  }

  function renderShell() {
    app.innerHTML = `
      <div class="app-shell">

        <header class="topbar">

          <a
            class="brand"
            href="./"
            aria-label="ServaCibum home"
          >

            <img
              class="brand-logo"
              src="
                ./assets/servacibum-logo.png
              "
              alt="ServaCibum"
            >

            <div class="brand-copy">

              <strong>
                ${escapeHtml(
                  settings.siteName
                )}
              </strong>

              <span>
                ${escapeHtml(
                  settings.tagline
                )}
              </span>

            </div>

          </a>

          <nav class="topnav">

            ${navigation
              .map(
                name => `
                  <button
                    class="
                      nav-button
                      ${
                        name === "Dashboard"
                          ? "active"
                          : ""
                      }
                    "
                    data-page="${
                      escapeHtml(name)
                    }"
                    ${name === "About Us" ? 'data-about-us-link="built-in"' : name === "Terms of Use" ? 'data-terms-link="built-in"' : name === "Privacy" ? 'data-privacy-link="built-in"' : ""}
                  >
                    ${escapeHtml(name)}
                  </button>
                `
              )
              .join("")}

          </nav>

          <a
            href="./get-involved.php"
            style="
              display:inline-flex;
              align-items:center;
              justify-content:center;
              padding:11px 24px;
              background:#158447;
              color:#fff;
              border-radius:9px;
              font-weight:800;
              text-decoration:none;
              white-space:nowrap;
            "
          >
            Get Involved
          </a>

        </header>

        <div class="body-grid">

          <aside class="sidebar">

            <nav class="sidebar-nav">

              ${navigation
                .map(
                  name => `
                    <button
                      class="${
                        name === "Dashboard"
                          ? "active"
                          : ""
                      }"
                      data-page="${
                        escapeHtml(name)
                      }"
                    ${name === "About Us" ? 'data-about-us-link="built-in"' : name === "Terms of Use" ? 'data-terms-link="built-in"' : name === "Privacy" ? 'data-privacy-link="built-in"' : ""}
                    >
                      ${escapeHtml(name)}
                    </button>
                  `
                )
                .join("")}

            </nav>

          </aside>

          <main class="main">

            ${renderDashboard()}

            <section
              id="page"
              class="page"
              hidden
            ></section>

          </main>

        </div>

        <footer
          style="
            padding:18px 20px 22px;
            text-align:center;
            color:#748279;
            font-size:11px;
            line-height:1.5;
          "
        >
          <span>
            ServaCibum · Serving Sugar Land, Texas ·
          </span>

          <a
            href="mailto:applications@servacibum.org"
            style="
              color:#587066;
              font-weight:700;
              text-decoration:none;
            "
          >
            Contact
          </a>
        </footer>

      </div>
    `;

    bindNavigation();
    bindMapButton();
  }

  function bindNavigation() {
    document
      .querySelectorAll(
        "[data-page]"
      )
      .forEach(element => {

        element.addEventListener(
          "click",
          event => {

            event.preventDefault();

            const page =
              element.dataset.page;

            /*
             * Public navigation enters
             * each secure portal at its
             * HOME page first.
             */

            if (
              page === "Donate Food"
            ) {
              window.location.href =
                "./donor/index.php";

              return;
            }

            if (
              page === "Request Food"
            ) {
              window.location.href =
                "./charity/index.php";

              return;
            }

            if (
              page ===
              "Volunteer Network"
            ) {
              window.location.href =
                "./volunteer/index.php";

              return;
            }

            if (page === "About Us") {
              window.location.href = "./about-us.php";
              return;
            }

            if (page === "Terms of Use") {
              window.location.href = "./terms-of-use.php";
              return;
            }

            if (page === "Privacy") {
              window.location.href = "./privacy.php";
              return;
            }

            showPage(page);
          }
        );

      });
  }

  function bindMapButton() {
    const button =
      document.getElementById(
        "routeButton"
      );

    if (!button) {
      return;
    }

    button.addEventListener(
      "click",
      () => {

        window.open(
          "https://www.google.com/maps/search/?api=1&query=Sugar+Land+TX",
          "_blank",
          "noopener"
        );

      }
    );
  }

  function showPage(pageName) {
    document
      .querySelectorAll(
        "[data-page]"
      )
      .forEach(element => {

        element.classList.toggle(
          "active",
          element.dataset.page ===
            pageName
        );

      });

    const dashboard =
      document.getElementById(
        "dashboard"
      );

    const page =
      document.getElementById(
        "page"
      );

    if (!dashboard || !page) {
      return;
    }

    if (
      pageName === "Dashboard"
    ) {
      dashboard.hidden = false;
      page.hidden = true;
      return;
    }

    if (
      pageName === "Map"
    ) {
      dashboard.hidden = true;
      page.hidden = false;

      page.innerHTML = `
        <h2>
          Service Area Map
        </h2>

        <p>
          ServaCibum currently supports
          food rescue activity across
          the Sugar Land area.
        </p>

        <iframe
          class="map-frame"
          title="
            Sugar Land food rescue map
          "
          loading="lazy"
          referrerpolicy="
            no-referrer-when-downgrade
          "
          src="
            https://www.google.com/maps?q=Sugar+Land,+TX&output=embed
          "
          style="
            width:100%;
            min-height:420px;
            border:0;
            border-radius:10px;
          "
        ></iframe>

        <p>

          <a
            href="
              https://www.google.com/maps/search/?api=1&query=Sugar+Land+TX
            "
            target="_blank"
            rel="noopener"
            style="
              display:inline-block;
              margin-top:10px;
              color:#158447;
              font-weight:800;
            "
          >
            Open Service Area
            in Google Maps
          </a>

        </p>
      `;

      return;
    }

    dashboard.hidden = false;
    page.hidden = true;
  }

  function cleanPublicDescription(
    description
  ) {
    return String(
      description || ""
    )
      .replace(
        /\brestaurants\b/gi,
        "food donors"
      )
      .replace(
        /\brestaurant partners\b/gi,
        "food donor partners"
      );
  }

  function installPublicLayoutFixes() {
    const style =
      document.createElement(
        "style"
      );

    style.textContent = `
      @media (min-width:1121px) {

        .public-dashboard-grid {
          grid-template-columns:
            minmax(0,.92fr)
            minmax(0,1.08fr);
        }

      }

      /*
       * Impact panel (replaces the old Food Donor Partners list).
       * Styled to match the rest of the site:
       *  - white panel + header bar identical to the Service Area map panel
       *  - green cards with white icon circles, exactly like the About Us
       *    cards (.about-card / .about-card-icon: #158447, 42px circle,
       *    23px outline icon, 2px rounded strokes)
       */

      .public-dashboard-grid {
        margin-top: 12px;
      }

      .impact-panel {
        display: flex;
        flex-direction: column;
      }

      /* Map panel title: a little larger, in the site's heading green */
      .public-dashboard-grid .panel-header strong {
        color: #153a28;
        font-size: 15px;
        font-weight: 800;
      }

      /* Big, bold "Impact" heading with no divider line */
      .impact-panel .panel-header {
        height: auto;
        min-height: 0;
        padding: 20px 16px 2px;
        border-bottom: 0;
      }

      /* Same font style as the "ServaCibum" name in the top-left header
         (.brand-copy strong in site.css): weight 800, #153a28, normal
         letter spacing. Only the size is larger. */
      .impact-panel .panel-header strong {
        color: #153a28;
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: normal;
      }

      .impact-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-content: center;
        gap: 12px;
        padding: 14px;
      }

      .impact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 14px;
        background: #158447;
        border-radius: 14px;
        color: #ffffff;
      }

      .impact-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #ffffff;
        color: #158447;
      }

      .impact-icon svg {
        display: block;
        width: 23px;
        height: 23px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
      }

      /* The filled hand-and-heart icon is wider than the outline icons,
         so it is drawn larger to match their visual size. */
      .impact-icon svg.impact-icon-lg {
        width: 28px;
        height: 28px;
      }

      .impact-copy {
        min-width: 0;
      }

      .impact-value {
        display: block;
        color: #ffffff;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.05;
        font-variant-numeric: tabular-nums;
      }

      .impact-label {
        display: block;
        margin-top: 3px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.3;
      }

      /* Phones */
      @media (max-width: 700px) {
        .impact-grid {
          gap: 9px;
          padding: 10px;
        }

        .impact-item {
          gap: 10px;
          padding: 12px 10px;
          border-radius: 12px;
        }

        .impact-value {
          font-size: 22px;
        }

        .impact-panel .panel-header {
          padding: 16px 12px 0;
        }

        .impact-panel .panel-header strong {
          font-size: 26px;
        }
      }

      /* Common Android width (360px): keep two columns, smaller icon */
      @media (max-width: 400px) {
        .impact-grid {
          gap: 8px;
          padding: 8px;
        }

        .impact-item {
          gap: 8px;
          padding: 11px 8px;
        }

        .impact-icon {
          width: 34px;
          height: 34px;
          flex-basis: 34px;
        }

        .impact-icon svg {
          width: 19px;
          height: 19px;
        }

        .impact-icon svg.impact-icon-lg {
          width: 23px;
          height: 23px;
        }

        .impact-value {
          font-size: 20px;
        }

        .impact-label {
          font-size: 12px;
        }
      }

      /* Only very narrow screens (older small phones) go single-column */
      @media (max-width: 339px) {
        .impact-grid {
          grid-template-columns: minmax(0, 1fr);
        }
      }
    `;

    document.head.appendChild(
      style
    );
  }

  async function loadLiveData() {
    try {

      const response =
        await fetch(
          "./api/bootstrap.php",
          {
            cache: "no-store"
          }
        );

      if (!response.ok) {
        return;
      }

      liveData =
        await response.json();

      if (
        liveData.settings
      ) {

        settings.siteName =
          liveData.settings
            .site_name ||
          settings.siteName;

        settings.tagline =
          liveData.settings
            .header_tagline ||
          settings.tagline;

        settings.slogan =
          liveData.settings
            .slogan ||
          settings.slogan;

        if (
          liveData.settings
            .homepage_description
        ) {

          settings.description =
            cleanPublicDescription(
              liveData.settings
                .homepage_description
            );

        }
      }

      renderShell();

    } catch (error) {

      console.error(
        "Could not load ServaCibum data:",
        error
      );

    }
  }

  installPublicLayoutFixes();
  renderShell();
  loadLiveData();

})();
