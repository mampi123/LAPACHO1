<?php

$style  = '';
$style .= ! empty( $attributes['backgroundColor'] )
	? esc_attr( safecss_filter_attr( 'background-color:' . $attributes['backgroundColor'] ) ) . ';'
	: '';
$style .= ! empty( $attributes['textColor'] )
	? esc_attr( safecss_filter_attr( 'color:' . $attributes['textColor'] ) ) . ';'
	: '';

$form      = \SureCart::cart()->getForm();
$form_mode = \SureCart::cart()->getMode();

// Stop if no form or mode found as for deletion.
if ( empty( $form->ID ) || empty( $form_mode ) ) {
	return '';
}

// Don't render if the cart is disabled.
if ( ! \SureCart::cart()->isCartEnabled() ) {
	return '';
}

$type = 'floating';

/**
 * Allow filtering of the cart menu icon.
 *
 * @param string $icon The icon.
 * @param string $mode The icon position.
 */
$icon = apply_filters( 'sc_cart_menu_icon', get_option( 'surecart_cart_icon', 'shopping-bag' ), $type );

// return the view.
return 'file:./view.php';
