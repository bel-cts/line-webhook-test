<?php
file_put_contents('webhook_log.txt', file_get_contents('php://input') . "\n", FILE_APPEND);
http_response_code(200);
echo "OK";
file_put_contents('log.txt', $input . PHP_EOL, FILE_APPEND);  // Log เนื้อหาเต็มจาก LINE

?>