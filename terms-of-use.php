<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="description" content="ServaCibum Terms of Use for visitors, food donors, charities and volunteers using the ServaCibum community food-rescue platform.">
  <title>Terms of Use - ServaCibum</title>
  <link rel="stylesheet" href="./assets/site.css?v=20261003-terms2">

  <style>
    :root {
      --green: #158447;
      --green-dark: #123f2b;
      --text: #213b2f;
      --muted: #65746c;
      --line: #dfe8e2;
      --soft: #f4f8f5;
      --soft-green: #e9f6ed;
    }

    body { background:#f7f9f7; }

    .policy-header {
      min-height:72px;
      padding:0 28px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:22px;
      background:#fff;
      border-bottom:1px solid #e5ebe7;
    }

    .policy-brand {
      display:inline-flex;
      align-items:center;
      gap:12px;
      color:inherit;
      text-decoration:none;
      min-width:0;
    }

    .policy-brand img {
      width:54px;
      height:54px;
      object-fit:contain;
    }

    .policy-brand-copy strong {
      display:block;
      color:var(--green-dark);
      font-size:20px;
      line-height:1.1;
    }

    .policy-brand-copy span {
      display:block;
      margin-top:3px;
      color:#65746c;
      font-size:11px;
      white-space:nowrap;
    }

    .policy-header-actions {
      display:flex;
      align-items:center;
      justify-content:flex-end;
      gap:9px;
      flex-wrap:wrap;
    }

    .policy-header-link {
      min-height:40px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding:10px 16px;
      color:#fff;
      background:var(--green);
      border:1px solid var(--green);
      border-radius:9px;
      font-size:12px;
      font-weight:800;
      text-decoration:none;
      white-space:nowrap;
    }

    .policy-header-link:hover { background:#116e3d; }

    .policy-wrap {
      width:min(1120px, calc(100% - 32px));
      margin:0 auto;
      padding:34px 0 58px;
    }

    .policy-hero {
      position:relative;
      overflow:hidden;
      padding:54px;
      border-radius:22px;
      background-image:
        linear-gradient(
          90deg,
          rgba(7,38,23,.90) 0%,
          rgba(7,38,23,.74) 44%,
          rgba(7,38,23,.34) 80%,
          rgba(7,38,23,.24) 100%
        ),
        url("./assets/servacibum-hero.png");
      background-size:cover;
      background-position:center;
      color:#fff;
      box-shadow:0 18px 48px rgba(18,63,43,.12);
    }

    .policy-eyebrow {
      display:inline-block;
      margin-bottom:13px;
      color:#ccebd7;
      font-size:11px;
      font-weight:900;
      letter-spacing:.12em;
      text-transform:uppercase;
    }

    .policy-hero h1 {
      max-width:900px;
      margin:0;
      font-size:clamp(34px,4.4vw,52px);
      line-height:1.04;
      letter-spacing:-.03em;
      font-weight:800;
    }

    .policy-hero p {
      max-width:820px;
      margin:20px 0 0;
      color:rgba(255,255,255,.9);
      font-size:16px;
      line-height:1.75;
    }

    .policy-effective {
      display:inline-block;
      margin-top:16px;
      color:#d9eee0;
      font-size:12px;
      font-weight:800;
    }

    .policy-section {
      margin-top:28px;
      padding:34px;
      background:#fff;
      border:1px solid var(--line);
      border-radius:18px;
      box-shadow:0 10px 28px rgba(22,58,42,.04);
    }

    .policy-section h2 {
      margin:0;
      color:var(--green-dark);
      font-size:27px;
      line-height:1.15;
    }

    .policy-section h3 {
      margin:22px 0 0;
      color:var(--green-dark);
      font-size:18px;
      line-height:1.3;
    }

    .policy-section p,
    .policy-section li {
      color:var(--muted);
      font-size:14px;
      line-height:1.75;
    }

    .policy-section p { margin:13px 0 0; }

    .policy-section ul,
    .policy-section ol {
      margin:13px 0 0;
      padding-left:22px;
    }

    .policy-section li + li { margin-top:7px; }

    .policy-section a,
    .signing-note a {
      color:var(--green);
      font-weight:800;
    }

    .policy-note {
      margin-top:18px;
      padding:16px 18px;
      background:var(--soft);
      border:1px solid #dfe9e2;
      border-radius:12px;
      color:#53685d;
      font-size:13px;
      line-height:1.7;
    }

    .policy-alert {
      margin-top:18px;
      padding:20px;
      background:#fff8ef;
      border:2px solid #d9a356;
      border-radius:14px;
      color:#5e4729;
      line-height:1.7;
    }

    .policy-alert strong { color:#4c371f; }

    .signing-note {
      margin-top:28px;
      padding:28px 30px;
      background:var(--soft-green);
      border:1px solid #d1e9d8;
      border-radius:18px;
    }

    .signing-note h2 {
      margin:0;
      color:var(--green-dark);
      font-size:24px;
    }

    .signing-note p {
      margin:8px 0 0;
      color:#567064;
      font-size:13px;
      line-height:1.7;
    }

    .related-links {
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top:18px;
    }

    .related-links a {
      display:inline-flex;
      min-height:40px;
      align-items:center;
      justify-content:center;
      padding:10px 15px;
      border-radius:9px;
      background:var(--green);
      color:#fff;
      text-decoration:none;
      font-size:12px;
      font-weight:800;
    }

    .related-links a:hover { background:#116e3d; }

    .policy-footer {
      margin-top:20px;
      color:#76837d;
      font-size:11px;
      line-height:1.6;
      text-align:center;
    }

    .policy-footer a {
      color:#587066;
      font-weight:700;
      text-decoration:none;
    }

    .policy-footer a:hover { text-decoration:underline; }

    @media (max-width:650px) {
      .policy-header {
        min-height:66px;
        padding:7px 10px;
        gap:8px;
      }

      .policy-brand img { width:46px; height:46px; }
      .policy-brand-copy strong { font-size:17px; }
      .policy-brand-copy span { display:none; }
      .policy-header-actions { gap:5px; }
      .policy-header-link { min-height:35px; padding:8px 10px; font-size:10px; }

      .policy-wrap {
        width:min(100% - 20px,1120px);
        padding-top:18px;
      }

      .policy-hero {
        padding:34px 23px;
        border-radius:16px;
      }

      .policy-hero p { font-size:14px; }

      .policy-section {
        margin-top:18px;
        padding:23px 20px;
        border-radius:15px;
      }

      .policy-section h2 { font-size:23px; }

      .signing-note {
        margin-top:18px;
        padding:23px 20px;
      }
    }
  </style>
</head>

<body>

<header class="policy-header">
  <a class="policy-brand" href="./" aria-label="ServaCibum home">
    <img src="./assets/servacibum-logo.png" alt="ServaCibum">
    <div class="policy-brand-copy">
      <strong>ServaCibum</strong>
      <span>Community food rescue platform.</span>
    </div>
  </a>

  <div class="policy-header-actions">
    <a class="policy-header-link" href="./">ServaCibum Home</a>
    <a class="policy-header-link" href="./privacy.php">Privacy Notice</a>
  </div>
</header>

<main class="policy-wrap">

  <section class="policy-hero">
    <span class="policy-eyebrow">TERMS OF USE</span>
    <h1>Terms of Use</h1>
    <p>
      These Terms govern access to and use of ServaCibum's public website, participant portals
      and food-rescue coordination features. They are intended to keep the platform safe,
      reliable and clear for food donors, charities and volunteers.
    </p>
    <span class="policy-effective">Effective: October 3, 2026</span>
  </section>

  <section class="policy-section">
    <h2>1. About ServaCibum</h2>
    <p>
      ServaCibum is a community food-rescue initiative serving the Sugar Land area. The platform
      helps approved food donors, charitable organizations and volunteers coordinate the transfer
      of eligible donated food.
    </p>
    <p>
      ServaCibum provides coordination tools. It does not sell food, operate as a grocery store
      or restaurant, inspect or certify donated food, provide transportation as a commercial
      carrier, or guarantee that a particular donation, request, match, pickup or delivery will occur.
    </p>
  </section>

  <section class="policy-section">
    <h2>2. Acceptance of these Terms and related policies</h2>
    <p>
      By accessing the website, submitting an application, using an authenticated ServaCibum portal,
      listing or requesting food, accepting an assignment, or otherwise participating in a rescue,
      you agree to follow these Terms and the policies that apply to your activity.
    </p>
    <p>
      Food-rescue participation is also subject to the
      <a href="./food-safety.php">Food Safety &amp; Donation Guidelines</a>.
      Volunteer drivers are additionally subject to the
      <a href="./volunteer-driver-agreement.php">Volunteer Driver Agreement</a>.
      ServaCibum's handling of personal information is described in the
      <a href="./privacy.php">Privacy Notice</a>.
    </p>
    <div class="policy-note">
      If a more specific ServaCibum policy applies to a particular activity, that policy controls
      for that activity to the extent it addresses the issue more specifically than these general Terms.
    </div>
  </section>

  <section class="policy-section">
    <h2>3. Authority, eligibility and accurate information</h2>
    <p>
      You may use ServaCibum only for activities you are permitted to perform. If you act on behalf
      of a food donor, charity or other organization, you must be authorized to act for that organization.
    </p>
    <p>
      Information submitted to ServaCibum must be reasonably accurate and current. You must not
      impersonate another person or organization, falsify eligibility information, create misleading
      rescue records, or knowingly submit materially false information.
    </p>
    <p>
      Activities that have separate eligibility requirements, including volunteer driving, may not
      be performed until those requirements are satisfied.
    </p>
  </section>

  <section class="policy-section">
    <h2>4. Accounts and account security</h2>
    <p>
      Approved participants may receive access to authenticated donor, charity or volunteer portals.
      Accounts are for the authorized account holder or organization and must not be shared with an
      unauthorized person.
    </p>
    <p>
      Users are responsible for keeping login credentials confidential and for promptly notifying
      ServaCibum if they reasonably believe an account, activation link, password-reset link or session
      has been accessed without authorization.
    </p>
  </section>

  <section class="policy-section">
    <h2>5. ServaCibum's role in a rescue</h2>
    <p>
      ServaCibum helps participants communicate, request food, list donations, approve or match rescues,
      assign volunteers and record pickup and delivery status. Those platform actions coordinate a rescue;
      they do not replace the judgment and responsibilities of the donor, volunteer or receiving charity.
    </p>
    <p>
      ServaCibum may decline, pause, cancel or reassign a rescue when reasonably necessary because of
      safety concerns, inaccurate information, participant unavailability, suspected misuse or another
      operational problem.
    </p>
    <p>
      No participant is guaranteed a particular donation, request, assignment, quantity of food,
      pickup opportunity or delivery.
    </p>
  </section>

  <section class="policy-section">
    <h2>6. Food safety</h2>
    <p>
      All food coordinated through ServaCibum must fit the current
      <a href="./food-safety.php">Food Safety &amp; Donation Guidelines</a>.
      The pilot intentionally limits the categories of food that may be coordinated.
    </p>

    <div class="policy-alert">
      <strong>Approval in the platform is not a food-safety inspection or certification.</strong>
      A donor, volunteer or receiving charity should stop or reject a handoff when food appears unsafe,
      damaged, contaminated, recalled, improperly stored or materially different from the approved listing.
    </div>

    <p>
      When there is a reasonable doubt about safety, participants should not complete or distribute
      the food merely because the rescue has already been approved in ServaCibum.
    </p>
  </section>

  <section class="policy-section">
    <h2>7. Food donor responsibilities</h2>
    <p>Food donors using ServaCibum are expected to:</p>
    <ul>
      <li>list only food that fits the current ServaCibum pilot rules;</li>
      <li>provide reasonably accurate descriptions, quantities, pickup windows and availability;</li>
      <li>keep donated food under appropriate conditions until the approved handoff;</li>
      <li>preserve original packaging, ingredient and allergen information when available;</li>
      <li>not knowingly offer recalled, spoiled, contaminated, opened or otherwise prohibited food;</li>
      <li>provide only the pickup location authorized for the donation; and</li>
      <li>use the required ServaCibum pickup-verification process at handoff.</li>
    </ul>
  </section>

  <section class="policy-section">
    <h2>8. Receiving charity responsibilities</h2>
    <p>
      The receiving charity makes the final decision whether to accept donated food at handoff.
      A charity may decline food that appears unsafe, damaged, contaminated or inconsistent with
      the approved rescue.
    </p>
    <p>
      After accepting the food, the charity is responsible for its own storage, handling and
      distribution practices and for following the legal, regulatory and organizational requirements
      that apply to its operations.
    </p>
  </section>

  <section class="policy-section">
    <h2>9. Volunteer responsibilities</h2>
    <p>
      Volunteers must follow the authorized assignment shown in their ServaCibum portal and use
      donor, charity and route information only for completing that assignment.
    </p>
    <p>
      Volunteers may not open, sample, consume, sell, keep, redirect or independently redistribute
      donated food entrusted to them through ServaCibum.
    </p>
    <p>
      A volunteer who drives for ServaCibum must satisfy the current driver-eligibility requirements,
      including any required documentation and, when applicable, parent or legal-guardian authorization,
      before accepting driving assignments.
    </p>
  </section>

  <section class="policy-section">
    <h2>10. Pickup, delivery and verification</h2>
    <p>
      Participants must use the pickup, assignment and verification steps provided through ServaCibum.
      Pickup codes and completion records are used to help confirm that an authorized handoff occurred.
    </p>
    <p>
      A participant must not falsely mark a pickup, delivery or receipt as complete; enter or share
      a pickup code for an unauthorized handoff; attempt to bypass the verification process; or interfere
      with another participant's authorized rescue.
    </p>
  </section>

  <section class="policy-section">
    <h2>11. Address, contact and rescue-information privacy</h2>
    <p>
      Exact pickup and delivery addresses, participant contact information, route details and other
      nonpublic rescue information may be provided when needed for an approved pickup, delivery or
      self-pickup.
    </p>
    <p>
      That information must be used only for the authorized ServaCibum activity. Participants must not
      publish private addresses, post screenshots containing private rescue information, unnecessarily
      share participant contact details, or retain private route information for unrelated purposes.
    </p>
  </section>

  <section class="policy-section">
    <h2>12. Prohibited use</h2>
    <p>You may not use ServaCibum to:</p>
    <ul>
      <li>submit false, fraudulent or intentionally misleading information;</li>
      <li>access another person's account or private rescue information without authorization;</li>
      <li>harass, threaten, discriminate against or intentionally endanger another participant;</li>
      <li>sell donated food or obtain donated food for unauthorized resale or personal diversion;</li>
      <li>scrape, publish, exploit or misuse private donor, charity or volunteer information;</li>
      <li>upload malicious code, probe security controls or deliberately interfere with the website, portals or database;</li>
      <li>circumvent account, approval, assignment, address-privacy or pickup-verification controls; or</li>
      <li>use the platform for unlawful activity.</li>
    </ul>
  </section>

  <section class="policy-section">
    <h2>13. Third-party services</h2>
    <p>
      ServaCibum may link to or open third-party services such as mapping, navigation, email or
      hosting-related services. Those services operate independently and may have their own terms,
      availability, security practices and privacy policies.
    </p>
    <p>
      A link to an outside service does not mean that ServaCibum controls that service or guarantees
      its availability or accuracy.
    </p>
  </section>

  <section class="policy-section">
    <h2>14. Platform availability and changes</h2>
    <p>
      ServaCibum is an evolving community pilot. Features may be changed, added, removed or temporarily
      unavailable because of maintenance, testing, security, safety, legal requirements or operational needs.
    </p>
    <p>
      ServaCibum does not promise uninterrupted or error-free access to the website or portals.
    </p>
  </section>

  <section class="policy-section">
    <h2>15. Suspension, restriction and removal</h2>
    <p>
      ServaCibum may restrict, suspend or remove access to an account, listing, request or assignment
      when reasonably necessary because of safety concerns, suspected misuse, inaccurate information,
      unauthorized access, repeated policy violations, expired eligibility information or other reasonable
      operational concerns.
    </p>
    <p>
      A participant whose access is restricted must not attempt to evade the restriction through another
      account or another person's credentials.
    </p>
  </section>

  <section class="policy-section">
    <h2>16. Participant judgment and assumption of ordinary participation risks</h2>
    <p>
      Food rescue involves real-world decisions and activities. Donors, charities and volunteers remain
      responsible for their own conduct and for decisions left to them, including whether a handoff should
      proceed and whether an activity can be completed safely and lawfully.
    </p>
    <p>
      ServaCibum does not provide legal, medical, insurance or professional food-safety advice. Information
      on the website is intended to explain ServaCibum's procedures and participation rules.
    </p>
    <div class="policy-note">
      Volunteer driving has additional risk, insurance, release and responsibility terms in the
      Volunteer Driver Agreement. Those driver-specific terms are not replaced by this general Terms of Use page.
    </div>
  </section>

  <section class="policy-section">
    <h2>17. No emergency service</h2>
    <p>
      ServaCibum is not an emergency-response service. The website and participant portals should not be
      used as a substitute for 911, emergency medical services, law enforcement, a poison-control service
      or another appropriate emergency resource.
    </p>
  </section>

  <section class="policy-section">
    <h2>18. Texas law and enforceability</h2>
    <p>
      These Terms are intended to be governed by applicable Texas law, together with applicable federal law.
    </p>
    <p>
      If a provision of these Terms is determined to be invalid or unenforceable, the remaining provisions
      are intended to continue in effect to the extent permitted by law.
    </p>
    <p>
      Nothing in these Terms is intended to waive, exclude or limit a right or responsibility that applicable
      law does not permit to be waived, excluded or limited.
    </p>
  </section>

  <section class="policy-section">
    <h2>19. Changes to these Terms</h2>
    <p>
      ServaCibum may update these Terms as the pilot and platform develop. When a material change is made,
      the effective date at the top of this page will be updated.
    </p>
    <p>
      Continued use of ServaCibum after revised Terms become effective means that future use of the platform
      is subject to the revised Terms.
    </p>
  </section>

  <section class="signing-note">
    <h2>Questions about these Terms</h2>
    <p>
      Questions may be sent to
      <a href="mailto:applications@servacibum.org">applications@servacibum.org</a>.
    </p>

    <div class="related-links">
      <a href="./privacy.php">Privacy Notice</a>
      <a href="./food-safety.php">Food Safety Guidelines</a>
      <a href="./volunteer-driver-agreement.php">Volunteer Driver Agreement</a>
    </div>
  </section>

  <footer class="policy-footer">
    ServaCibum &middot; Serving Sugar Land, Texas &middot;
    <a href="./privacy.php">Privacy</a>
    &middot;
    <a href="./food-safety.php">Food Safety</a>
    &middot;
    <a href="mailto:applications@servacibum.org">Contact</a>
  </footer>

</main>

</body>
</html>
