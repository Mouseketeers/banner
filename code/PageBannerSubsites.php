<?php
class PageBannerSubsites extends DataObjectDecorator
{
    public function extraStatics()
    {
        return array(
            'has_one' => array(
                'Subsite' => 'Subsite',
            )
        );
    }
    public function augmentSQL(SQLQuery &$query)
    {
        if (Subsite::$disable_subsite_filter) {
            return;
        }
        $subsiteID = (int)Subsite::currentSubsiteID();
        $where = '"PageBanner"."SubsiteID" IN ('.$subsiteID.')';
        $query->where[] = $where;
    }
    public function onBeforeWrite()
    {
        if (!$this->owner->ID && !$this->owner->SubsiteID) {
            $this->owner->SubsiteID = Subsite::currentSubsiteID();
        }
    }
}
