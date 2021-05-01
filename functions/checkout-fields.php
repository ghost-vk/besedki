<?php
/**
 * @param $id {String} - cookie key
 * @param $label {String} - will be display in order
 */
add_action('add_hidden_checkout_field', 'add_hidden_checkout_field', 10, 2);
function add_hidden_checkout_field($id, $label) {
	if ( isset($_COOKIE[$id]) ) {
		woocommerce_form_field( $id, array(
			'type' => 'text',
			'class' => ['hidden-input'],
			'label' => $label
		),  $_COOKIE[$id]);
	} else {
		error_log('Cookies `' . $id . '` is not set in function `add_hidden_checkout_field`', 0);
	}
}

/**
 * Function set value to checkout field if exists cookie with key $name
 * @param $name { String } - cookie name
 * @param $key { String } - checkout field key
 * @param $field { String } - checkout field
 */
add_action('set_value_in_checkout_field', 'set_value_in_checkout_field', 10, 3);
function set_value_in_checkout_field($name, $key, $field) {
	if ( isset($_COOKIE[$name]) ) {
		woocommerce_form_field( $key, $field, $_COOKIE[$name] );
	} else {
		error_log('Cookie `' . $name . '` is not set in function `set_value_in_checkout_field`', 0);
	}
}