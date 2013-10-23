<?php
class PageBannerSubsites extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'has_one' => array(
				'Subsite' => 'Subsite',
			)
		);
	}
	function augmentSQL(SQLQuery &$query) {
		if(Subsite::$disable_subsite_filter) return;
		$subsiteID = (int)Subsite::currentSubsiteID();
		$where = '"PageBanner"."SubsiteID" IN ('.$subsiteID.')';
		$query->where[] = $where;
	}
	function onBeforeWrite() {
		if (!$this->owner->ID && !$this->owner->SubsiteID) {
			$this->owner->SubsiteID = Subsite::currentSubsiteID();
		}
	}
}