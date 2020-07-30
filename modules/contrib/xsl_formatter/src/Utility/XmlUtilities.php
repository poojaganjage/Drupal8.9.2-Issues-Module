<?php

namespace Drupal\xsl_formatter\Utility;

use DOMDocument;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\xsl_formatter\Entity\Xslt;
use Drupal\xsl_formatter\Exception\XslFormatterException;
use XSLTProcessor;

/**
 * Xml utilities for XSL formatter.
 *
 * Ultra-paranoid and layered with pessimism.
 * Because XML always goes wrong.
 *
 * @package Drupal\xsl_formatter\Utility
 */
class XmlUtilities {

  /**
   * Parses the XSLT string data to a dom object and returns it.
   *
   * @param \Drupal\xsl_formatter\Entity\Xslt $xslt
   *   XSLT config entity.
   *
   * @throws \Exception
   *   If anything goes wrong (file-not-found or invalid XML).
   *
   * @return \DOMDocument
   *   Parsed Dom Object to work on.
   */
  public static function getXmlDoc(Xslt $xslt) {
    $xmlDoc = new DOMDocument();
    $xslString = $xslt->xsl;
    $isLoaded = $xmlDoc->loadXml($xslString);
    if (!$isLoaded) {
      throw new XslFormatterException("Unable to parse the XSL '$xslt->label'");
    }

    return $xmlDoc;
  }

  /**
   * Do the actual conversion between XML+XSL.
   *
   * Input and output are full DOM objects in PHP5
   * We return the result STRING, as that's what
   * the process gives us :-/
   * Need to parse it back in again for pipelining.
   *
   * Support for PHP4 XSL removed.
   *
   * If it uses includes, the xsl must have
   * had its documentURI set correctly prior to this, but it can be set in the
   * parameters also.
   *
   * @param \DOMDocument $xml_doc
   *   XML dom document.
   * @param \DOMDocument $xsl_doc
   *   XSL dom document.
   * @param array $parameters
   *   To be passed into the xslt_process().
   *
   * @returns string The result.
   */
  public static function xmldocPlusXsldoc(\DOMDocument $xml_doc,
                                   \DOMDocument $xsl_doc,
                                   array $parameters = []) {
    if (!extension_loaded('xsl')) {
      \Drupal::messenger()->addError(t('PHP XSL library is not enabled. Please see @link1 or @link2',
        [
          '@link1' => Link::fromTextAndUrl('XSL Formatter project on drupal.org', Url::fromUri('https://drupal.org/project/xsl_formatter'))->toString(),
          '@link2' => Link::fromTextAndUrl('XSL installation on php.net', Url::fromUri('http://php.net/manual/en/xsl.installation.php'))->toString(),
        ]));
      return t('PHP XSL library is not enabled. See log for details.');
    }
    $xsltproc = new XSLTProcessor();

    // Attach the xsl rules.
    $xsltproc->importStyleSheet($xsl_doc);
    // Set any processing parameters and flags.
    if ($parameters) {
      foreach ($parameters as $param => $value) {
        $xsltproc->setParameter("", $param, $value);
      }
    }

    $out = $xsltproc->transformToXml($xml_doc);

    if (function_exists('charset_decode_utf_8')) {
      // I just CAN'T trust XML not to have squashed the entities into
      // bytecodes. Expand them before returning or I can never trust that my
      // result here is actually valid to put in anywhere else again.
      return charset_decode_utf_8($out);
    }

    return $out;
  }

}
