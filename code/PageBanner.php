<?php 
class PageBanner extends SiteTreeDecorator {
	
	static $defaultBannerImageURL = '';
	
	function extraStatics() {
		return array(
			'has_one' => array(
				'BannerImage' => 'Image'
			)
		);
	}
	function updateCMSFields(&$fields){
		$fields->addFieldToTab('Root.Content.Main', new ImageField('BannerImage', 'Banner Image',null,null,null,'Bannere'));
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