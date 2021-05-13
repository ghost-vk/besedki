<?php
namespace Utility\MetaTags;
require_once __DIR__ . '/RenderOpenGraphData.php';

/**
 * Class RenderOpenGraph
 * Used for render Open Graph meta tags
 * @package Utility\MetaTags
 */
class RenderOpenGraph {
	public $data_client; // Data Access Layer
	
	/**
	 * RenderOpenGraph constructor.
	 */
	public function __construct() {
		$this->data_client = new RenderOpenGraphData();
	}
	
	/**
	 * Method render all available Open Graph meta tags
	 */
	public function RenderAll() {
		$this->RenderTitle(); 		// og:title
		$this->RenderSiteName();    // og:site_name
		$this->RenderURL();			// og:url
		$this->RenderType(); 		// og:type
		$this->RenderLocale();		// og:locale
		$this->RenderDescription(); // og:description
		$this->RenderImage(); 		// og:image
		$this->RenderVideo(); 		// og:video
	}
	
	/**
	 * Method render og:title
	 */
	public function RenderSiteName() {
		if ( ! $this->data_client ) {
			return;
		}
		$site_name = $this->data_client->GetSiteName();
		if ( $site_name ) {
			echo "<meta property='og:site_name' content='$site_name' />";
		}
	}
	
	/**
	 * Method render og:title
	 */
	public function RenderTitle() {
		if ( ! $this->data_client ) {
			return;
		}
		$title = $this->data_client->GetTitle();
		if ( $title ) {
			echo "<meta property='og:title' content='$title' />";
		}
	}
	
	/**
	 * Method render og:type
	 */
	public function RenderType() {
		if ( ! $this->data_client ) {
			return;
		}
		$title = $this->data_client->GetType();
		if ( $title ) {
			echo "<meta property='og:type' content='$title' />";
		}
	}
	
	/**
	 * Method render og:locale
	 */
	public function RenderLocale() {
		if ( ! $this->data_client ) {
			return;
		}
		$locale = $this->data_client->GetLocale();
		if ( $locale ) {
			echo "<meta property='og:locale' content='$locale' />";
		}
	}
	
	/**
	 * Method render og:description
	 */
	public function RenderDescription() {
		if ( ! $this->data_client ) {
			return;
		}
		$description = $this->data_client->GetDescription();
		if ( $description ) {
			echo "<meta property='og:description' content='$description' />";
		}
	}
	
	/**
	 * Method render og:image
	 */
	public function RenderImage() {
		if ( ! $this->data_client ) {
			return;
		}
		$image = $this->data_client->GetImage();
		if ( $image ) {
			echo "<meta property='og:image' content='$image' />";
		}
	}
	
	/**
	 * Method render og:image
	 */
	public function RenderVideo() {
		if ( ! $this->data_client ) {
			return;
		}
		$video = $this->data_client->GetVideo();
		if ( $video ) {
			echo "<meta property='og:video' content='$video' />";
		}
	}
	
	/**
	 * Method render og:url
	 */
	public function RenderURL() {
		if ( ! $this->data_client ) {
			return;
		}
		$url = $this->data_client->GetCurrentUrl();
		if ( $url ) {
			echo "<meta property='og:url' content='$url' />";
		}
	}
}