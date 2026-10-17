<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, viewport-fit=cover"
  >

  <meta
    name="description"
    content="Learn about ServaCibum, a student-led community food rescue platform connecting food donors, charities and volunteers."
  >

  <title>About Us · ServaCibum</title>

  <link
    rel="stylesheet"
    href="./assets/site.css?v=20260928-about1"
  >

  <style>
    :root {
      --about-green: #158447;
      --about-green-dark: #123f2b;
      --about-text: #213b2f;
      --about-muted: #65746c;
      --about-line: #dfe8e2;
      --about-soft: #f4f8f5;
      --about-soft-green: #eaf6ee;
    }

    body {
      background: #f7f9f7;
    }

    .about-header {
      min-height: 72px;
      padding: 0 28px;

      display: flex;
      align-items: center;
      justify-content: space-between;

      gap: 22px;

      background: #fff;
      border-bottom: 1px solid #e5ebe7;
    }

    .about-brand {
      display: inline-flex;
      align-items: center;

      gap: 12px;

      color: inherit;
      text-decoration: none;

      min-width: 0;
    }

    .about-brand img {
      width: 54px;
      height: 54px;

      object-fit: contain;
    }

    .about-brand-copy strong {
      display: block;

      color: var(--about-green-dark);

      font-size: 20px;
      line-height: 1.1;
    }

    .about-brand-copy span {
      display: block;

      margin-top: 3px;

      color: #65746c;

      font-size: 11px;

      white-space: nowrap;
    }

    .about-header-actions {
      display: flex;
      align-items: center;
      justify-content: flex-end;

      gap: 9px;

      flex-wrap: wrap;
    }

    .about-header-link {
      min-height: 40px;

      display: inline-flex;
      align-items: center;
      justify-content: center;

      padding: 10px 16px;

      color: #fff;
      background: var(--about-green);

      border: 1px solid var(--about-green);
      border-radius: 9px;

      font-size: 12px;
      font-weight: 800;

      text-decoration: none;

      white-space: nowrap;
    }

    .about-header-link.primary {
      color: #fff;
      background: var(--about-green);
    }

    .about-header-link:hover,
    .about-header-link.primary:hover {
      background: #116e3d;
    }

    .about-wrap {
      width: min(
        1120px,
        calc(100% - 32px)
      );

      margin: 0 auto;

      padding: 34px 0 58px;
    }

    .about-hero {
      position: relative;

      overflow: hidden;

      padding: 54px;

      border-radius: 22px;

      background-image:
        linear-gradient(
          90deg,
          rgba(7, 38, 23, .88) 0%,
          rgba(7, 38, 23, .70) 42%,
          rgba(7, 38, 23, .32) 78%,
          rgba(7, 38, 23, .22) 100%
        ),
        url("./assets/servacibum-hero.png");

      background-size: cover;
      background-position: center;

      color: #fff;

      box-shadow:
        0 18px 48px
        rgba(18, 63, 43, .12);
    }

    .about-eyebrow {
      display: inline-block;

      margin-bottom: 13px;

      color: #ccebd7;

      font-size: 11px;
      font-weight: 900;

      letter-spacing: .12em;

      text-transform: uppercase;
    }

    .about-hero h1 {
      position: relative;
      z-index: 1;

      max-width: 880px;

      margin: 0;

      font-size:
        clamp(
          34px,
          4.4vw,
          52px
        );

      line-height: 1.04;

      letter-spacing: -.03em;

      font-weight: 800;
    }

    .about-hero h1 .headline-line {
      display: block;

      white-space: nowrap;
    }

    .about-hero p {
      position: relative;
      z-index: 1;

      max-width: 760px;

      margin: 20px 0 0;

      color:
        rgba(
          255,
          255,
          255,
          .9
        );

      font-size: 16px;
      line-height: 1.75;
    }

    .about-section {
      margin-top: 28px;

      padding: 34px;

      background: #fff;

      border:
        1px solid
        var(--about-line);

      border-radius: 18px;

      box-shadow:
        0 10px 28px
        rgba(22, 58, 42, .04);
    }

    .about-section h2 {
      margin: 0;

      color: var(--about-green-dark);

      font-size: 27px;
      line-height: 1.15;
    }

    .about-section > p {
      max-width: 850px;

      margin: 13px 0 0;

      color: var(--about-muted);

      font-size: 14px;
      line-height: 1.75;
    }

    .about-grid {
      display: grid;

      grid-template-columns:
        repeat(
          3,
          1fr
        );

      gap: 15px;

      margin-top: 23px;
    }

    .about-card {
      min-height: 190px;

      padding: 22px;

      background: var(--about-soft);

      border:
        1px solid
        var(--about-line);

      border-radius: 15px;
    }

    .about-card h3 {
      margin: 17px 0 0;

      color: var(--about-text);

      font-size: 18px;
    }

    .about-card p {
      margin: 9px 0 0;

      color: var(--about-muted);

      font-size: 13px;
      line-height: 1.65;
    }

    .about-grid-green .about-card {
      background: var(--about-green);

      border-color: var(--about-green);

      box-shadow:
        0 10px 24px
        rgba(21, 132, 71, .10);
    }

    .about-grid-green .about-card h3,
    .about-grid-green .about-card p {
      color: #fff;
    }

    .about-card-icon {
      width: 42px;
      height: 42px;

      display: grid;
      place-items: center;

      color: var(--about-green);
      background: #fff;

      border-radius: 50%;
    }

    .about-card-icon svg {
      width: 23px;
      height: 23px;

      display: block;

      stroke: currentColor;
      stroke-width: 2;

      stroke-linecap: round;
      stroke-linejoin: round;

      fill: none;
    }

    .about-two-col {
      display: grid;

      grid-template-columns:
        1fr 1fr;

      gap: 18px;

      margin-top: 22px;
    }

    .about-panel {
      padding: 23px;

      background: var(--about-soft);

      border-radius: 15px;
    }

    .about-panel h3 {
      margin: 0;

      color: var(--about-text);

      font-size: 17px;
    }

    .about-panel p {
      margin: 9px 0 0;

      color: var(--about-muted);

      font-size: 13px;
      line-height: 1.7;
    }

    .about-food-list {
      margin: 13px 0 0;

      padding-left: 20px;

      color: var(--about-muted);

      font-size: 13px;
      line-height: 1.75;
    }

    .about-callout {
      margin-top: 28px;

      padding: 28px 30px;

      display: flex;
      align-items: center;
      justify-content: space-between;

      gap: 22px;

      background: #e9f6ed;

      border: 1px solid #d1e9d8;
      border-radius: 18px;
    }

    .about-callout h2 {
      margin: 0;

      color: var(--about-green-dark);

      font-size: 24px;
    }

    .about-callout p {
      margin: 8px 0 0;

      color: #567064;

      font-size: 13px;
      line-height: 1.65;
    }

    .about-callout a {
      min-height: 44px;

      display: inline-flex;
      align-items: center;
      justify-content: center;

      flex: 0 0 auto;

      padding: 12px 19px;

      color: #fff;
      background: var(--about-green);

      border-radius: 10px;

      font-weight: 850;

      text-decoration: none;

      white-space: nowrap;
    }

    .about-footer {
      margin-top: 20px;

      color: #76837d;

      font-size: 11px;
      line-height: 1.6;

      text-align: center;
    }

    .about-footer a {
      color: #587066;
      font-weight: 700;
      text-decoration: none;
    }

    .about-footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 850px) {
      .about-grid,
      .about-two-col {
        grid-template-columns: 1fr;
      }

      .about-callout {
        align-items: flex-start;
        flex-direction: column;
      }
    }

    @media (max-width: 650px) {
      .about-header {
        min-height: 66px;

        padding: 7px 10px;

        gap: 8px;
      }

      .about-brand img {
        width: 46px;
        height: 46px;
      }

      .about-brand-copy strong {
        font-size: 17px;
      }

      .about-brand-copy span {
        display: none;
      }

      .about-header-actions {
        gap: 5px;
      }

      .about-header-link {
        min-height: 35px;

        padding: 8px 10px;

        font-size: 10px;
      }

      .about-wrap {
        width:
          min(
            100% - 20px,
            1120px
          );

        padding-top: 18px;
      }

      .about-hero {
        padding: 34px 23px;

        border-radius: 16px;
      }

      .about-hero p {
        font-size: 14px;
      }

      .about-hero h1 .headline-line {
        white-space: normal;
      }

      .about-section {
        margin-top: 18px;

        padding: 23px 20px;

        border-radius: 15px;
      }

      .about-section h2 {
        font-size: 23px;
      }

      .about-card {
        min-height: 0;
      }

      .about-callout {
        margin-top: 18px;

        padding: 23px 20px;
      }

      .about-callout a {
        width: 100%;
      }
    }
  </style>
