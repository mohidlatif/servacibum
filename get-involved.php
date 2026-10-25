<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

require __DIR__ . '/includes/application_helpers.php';

$dbConfig = require __DIR__ . '/config/database.php';
$mailConfig = [];

$mailConfigFile = __DIR__ . '/config/mail.php';

if (is_file($mailConfigFile)) {
    try {
        $config = require $mailConfigFile;

        if (is_array($config)) {
            $mailConfig = $config;
        }
    } catch (Throwable $e) {
        $mailConfig = [];
    }
}

function h(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function old(string $name): string
{
    return trim((string)($_POST[$name] ?? ''));
}

/*
 * Volunteer applications have one canonical workflow.
 * Old bookmarks and cached copies of the former volunteer form are routed
 * into the dedicated Volunteer registration page, which creates the portal
 * password during application.
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'
    && (string)($_GET['type'] ?? '') === 'volunteer'
) {
    header('Location: ./volunteer/apply.php', true, 302);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && (string)($_POST['application_type'] ?? '') === 'volunteer'
) {
    header('Location: ./volunteer/apply.php', true, 303);
    exit;
}

$pdo = null;
$dbError = false;

try {
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $dbConfig['host'],
        $dbConfig['database'],
        $dbConfig['charset']
    );

    $pdo = new PDO(
        $dsn,
        $dbConfig['username'],
        $dbConfig['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    ensure_applications_table($pdo);
} catch (Throwable $e) {
    $dbError = true;
}

if (empty($_SESSION['public_application_csrf'])) {
    $_SESSION['public_application_csrf'] = bin2hex(random_bytes(32));
}

$allowedTypes = ['restaurant', 'charity'];

$selectedType = (string)($_GET['type'] ?? '');

if (!in_array($selectedType, $allowedTypes, true)) {
    $selectedType = '';
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$dbError && $pdo instanceof PDO) {
    $selectedType = (string)($_POST['application_type'] ?? '');

    if (!in_array($selectedType, $allowedTypes, true)) {
        $errors[] = 'Please choose an application type.';
    }

    $token = (string)($_POST['csrf'] ?? '');

    if (
        !$token ||
        !hash_equals(
            (string)$_SESSION['public_application_csrf'],
            $token
        )
    ) {
        $errors[] = 'Your form session expired. Please refresh and try again.';
    }

    // Hidden field used to catch basic bot submissions.
    if (old('website') !== '') {
        $errors[] = 'The form could not be submitted.';
    }

    $lastSubmit = (int)($_SESSION['last_application_submit'] ?? 0);

    if ($lastSubmit && (time() - $lastSubmit) < 15) {
        $errors[] = 'Please wait a few seconds before submitting another application.';
    }

    $applicantName = old('applicant_name');
    $organizationName = old('organization_name');
    $email = old('email');
    $phone = old('phone');
    $address = old('address');
    $zip = old('zip');
    $availability = old('availability');
    $transportation = old('transportation');
    $foodTypes = old('food_types');
    $needsCapacity = old('needs_capacity');
    $notes = old('notes');

    if ($applicantName === '') {
        $errors[] = 'Name / contact person is required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($phone === '') {
        $errors[] = 'Phone number is required.';
    }

    if ($zip === '') {
        $errors[] = 'ZIP code is required.';
    }

    if ($selectedType === 'restaurant') {
        if ($organizationName === '') {
            $errors[] = 'Business name is required.';
        }

        if ($address === '') {
            $errors[] = 'Business address is required.';
        }

        if ($foodTypes === '') {
            $errors[] = 'Please describe the type of food normally available.';
        }
    }

    if ($selectedType === 'charity') {
        if ($organizationName === '') {
            $errors[] = 'Organization name is required.';
        }

        if ($address === '') {
            $errors[] = 'Organization address is required.';
        }

        if ($needsCapacity === '') {
            $errors[] = 'Please describe your organization needs or capacity.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO applications (
                application_type,
                applicant_name,
                organization_name,
                email,
                phone,
                address,
                zip,
                availability,
                transportation,
                food_types,
                needs_capacity,
                notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $selectedType,
            $applicantName,
            $organizationName !== '' ? $organizationName : null,
            $email,
            $phone,
            $address !== '' ? $address : null,
            $zip,
            $availability !== '' ? $availability : null,
            $transportation !== '' ? $transportation : null,
            $foodTypes !== '' ? $foodTypes : null,
            $needsCapacity !== '' ? $needsCapacity : null,
            $notes !== '' ? $notes : null,
        ]);

        $applicationId = (int)$pdo->lastInsertId();

        $application = [
            'application_type' => $selectedType,
            'applicant_name' => $applicantName,
            'organization_name' => $organizationName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'zip' => $zip,
            'availability' => $availability,
            'transportation' => $transportation,
            'food_types' => $foodTypes,
            'needs_capacity' => $needsCapacity,
            'notes' => $notes,
        ];

        $sent = send_application_email($mailConfig, $application);

        $stmt = $pdo->prepare(
            'UPDATE applications
             SET notification_sent = ?
             WHERE id = ?'
        );

        $stmt->execute([
            $sent ? 1 : 0,
            $applicationId,
        ]);

        $_SESSION['last_application_submit'] = time();
        $_SESSION['public_application_csrf'] = bin2hex(random_bytes(32));

        header('Location: get-involved.php?submitted=1');
        exit;
    }
}

$submitted = isset($_GET['submitted']);
?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="description"
        content="Apply to volunteer or partner with ServaCibum."
    >

    <title>Get Involved - ServaCibum</title>

    <link
        rel="stylesheet"
        href="./assets/get-involved.css?v=20261018-webp-hero"
    >

    <style>
        .approved-partner-box {
            margin: 16px 0 4px;
            padding: 14px 16px;
            background: #eef8f1;
            border: 1px solid #cfe7d6;
            border-radius: 10px;
            color: #173326;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .donate-food-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 12px 20px;

            background: #158447;
            color: #fff;

            border-radius: 9px;

            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .donate-food-button:hover {
            background: #116f3c;
        }

        .privacy-disclosure {
            margin: 0 0 14px;
            padding: 12px 14px;
            border: 1px solid #d8e8dd;
            border-radius: 10px;
            background: #f4f8f5;
            color: #5b6d63;
            font-size: 12px;
            line-height: 1.6;
        }

        .privacy-disclosure strong {
            color: #173326;
        }

        .privacy-disclosure a {
            color: #158447;
            font-weight: 800;
            text-decoration: none;
        }

        .privacy-disclosure a:hover {
            text-decoration: underline;
        }

        .public-site-footer {
            padding: 18px 20px 22px;
            text-align: center;
            color: #748279;
            font-size: 11px;
            line-height: 1.5;
        }

        .public-site-footer a {
            color: #587066;
            font-weight: 700;
            text-decoration: none;
        }

        .public-site-footer a:hover {
            text-decoration: underline;
        }


        /* Role cards: simple public-facing choices. */
        .choice-card {
            min-height: 230px;
        }

        .role-actions {
            display: grid;
            gap: 8px;
            margin-top: auto;
            padding-top: 18px;
        }

        .role-primary,
        .role-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 850;
            text-align: center;
        }

        .role-primary {
            background: #fff;
            color: #0c6636;
        }

        .role-primary:hover {
            background: #f2fff6;
        }

        .role-secondary {
            border: 1px solid rgba(255,255,255,.36);
            color: #fff;
            background: rgba(255,255,255,.06);
        }

        .role-secondary:hover {
            background: rgba(255,255,255,.14);
        }

        .volunteer-requirements {
            margin-top: 12px;
            color: rgba(255,255,255,.92);
            font-size: 11px;
            line-height: 1.55;
        }

        .volunteer-requirements strong {
            color: #fff;
        }

        @media (max-width: 760px) {
            .choice-card {
                min-height: 0;
            }
        }
    </style>
