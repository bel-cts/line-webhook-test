<?php

// $accessToken = 'YOUR_CHANNEL_ACCESS_TOKEN'; // ใส่ของจริง
$accessToken ="78o/tBMTwtYz6e9kaQhbEUALyZq5oJ5hnM4Kj9Eo7IV6PjJ1WuUs38Qdwk9Nn0mEUZAlR4uQntpPMo9WfYrc4EJ5VqkyqwPLlqNaQ/eQO8T+oL8Z5c9NiZSYdzVIb6kr5p3XfPfB04tTWBdxYwRkiQdB04t89/1O/w1cDnyilFU=";
$logFile = 'webhook_log.txt'; // เอาไว้ Debug ดูข้อมูลที่เข้ามา

// รับข้อมูลจาก LINE (Webhook)
$content = file_get_contents('php://input');
file_put_contents($logFile, $content . "\n", FILE_APPEND); // Log ข้อมูล

$events = json_decode($content, true);

// ตรวจสอบว่าเป็น Message Event หรือเปล่า
if (!empty($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $userId = $event['source']['userId']; // ดึง User ID มา
            $replyToken = $event['replyToken']; // ดึง replyToken สำหรับตอบกลับทันที
            $userMessage = $event['message']['text']; // ข้อความที่ผู้ใช้ส่งมา

            // ตอบกลับข้อความ (Reply Message)
            replyMessage($replyToken, $userMessage, $accessToken);

            // หรือถ้าต้องการเก็บ User ID ไว้ใช้ Push ทีหลัง
            file_put_contents('user_ids.txt', $userId . "\n", FILE_APPEND);
        }
    }
}

// ฟังก์ชันตอบกลับ (Reply Message)
function replyMessage($replyToken, $userMessage, $accessToken)
{
    $replyText = "คุณส่งข้อความว่า: " . $userMessage;

    $data = [
        'replyToken' => $replyToken,
        'messages' => [
            [
                'type' => 'text',
                'text' => $replyText
            ]
        ]
    ];

    $ch = curl_init('https://api.line.me/v2/bot/message/reply');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