</head>

<body>

<header class="about-header">

  <a
    class="about-brand"
    href="./"
    aria-label="ServaCibum home"
  >

    <img
      src="./assets/servacibum-logo.png"
      alt="ServaCibum"
    >

    <div class="about-brand-copy">

      <strong>
        ServaCibum
      </strong>

      <span>
        Community food rescue platform.
      </span>

    </div>

  </a>

  <div class="about-header-actions">

    <a
      class="about-header-link"
      href="./"
    >
      ServaCibum Home
    </a>

    <a
      class="about-header-link primary"
      href="./get-involved.php"
    >
      Get Involved
    </a>

  </div>

</header>

<main class="about-wrap">

  <section class="about-hero">

    <span class="about-eyebrow">
      ABOUT SERVACIBUM
    </span>

    <h1>
      <span class="headline-line">
        Bringing local food donors,
      </span>

      <span class="headline-line">
        charities, and volunteers together.
      </span>
    </h1>

    <p>
      ServaCibum is a student-led food rescue platform that connects local food
      donors, approved charitable organizations and volunteers. The platform
      helps coordinate eligible surplus food from donation through pickup,
      delivery and confirmed receipt.
    </p>

  </section>

  <section class="about-section">

    <h2>
      Our mission
    </h2>

    <p>
      Our mission is to make local food rescue easier to coordinate, easier to
      verify and easier for community organizations to participate in.
      ServaCibum helps turn usable surplus food into organized, trackable
      rescues instead of letting it go unused.
    </p>

    <div class="about-grid about-grid-green">

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <path d="M3 10h18"></path>
            <path d="M5 10V5h14v5"></path>
            <path d="M6 10v9h12v-9"></path>
            <path d="M9 19v-5h6v5"></path>
            <path d="M4 10c0 2 3 2 3 0"></path>
            <path d="M7 10c0 2 3 2 3 0"></path>
            <path d="M10 10c0 2 4 2 4 0"></path>
            <path d="M14 10c0 2 3 2 3 0"></path>
            <path d="M17 10c0 2 3 2 3 0"></path>

          </svg>

        </span>

        <h3>
          Food Donors
        </h3>

        <p>
          Food donors list eligible surplus food, available quantities and pickup
          windows so it can be matched with a local organization.
        </p>

      </article>

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <path d="M3 9h18"></path>
            <path d="M5 9v8"></path>
            <path d="M9 9v8"></path>
            <path d="M15 9v8"></path>
            <path d="M19 9v8"></path>
            <path d="M3 17h18"></path>
            <path d="M2 20h20"></path>
            <path d="M12 3l9 4H3l9-4z"></path>

          </svg>

        </span>

        <h3>
          Charity Partners
        </h3>

        <p>
          Approved charities can request available food or receive food allocated
          to them through ServaCibum, then follow each rescue through pickup and
          receipt.
        </p>

      </article>

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <circle
              cx="12"
              cy="8"
              r="3"
            ></circle>

            <path
              d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"
            ></path>

            <path
              d="M5 11a2.5 2.5 0 1 1 0-5"
            ></path>

            <path
              d="M19 11a2.5 2.5 0 1 0 0-5"
            ></path>

            <path
              d="M2 19c0-2.4 1.7-4.4 4-4.9"
            ></path>

            <path
              d="M22 19c0-2.4-1.7-4.4-4-4.9"
            ></path>

          </svg>

        </span>

        <h3>
          Volunteers
        </h3>

        <p>
          Approved volunteers can claim available deliveries, collect food from
          donors and transport it to the receiving charity.
        </p>

      </article>

    </div>

  </section>

  <section class="about-section">

    <h2>
      How ServaCibum works
    </h2>

    <p>
      Every rescue is organized as a real-world handoff. Food traveling together
      stays grouped throughout the process so donors, charities, volunteers and
      ServaCibum are all following the same rescue.
    </p>

    <div class="about-grid about-grid-green">

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <rect
              x="5"
              y="3"
              width="14"
              height="18"
              rx="2"
            ></rect>

            <path d="M9 8h6"></path>
            <path d="M9 12h6"></path>
            <path d="M9 16h4"></path>

          </svg>

        </span>

        <h3>
          Food becomes available
        </h3>

        <p>
          An approved food donor lists eligible surplus food, including the
          quantity and pickup window.
        </p>

      </article>

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <path
              d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1"
            ></path>

            <path
              d="M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1"
            ></path>

          </svg>

        </span>

        <h3>
          Food is matched with a charity
        </h3>

        <p>
          A charity may request available food, or ServaCibum may offer or
          allocate suitable food to an approved charity. Once confirmed, the
          food is reserved for that rescue.
        </p>

      </article>

      <article class="about-card">

        <span
          class="about-card-icon"
          aria-hidden="true"
        >

          <svg viewBox="0 0 24 24">

            <circle
              cx="12"
              cy="12"
              r="9"
            ></circle>

            <path
              d="M8 12l2.5 2.5L16.5 8.5"
            ></path>

          </svg>

        </span>

        <h3>
          The handoff is verified
        </h3>

        <p>
          The charity can collect the food directly or an approved volunteer can
          deliver it. Pickup verification and receipt confirmation provide a
          clear record from donor to charity.
        </p>

      </article>

    </div>

  </section>

  <section class="about-section">

    <h2>
      A focused pilot
    </h2>

    <p>
      ServaCibum is starting with foods that can be transported safely without
      refrigerated or temperature-controlled delivery. Keeping the first pilot
      focused allows the pickup and verification process to be tested carefully
      before the platform expands.
    </p>

    <div class="about-two-col">

      <article class="about-panel">

        <h3>
          Accepted during the pilot
        </h3>

        <ul class="about-food-list">

          <li>
            Pantry staples such as rice, pasta, flour, cereal and oats
          </li>

          <li>
            Beans, lentils and other shelf-stable staples
          </li>

          <li>
            Sealed snacks, crackers, granola bars and similar packaged food
          </li>

          <li>
            Canned and jarred foods
          </li>

          <li>
            Whole, uncut produce
          </li>

          <li>
            Sealed shelf-stable drinks
          </li>

          <li>
            Packaged bakery items such as bread, rolls and bagels
          </li>

        </ul>

      </article>

      <article class="about-panel">

        <h3>
          Not currently accepted
        </h3>

        <ul class="about-food-list">

          <li>
            Prepared hot meals
          </li>

          <li>
            Cooked meat, pizza or sandwiches
          </li>

          <li>
            Refrigerated food
          </li>

          <li>
            Frozen food
          </li>

          <li>
            Opened food
          </li>

          <li>
            Items that cannot be safely transferred in the pilot workflow
          </li>

        </ul>

      </article>

    </div>

  </section>

  <section class="about-section">

    <h2>
      Built around accountable handoffs
    </h2>

    <p>
      A ServaCibum rescue does not end when someone clicks a button. Each rescue
      moves through a defined chain of custody: food is approved and reserved,
      the physical pickup is verified, the delivery is recorded and the
      receiving charity confirms receipt.
    </p>

    <div class="about-two-col">

      <article class="about-panel">

        <h3>
          Verified handoffs
        </h3>

        <p>
          One-time pickup verification helps confirm that food actually changed
          hands at the donor location. Volunteer deliveries remain tracked until
          the receiving charity confirms receipt.
        </p>

      </article>

      <article class="about-panel">

        <h3>
          Privacy where it matters
        </h3>

        <p>
          Exact pickup information is shared only with approved participants who
          need it for an active rescue rather than being displayed publicly.
        </p>

      </article>

    </div>

    <div
      class="about-two-col"
      style="
        grid-template-columns:1fr;
        margin-top:18px;
      "
    >

      <article class="about-panel">

        <h3>
          Designed for community-scale rescue
        </h3>

        <p>
          ServaCibum focuses on practical local coordination: nearby donors,
          approved charities, manageable pickup windows and volunteers who can
          complete short community deliveries.
        </p>

      </article>

    </div>

  </section>

  <section class="about-section">

    <h2>
      Student-led. Community-focused. Built for real-world use.
    </h2>

    <p>
      ServaCibum began with a simple question: can technology make local food
      rescue easier to coordinate and more accountable? The platform is being
      developed around the practical needs of food rescue — inventory, charity
      matching, grouped pickups, volunteer delivery, self-pickup, handoff
      verification and confirmed receipt — with each workflow tested and
      improved as the pilot develops.
    </p>

  </section>

  <section class="about-callout">

    <div>

      <h2>
        Join the ServaCibum pilot
      </h2>

      <p>
        Local food donors, charitable organizations and volunteers can help
        build a stronger food rescue network in their community.
      </p>

    </div>

    <a href="./get-involved.php">
      Get Involved
    </a>

  </section>

  <footer class="about-footer">
    ServaCibum · Serving Sugar Land, Texas ·
    <a href="mailto:applications@servacibum.org">
      Contact: applications@servacibum.org
    </a>
  </footer>

</main>

<script src="/assets/page-end-nav.js?v=20261016a" defer></script>
</body>
</html>