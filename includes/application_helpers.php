<?php
declare(strict_types=1);

function ensure_applications_table(PDO $pdo): void
{
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS applications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            application_type ENUM('volunteer','restaurant','charity') NOT NULL,
            applicant_name VARCHAR(150) NOT NULL,
            organization_name VARCHAR(180) NULL,
            email VARCHAR(190) NOT NULL,
            phone VARCHAR(50) NOT NULL,
            address VARCHAR(255) NULL,
            zip VARCHAR(12) NULL,
            availability VARCHAR(40) NULL,
            transportation VARCHAR(30) NULL,
            food_types TEXT NULL,
            needs_capacity TEXT NULL,
            notes TEXT NULL,
            status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
            notification_sent TINYINT(1) NOT NULL DEFAULT 0,
            reviewed_by VARCHAR(100) NULL,
            reviewed_at DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_applications_status (status),
            INDEX idx_applications_type (application_type),
            INDEX idx_applications_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );
}

function clean_single_line(string $value): string
{
    return trim(str_replace(["\r", "\n"], ' ', $value));
}

function application_type_label(string $type): string
{
    switch ($type) {
        case 'volunteer':
            return 'Volunteer';

        case 'restaurant':
            return 'Restaurant Partner';

        case 'charity':
            return 'Charity / Organization Partner';

        default:
            return 'Application';
    }
}

function smtp_read_response($socket): array
{
    $lines = [];

    while (($line = fgets($socket, 515)) !== false) {
        $lines[] = rtrim($line, "\r\n");

        if (strlen($line) >= 4 && $line[3] === ' ') {
            break;
        }
    }

    $last = end($lines) ?: '';
    $code = (int) substr($last, 0, 3);

    return [$code, implode("\n", $lines)];
}

function smtp_command($socket, string $command, array $expectedCodes): void
{
    fwrite($socket, $command . "\r\n");

    list($code, $response) = smtp_read_response($socket);

    if (!in_array($code, $expectedCodes, true)) {
        throw new RuntimeException(
            'SMTP command failed: ' . $response
        );
    }
}

function send_application_email(array $mailConfig, array $application): bool
{
    $host = (string) ($mailConfig['host'] ?? '');
    $port = (int) ($mailConfig['port'] ?? 465);
    $username = (string) ($mailConfig['username'] ?? '');
    $password = (string) ($mailConfig['password'] ?? '');

    $fromEmail = clean_single_line(
        (string) ($mailConfig['from_email'] ?? $username)
    );

    $fromName = clean_single_line(
        (string) ($mailConfig['from_name'] ?? 'ServaCibum Applications')
    );

    $adminEmail = clean_single_line(
        (string) ($mailConfig['admin_email'] ?? $username)
    );

    $applicantEmail = (string) ($application['email'] ?? '');

    if (filter_var($applicantEmail, FILTER_VALIDATE_EMAIL)) {
        $replyTo = clean_single_line($applicantEmail);
    } else {
        $replyTo = $fromEmail;
    }

    if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        $adminEmail = 'applications@servacibum.org';
    }

    if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
        $fromEmail = 'applications@servacibum.org';
    }

    $label = application_type_label(
        (string) $application['application_type']
    );

    $subject = 'New ServaCibum ' . $label . ' Application';

    $lines = [
        'A new public application was submitted to ServaCibum.',
        '',
        'Application type: ' . $label,
        'Applicant / contact: ' . ($application['applicant_name'] ?? '')
    ];

    if (!empty($application['organization_name'])) {
        $lines[] =
            'Organization / business: ' .
            $application['organization_name'];
    }

    $lines[] = 'Email: ' . ($application['email'] ?? '');
    $lines[] = 'Phone: ' . ($application['phone'] ?? '');

    if (!empty($application['address'])) {
        $lines[] = 'Address: ' . $application['address'];
    }

    if (!empty($application['zip'])) {
        $lines[] = 'ZIP: ' . $application['zip'];
    }

    if (!empty($application['availability'])) {
        $lines[] =
            'Availability: ' .
            $application['availability'];
    }

    if (!empty($application['transportation'])) {
        $lines[] =
            'Transportation access: ' .
            $application['transportation'];
    }

    if (!empty($application['food_types'])) {
        $lines[] =
            'Food normally available: ' .
            $application['food_types'];
    }

    if (!empty($application['needs_capacity'])) {
        $lines[] =
            'Needs / capacity: ' .
            $application['needs_capacity'];
    }

    if (!empty($application['notes'])) {
        $lines[] =
            'Notes: ' .
            $application['notes'];
    }

    $lines[] = '';
    $lines[] =
        'Review this application in the ServaCibum Admin Console:';

    $lines[] =
        'https://servacibum.org/admin/applications.php';

    $body = implode("\r\n", $lines);

    try {

        if ($host === '' || $username === '' || $password === '') {
            throw new RuntimeException(
                'SMTP credentials are unavailable.'
            );
        }

        $prefix =
            (($mailConfig['encryption'] ?? 'ssl') === 'ssl')
            ? 'ssl://'
            : 'tcp://';

        $transport = $prefix . $host . ':' . $port;

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false
            ]
        ]);

        $errno = 0;
        $errstr = '';

        $socket = @stream_socket_client(
            $transport,
            $errno,
            $errstr,
            15,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$socket) {
            throw new RuntimeException(
                'SMTP connection failed.'
            );
        }

        stream_set_timeout($socket, 15);

        list($code) = smtp_read_response($socket);

        if ($code !== 220) {
            throw new RuntimeException(
                'SMTP greeting failed.'
            );
        }

        smtp_command(
            $socket,
            'EHLO servacibum.org',
            [250]
        );

        smtp_command(
            $socket,
            'AUTH LOGIN',
            [334]
        );

        smtp_command(
            $socket,
            base64_encode($username),
            [334]
        );

        smtp_command(
            $socket,
            base64_encode($password),
            [235]
        );

        smtp_command(
            $socket,
            'MAIL FROM:<' . $fromEmail . '>',
            [250]
        );

        smtp_command(
            $socket,
            'RCPT TO:<' . $adminEmail . '>',
            [250, 251]
        );

        smtp_command(
            $socket,
            'DATA',
            [354]
        );

        $headers = [
            'Date: ' . date(DATE_RFC2822),
            'From: ' .
                $fromName .
                ' <' .
                $fromEmail .
                '>',
            'To: ' . $adminEmail,
            'Reply-To: ' . $replyTo,
            'Subject: ' . $subject,
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit'
        ];

        $payload =
            implode("\r\n", $headers) .
            "\r\n\r\n" .
            $body;

        fwrite(
            $socket,
            $payload . "\r\n.\r\n"
        );

        list($dataCode) =
            smtp_read_response($socket);

        if ($dataCode !== 250) {
            throw new RuntimeException(
                'SMTP message was not accepted.'
            );
        }

        @smtp_command(
            $socket,
            'QUIT',
            [221]
        );

        fclose($socket);

        return true;

    } catch (Throwable $e) {

        $headers = [
            'From: ' .
                $fromName .
                ' <' .
                $fromEmail .
                '>',
            'Reply-To: ' . $replyTo,
            'Content-Type: text/plain; charset=UTF-8'
        ];

        return @mail(
            $adminEmail,
            $subject,
            str_replace(
                "\r\n",
                PHP_EOL,
                $body
            ),
            implode("\r\n", $headers)
        );
    }
}