
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="description" content="Learn how ServaCibum collects, uses, shares, protects and retains information from applicants, partners and volunteers.">
  <title>Privacy ¡¤ ServaCibum</title>

  <link rel="stylesheet" href="./assets/site.css?v=20261002-privacy2">

  <style>
    :root {
      --green: #158447;
      --green-dark: #123f2b;
      --text: #213b2f;
      --muted: #65746c;
      --line: #dfe8e2;
      --soft: #f4f8f5;
    }

    body { background: #f7f9f7; }

    .privacy-header {
      min-height: 72px;
      padding: 0 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 22px;
      background: #fff;
      border-bottom: 1px solid #e5ebe7;
    }

    .privacy-brand {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      color: inherit;
      text-decoration: none;
      min-width: 0;
    }

    .privacy-brand img {
      width: 54px;
      height: 54px;
      object-fit: contain;
    }

    .privacy-brand-copy strong {
      display: block;
      color: var(--green-dark);
      font-size: 20px;
      line-height: 1.1;
    }

    .privacy-brand-copy span {
      display: block;
      margin-top: 3px;
      color: #65746c;
      font-size: 11px;
      white-space: nowrap;
    }

    .privacy-header-actions {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 9px;
      flex-wrap: wrap;
    }

    .privacy-header-link {
      min-height: 40px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 10px 16px;
      color: #fff;
      background: var(--green);
      border: 1px solid var(--green);
      border-radius: 9px;
      font-size: 12px;
      font-weight: 800;
      text-decoration: none;
      white-space: nowrap;
    }

    .privacy-header-link:hover { background: #116e3d; }

    .privacy-wrap {
      width: min(1120px, calc(100% - 32px));
      margin: 0 auto;
      padding: 34px 0 58px;
    }

    .privacy-hero {
      position: relative;
      overflow: hidden;
      padding: 54px;
      border-radius: 22px;
      background-image:
        linear-gradient(90deg, rgba(7,38,23,.90) 0%, rgba(7,38,23,.74) 44%, rgba(7,38,23,.34) 80%, rgba(7,38,23,.24) 100%),
        url("./assets/servacibum-hero.png");
      background-size: cover;
      background-position: center;
      color: #fff;
      box-shadow: 0 18px 48px rgba(18,63,43,.12);
    }

    .privacy-eyebrow {
      display: inline-block;
      margin-bottom: 13px;
      color: #ccebd7;
      font-size: 11px;
      font-weight: 900;
      letter-spacing: .12em;
      text-transform: uppercase;
    }

    .privacy-hero h1 {
      max-width: 880px;
      margin: 0;
      font-size: clamp(34px, 4.4vw, 52px);
      line-height: 1.04;
      letter-spacing: -.03em;
      font-weight: 800;
    }

    .privacy-hero p {
      max-width: 760px;
      margin: 20px 0 0;
      color: rgba(255,255,255,.9);
      font-size: 16px;
      line-height: 1.75;
    }

    .privacy-effective {
      display: inline-block;
      margin-top: 16px;
      color: #d9eee0;
      font-size: 12px;
      font-weight: 800;
    }

    .privacy-section {
      margin-top: 28px;
      padding: 34px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: 0 10px 28px rgba(22,58,42,.04);
    }

    .privacy-section h2 {
      margin: 0;
      color: var(--green-dark);
      font-size: 27px;
      line-height: 1.15;
    }

    .privacy-section p,
    .privacy-section li {
      color: var(--muted);
      font-size: 14px;
      line-height: 1.75;
    }

    .privacy-section p { margin: 13px 0 0; }
    .privacy-section ul { margin: 13px 0 0; padding-left: 22px; }
    .privacy-section li + li { margin-top: 7px; }

    .privacy-note {
      margin-top: 18px;
      padding: 16px 18px;
      background: var(--soft);
      border: 1px solid #dfe9e2;
      border-radius: 12px;
      color: #53685d;
      font-size: 13px;
      line-height: 1.7;
    }

    .privacy-contact {
      margin-top: 28px;
      padding: 28px 30px;
      background: #e9f6ed;
      border: 1px solid #d1e9d8;
      border-radius: 18px;
    }

    .privacy-contact h2 {
      margin: 0;
      color: var(--green-dark);
      font-size: 24px;
    }

    .privacy-contact p {
      margin: 8px 0 0;
      color: #567064;
      font-size: 13px;
      line-height: 1.65;
    }

    .privacy-contact a {
      color: var(--green);
      font-weight: 800;
      text-decoration: none;
    }

    .privacy-contact a:hover { text-decoration: underline; }



    .policy-links {
      margin-top: 28px;
      padding: 34px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: 0 10px 28px rgba(22,58,42,.04);
    }

    .policy-links h2 {
      margin: 0;
      color: var(--green-dark);
      font-size: 27px;
      line-height: 1.15;
    }

    .policy-links > p {
      margin: 10px 0 0;
      color: var(--muted);
      font-size: 14px;
      line-height: 1.7;
    }

    .policy-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 16px;
      margin-top: 20px;
    }

    .policy-card {
      display: flex;
      flex-direction: column;
      min-height: 215px;
      padding: 24px;
      background: var(--soft);
      border: 1px solid #dfe9e2;
      border-radius: 15px;
    }

    .policy-card .policy-kicker {
      color: var(--green);
      font-size: 10px;
      font-weight: 900;
      letter-spacing: .10em;
      text-transform: uppercase;
    }

    .policy-card h3 {
      margin: 8px 0 0;
      color: var(--green-dark);
      font-size: 20px;
      line-height: 1.25;
    }

    .policy-card p {
      margin: 10px 0 18px;
      color: var(--muted);
      font-size: 13px;
      line-height: 1.65;
    }

    .policy-card a {
      margin-top: auto;
      align-self: flex-start;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 40px;
      padding: 10px 15px;
      color: #fff;
      background: var(--green);
      border-radius: 9px;
      font-size: 12px;
      font-weight: 800;
      text-decoration: none;
    }

    .policy-card a:hover { background: #116e3d; }

    .privacy-footer {
      margin-top: 20px;
      color: #76837d;
      font-size: 11px;
      line-height: 1.6;
      text-align: center;
    }

    .privacy-footer a {
      color: #587066;
      font-weight: 700;
      text-decoration: none;
    }

    .privacy-footer a:hover { text-decoration: underline; }

    @media (max-width: 650px) {
      .privacy-header {
        min-height: 66px;
        padding: 7px 10px;
        gap: 8px;
      }

      .privacy-brand img { width: 46px; height: 46px; }
      .privacy-brand-copy strong { font-size: 17px; }
      .privacy-brand-copy span { display: none; }
      .privacy-header-actions { gap: 5px; }
      .privacy-header-link { min-height: 35px; padding: 8px 10px; font-size: 10px; }

      .privacy-wrap {
        width: min(100% - 20px, 1120px);
        padding-top: 18px;
      }

      .privacy-hero {
        padding: 34px 23px;
        border-radius: 16px;
      }

      .privacy-hero p { font-size: 14px; }

      .privacy-section {
        margin-top: 18px;
        padding: 23px 20px;
        border-radius: 15px;
      }

      .privacy-section h2 { font-size: 23px; }

      .privacy-contact {
        margin-top: 18px;
        padding: 23px 20px;
      }

      .policy-links {
        margin-top: 18px;
        padding: 23px 20px;
      }

      .policy-links h2 { font-size: 23px; }
      .policy-grid { grid-template-columns: 1fr; }
      .policy-card { min-height: 0; padding: 20px; }
    }
  </style>
</head>

<body>

<header class="privacy-header">
  <a class="privacy-brand" href="./" aria-label="ServaCibum home">
    <img src="./assets/servacibum-logo.png" alt="ServaCibum">
    <div class="privacy-brand-copy">
      <strong>ServaCibum</strong>
      <span>Community food rescue platform.</span>
    </div>
  </a>

  <div class="privacy-header-actions">
    <a class="privacy-header-link" href="./">ServaCibum Home</a>
    <a class="privacy-header-link" href="./get-involved.php">Get Involved</a>
  </div>
</header>

<main class="privacy-wrap">

  <section class="privacy-hero">
    <span class="privacy-eyebrow">PRIVACY</span>
    <h1>Privacy Notice</h1>
    <p>
      ServaCibum is a student-led community food rescue platform serving Sugar Land, Texas.
      This Privacy Notice explains what information we collect when you apply, use a ServaCibum
      portal or participate in a food rescue, how we use and share that information, how long we
      keep it and how you can contact us about your information.
    </p>
    <span class="privacy-effective">Effective: October 2, 2026</span>
  </section>

  <section class="privacy-section">
    <h2>1. Information we collect</h2>
    <p>
      The information we collect depends on how you interact with ServaCibum. It may include:
    </p>
    <ul>
      <li>
        <strong>Contact information:</strong> name, email address, phone number and ZIP code.
      </li>
      <li>
        <strong>Organization information:</strong> food donor or charity name, organization
        address and contact person.
      </li>
      <li>
        <strong>Volunteer information:</strong> availability, transportation access, current ZIP
        code and any optional notes you choose to provide.
      </li>
      <li>
        <strong>Donation and rescue information:</strong> food type, quantity, pickup window,
        requests, assignments, pickup verification, delivery status and receipt confirmation.
      </li>
      <li>
        <strong>Account information:</strong> information used to create, authenticate and manage
        approved donor, charity, volunteer and administrator accounts.
      </li>
      <li>
        <strong>Technical information:</strong> session data, timestamps and other basic security
        or server information that may be recorded when the website is used.
      </li>
    </ul>
  </section>

  <section class="privacy-section">
    <h2>2. How we use information</h2>
    <p>
      We use information to operate, administer and protect the ServaCibum platform. This includes:
    </p>
    <ul>
      <li>Reviewing volunteer, food donor and charity applications.</li>
      <li>Creating and managing approved participant accounts.</li>
      <li>Coordinating food donations, requests, matching, pickups, deliveries and confirmed receipt.</li>
      <li>Contacting participants about an application, account or active rescue.</li>
      <li>Keeping operational records so rescue activity and important account actions can be verified.</li>
      <li>Protecting the platform, investigating technical problems and preventing misuse.</li>
    </ul>
    <div class="privacy-note">
      ServaCibum does not sell personal information and does not use application information for advertising.
    </div>
  </section>

  <section class="privacy-section">
    <h2>3. Who may access information</h2>
    <p>
      Access is limited to people and service providers who need information to operate ServaCibum
      or complete an authorized rescue.
    </p>
    <ul>
      <li>
        ServaCibum administrators may access application, account and rescue information when needed
        to review applications, manage accounts, coordinate rescues or address safety and security issues.
      </li>
      <li>
        Approved food donors, charities and volunteers receive only the information needed for the
        rescue or account function they are authorized to perform.
      </li>
      <li>
        Hosting, email and other technical service providers may process information when necessary
        to provide their services to ServaCibum.
      </li>
      <li>
        Information may be disclosed when reasonably necessary to comply with law, respond to a valid
        legal request or protect the safety and security of participants or the platform.
      </li>
    </ul>
  </section>

  <section class="privacy-section">
    <h2>4. Public information and location privacy</h2>
    <p>
      ServaCibum may display limited information about approved partner organizations or platform
      activity, such as an organization name, general service area or aggregate rescue statistics.
      Personal contact information is not intended to be displayed publicly.
    </p>
    <div class="privacy-note">
      Exact donor pickup addresses and route details are not displayed on the public site. They are
      shared only with approved participants when needed for an authorized pickup, self-pickup or delivery.
    </div>
  </section>

  <section class="privacy-section">
    <h2>5. Sessions and website technology</h2>
    <p>
      ServaCibum uses session technology and similar website functions to keep users signed in, protect
      forms and support secure portal activity. Your browser or the hosting environment may also record
      basic technical information needed for security, troubleshooting and normal website operation.
    </p>
  </section>

  <section class="privacy-section">
    <h2>6. How long information is kept</h2>
    <p>
      We keep information only for as long as it is reasonably needed for the purpose for which it was
      collected, for administration of the platform or for legitimate recordkeeping and security needs.
      Application information may be kept during review and for a reasonable period afterward. Information
      for approved participants may be kept while an account is active and for a reasonable period after
      it is deactivated.
    </p>
    <p>
      Rescue records may be retained longer when needed to preserve a reliable history of donations,
      pickups, deliveries, verification and receipt, or when retention is reasonably necessary for
      security, dispute resolution, legal obligations or prevention of misuse.
    </p>
  </section>

  <section class="privacy-section">
    <h2>7. Your choices</h2>
    <p>
      You may contact ServaCibum to ask about personal information associated with you, request a correction
      or request deletion of information that is no longer needed. We may ask for enough information to
      verify the request before making a change.
    </p>
    <p>
      Some records may need to be retained when reasonably necessary for completed-rescue records, security,
      legal obligations, dispute resolution or prevention of misuse.
    </p>
  </section>

  <section class="privacy-section">
    <h2>8. Security</h2>
    <p>
      ServaCibum uses authenticated portals, access controls and other administrative and technical measures
      intended to limit unauthorized access to application, account and rescue information. No website,
      database or internet transmission, however, can be guaranteed to be completely secure.
    </p>
  </section>

  <section class="privacy-section">
    <h2>9. External services and links</h2>
    <p>
      ServaCibum may link to third-party services such as Google Maps. If you choose to use an external
      service, information handled by that service is governed by its own privacy practices rather than
      this Privacy Notice.
    </p>
  </section>

  <section class="privacy-section">
    <h2>10. Changes to this notice</h2>
    <p>
      ServaCibum may update this Privacy Notice as the pilot and platform develop. When material changes
      are made, the effective date at the top of this page will be updated.
    </p>
  </section>

  <section class="privacy-contact">
    <h2>Questions or privacy requests</h2>
    <p>
      For questions about this notice or requests concerning your information, contact ServaCibum at
      <a href="mailto:applications@servacibum.org">applications@servacibum.org</a>.
    </p>
  </section>



  <section class="policy-links" aria-labelledby="related-policies-title">
    <h2 id="related-policies-title">Related ServaCibum policies</h2>
    <p>
      These policies explain additional requirements that apply to food-rescue participation.
    </p>

    <div class="policy-grid">
      <article class="policy-card">
        <span class="policy-kicker">Platform rules</span>
        <h3>Terms of Use</h3>
        <p>
          The general rules for using ServaCibum, including account responsibilities, authorized use,
          pickup and delivery verification, prohibited conduct, privacy and platform availability.
        </p>
        <a href="./terms-of-use.php">Read Terms of Use</a>
      </article>

      <article class="policy-card">
        <span class="policy-kicker">Volunteer safety</span>
        <h3>Volunteer Driver Agreement</h3>
        <p>
          Driver eligibility, insurance responsibilities, safe-driving rules, privacy duties,
          assumption of risk and the liability terms that apply before an approved volunteer may drive for ServaCibum.
        </p>
        <a href="./volunteer-driver-agreement.php">Read Driver Agreement</a>
      </article>

      <article class="policy-card">
        <span class="policy-kicker">Food safety</span>
        <h3>Food Safety &amp; Donation Guidelines</h3>
        <p>
          The foods ServaCibum accepts during the pilot, foods we do not coordinate, and the basic
          responsibilities of donors, volunteers and receiving charities.
        </p>
        <a href="./food-safety.php">Read Food Safety Guidelines</a>
      </article>
    </div>
  </section>


  <footer class="privacy-footer">
    ServaCibum &middot; Serving Sugar Land, Texas &middot; <a href="./terms-of-use.php">Terms of Use</a> &middot; Privacy
  </footer>

</main>

</body>
</html>
