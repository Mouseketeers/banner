<?php
class PageBannerDecorator extends DataObjectDecorator {
	static $alternativeCMSLabel = '';
	static $inherit_parent_banner = true;
	static $use_default_banner = true;
	static $content_enabled = false;

	function extraStatics() {
		return array(
			'has_one' => array(
				'PageBanner' => 'PageBanner'
			)
		);
	}
	public function ManagedBanners() {
		$page_banner = $this->owner->PageBanner();
		if($page_banner->exists()) {
			return $this->owner->PageBanner();	
		}
		if(self::$inherit_parent_banner) {
			$parent = $this->owner->Parent(); 
			while($parent && $parent->exists()) {
				if($parent->PageBanner()->exists()) {
					return $parent->PageBanner();
				}
				$parent = $parent->Parent();
			}
		}
		if(self::$use_default_banner) {
			$default_banner = DataObject::get_one('PageBanner','DefaultBanner = 1');
			return $default_banner;
		}
	}
	function updateCMSFields(&$fields){
		$manager = new HasOneDataObjectManager(
			$this->owner,
			'PageBanner',
			'PageBanner',
			array(
				'ThumbmailOfBannerImage' => 'Image',
				'ImageTitle' => 'Banner Image Title',
				'BannerLinkURL' => 'Links to',
				'IfDefaultBanner' => 'Default banner?'
			),
			'getCMSFields_forPopup'
		);
		$manager->setParentClass('Page');
		$fields->addFieldToTab( 'Root.Content.Banner', $manager );
		return $fields;
	}
	public function enableInheritance($option = true) {
		self::$inherit_parent_banner = $option;
	}
	public function enableContent($option = true) {
		self::$content_enabled = $option;
	}
	public function useDefaultBanner($option = true) {
		self::$use_default_banner = $option;
	}
	
}