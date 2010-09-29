<?php 
class PageBanner extends SiteTreeDecorator {
	
	static $defaultBannerImageURL = '';
	static $alternativeCMSLabel = '';
	
	function extraStatics() {
		return array(
			'has_one' => array(
				'BannerImage' => 'Image'
			)
		);
	}
	function updateCMSFields(&$fields){
		$label = (self::$alternativeCMSLabel) ? self::$alternativeCMSLabel : 'Banner Image';
		$fields->addFieldToTab('Root.Content.Main', new ImageField('BannerImage', $label));
		return $fields;
	}
	function SetDefaultBannerImage($url='') {
		self::$defaultBannerImageURL = $url;
	}
	function Banner() {
		$bannerImage = $this->owner->BannerImage();
		
		if(!$bannerImage->ID) {
			$parents = $this->Parents();
			foreach($parents as $parent) {
				if($parent->BannerImageID) {
					$bannerImage = $parent->BannerImage();
					break;
				}
			}
		}
		if($bannerImage->ID) return $bannerImage;
	}
	function Parents() {   
		$parent = $this->owner->Parent();
		$output = new DataObjectSet();
      	while( $parent && $parent->exists() ) {
			$output->push($parent);
			$parent = $parent->owner->Parent();         
		}
		return $output;
	}
}
?>