<?php
/**
 * Helper functions for interacting with the Store API.
 *
 * This file is autoloaded via composer.json.
 */

use Automattic\WooCommerce\StoreApi\StoreApi;
use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;

if ( ! function_exists( 'woocommerce_store_api_register_endpoint_data' ) ) {

	/**
	 * Register endpoint data under a specified namespace.
	 *
	 * @see Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema::register_endpoint_data()
	 *
	 * @param array $args Args to pass to register_endpoint_data.
	 * @returns boolean|\WP_Error True on success, WP_Error on fail.
	 */
	function woocommerce_store_api_register_endpoint_data( $args ) {
		try {
			$extend = StoreApi::container()->get( ExtendSchema::class );
			$extend->register_endpoint_data( $args );
		} catch ( \Exception $error ) {
			return new \WP_Error( 'error', $error->getMessage() );
		}
		return true;
	}
}

if ( ! function_exists( 'woocommerce_store_api_register_update_callback' ) ) {

	/**
	 * Add callback functions that can be executed by the cart/extensions endpoint.
	 *
	 * @see Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema::register_update_callback()
	 *
	 * @param array $args Args to pass to register_update_callback.
	 * @returns boolean|\WP_Error True on success, WP_Error on fail.
	 */
	function woocommerce_store_api_register_update_callback( $args ) {
		try {
			$extend = StoreApi::container()->get( ExtendSchema::class );
			$extend->register_update_callback( $args );
		} catch ( \Exception $error ) {
			return new \WP_Error( 'error', $error->getMessage() );
		}
		return true;
	}
}

if ( ! function_exists( 'woocommerce_store_api_register_payment_requirements' ) ) {

	/**
	 * Registers and validates payment requirements callbacks.
	 *
	 * @see Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema::register_payment_requirements()
	 *
	 * @param array $args Args to pass to register_payment_requirements.
	 * @returns boolean|\WP_Error True on success, WP_Error on fail.
	 */
	function woocommerce_store_api_register_payment_requirements( $args ) {
		try {
			$extend = StoreApi::container()->get( ExtendSchema::class );
			$extend->register_payment_requirements( $args );
		} catch ( \Exception $error ) {
			return new \WP_Error( 'error', $error->getMessage() );
		}
		return true;
	}
}

if ( ! function_exists( 'woocommerce_store_api_get_formatter' ) ) {

	/**
	 * Returns a formatter instance.
	 *
	 * @see Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema::get_formatter()
	 *
	 * @param string $name Formatter name.
	 * @return Automattic\WooCommerce\StoreApi\Formatters\FormatterInterface
	 */
	function woocommerce_store_api_get_formatter( $name ) {
		return StoreApi::container()->get( ExtendSchema::class )->get_formatter( $name );
	}
}
function generate_jwt_token() {
    // Verificar si el usuario está autenticado
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;  // Usamos el usuario autenticado

        // Realizar la solicitud para obtener el token JWT, utilizando el nombre de usuario
        // Aquí la clave secreta ya es usada por el plugin JWT Authentication
        $response = wp_remote_post('http://lapacho-1.local/wp-json/jwt-auth/v1/token', [
            'body' => [
                'username' => $username,
                'password' => '',  // Como el usuario ya está autenticado, no necesitamos la contraseña
            ]
        ]);

        // Si la solicitud fue exitosa
        if (is_wp_error($response)) {
            return new WP_Error('authentication_failed', 'Error al obtener el token.', ['status' => 401]);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Si el token fue recibido correctamente, lo devolvemos
        if (isset($data['token'])) {
            return new WP_REST_Response(['token' => $data['token']], 200);
        } else {
            return new WP_Error('authentication_failed', 'No se pudo generar el token.', ['status' => 401]);
        }
    } else {
        return new WP_Error('authentication_failed', 'Usuario no autenticado.', ['status' => 401]);
    }
}

// Registrar el endpoint REST para obtener el token
add_action('rest_api_init', function () {
    register_rest_route('my-api/v1', '/get-jwt-token/', [
        'methods' => 'GET',
        'callback' => 'generate_jwt_token',
        'permission_callback' => function () {
            return is_user_logged_in();  // Solo permitir la solicitud si el usuario está autenticado
        },
    ]);
});

// Cambiar el nombre de la función para evitar el conflicto con WooCommerce
function generate_custom_jwt_token() {
    // Verificar si el usuario está autenticado
    if (is_user_logged_in()) {
        // Obtenemos el usuario actual
        $current_user = wp_get_current_user();

        // Generar el token JWT utilizando el plugin JWT Authentication for WP REST API
        $token = jwt_auth_generate_token($current_user); // Usamos la función interna para generar el token

        // Verificar si el token fue generado correctamente
        if ($token) {
            return new WP_REST_Response(['token' => $token], 200);
        } else {
            return new WP_Error('authentication_failed', 'No se pudo generar el token.', ['status' => 401]);
        }
    } else {
        return new WP_Error('authentication_failed', 'Usuario no autenticado.', ['status' => 401]);
    }
}

// Registrar el endpoint REST para obtener el token
add_action('rest_api_init', function () {
    register_rest_route('my-api/v1', '/get-jwt-token/', [
        'methods' => 'GET',
        'callback' => 'generate_custom_jwt_token', // Usamos el nuevo nombre de la función
        'permission_callback' => function () {
            return is_user_logged_in();  // Solo permitir la solicitud si el usuario está autenticado
        },
    ]);
});
