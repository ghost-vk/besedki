<?php
global $woocommerce;
$cart_items = $woocommerce->cart->get_cart();
do_action( 'remove_unavailable_items', $cart_items );
?>
<?php get_header(); ?>
    <div class="cartBody">
		<?php echo do_shortcode("[woocommerce_cart]"); ?>
    </div>
<?php get_footer(); ?>