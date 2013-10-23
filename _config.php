<?php
//DataObject::add_extension('Page', 'PageBannerDecorator');
//PageBanner::enableInheritance
//PageBanner::enableContent();
//PageBanner::setDefaultBannerImage($url)
// <% include Banner %>
if (class_exists('Subsite')) Object::add_extension('PageBanner', 'PageBannerSubsites');