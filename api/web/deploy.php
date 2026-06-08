<?php

$secret = 'bba7eca98b8815eacdaca52ee5ab0b25956dc1f9'; // <--- bu sizning tokeningiz

$payload = file_get_contents('php://input');
$headers = getallheaders();

if (!isset($headers['X-Hub-Signature-256'])) {
    http_response_code(403);
    exit('No signature header');
}

$signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($signature, $headers['X-Hub-Signature-256'])) {
    http_response_code(403);
    exit('Signature mismatch');
}

// Kodni yuklab olamiz
exec('cd /var/www/med-yii2 && sudo git pull origin main 2>&1', $output);
echo implode("\n", $output);
