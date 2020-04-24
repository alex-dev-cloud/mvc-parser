<?php

$Host = getenv('SMTP_HOST') ?: 'smtp.mailtrap.io';
$SMTPEmail = getenv('SMTP_EMAIL') ?: 'e3333a0a4f-ab8ade@inbox.mailtrap.io';
$SMTPAuth = getenv('SMTP_AUTH') ?: 'true';
$Username = getenv('SMTP_USERNAME') ?: '6b34c45b2c86f9';
$Password = getenv('SMTP_PASSWORD') ?: '200b604c529f0e';
$SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
$Port = getenv('SMTP_PORT') ?: '2525';

define('SMTP_HOST', $Host);
define('SMTP_EMAIL', $SMTPEmail);
define('SMTP_AUTH', $SMTPAuth);
define('SMTP_USERNAME', $Username);
define('SMTP_PASSWORD', $Password);
define('SMTP_SECURE', $SMTPSecure);
define('SMTP_PORT', $Port);