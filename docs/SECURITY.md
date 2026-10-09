# Security and Privacy Notes

ServaCibum handles information about food donors, charities, volunteers, pickup locations, and delivery workflows. The public repository is therefore intentionally narrower than the production deployment.

## Production controls represented in the project

The production codebase includes controls such as:

- server-side sessions with secure/HTTP-only cookie settings for authenticated workflows;
- CSRF protection on state-changing forms;
- PDO prepared statements for database operations;
- password hashing using PHP's password hashing APIs;
- random, time-limited account/reset/magic-link tokens stored as hashes rather than plaintext;
- login-attempt rate limiting on authenticated portals;
- role-based access to donor, charity, volunteer, and administrator workflows;
- exact pickup/contact information withheld until an authorized assignment or claim;
- donor-controlled one-time pickup verification at handoff;
- server configuration that blocks direct web access to sensitive config and log files.

## Deliberately excluded from this repository

The following are not published:

- production database credentials;
- SMTP credentials;
- server error logs and hosting paths;
- private participant uploads or identifiable personal data;
- authenticated production portal and admin-console source;
- backup ZIPs and deployment artifacts.

## Configuration

Use the files in `config/*.example.php` as templates for local development. Never commit real production credentials.
