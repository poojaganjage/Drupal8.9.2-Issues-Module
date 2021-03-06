INTRODUCTION
------------

A XSL Formatter module required to be enabled a PHP XSL library
that runs given XML content (pasted data, linked URL and uploaded
file) through a defined XSL stylesheet before rendering.

When module enabled, this provides a format as Transformed by XSL
which is available in 'manage display' for use in content types or
views. The result is then shown in the page and managed like any
other field display.

The data source can be:

* A Text(plain, long) field which contains the raw XML.
* A link field defining a remote or filesystem data source.
* A file field where you can upload an XML file directly.

* For a full description of this module, visit the project page:
   https://www.drupal.org/project/xsl_formatter

* To submit bug reports and feature suggestions, or track changes:
   https://www.drupal.org/project/issues/xsl_formatter


REQUIREMENTS
------------

This module requires the following library:

* PHP XSL Library (https://www.php.net/manual/en/xsl.installation.php)


INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.


CONFIGURATION
-------------

To add a XSL Formatter, navigate to "Structure > Content Types"
and select any existing content type or can add new content type
with creating field by choosing under the Text(plain, long), link
and file. Click on Manage Display and select format as Transformed
by XSL for created field as you choose to upload a file and click
on cogwheel which is on right side and put settings as needed.


MAINTAINERS
-----------

Current maintainers:
 * Johannes Kowald (JoCowood) - https://www.drupal.org/u/jocowood
 * Dan Morrison (dman) - https://www.drupal.org/u/dman
