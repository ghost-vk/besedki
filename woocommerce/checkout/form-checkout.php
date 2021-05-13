<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . './../../class/FormatterUI/FormatterUIHandler.php';

?>

    <div class="checkoutBody py-5">
        <h1 class="text-primary mb-5 text-center">Оформление заказа</h1>

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
			
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                <div class="row justify-content-between">
                    <div class="col-md-8" id="customer_details">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
                    </div>
                    <div class="col-md-4">
						<?php if ( !is_mobile() ) : ?>
							<?php require_once __DIR__ . '/../../blocks/checkout-additional-info.php'; ?>
						<?php endif; ?>
                    </div>
                </div>
			
			<?php endif; ?>

            <div class="row mt-3 mb-3">
                <div class="col-md-8 mb-md-0 mb-3">
                    <div class="p-3 rounded bg-light">
                        <h4 class="text-center mb-3" id="order_review_heading">Мой заказ</h4>
                        <div class="woocommerce-checkout-review-order">
                            <table class="shop_table woocommerce-checkout-review-order-table bg-warning">
                                <thead>
                                <tr>
                                    <th class="product-name"><span class="fw-bold">Беседка</span></th>
                                    <th class="product-total"><span class="fw-bold">Всего</span></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								do_action( 'woocommerce_review_order_before_cart_contents' );
								
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									
									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										?>
                                        <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                            <td class="product-name">
                                                <span>
                                                    <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
													<?php if ( isset($cart_item['start_datetime']) ) : // If start datetime is set ?>
														<?php
                                                        $formatter = new BESEDKA\FormatterUIHandler('datetime', $cart_item['start_datetime']);
                                                        $start_datetime_nice = $formatter->Format();
														?>
                                                        (<?php echo $start_datetime_nice; ?>)
													<?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="product-total">
												<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            </td>
                                        </tr>
										<?php
									}
								}
								
								do_action( 'woocommerce_review_order_after_cart_contents' );
								?>
                                </tbody>
                                <tfoot>

                                <tr class="cart-subtotal">
                                    <th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                                    <td><?php wc_cart_totals_subtotal_html(); ?></td>
                                </tr>
								
								<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
									<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
										<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                                            <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                                                <th><?php echo esc_html( $tax->label ); ?></th>
                                                <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                                            </tr>
										<?php endforeach; ?>
									<?php else : ?>
                                        <tr class="tax-total">
                                            <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                                            <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                                        </tr>
									<?php endif; ?>
								<?php endif; ?>

                                <tr class="order-total">
                                    <th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                                    <td><?php wc_cart_totals_order_total_html(); ?></td>
                                </tr>

                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bg-light p-3 rounded">
                        <h4 class="text-center mb-3">Оплата</h4>
                        <p class="text-muted mb-2">После оплаты вам на почту придет письмо с номером заказа. Сохраните этот номер себе, он вам понадобится для посещения наших беседок.</p>
                        <p class="text-muted mb-2">С собой будет необходимо взять паспорт соответствующий данным, указанным вами в полях для оформления заказа.</p>
                        <p class="text-muted mb-3">Нажимая кнопку "Оплатить", Вы подтверждаете бронирование выбранных услуг и соглашаетесь с
                            <a href="<?php echo home_url('/rent-agreement')?>">Правилами аренды беседок</a>.</p>
						<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
                        <button type="submit" class="btn btn-success btn-lg w-100" name="woocommerce_checkout_place_order" id="checkoutSubmit"><span class="text-white">Оплатить</span></button>
                    </div>
                </div>
            </div>

            <div class="d-block d-md-none">
				<?php if ( is_mobile() ) : ?>
					<?php require_once __DIR__ . '/../../blocks/checkout-additional-info.php'; ?>
				<?php endif; ?>
            </div>

            <!--     PAYMENT METHOD       -->
            <div class="d-none">
				<?php
				$WC_Payment_Gateways = new WC_Payment_Gateways();
				$available_gateways = $WC_Payment_Gateways->get_available_payment_gateways();
				$gateway_cheque = $available_gateways["cheque"];
				$gateway = $available_gateways["yookassa_epl"];
				if ( get_current_user_id() === 1 ) : ?>
					<input type="radio" name="payment_method" value="<?php echo esc_attr( $gateway_cheque->id ); ?>" />
                <?php endif; ?>
                <input type="radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" checked="checked" />
            </div>
        </form>
    </div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>