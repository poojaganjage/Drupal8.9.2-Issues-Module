<?php

namespace Drupal\xsl_formatter\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Example entity.
 *
 * @ConfigEntityType(
 *   id = "xslt",
 *   label = @Translation("XSLT"),
 *   handlers = {
 *     "list_builder" = "Drupal\xsl_formatter\Controller\XSLTListBuilder",
 *     "form" = {
 *       "add" = "Drupal\xsl_formatter\Form\XsltForm",
 *       "edit" = "Drupal\xsl_formatter\Form\XsltForm",
 *       "delete" = "Drupal\xsl_formatter\Form\XsltDeleteForm",
 *     }
 *   },
 *   config_prefix = "template",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "description" = "description",
 *     "xsl" = "xsl",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "xsl",
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/xslt/{example}",
 *     "delete-form" = "/admin/config/system/xslt/{example}/delete",
 *   }
 * )
 */
class Xslt extends ConfigEntityBase implements XsltInterface {

  /**
   * ID of the XSLT.
   *
   * @var string
   */
  public $id;

  /**
   * Label of the XSLT.
   *
   * @var string
   */
  public $label;

  /**
   * Description of the XSLT.
   *
   * @var string
   */
  public $description;

  /**
   * XSL content.
   *
   * @var string
   */
  public $xsl;

  /**
   * {@inheritDoc}
   */
  public function getXsl() {
    return $this->xsl;
  }

}
