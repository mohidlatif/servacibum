# ServaCibum

**ServaCibum is a student-built food-rescue platform designed to connect food donors, charities, and volunteers so surplus food can be coordinated for community use rather than wasted.**

**Live site:** [servacibum.org](https://servacibum.org)

## What the Platform Does

ServaCibum supports a structured food-rescue workflow:

1. A food donor posts available surplus food.
2. A charity requests food.
3. An administrator reviews and matches requests.
4. An approved volunteer can claim or accept a delivery, or the charity can use an approved self-pickup flow.
5. The physical pickup is verified.
6. The receiving charity confirms receipt.

The production platform includes separate donor, charity, volunteer, and administrator experiences.

## Public Repository

This repository is a **portfolio-safe public snapshot** of the project. It contains the public website, public API bootstrap, PWA assets, and configuration examples.

Production credentials, logs, private participant data, authenticated portal code, and administrator source are intentionally excluded.

See:

- [Architecture](docs/ARCHITECTURE.md)
- [Security and Privacy Notes](docs/SECURITY.md)

## Technologies

- PHP
- MySQL / PDO
- HTML
- CSS
- JavaScript
- JSON
- Progressive Web App (PWA) features
- Git and GitHub

## Selected Engineering Features

- Role-based donor, charity, volunteer, and admin workflows
- Donation/request matching and delivery coordination
- Volunteer self-claim and assignment workflows
- Privacy-aware pickup/contact information handling
- One-time pickup verification at physical handoff
- Receipt confirmation and delivery-state tracking
- CSRF protection, prepared database queries, password hashing, and login-rate controls
- Installable PWA shell with authenticated/live workflow pages kept network-only

## My Role

**Mohid Latif — Founder & Developer**

I founded ServaCibum and designed and developed the platform's workflow, public website, and role-based donor, charity, volunteer, and administrative experiences. My work has included the donation/request workflow, matching and delivery logic, pickup verification, privacy and security controls, PWA behavior, and ongoing testing for a controlled community pilot.

## Repository Structure

```text
api/        Public read-only API bootstrap
app/        Public JavaScript application code
assets/     Public styles and images
config/     Example configuration templates only
docs/       Architecture and security documentation
includes/   Shared public application helpers
pwa/        PWA icons and assets

index.html          Public homepage
about-us.php        About ServaCibum
food-safety.php     Pilot food-safety guidance
get-involved.php    Public participation/application page
privacy.php         Privacy information
terms-of-use.php    Terms of use
manifest.webmanifest
sw.js               Service worker
offline.html        Offline fallback
```

## Local Configuration

Copy the example configuration files before running database-backed features:

```bash
cp config/database.example.php config/database.php
cp config/mail.example.php config/mail.php
```

Then fill in your own **local/development** database and mail settings. Never use or commit production credentials.

---

**ServaCibum**  
Sugar Land, Texas
