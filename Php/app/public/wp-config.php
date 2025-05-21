<?php

//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'jiqm51DJDIe35DIAmJqzcdWMNZSextn83oqKbPMOgLF6cwLxDSA3tLCDTZ3MKlGd');
//END Really Simple Security key
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lapacho');   // El nombre de la base de datos en phpMyAdmin
define('DB_USER', 'root');               // Usuario por defecto en XAMPP
define('DB_PASSWORD', '');               // Contraseña vacía por defecto en XAMPP
define('DB_HOST', 'localhost');          // Normalmente 'localhost'
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);


/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '8v_wA1S=ZS(t1;1y[&P1Y-yFG:(16U`V~Z@;d{WNb+hPy7^l,U5,e&{<aWoh!HL>' );
define( 'SECURE_AUTH_KEY',   'x-e%;0KwhT;ipc&=kK$&i?<`CrhmUls`bS-rW^^[j?q4>ZXQ!X~+du/ZjwmJ16^Q' );
define( 'LOGGED_IN_KEY',     'wQf56_wQUwpGD^)P9kKYF;s;Cf3o1`5FwC<nS8DmxfkyLLS>3:(la1>lc(K-iMlS' );
define( 'NONCE_KEY',         'sNZ){P)SgR{ZEg=?/U/GHJsbs?<3ii<,Q^ABjrfSyBz#f43Za`gfplVg& 3BvyYn' );
define( 'AUTH_SALT',         '#]}[uWA>bJt>M*_n`0zO5Tp:,Fk!V *l^yp2dF1MttSM3 R:N7_.L- /@&mdVs2j' );
define( 'SECURE_AUTH_SALT',  'EAZSDdGdR_|q^=Kf5A3N0^PILXp`p`:E<TN0tMwkd;?XQd*6wAiZgO9]rx$W<$sB' );
define( 'LOGGED_IN_SALT',    'd!QVaVD=A+h?3@L3x9&]]$9MrG:RSMxAJLvF`v]?K;&8^IrFJ^;c~,CA!EiFUf7Y' );
define( 'NONCE_SALT',        'K xI(kQ*&_>zJOiLmb8~B$v555yL{|5bbsO}0h{.QC4XD2y28~](;&{_~r_C[kNJ' );
define( 'WP_CACHE_KEY_SALT', 'o^tM>N&[Z_HBIU,yRD7tK>lsHZ{qXru/,kwA[Eds9J:-5L-oAWr@5}$ P#U70_1y' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'SURECART_ENCRYPTION_KEY', 'wQf56_wQUwpGD^)P9kKYF;s;Cf3o1`5FwC<nS8DmxfkyLLS>3:(la1>lc(K-iMlS' );
define('JWT_AUTH_SECRET_KEY','Lapacho13682#');
define('JWT_AUTH_CORS_ENABLE', true);

// 🔥 HABILITAR CORS SIN RESTRICCIONES 🔥
define('ALLOW_CORS', true);

if (defined('ALLOW_CORS') && ALLOW_CORS) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");

    // Permitir solicitudes preflight (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        status_header(200);
        exit();
    }
}


/* That's all, stop editing! Happy publishing. */
define('WC_SESSION_HANDLER', 'WC_Session_Handler');

define('WP_HOME', 'http://lapacho-1.local');
define('WP_SITEURL', 'http://lapacho-1.local');





/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


// En functions.php, sin cerrar la etiqueta PHP antes
function custom_decrease_item() {
    // Verificar que item_key venga en POST
    if ( empty($_POST['item_key']) ) {
        wp_send_json_error('Falta el item_key');
        wp_die();
    }
    $item_key = sanitize_text_field($_POST['item_key']);

    // Asegurarse que el carrito esté inicializado
    if ( !WC()->cart ) {
        wp_send_json_error('Carrito no está inicializado');
        wp_die();
    }

    $cart = WC()->cart->get_cart();

    if ( !isset($cart[$item_key]) ) {
        wp_send_json_error('No se encontró ese producto en el carrito');
        wp_die();
    }

    $current_quantity = $cart[$item_key]['quantity'];
    $new_quantity = $current_quantity - 1;

    if ( $new_quantity < 1 ) {
        WC()->cart->remove_cart_item($item_key);
    } else {
        WC()->cart->set_quantity($item_key, $new_quantity);
    }

    // Forzar actualización del carrito y guardar
    WC()->cart->calculate_totals();
    WC()->cart->maybe_set_cart_cookies();

    wp_send_json_success('Cantidad disminuida');
    wp_die();
}
add_action('wp_ajax_decrease_item', 'custom_decrease_item');
add_action('wp_ajax_nopriv_decrease_item', 'custom_decrease_item');


function custom_remove_item() {
    if ( empty($_POST['item_key']) ) {
        wp_send_json_error('Falta el item_key');
    }
    $item_key = sanitize_text_field($_POST['item_key']);

    $removed = WC()->cart->remove_cart_item($item_key);
    if ( !$removed ) {
        wp_send_json_error('No se pudo eliminar el ítem');
    }
    wp_send_json_success('Ítem eliminado');
}
add_action('wp_ajax_remove_item', 'custom_remove_item');
add_action('wp_ajax_nopriv_remove_item', 'custom_remove_item');

function custom_clear_cart() {
    WC()->cart->empty_cart();
    wp_send_json_success('Carrito vaciado');
}
add_action('wp_ajax_clear_cart', 'custom_clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'custom_clear_cart');

// Endpoint AJAX para obtener el carrito completo en JSON
function ajax_get_cart_items() {
    if ( ! WC()->cart ) {
        wp_send_json_error('Carrito no disponible');
        wp_die();
    }

    $cart = WC()->cart->get_cart();
    $items = [];

    foreach ( $cart as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        $items[] = [
            'key'      => $cart_item_key,
            'product_id' => $product->get_id(),
            'name'     => $product->get_name(),
            'price'    => $product->get_price(),
            'quantity' => $cart_item['quantity'],
            'image'    => wp_get_attachment_url( $product->get_image_id() ),
            'subtotal' => WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ),
        ];
    }

    $response = [
        'items'       => $items,
        'total'       => WC()->cart->get_total(''),
        'items_count' => WC()->cart->get_cart_contents_count(),
    ];

    wp_send_json_success( $response );
    wp_die();
}
add_action( 'wp_ajax_get_cart_items', 'ajax_get_cart_items' );
add_action( 'wp_ajax_nopriv_get_cart_items', 'ajax_get_cart_items' );


