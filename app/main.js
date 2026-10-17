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

  const donorImages = [
    "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=240&h=180&q=80",
    "https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=240&h=180&q=80",
    "https://images.unsplash.com/photo-1555396273-367ea4eb4db5d8?auto=format&fit=crop&w=240&h=180&q=80",
    "https://images.unsplash.com/photo-1559329007-40df8a9345d8?auto=format&fit=crop&w=240&h=180&q=80"
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

  function formatQuantity(value) {
    const raw = String(value ?? "").trim();

    if (raw === "") {
      return "";
    }

    const number = Number(raw);

    if (!Number.isFinite(number)) {
      return raw;
    }

    return String(number);
  }

  function donorImage(name) {
    const text = String(name || "food donor");
    let hash = 0;

    for (let i = 0; i < text.length; i += 1) {
      hash = ((hash << 5) - hash) + text.charCodeAt(i);
      hash |= 0;
    }

    return donorImages[
      Math.abs(hash) % donorImages.length
    ];
  }

  function donorLocation(item) {
    const city = String(
      item.restaurant_city ||
      item.city ||
      ""
    ).trim();

    const state = String(
      item.restaurant_state ||
      item.state ||
      ""
    ).trim();

    const zip = String(
      item.restaurant_zip ||
      item.zip ||
      ""
    ).trim();

    const cityState = [
      city,
      state
    ]
      .filter(Boolean)
      .join(", ");

    return [
      cityState,
      zip
    ]
      .filter(Boolean)
      .join(" ") || "Pickup area pending";
  }

  function priorityLabel(urgency) {
    switch (
      String(urgency || "medium").toLowerCase()
    ) {
      case "low":
        return "Flexible";

      case "high":
        return "Time-Sensitive";

      default:
        return "Standard";
    }
  }

  function countMetrics() {
    if (!liveData) {
      return [
        ["—", "Available Donations"],
        ["—", "Food Donors"],
        ["—", "Partner Charities"],
        ["—", "Completed Deliveries"]
      ];
    }

    const listings =
      Array.isArray(liveData.foodListings)
        ? liveData.foodListings
        : [];

    const donors =
      Array.isArray(liveData.restaurants)
        ? liveData.restaurants
        : [];

    const charities =
      Array.isArray(liveData.charities)
        ? liveData.charities
        : [];

    const availableDonations =
      listings.filter(item =>
        item.status === "active" ||
        item.status === "available"
      ).length;

    const activeDonors =
      donors.filter(
        item => item.status !== "archived"
      ).length;

    const activeCharities =
      charities.filter(
        item => item.status !== "archived"
      ).length;

    const completedDeliveries =
      listings.filter(
        item =>
          item.status === "delivered" ||
          item.status === "completed"
      ).length;

    return [
      [
        String(availableDonations),
        "Available Donations"
      ],
      [
        String(activeDonors),
        "Food Donors"
      ],
      [
        String(activeCharities),
        "Partner Charities"
      ],
      [
        String(completedDeliveries),
        "Completed Deliveries"
      ]
    ];
  }

  function currentPickups() {
    if (
      !liveData ||
      !Array.isArray(liveData.foodListings)
    ) {
      return [];
    }

    const listings =
      liveData.foodListings.filter(item => {
        return (
          item.status !== "archived" &&
          item.status !== "rejected"
        );
      });

    if (!listings.length) {
      return [];
    }

    const grouped = new Map();

    const priorityRank = {
      low: 1,
      medium: 2,
      high: 3
    };

    listings.forEach(item => {
      const donorName =
        item.restaurant_name ||
        "Food Donor Partner";

      const key = String(
        item.restaurant_id ||
        donorName
      );

      const rawQuantity =
        item.available_quantity ??
        item.quantity ??
        "";

      const amount = [
        formatQuantity(rawQuantity),
        item.unit || ""
      ]
        .filter(Boolean)
        .join(" ");

      const food = [
        item.food_name || "Food Donation",
        amount
      ]
        .filter(Boolean)
        .join(" - ");

      const urgency =
        String(
          item.urgency || "medium"
        ).toLowerCase();

      if (!grouped.has(key)) {
        grouped.set(key, {
          donorName,
          location: donorLocation(item),
          foods: [],
          count: 0,
          urgency,
          priority: priorityLabel(urgency),
          image: donorImage(donorName)
        });
      }

      const donor = grouped.get(key);

      donor.foods.push(food);
      donor.count += 1;

      const currentRank =
        priorityRank[donor.urgency] || 0;

      const newRank =
        priorityRank[urgency] || 0;

      if (newRank > currentRank) {
        donor.urgency = urgency;
        donor.priority =
          priorityLabel(urgency);
      }
    });

    return Array.from(grouped.values())
      .sort((a, b) => {
        return (
          (priorityRank[b.urgency] || 0) -
          (priorityRank[a.urgency] || 0)
        );
      })
      .slice(0, 5);
  }

  function renderPickup(item) {
    const visibleFoods =
      item.foods.slice(0, 3);

    const extraCount =
      item.foods.length -
      visibleFoods.length;

    const foodList =
      visibleFoods
        .map(food => `
          <div
            style="
              margin-top:2px;
              font-size:10px;
              line-height:1.3;
              color:#53645b;
            "
          >
            ${escapeHtml(food)}
          </div>
        `)
        .join("");

    const more =
      extraCount > 0
        ? `
          <div
            style="
              margin-top:3px;
              font-size:10px;
              font-weight:700;
              color:#158447;
            "
          >
            +${extraCount} more
          </div>
        `
        : "";

    const donationCount =
      item.count === 1
        ? "1 available donation"
        : `${item.count} available donations`;

    return `
      <div
        class="pickup-row"
        style="
          display:grid;
          grid-template-columns:
            52px minmax(0,1fr) auto;
          gap:10px;
          align-items:start;
          padding:10px 12px;
        "
      >

        <div
          class="pickup-photo"
          style="
            width:52px;
            height:46px;
            margin:0;
            overflow:hidden;
            border-radius:7px;
          "
        >
          <img
            src="${escapeHtml(item.image)}"
            alt="${escapeHtml(item.donorName)}"
            style="
              display:block;
              width:100%;
              height:100%;
              object-fit:cover;
            "
          >
        </div>

        <div
          class="pickup-details"
          style="
            min-width:0;
            margin:0;
            padding:0;
          "
        >

          <h4
            style="
              margin:0 0 2px;
              padding:0;
              font-size:12px;
              line-height:1.25;
            "
          >
            ${escapeHtml(item.donorName)}
          </h4>

          <div
            style="
              margin-bottom:3px;
              font-size:9px;
              line-height:1.3;
              color:#68776f;
            "
          >
            ${escapeHtml(item.location)}
          </div>

          ${foodList}
          ${more}

        </div>

        <div
          style="
            padding-left:8px;
            text-align:right;
            white-space:nowrap;
          "
        >

          <span
            class="urgency ${escapeHtml(
              item.urgency
            )}"
          >
            ${escapeHtml(item.priority)}
          </span>

          <div
            class="expiry"
            style="
              margin-top:6px;
              font-size:9px;
              font-weight:700;
            "
          >
            ${escapeHtml(donationCount)}
          </div>

        </div>

      </div>
    `;
  }

  function renderDashboard() {
    const metrics =
      countMetrics();

    const pickups =
      currentPickups();

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
            metric-row
            public-four-metrics
          "
        >

          ${metrics
            .map(
              ([value, label]) => `
                <article
                  class="metric-card"
                >

                  <span
                    class="metric-value"
                  >
                    ${escapeHtml(value)}
                  </span>

                  <span
                    class="metric-label"
                  >
                    ${escapeHtml(label)}
                  </span>

                  <span
                    class="metric-note"
                  >
                    ${
                      liveData
                        ? "Live data"
                        : "Loading data"
                    }
                  </span>

                </article>
              `
            )
            .join("")}

        </section>

        <section
          class="
            dashboard-grid
            public-dashboard-grid
          "
        >

                <article class="panel">

            <div class="panel-header">

              <strong>
                Food Donor Partners
              </strong>

            </div>

            <div class="pickup-list">

              ${
                pickups.length
                  ? pickups
                      .map(renderPickup)
                      .join("")
                  : `
                    <div
                      class="empty-state"
                    >
                      No food donor donations
                      are available right now.
                    </div>
                  `
              }

            </div>

          </article>

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

            const publicPages = {
              "About Us": "./about-us.php",
              "Terms of Use": "./terms-of-use.php",
              "Privacy": "./privacy.php"
            };
            if (Object.prototype.hasOwnProperty.call(publicPages, page)) {
              window.location.href = publicPages[page];
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

        .public-four-metrics {
          grid-template-columns:
            repeat(
              4,
              minmax(0,1fr)
            );
        }

        .public-dashboard-grid {
          grid-template-columns:
            minmax(0,.92fr)
            minmax(0,1.08fr);
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
