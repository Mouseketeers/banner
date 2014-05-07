# SilverStripe Banner Module
Module for adding banner images to pages

## Maintainer Contact
* Henrik Olsen
  <Henrik (at) mouseketeers (dot) dk>

## Requirements
* Silverstripe 2.4
* DataObjectManager < http://silverstripe.org/dataobjectmanager-module/ >
* Uploadify < http://silverstripe.org/uploadify-module/ >

## Installation Instructions

1. Install DataObjectManager < http://silverstripe.org/dataobjectmanager-module/ > and Uploadify < http://silverstripe.org/uploadify-module/ >

1. Put the banner folder inside your project

2. To enable the banner module on all pages, add the following to your mysite/_config.php file:

DataObject::add_extension('Page', 'Banner');

To enable the slideshow on specific pages, for example your home page, add the following to your mysite/_config.php file:

DataObject::add_extension('HomePage', 'Banner');


3. Build the database (e.g. http://localhost/mysite/dev/build)

4. Add <% include Banner %> to your template
