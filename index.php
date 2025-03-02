<?php
file_put_contents('webhook_log.txt', file_get_contents('php://input') . "\n", FILE_APPEND);
http_response_code(200);
echo "OK";
?>