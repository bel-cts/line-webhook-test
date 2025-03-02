<?php
$channelToken = 'ใส่ Channel Access Token ตรงนี้';
$userId = 'ใส่ User ID ของคนรับ';

$message = 'Hello from Render PHP';

$data = [
    'to' => $userId,
    'messages' => [
        ['type' => 'text', 'text' => $message]
    ]
];

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $channelToken,
];

$ch = curl_init('https://api.line.me/v2/bot/message/push');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo 'Response: ' . $response;
?>