<?php
namespace BESEDKA;
require_once __DIR__ . '/BookingCleaner.php';

class BookingCleanerAdmin {
	public function DeleteNeedlessRecords()
	{
		if ( isset($_COOKIE['is_cleaned_records']) && $_COOKIE['is_cleaned_records'] === 'true' ) {
			return;
		}
		$args = array (
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'product_cat'    => 'besedki',
			'meta_query' => array(),
		);
		$products = get_posts($args); // Returns array of product type post
		if ( ! empty($products) ) {
			foreach ( $products as $product ) {
				$id = $product->ID;
				$_cleaner = new BookingCleaner($id);
				$_cleaner->CleanNeedlessRecords();
			}
		}
		$this->SetCookie();
	}
	
	protected function SetCookie() {
		setcookie('is_cleaned_records', 'true', time() + 900, '/', '', 0);
	}
}