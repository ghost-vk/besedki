<?php defined( 'ABSPATH' ) || exit; ?>
<div class="thankYou">
	<div class="container">
		<div class="woocommerce-order">
			
			<?php if ( $order ) : ?>
				
				<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
				
				<?php if ( $order->has_status( 'failed' ) ) : ?>
					<div class="thankYou__content">
						<h1 class="title-1">Ошибка при оплате</h1>
						<p class="mainText-1">Не удалось оплатить заказ</p>
						<p class="mainText-2">Платежная система отклонила ваш платеж, возможно не достаточно средств на счете</p>
					</div>
				<?php else : ?>
					<div class="thankYou__content">
						<h1 class="title-1">Спасибо за ваш заказ!</h1>
						<p class="mainText-1">Ждем вас в гости</p>
						<p class="mainText-2">Не забудьте взять с собой паспорт, который вы указали при оформлении заказа</p>
					</div>
				<?php endif; ?>
			
			<?php else : ?>
				
				<div class="thankYou__content">
					<h1 class="title-1">Ошибка при оплате</h1>
					<p class="mainText-1 woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				</div>
			
			<?php endif; ?>
		
		</div>
	</div>
</div>