</head>

<body>

<header class="public-header">

    <a
        class="public-brand"
        href="./"
        aria-label="ServaCibum home"
    >
        <img
            src="./assets/servacibum-logo.png"
            alt="ServaCibum"
        >

        <div class="public-brand-copy">
            <strong>ServaCibum</strong>
            <span>Community food rescue platform.</span>
        </div>
    </a>

    <nav class="public-nav" aria-label="ServaCibum navigation">
        <a href="./">Dashboard</a>
        <a href="./donor/index.php">Donate Food</a>
        <a href="./charity/index.php">Request Food</a>
        <a
            href="https://www.google.com/maps/search/?api=1&query=Sugar+Land+TX"
            target="_blank"
            rel="noopener"
        >Map</a>
        <a href="./volunteer/index.php">Volunteer Network</a>
        <a href="./about-us.php">About Us</a>
    </nav>

    <a
        class="get-involved-link active"
        href="./get-involved.php"
    >
        Get Involved
    </a>

</header>

<nav class="mobile-public-nav" aria-label="ServaCibum mobile navigation">
    <a href="./">Dashboard</a>
    <a href="./donor/index.php">Donate Food</a>
    <a href="./charity/index.php">Request Food</a>
    <a
        href="https://www.google.com/maps/search/?api=1&query=Sugar+Land+TX"
        target="_blank"
        rel="noopener"
    >Map</a>
    <a href="./volunteer/index.php">Volunteer Network</a>
    <a href="./about-us.php">About Us</a>
