<?php
defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/../../class/class-wc-course-product.php';

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';
	
	$parent_id = $item->get_product_id();
	$variation_id = $item->get_variation_id();
	
	$WC_Course_Product = new LASH\WC_Course_Product($parent_id);
	if ( $WC_Course_Product && $variation_id ) {
		$WC_Course_Product->set_variation($variation_id);
		$package_name = $WC_Course_Product->get_package_name();
	}
	
	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}
	
	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}
	
	?>
	<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
		<td class="td" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
			<?php
			
			// Product name.
//			echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
			echo get_the_title($parent_id);
			if ( isset($package_name) ) {
				echo ' - "' . $package_name . '"<br><br>';
				echo '<strong>Дата старта: ' . $WC_Course_Product->get_nice_start_date() . '</strong><br><br>';
				$WC_Course_Product->print_features(true);
			}
			?>
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
		</td>
	</tr>

	<?php
	
	if ( $show_purchase_note && $purchase_note ) {
		?>
		<tr>
			<td colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php
				echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) );
				?>
			</td>
		</tr>
		<?php
	}
	?>

<?php endforeach; ?>