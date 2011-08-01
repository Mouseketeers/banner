<?php 
class PageBanner extends DataObjectDecorator {
	static $defaultBannerImageURL = '';
	static $alternativeCMSLabel = '';
	static $inherit_parent_banner = false;
	static $flash_enabled = false;
	
	function extraStatics() {
		return array(
			'db' => array(
				'BannerLinkTitle' => 'Varchar(255)',
				'BannerWidth' => 'Varchar',
				'BannerHeight' => 'Varchar'
			),
			'has_one' => array(
				'BannerImage' => 'Image',
				'BannerFlashFile' => 'File',

				'BannerLink' => 'SiteTree'
			)
		);
	}
	function updateCMSFields(&$fields){
		$label = (self::$alternativeCMSLabel) ? self::$alternativeCMSLabel : 'Banner Image';
		
		$PageDropDown = new SimpleTreeDropdownField('BannerLinkID', 'Link to page');
		$PageDropDown->setEmptyString('-- None --');
		
		//$flashFileOploadField->setAllowedExtensions(array('swf'));

		$fields->addFieldsToTab('Root.Content.Banner', array(
			new FileUploadField('BannerImage', $label),
			$PageDropDown,
			new TextField('BannerLinkTitle', 'Link text')
		));
		
		if(self::$flash_enabled) {
			$flashFileOploadField = new FileUploadField('BannerFlashFile', 'Flash banner');
			$fields->addFieldsToTab('Root.Content.Banner', array(
				$flashFileOploadField,
				new TextField('BannerWidth', _t('PageBanner.BANNERWIDTH', 'Width of Flash banner')),
				new TextField('BannerHeight', _t('PageBanner.BANNERHEIGHT', 'Height of Flash banner'))
			));
		}
		return $fields;
	}
	function index() {
		if(self::$flash_enabled && $this->owner->BannerFlashFile()->exists()) {
			$flash_vars = 'link:"'.Director::absoluteURL($this->owner->BannerLink()->Link()).'"';
			$flash_params = 'wmode:"transparent"';
			Requirements::javascript('http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js');
			Requirements::customScript('
				var flashvars = { '.$flash_vars.' };
				var params = { '.$flash_params.' };
				swfobject.embedSWF("'. $this->BannerFlashFile()->FileName .'", "BannerContent", "'.$this->owner->BannerWidth.'", "'.$this->owner->BannerHeight.'", "9.0.0", "", flashvars, params);'
			);
			//set_write_js_to_body
		}
		return array();
	}
	
	function HasBanner() {
		return ($this->owner->BannerImage()->exists() || $this->owner->BannerFlashFile()->exists());
	}
	function HasFlasBanner() {
		return ($this->owner->BannerFlashFile()->exists());
	}
	
	function setDefaultBannerImage($url='') {
		self::$defaultBannerImageURL = $url;
	}
	public function enableFlash() {
		self::$flash_enabled = true;
	}
	public function enableInheritance() {
		self::$inherit_parent_banner = true;
	}
	/*function getBannerImage() {
		$bannerImage = $this->owner->BannerImage();
		if(self::$inherit_parent_banner && !$bannerImage->ID) {
			$parents = $this->Parents();
			foreach($parents as $parent) {
				if($parent->BannerImageID) {
					$bannerImage = $parent->BannerImage();
					break;
				}
			}
		}
		if($bannerImage->ID) return $bannerImage;
	}*/
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