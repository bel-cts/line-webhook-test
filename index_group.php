<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$raw = file_get_contents("php://input");
file_put_contents("webhook.log", date("Y-m-d H:i:s") . "\n" . $raw . "\n\n", FILE_APPEND);

$data = json_decode($raw, true);

if (isset($data['events'][0]['source']['groupId'])) {
    $groupId = $data['events'][0]['source']['groupId'];
    file_put_contents("group_id.log", $groupId . "\n", FILE_APPEND);
    echo "Group ID: " . $groupId;
} else {
    echo "This is not a group event.";
}
