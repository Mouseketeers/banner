<?php
class PageBannerDecorator extends DataObjectDecorator {

	public static $inherit_parent_banner = true;
	public static $use_default_banner = true;
	public static $content_enabled = false;
	public static $enable_html_editor = false;

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
		$summary_fields = array();
		$summary_fields['ThumbmailOfBannerImage'] = 'Image';
		$summary_fields['ImageTitle'] = 'Banner Image Title';
		if(self::$content_enabled) $summary_fields['ContentSummary'] = 'BannerContent';
		$summary_fields['BannerLinkURL'] = 'Links to';
		if(self::$use_default_banner) $summary_fields['IfDefaultBanner'] = 'Default banner?';

		$manager = new HasOneDataObjectManager(
			$this->owner,
			'PageBanner',
			'PageBanner',
			$summary_fields,
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
	public function enableHTMLEditor($option = true) {
		if ($option) self::enableContent();
		self::$enable_html_editor = $option;		
	}

	public function useDefaultBanner($option = true) {
		self::$use_default_banner = $option;
	}
	
}