<?php
// $channelToken = 'ใส่ Channel Access Token ตรงนี้';
// $userId = 'ใส่ User ID ของคนรับ';

$channelToken = "78o/tBMTwtYz6e9kaQhbEUALyZq5oJ5hnM4Kj9Eo7IV6PjJ1WuUs38Qdwk9Nn0mEUZAlR4uQntpPMo9WfYrc4EJ5VqkyqwPLlqNaQ/eQO8T+oL8Z5c9NiZSYdzVIb6kr5p3XfPfB04tTWBdxYwRkiQdB04t89/1O/w1cDnyilFU=";  // ใส่ Token จริงของคุณตรงนี้
$userId = "U5c03588801f02198d250e6b8da6b037d";  // User ID ตัวอย่าง (เปลี่ยนตามจริง)


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