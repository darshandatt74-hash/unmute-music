<?php
function app_mail_config(): array
{
    $username = getenv('SMTP_USERNAME') ?: '';
    $from = getenv('SMTP_FROM') ?: $username;
    if (!$from) {
        $from = 'no-reply@example.com';
    }

    return [
        'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
        'port' => (int) (getenv('SMTP_PORT') ?: 587),
        'username' => $username,
        'password' => getenv('SMTP_PASSWORD') ?: '',
        'from' => $from,
        'from_name' => getenv('SMTP_FROM_NAME') ?: 'UNMUTE MUSIC',
    ];
}
?>
