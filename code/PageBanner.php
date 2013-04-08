<?php 
class PageBanner extends DataObject {
	static $inherit_parent_banner = true;
	static $use_default_banner = true;
	static $content_enabled = false;

	static $db =  array(
		'BannerContent' => 'HTMLText',
		'BannerLinkTitle' => 'Varchar(255)',
		'BannerWidth' => 'Varchar',
		'BannerHeight' => 'Varchar',
		'DefaultBanner' => 'Boolean'
	);
	static $has_one = array(
		'BannerImage' => 'Image',
		'BannerLink' => 'SiteTree',
		'Page' => 'Page'
	);
	function getCMSFields_forPopup() {
		$fields = new FieldSet();

		$fields->push( new FileUploadField('BannerImage', "Banner Image" ));
		
		$page_dropdown = new SimpleTreeDropdownField('BannerLinkID', 'Link to page');
		$page_dropdown->setEmptyString('-- None --');
		$fields->push( $page_dropdown );
		if(PageBannerDecorator::$use_default_banner) {
			$fields->push( new CheckboxField('DefaultBanner', 'Set this as the default banner' ));
		}
		return $fields;
	}
	function getIfDefaultBanner() {
		if($this->DefaultBanner) return 'Default';
	}
	function getImageTitle() {
		return $this->BannerImage()->Title;
	}
	function getThumbmailOfBannerImage() {
		return $this->BannerImage()->StripThumbnail();
	}
	function getBannerLinkURL() {
		return $this->BannerLink()->Title;
	}
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		if($this->DefaultBanner) {
			$current_default_banner = DataObject::get_one('PageBanner','DefaultBanner = 1');
			if($current_default_banner) {
				$current_default_banner->DefaultBanner = 0;
				$current_default_banner->write();
			}
		}
	}
}