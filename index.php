<?php
$input = file_get_contents("php://input");
file_put_contents("log.txt", date("Y-m-d H:i:s") . "\n" . $input . "\n", FILE_APPEND);
http_response_code(200);
echo "OK";
?>
