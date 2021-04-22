<?php defined( 'ABSPATH' ) || exit; ?>

<section class="shopping-cart dark">
    <div class="container">
        <div class="block-heading">
            <h2 class="no-select">Мой заказ</h2>
        </div>
		<?php
		global $woocommerce;
		$count_products = $woocommerce->cart->cart_contents_count;
		$cart_items = $woocommerce->cart->get_cart();
		
		require_once __DIR__ . '/../../functions/bookingFormat.class.php'; // Need to format date and duration
        ?>
        <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <div class="content rounded overflow-hidden">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="items">
                        <?php foreach ( $cart_items as $cart_item_key => $cart_item ) : ?>
                        
                            <?php
                            // Get data for row
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                            
                            $product_name = $_product->get_name();
                            
                            $thumbnail_src = get_field('square_image', $product_id);
                            if ( empty($thumbnail_src) ) {
                                $thumbnail_src = wp_get_attachment_image_url( 5, 'medium' );
                            }

                            
                            if ( isset($cart_item['start_datetime']) ) {
                                $start_datetime = $cart_item['start_datetime'];
								$format = new BESEDKA\bookingFormat( $start_datetime );
								$start_datetime = $format->format_datetime_for_ui();
                            } else {
                                $start_datetime = 'Дата не определена';
                            }

                            if ( isset($cart_item['rent_duration']) ) {
                                $duration = $cart_item['rent_duration'];
								$format = new BESEDKA\bookingFormat( $duration );
								$duration = $format->format_duration_for_ui();
                            } else {
                                $duration = 'Время аренды не задано';
                            }
                            
                            $placement = get_field( 'location', $product_id )['label'];
                            
                            $price = $woocommerce->cart->get_product_price( $_product );

                            $remove_url = wc_get_cart_remove_url( $cart_item_key );
                            ?>
                            <div class="product">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img class="mx-auto d-block image rounded" src="<?= $thumbnail_src; ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col-md-6 product-name">
                                                    <div class="product-name py-2">
                                                        <a href="<?= home_url('reservation'); ?>"><?= $product_name; ?></a>
                                                        <div class="product-info">
                                                            <div>Дата и время: <span class="value"><?= $start_datetime; ?></span></div>
                                                            <div>На сколько: <span class="value"><?= $duration; ?></span></div>
                                                            <div>Расположение: <span class="value"><?= $placement; ?></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6 price">
                                                    <span><?= $price; ?></span>
                                                </div>
                                                <div class="col-md-2 col-6 remove">
                                                    <a class="btn btn-sm btn-dark" href="<?= $remove_url; ?>"><span class="d-inline-block d-md-none text-white">Удалить&nbsp;&nbsp;</span><i class="fas fa-times"></i></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
                // Get total
                $subtotal = $woocommerce->cart->get_cart_subtotal();
                $total = $woocommerce->cart->get_cart_total();
                $tax = "0 " . get_woocommerce_currency_symbol();
                ?>
                <div class="col-md-12 col-lg-4">
                    <div class="summary">
                        <h3>Итого</h3>
                        <div class="summary-item"><span class="text">Подытог</span><span class="price"><?= $subtotal; ?></span></div>
                        <div class="summary-item"><span class="text">Скидка</span><span class="price"><?= $tax; ?></span></div>
                        <div class="summary-item"><span class="text">Итог</span><span class="price"><?= $total; ?></span></div>
                        <div class="d-flex justify-content-md-end justify-content-center mt-4">
                            <a href="<?= wc_get_checkout_url() ?>" class="btn btn-primary btn-lg btn-block">Оформить заказ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>