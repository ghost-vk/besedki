<?php
global $woocommerce;
$cart_items = $woocommerce->cart->get_cart();
do_action( 'remove_unavailable_items', $cart_items ); // Remove items with expired reservation time
do_action( 'remove_cart_items_from_second_one', $cart_items ); // Remove items from second one (save only first)
?>
<?php get_header(); ?>
    <div class="cartBody">
		<?php echo do_shortcode("[woocommerce_cart]"); ?>
    </div>
<?php get_footer(); ?>