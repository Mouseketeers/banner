<?php 
class Banner extends SiteTreeDecorator {
	function extraStatics() {
		return array(
			'has_one' => array(
				'BannerImage' => 'Image'
			)
		);
	}
	function updateCMSFields(&$fields){
		$fields->addFieldToTab('Root.Content.Main', new ImageField('BannerImage', 'Banner Image'));
		return $fields;
	}
}
?>