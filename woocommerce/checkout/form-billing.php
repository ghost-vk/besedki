<?php defined( 'ABSPATH' ) || exit; ?>
<div class="woocommerce-billing-fields p-3 bg-light rounded">
    <h4 class="mb-4 text-center">Для оформления заказа заполните поля</h4>
	
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="woocommerce-billing-fields__field-wrapper billingFields">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );
		
		foreach ( $fields as $key => $field ) {
		    switch ($key) {
                case ('billing__start') : {
					do_action('set_value_in_checkout_field', '_start', $key, $field);
					break;
                }
                case ('billing_duration') : {
					do_action('set_value_in_checkout_field', '_duration', $key, $field);
					break;
                }
                default : {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                }
            }
		}
		?>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="checkPolicy">
            <label class="form-check-label" for="checkPolicy">
                Я ознакомлен и согласен с <a href="<?php echo home_url('privacy'); ?>">Политикой конфиденциальности</a>
            </label>
        </div>
    </div>

    <!--   CHECKOUT ERRORS SHOWS HERE    -->
    <div id="billingError"></div>
	
	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>