</nav>


<main class="application-shell">

<?php if ($submitted): ?>

    <section class="success-card">

        <span class="kicker">
            APPLICATION RECEIVED
        </span>

        <h1>
            Thank you for getting involved.
        </h1>

        <p>
            Your application has been submitted for review.
            A ServaCibum administrator will review it before
            anything is added to the public platform.
        </p>

        <a
            class="primary-link"
            href="./"
        >
            Return to ServaCibum
        </a>

    </section>


<?php elseif ($dbError): ?>

    <section class="success-card error-card">

        <span class="kicker">
            TEMPORARILY UNAVAILABLE
        </span>

        <h1>
            Applications cannot be submitted right now.
        </h1>

        <p>
            Please try again later.
        </p>

        <a
            class="primary-link"
            href="./"
        >
            Return to ServaCibum
        </a>

    </section>


<?php else: ?>

    <section class="intro">

        <span class="kicker">
            GET INVOLVED
        </span>

        <h1>
            How would you like to help?
        </h1>

        <p>
            Public submissions are reviewed by ServaCibum
            before they become active on the platform.
        </p>

    </section>


    <?php if ($errors): ?>

        <div class="form-errors">

            <strong>
                Please check the form:
            </strong>

            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>

        </div>

    <?php endif; ?>


    <section class="choice-grid" aria-label="Choose how to get involved">

        <article class="choice-card">
            <span class="choice-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" role="img">
                    <circle cx="12" cy="7" r="3"></circle>
                    <circle cx="5.5" cy="9" r="2.2"></circle>
                    <circle cx="18.5" cy="9" r="2.2"></circle>
                    <path d="M7 20v-1.1c0-3.2 2.2-5.6 5-5.6s5 2.4 5 5.6V20H7Z"></path>
                    <path d="M2 20v-.7c0-2.6 1.6-4.6 3.8-4.6.8 0 1.5.2 2.1.6A7.1 7.1 0 0 0 5.5 20H2Z"></path>
                    <path d="M22 20h-3.5a7.1 7.1 0 0 0-2.4-4.7c.6-.4 1.3-.6 2.1-.6 2.2 0 3.8 2 3.8 4.6v.7Z"></path>
                </svg>
            </span>

            <h2>Become a Volunteer Driver</h2>
            <p>Pick up rescued food from local donors and deliver it to community organizations.</p>

            <p class="volunteer-requirements">
                <strong>Driver requirements:</strong>
                You must be 16+, hold a valid driver’s license, and have access to a
                currently registered and insured vehicle. Ages 16–17 also require
                parent/legal-guardian authorization.
            </p>

            <div class="role-actions">
                <a class="role-primary" href="./volunteer/apply.php">Apply as a Volunteer Driver →</a>
                <a class="role-secondary" href="./volunteer/signin.php">Already approved? Volunteer Sign In</a>
            </div>
        </article>


        <article class="choice-card <?= $selectedType === 'restaurant' ? 'selected' : '' ?>">
            <span class="choice-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" role="img">
                    <path d="M4 4h16l1 5.5a3 3 0 0 1-2.9 3.5c-.8 0-1.55-.31-2.1-.86A2.95 2.95 0 0 1 13.9 13c-.72 0-1.4-.25-1.9-.7-.5.45-1.18.7-1.9.7-.8 0-1.55-.31-2.1-.86A2.95 2.95 0 0 1 5.9 13 3 3 0 0 1 3 9.5L4 4Zm1.4 10.1c.18.02.35.03.5.03.78 0 1.52-.2 2.15-.56.62.36 1.34.56 2.05.56.72 0 1.38-.18 1.9-.5.52.32 1.18.5 1.9.5.72 0 1.43-.2 2.05-.56.63.36 1.37.56 2.15.56.15 0 .32-.01.5-.03V20H5.4v-5.9ZM8 16v4h3v-4H8Zm6 0v2h3v-2h-3Z"/>
                </svg>
            </span>

            <h2>Become a Food Donor Partner</h2>
            <p>Apply to join ServaCibum as an approved local food donor partner.</p>

            <div class="role-actions">
                <a class="role-primary" href="?type=restaurant#application-form">Apply as a Food Donor →</a>
                <a class="role-secondary" href="./donor/index.php">Already approved? Food Donor Portal</a>
            </div>
        </article>


        <article class="choice-card <?= $selectedType === 'charity' ? 'selected' : '' ?>">
            <span class="choice-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" role="img">
                    <path d="M12 3 3 8v2h18V8l-9-5Zm-6 9v7H4v2h16v-2h-2v-7h-2v7h-3v-7h-2v7H8v-7H6Zm6-6.2 4.6 2.55H7.4L12 5.8Z"/>
                    <path d="M11 9h2v2h-2z"/>
                </svg>
            </span>

            <h2>Become a Charity Partner</h2>
            <p>Apply as a charity or community organization that can receive rescued food.</p>

            <div class="role-actions">
                <a class="role-primary" href="?type=charity#application-form">Apply as a Charity →</a>
                <a class="role-secondary" href="./charity/index.php">Already approved? Charity Portal</a>
            </div>
        </article>

    </section>

    <?php if ($selectedType): ?>

        <section
            class="form-card"
            id="application-form"
        >

            <div class="form-heading">

                <span class="kicker">
                    <?= $selectedType === 'restaurant'
                        ? 'FOOD DONOR PARTNER'
                        : 'CHARITY PARTNER' ?>
                </span>

                <h2>
                    <?= $selectedType === 'restaurant'
                        ? 'Apply to become a Food Donor Partner'
                        : 'Apply to become a Charity Partner' ?>
                </h2>

                <p>
                    Submit your organization information for ServaCibum review.
                    If approved, we will create your portal account and send a
                    one-time activation email so you can create your password.
                </p>

            </div>


            <form
                method="post"
                action="get-involved.php?type=<?= h($selectedType) ?>"
            >

                <input
                    type="hidden"
                    name="csrf"
                    value="<?= h(
                        (string)$_SESSION['public_application_csrf']
                    ) ?>"
                >

                <input
                    type="hidden"
                    name="application_type"
                    value="<?= h($selectedType) ?>"
                >


                <label
                    class="trap"
                    aria-hidden="true"
                >
                    Website

                    <input
                        name="website"
                        tabindex="-1"
                        autocomplete="off"
                    >
                </label>


                <?php if ($selectedType === 'restaurant'): ?>


                    <div class="form-grid">

                        <label>
                            <span>Business name</span>

                            <input
                                name="organization_name"
                                required
                                value="<?= h(old('organization_name')) ?>"
                            >
                        </label>


                        <label>
                            <span>Contact person</span>

                            <input
                                name="applicant_name"
                                required
                                autocomplete="name"
                                value="<?= h(old('applicant_name')) ?>"
                            >
                        </label>


                        <label>
                            <span>Email</span>

                            <input
                                type="email"
                                name="email"
                                required
                                autocomplete="email"
                                value="<?= h(old('email')) ?>"
                            >
                        </label>


                        <label>
                            <span>Phone</span>

                            <input
                                type="tel"
                                name="phone"
                                required
                                autocomplete="tel"
                                value="<?= h(old('phone')) ?>"
                            >
                        </label>


                        <label class="wide">
                            <span>Address</span>

                            <input
                                name="address"
                                required
                                autocomplete="street-address"
                                value="<?= h(old('address')) ?>"
                            >
                        </label>


                        <label>
                            <span>ZIP code</span>

                            <input
                                name="zip"
                                required
                                inputmode="numeric"
                                autocomplete="postal-code"
                                value="<?= h(old('zip')) ?>"
                            >
                        </label>

                    </div>


                    <label class="full-field">
                        <span>Type of food normally available</span>

                        <textarea
                            name="food_types"
                            rows="5"
                            required
                            placeholder="For example: pantry staples, canned goods, whole produce, sealed packaged food, or packaged bakery items."
                        ><?= h(old('food_types')) ?></textarea>
                    </label>


                    <label class="full-field">
                        <span>Optional notes</span>

                        <textarea
                            name="notes"
                            rows="4"
                        ><?= h(old('notes')) ?></textarea>
                    </label>


                <?php else: ?>

                    <div class="form-grid">

                        <label>
                            <span>Organization name</span>

                            <input
                                name="organization_name"
                                required
                                value="<?= h(old('organization_name')) ?>"
                            >
                        </label>


                        <label>
                            <span>Contact person</span>

                            <input
                                name="applicant_name"
                                required
                                autocomplete="name"
                                value="<?= h(old('applicant_name')) ?>"
                            >
                        </label>


                        <label>
                            <span>Email</span>

                            <input
                                type="email"
                                name="email"
                                required
                                autocomplete="email"
                                value="<?= h(old('email')) ?>"
                            >
                        </label>


                        <label>
                            <span>Phone</span>

                            <input
                                type="tel"
                                name="phone"
                                required
                                autocomplete="tel"
                                value="<?= h(old('phone')) ?>"
                            >
                        </label>


                        <label class="wide">
                            <span>Address</span>

                            <input
                                name="address"
                                required
                                autocomplete="street-address"
                                value="<?= h(old('address')) ?>"
                            >
                        </label>


                        <label>
                            <span>ZIP code</span>

                            <input
                                name="zip"
                                required
                                inputmode="numeric"
                                autocomplete="postal-code"
                                value="<?= h(old('zip')) ?>"
                            >
                        </label>

                    </div>


                    <label class="full-field">
                        <span>Needs / receiving capacity</span>

                        <textarea
                            name="needs_capacity"
                            rows="5"
                            required
                            placeholder="Tell us what food your organization can use, storage limitations, typical quantities, or pickup needs."
                        ><?= h(old('needs_capacity')) ?></textarea>
                    </label>


                    <label class="full-field">
                        <span>Optional notes</span>

                        <textarea
                            name="notes"
                            rows="4"
                        ><?= h(old('notes')) ?></textarea>
                    </label>

                <?php endif; ?>


                <div class="privacy-disclosure">
                    <strong>Privacy:</strong> Information submitted through this application is used
                    to review your application, contact you about ServaCibum participation and, if
                    approved, manage your account and food-rescue activity. Please review the
                    <a href="./privacy.php" target="_blank" rel="noopener">ServaCibum Privacy Notice</a>.
                </div>

                <div class="form-footer">

                    <p>
                        Submitting this form creates a pending application.
                        After Admin approval, you will receive a one-time portal activation email.
                    </p>

                    <button type="submit">
                        Submit for Review
                    </button>

                </div>

            </form>

        </section>

    <?php endif; ?>

<?php endif; ?>
</main>

<footer class="public-site-footer">
    ServaCibum &middot; Serving Sugar Land, Texas &middot;
    <a href="mailto:applications@servacibum.org">
        Contact: applications@servacibum.org
    </a>
    &middot;
    <a href="./privacy.php">Privacy</a>
</footer>

<script src="/assets/page-end-nav.js?v=20261016a" defer></script>
</body>
</html>