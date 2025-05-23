<?php
header('Access-Control-Allow-Origin: *');
echo json_encode(['status' => 'ok', 'time' => date('c')]);
