<?php
namespace Utility\MetaTags;

/**
 * Class RenderOpenGraphData
 * Used for get data for render from database
 * @package Utility\MetaTags
 */
class RenderOpenGraphData {
	public $page_id; // WordPress page ID, used for getting data through ACF
	
	/**
	 * RenderOpenGraphData constructor.
	 */
	public function __construct()
	{
		$hide_id = get_hide_current_page_id();
		$this->page_id = ( $hide_id ) ? $hide_id : get_the_ID();
	}
	
	/**
	 * Method returns og:title value
	 * @return String
	 */
	public function GetTitle() {
		return get_field('og_title', $this->page_id);
	}
	
	/**
	 * Method returns og:site_name value
	 * @return mixed
	 */
	public function GetSiteName() {
		return get_field('og_site_name', $this->page_id);
	}
	
	/**
	 * Method returns og:type value
	 * @return String
	 */
	public function GetType() {
		return get_field('og_type', $this->page_id);
	}
	
	/**
	 * Method returns og:locale value
	 * @return String
	 */
	public function GetLocale() {
		return get_field('og_locale', $this->page_id);
	}
	
	/**
	 * Method returns og:description value
	 * @return String
	 */
	public function GetDescription() {
		return get_field('og_description', $this->page_id);
	}
	
	/**
	 * Method returns og_image value
	 * @return String
	 */
	public function GetImage() {
		return get_field('og_image', $this->page_id);
	}
	
	/**
	 * Method returns og:description value
	 * @return String
	 */
	public function GetVideo() {
		return get_field('og_video', $this->page_id);
	}
	
	/**
	 * Method get current page URL
	 */
	public function GetCurrentUrl() {
		return get_page_link($this->page_id);
	}
}