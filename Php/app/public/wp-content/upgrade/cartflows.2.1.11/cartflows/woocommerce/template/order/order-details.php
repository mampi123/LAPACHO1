<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

$thankyou_id = wcf()->flow->get_thankyou_page_id( $order );
$thankyou_layout = wcf()->options->get_thankyou_meta_value( $thankyou_id, 'wcf-tq-layout' );

// If main order is cancelled then show the new order details.
if( $order->has_status( 'cancelled' ) ){
	do_action( 'cartflows_woocommerce_order_details_cancelled', $order );
}else{

	if ( $show_downloads ) {
		wc_get_template(
			'order/order-downloads.php',
			array(
				'downloads'  => $downloads,
				'show_title' => true,
			)
		);
	}
	?>
	<section class="woocommerce-order-details">
		<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
		<?php if('modern-tq-layout' === $thankyou_layout) { ?>
			<h2 class="woocommerce-order-details__title woocommerce-column__title"><?php esc_html_e( 'Order #', 'woocommerce' ); ?><?php echo esc_html( $order->get_order_number() ); ?></h2>
		<?php } else { ?>
			<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h2>
		<?php } ?>
		<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
		<?php if('legacy-tq-layout' === $thankyou_layout) { ?>
			<thead>
				<tr>
					<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
					<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>
		<?php } ?>
			<tbody>
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template(
						'order/order-details-item.php',
						array(
							'order'              => $order,
							'item_id'            => $item_id,
							'item'               => $item,
							'show_purchase_note' => $show_purchase_note,
							'purchase_note'      => $product ? $product->get_purchase_note() : '',
							'product'            => $product,
						)
					);
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				
				if('legacy-tq-layout' === $thankyou_layout) { ?>
				</tbody>

				<tfoot>
				<?php } 

				foreach ( $order->get_order_item_totals() as $key => $total ) {
					if ( 'modern-tq-layout' === $thankyou_layout && $key === 'payment_method' ) {
						continue;
					}
					?>
					<tr>
						<th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
						<?php if('modern-tq-layout' === $thankyou_layout) { ?>
							<td><?php echo wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<?php } else { ?>
							<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<?php } ?>	
					</tr>
					<?php
				}
				?>
				<?php if ( $order->get_customer_note() ) : ?>
					<tr>
						<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
						<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
					</tr>
				<?php endif; 
				if('legacy-tq-layout' === $thankyou_layout) { ?>
				</tbody>

				<tfoot>
				<?php } ?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	</section>
<?php } ?>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
