<div class="container py-4">
	<h1>Тестовая страница бронирования</h1>
	<div class="tester row mb-4">
		<style>
			.tester {
				padding-top:30px;
				min-height: 400px;
			}
			p {
                margin-bottom: 15px;
			}
			.pick {
                margin-top: 30px;
			}
		</style>
  
		<?php
		// My library to works with booking products
		require_once __DIR__ . '/../functions/bookingProduct.class.php';
		
		// Get all products
		$args = array (
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'product_cat'    => 'besedki'
		);
		$products = wc_get_products( $args ); // Returns array of WC_Product_Simple objects
		?>
		
		<?php foreach ( $products as $product ) : ?>
			<?php
			$product_id = $product->get_id(); // Returns {Integer}
			if ( ! isset($product_id) ) {
				continue;
			}
			
			$product_name = get_the_title($product_id);
			?>
		
			<p>Название: <?= $product_name; ?></p>
		
			<?php
			$booking_product = new BESEDKA\bookingProduct($product_id);
			if ( $booking_product->validate() !== true ) {
				continue;
			}
			
			$WC_Product_Variable = new WC_Product_Variable();
			
			$variations = $product->get_available_variations('objects'); // Returns array of WC_Product_Variation ?>
		    <div class="select col-4 mb-3">
                <select class="form-select" name="" id="rentDuration">
					<?php $attr_label = wc_attribute_label( 'pa_rent_duration', $product ); // Returns "Длительность аренды" ?>
                    <option value="0" selected><?= $attr_label; ?></option>
				
					<?php foreach ( $variations as $variation ) : ?>
						<?php
                        $variation_id = $variation->get_id();
						$attr_name = $variation->get_attribute( 'pa_rent_duration' ); // Returns "1 час", "2 часа" e.t.c
						$term = get_term_by( 'name', $attr_name, 'pa_rent_duration' );
						$attr_key = $term->slug; // Returns "1", "2", .., "Целый день"
						?>
                        <option value="<?= $attr_key; ?>" data-id="<?= $variation_id; ?>" data-parent="<?= $product_id; ?>">
                            <?= $attr_name; ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
		    <div class="col-12"></div>
<!--            <div class="col-4">-->
<!--                <button class="btn btn-secondary" id="getTimeBtn" data-product="--><?//= $product_id; ?><!--">Получить доступные дату и время</button>-->
<!--            </div>-->
            
		<?php endforeach; ?>
		
		<div class="pick">
			<input id="datetimepicker" type="text" />
		</div>
        
        <div>
            <button class="btn btn-primary" id="rentSubmit">Забронировать</button>
        </div>
		
		<?php wp_reset_postdata(); ?>
	</div>
    <div class="reservation">
        <div class="reservation__title">
            <h1>Тест карт</h1>
        </div>
        <div id="map"></div>
    </div>
</div>