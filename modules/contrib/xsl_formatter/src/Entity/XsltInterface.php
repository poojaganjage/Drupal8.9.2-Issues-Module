<?php

namespace Drupal\xsl_formatter\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Interface of XSLT entity.
 */
interface XsltInterface extends ConfigEntityInterface {

  /**
   * Returns the XSL content as a a string.
   *
   * @return string
   *   The XSL content.
   */
  public function getXsl();

}
