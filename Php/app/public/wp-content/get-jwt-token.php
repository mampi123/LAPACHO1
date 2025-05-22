<?php

// Datos de usuario para autenticarse
$username = "mampelmartina@gmail.com";
$password = "TALABARTERIA";

// URL de la API para obtener el token
$api_url = "https://www.talabarterialapacho.com/wp-json/jwt-auth/v1/token";

// Claves de WooCommerce (consumer key y secret key)
$consumer_key = "ck_c1a0af3d4f94c512a55733281ad47c50628f52de";
$consumer_secret = "cs_a570b08a9230bec702af4f03809ea5606c073ecf";

// Preparar los datos para la solicitud
$data = json_encode(array(
    'username' => $username,
    'password' => $password,
));

// Crear la solicitud cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Usamos JSON en lugar de x-www-form-urlencoded
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',  // Cambié esto para ser JSON
    'Content-Length: ' . strlen($data),  // Asegurarse de que la longitud sea correcta
    'Authorization: Basic ' . base64_encode($consumer_key . ':' . $consumer_secret) // Claves de WooCommerce en el encabezado
));

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Verificar si hubo algún error con la solicitud cURL
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Cerrar la sesión cURL
curl_close($ch);

// Decodificar la respuesta JSON
$response_data = json_decode($response, true);

// Comprobar si se recibió el token
if (isset($response_data['token'])) {
    echo "" . $response_data['token'];
} else {
    echo "Error al obtener el token: " . $response_data['message'];
}

?>
