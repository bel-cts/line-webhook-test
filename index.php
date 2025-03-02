<?php
// ตั้งค่า Error Reporting เพื่อดูปัญหา
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ตั้ง Timezone
date_default_timezone_set("Asia/Bangkok");

// Channel Access Token ของคุณ
$channelToken = "78o/tBMTwtYz6e9kaQhbEUALyZq5oJ5hnM4Kj9Eo7IV6PjJ1WuUs38Qdwk9Nn0mEUZAlR4uQntpPMo9WfYrc4EJ5VqkyqwPLlqNaQ/eQO8T+oL8Z5c9NiZSYdzVIb6kr5p3XfPfB04tTWBdxYwRkiQdB04t89/1O/w1cDnyilFU=";

// รับข้อมูลจาก LINE Webhook
$input = file_get_contents('php://input');
file_put_contents('log.txt', $input . PHP_EOL, FILE_APPEND);  // เก็บ Log ไว้ดู
$events = json_decode($input, true);

// ตรวจสอบข้อมูล
if (!is_array($events['events']) || count($events['events']) === 0) {
    echo "No events received";
    exit;
}

// วนลูปอ่านทุก event (ปกติจะมา 1 event ต่อครั้ง)
foreach ($events['events'] as $event) {
    // ตรวจสอบว่าเป็นข้อความหรือไม่
    if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
        $replyToken = $event['replyToken'];
        $userMessage = $event['message']['text'];

        // เตรียมข้อความตอบกลับ
        $replyMessage = "คุณพิมพ์ว่า: " . $userMessage;

        // ส่งข้อความกลับไป
        $url = "https://api.line.me/v2/bot/message/reply";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . $channelToken
        ];
        $data = [
            "replyToken" => $replyToken,
            "messages" => [
                ["type" => "text", "text" => $replyMessage]
            ]
        ];

        // ใช้ CURL ส่งข้อความ
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Log การส่งกลับ
        file_put_contents('log.txt', "Reply Response: " . $response . PHP_EOL, FILE_APPEND);
    }
}

echo "OK";
