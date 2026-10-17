<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="description" content="ServaCibum food safety and donation guidelines for food donors, volunteers and receiving charities.">
  <title>Food Safety &amp; Donation Guidelines · ServaCibum</title>
  <link rel="stylesheet" href="./assets/site.css?v=20261002-policy1">
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
      min-height:72px; padding:0 28px; display:flex; align-items:center;
      justify-content:space-between; gap:22px; background:#fff; border-bottom:1px solid #e5ebe7;
    }
    .policy-brand { display:inline-flex; align-items:center; gap:12px; color:inherit; text-decoration:none; min-width:0; }
    .policy-brand img { width:54px; height:54px; object-fit:contain; }
    .policy-brand-copy strong { display:block; color:var(--green-dark); font-size:20px; line-height:1.1; }
    .policy-brand-copy span { display:block; margin-top:3px; color:#65746c; font-size:11px; white-space:nowrap; }
    .policy-header-actions { display:flex; align-items:center; justify-content:flex-end; gap:9px; flex-wrap:wrap; }
    .policy-header-link {
      min-height:40px; display:inline-flex; align-items:center; justify-content:center; padding:10px 16px;
      color:#fff; background:var(--green); border:1px solid var(--green); border-radius:9px;
      font-size:12px; font-weight:800; text-decoration:none; white-space:nowrap;
    }
    .policy-header-link:hover { background:#116e3d; }
    .policy-wrap { width:min(1120px, calc(100% - 32px)); margin:0 auto; padding:34px 0 58px; }
    .policy-hero {
      position:relative; overflow:hidden; padding:54px; border-radius:22px;
      background-image:linear-gradient(90deg, rgba(7,38,23,.90) 0%, rgba(7,38,23,.74) 44%, rgba(7,38,23,.34) 80%, rgba(7,38,23,.24) 100%), url("./assets/servacibum-hero.png");
      background-size:cover; background-position:center; color:#fff; box-shadow:0 18px 48px rgba(18,63,43,.12);
    }
    .policy-eyebrow { display:inline-block; margin-bottom:13px; color:#ccebd7; font-size:11px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; }
    .policy-hero h1 { max-width:900px; margin:0; font-size:clamp(34px,4.4vw,52px); line-height:1.04; letter-spacing:-.03em; font-weight:800; }
    .policy-hero p { max-width:800px; margin:20px 0 0; color:rgba(255,255,255,.9); font-size:16px; line-height:1.75; }
    .policy-effective { display:inline-block; margin-top:16px; color:#d9eee0; font-size:12px; font-weight:800; }
    .policy-section {
      margin-top:28px; padding:34px; background:#fff; border:1px solid var(--line); border-radius:18px;
      box-shadow:0 10px 28px rgba(22,58,42,.04);
    }
    .policy-section h2 { margin:0; color:var(--green-dark); font-size:27px; line-height:1.15; }
    .policy-section h3 { margin:22px 0 0; color:var(--green-dark); font-size:18px; line-height:1.3; }
    .policy-section p, .policy-section li { color:var(--muted); font-size:14px; line-height:1.75; }
    .policy-section p { margin:13px 0 0; }
    .policy-section ul, .policy-section ol { margin:13px 0 0; padding-left:22px; }
    .policy-section li + li { margin-top:7px; }
    .policy-note { margin-top:18px; padding:16px 18px; background:var(--soft); border:1px solid #dfe9e2; border-radius:12px; color:#53685d; font-size:13px; line-height:1.7; }
    .policy-alert { margin-top:18px; padding:20px; background:#fff8ef; border:2px solid #d9a356; border-radius:14px; color:#5e4729; }
    .policy-alert strong { color:#4c371f; }
    .release-box { margin-top:28px; padding:30px; background:#fffaf4; border:3px solid #8b5b23; border-radius:16px; }
    .release-box h2 { color:#5d3a14; font-size:28px; }
    .release-box h3 { margin:10px 0 0; color:#5d3a14; font-size:17px; }
    .release-box p { color:#4d4134; }
    .release-box .release-text { font-weight:900; text-transform:uppercase; letter-spacing:.01em; }
    .signing-note { margin-top:28px; padding:28px 30px; background:var(--soft-green); border:1px solid #d1e9d8; border-radius:18px; }
    .signing-note h2 { margin:0; color:var(--green-dark); font-size:24px; }
    .signing-note p { margin:8px 0 0; color:#567064; font-size:13px; line-height:1.7; }
    .related-links { display:flex; gap:10px; flex-wrap:wrap; margin-top:18px; }
    .related-links a { display:inline-flex; min-height:40px; align-items:center; justify-content:center; padding:10px 15px; border-radius:9px; background:var(--green); color:#fff; text-decoration:none; font-size:12px; font-weight:800; }
    .related-links a:hover { background:#116e3d; }
    .policy-footer { margin-top:20px; color:#76837d; font-size:11px; line-height:1.6; text-align:center; }
    .policy-footer a { color:#587066; font-weight:700; text-decoration:none; }
    .policy-footer a:hover { text-decoration:underline; }
    @media (max-width:650px) {
      .policy-header { min-height:66px; padding:7px 10px; gap:8px; }
      .policy-brand img { width:46px; height:46px; }
      .policy-brand-copy strong { font-size:17px; }
      .policy-brand-copy span { display:none; }
      .policy-header-actions { gap:5px; }
      .policy-header-link { min-height:35px; padding:8px 10px; font-size:10px; }
      .policy-wrap { width:min(100% - 20px,1120px); padding-top:18px; }
      .policy-hero { padding:34px 23px; border-radius:16px; }
      .policy-hero p { font-size:14px; }
      .policy-section, .release-box { margin-top:18px; padding:23px 20px; border-radius:15px; }
      .policy-section h2, .release-box h2 { font-size:23px; }
      .signing-note { margin-top:18px; padding:23px 20px; }
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
    <span class="policy-eyebrow">FOOD SAFETY</span>
    <h1>Food Safety &amp; Donation Guidelines</h1>
    <p>
      ServaCibum's pilot intentionally accepts a narrow range of low-risk foods so donors, volunteers and charities can coordinate local rescues without handling hot, refrigerated or frozen foods.
    </p>
    <span class="policy-effective">Pilot version: October 2, 2026</span>
  </section>

  <section class="policy-section">
    <h2>1. Scope of the pilot</h2>
    <p>These are ServaCibum's own participation rules for rescues coordinated through the platform. They are intentionally more restrictive than some foods that may otherwise be donated under applicable law.</p>
    <div class="policy-note"><strong>Current rule:</strong> ServaCibum does not coordinate foods that require refrigeration, freezing, hot holding or other time/temperature control for safety during this pilot.</div>
  </section>

  <section class="policy-section">
    <h2>2. Foods ServaCibum currently accepts</h2>
    <ul>
      <li>Commercially packaged shelf-stable pantry staples in intact packaging.</li>
      <li>Sealed canned or jarred foods with no leaking, bulging, severe damage, broken seals or other obvious signs of spoilage.</li>
      <li>Dry packaged foods such as rice, pasta, cereal, flour or similar shelf-stable items.</li>
      <li>Sealed shelf-stable beverages that do not require refrigeration.</li>
      <li>Whole, uncut produce in reasonably good condition.</li>
      <li>Packaged bakery items that are shelf-stable and do not require refrigeration.</li>
    </ul>
    <p>ServaCibum may decline any item when its condition, labeling, storage history or suitability is uncertain.</p>
  </section>

  <section class="policy-section">
    <h2>3. Foods ServaCibum does not accept during the pilot</h2>
    <ul>
      <li>Prepared hot meals, pizza, sandwiches or other ready-to-eat prepared meals.</li>
      <li>Cooked meat, poultry, seafood or other foods requiring temperature control.</li>
      <li>Refrigerated or frozen foods.</li>
      <li>Milk, dairy products, eggs or similar temperature-controlled foods.</li>
      <li>Cut melons, cut leafy greens, cut tomatoes, raw seed sprouts or other foods requiring time/temperature control for safety.</li>
      <li>Opened, partially consumed, repackaged or unsealed foods.</li>
      <li>Food prepared in a private home.</li>
      <li>Food with visible mold, spoilage, contamination, pest damage, leaking packaging or broken seals.</li>
      <li>Food subject to an active recall.</li>
      <li>Any food that a donor, volunteer or receiving charity reasonably believes may be unsafe.</li>
    </ul>
  </section>

  <section class="policy-section">
    <h2>4. Food donor responsibilities</h2>
    <p>Food donors participating through ServaCibum are responsible for using reasonable care before handoff. Donors should:</p>
    <ul>
      <li>List only food that fits the current ServaCibum pilot categories.</li>
      <li>Keep food under appropriate storage conditions until the approved physical handoff.</li>
      <li>Keep original product packaging and ingredient/allergen labels intact when they exist.</li>
      <li>Not donate food known to be spoiled, contaminated, tampered with or recalled.</li>
      <li>Accurately describe the food, quantity and pickup window.</li>
      <li>Use the ServaCibum pickup-verification process at handoff.</li>
    </ul>
    <div class="policy-note">A ServaCibum listing or approval is a coordination step. It is not a professional food-safety inspection or certification of the donated food.</div>
  </section>

  <section class="policy-section">
    <h2>5. Volunteer responsibilities</h2>
    <p>Volunteers are responsible for reasonable care during transport. Volunteers should:</p>
    <ul>
      <li>Accept only the food included in the authorized assignment.</li>
      <li>Refuse or report items that are obviously open, leaking, spoiled, contaminated or materially different from the approved listing.</li>
      <li>Keep food protected from dirt, chemicals, pets, smoking, rain and other obvious contamination risks.</li>
      <li>Keep food out of direct sun or excessive vehicle heat when reasonably possible.</li>
      <li>Travel to the approved receiving charity without unnecessary delay.</li>
      <li>Not open, sample, consume, sell, keep or independently redistribute donated food.</li>
      <li>Report a damaged package, spill, accident or other incident that may affect the food before completing the delivery.</li>
    </ul>
  </section>

  <section class="policy-section">
    <h2>6. Receiving charity responsibilities</h2>
    <p>The receiving charity makes the final decision whether to accept donated food at handoff. The charity should:</p>
    <ul>
      <li>Inspect the condition of the food when it is received.</li>
      <li>Decline food that appears unsafe, damaged, contaminated or inconsistent with the approved rescue.</li>
      <li>Store accepted food appropriately after receipt.</li>
      <li>Preserve original labels and allergen information when applicable.</li>
      <li>Follow its own legal, regulatory and organizational requirements for storage and distribution.</li>
      <li>Confirm receipt through ServaCibum's applicable handoff or receipt process.</li>
    </ul>
  </section>

  <section class="policy-section">
    <h2>7. Packaging, labels and allergens</h2>
    <p>Original commercial packaging and labels should remain intact whenever available. Volunteers should not remove, replace or alter ingredient, allergen, lot-code or manufacturer information.</p>
    <p>ServaCibum does not independently verify ingredient or allergen information. Donors and receiving charities should rely on the manufacturer's original labeling and their own procedures when serving people with food allergies or dietary restrictions.</p>
  </section>

  <section class="policy-section">
    <h2>8. When there is doubt</h2>
    <p><strong>Do not complete a handoff just because a rescue has already been approved in the platform.</strong> If the food's safety or condition is reasonably in doubt, the donor, volunteer or receiving charity should stop the handoff and contact ServaCibum.</p>
    <div class="policy-alert"><strong>When in doubt, do not distribute the food.</strong> A delayed or cancelled rescue is preferable to distributing food that may be unsafe.</div>
  </section>

  <section class="policy-section">
    <h2>9. Recalls and serious safety concerns</h2>
    <p>Food subject to a known active recall must not be donated through ServaCibum. If a recall or serious safety concern is discovered after a handoff, the participant who becomes aware of it should promptly notify ServaCibum and the receiving organization.</p>
  </section>

  <section class="policy-section">
    <h2>10. No direct-to-individual distribution through the pilot</h2>
    <p>ServaCibum's current rescue workflow coordinates food from an approved food donor to an approved charitable organization. Volunteers are not authorized to redirect donated food to themselves, friends, families or members of the public.</p>
  </section>

  <section class="policy-section">
    <h2>11. Applicable law and participant responsibilities</h2>
    <p>These guidelines do not replace food-safety, licensing, storage, labeling or other legal obligations that independently apply to a donor or receiving organization. Each participating organization remains responsible for following the requirements that apply to its own operations.</p>
    <p>ServaCibum may make its pilot rules more restrictive than the minimum requirements of law and may refuse to coordinate a donation that falls outside the current pilot scope.</p>
  </section>

  <section class="policy-section">
    <h2>12. Changes to these guidelines</h2>
    <p>ServaCibum may update these guidelines as the pilot develops, including if the platform later supports additional food categories, storage methods or transportation controls. The version date at the top of this page will be updated when material changes are made.</p>
  </section>

  <section class="signing-note">
    <h2>Questions or safety concerns</h2>
    <p>Contact ServaCibum at <a href="mailto:applications@servacibum.org">applications@servacibum.org</a> before completing a handoff if a food item does not clearly fit these guidelines.</p>
    <div class="related-links">
      <a href="./volunteer-driver-agreement.php">Volunteer Driver Agreement</a>
      <a href="./privacy.php">Privacy Notice</a>
    </div>
  </section>

  <footer class="policy-footer">
  ServaCibum &middot; Serving Sugar Land, Texas &middot;
  <a href="mailto:applications@servacibum.org">Contact: applications@servacibum.org</a>
  &middot; <a href="./privacy.php">Privacy</a>
</footer>
</main>
<script src="/assets/page-end-nav.js?v=20261016a" defer></script>
</body>
</html>
