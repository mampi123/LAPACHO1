<?php
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../../../');
}
require_once ABSPATH . 'wp-load.php';

header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$user = wp_get_current_user();

if (!$user || 0 === $user->ID) {
    http_response_code(401);
    exit('Unauthorized');
}

// En vez del JWT real, devolvemos un texto fijo para probar acceso
echo 'TOKEN_DE_PRUEBA_12345';
