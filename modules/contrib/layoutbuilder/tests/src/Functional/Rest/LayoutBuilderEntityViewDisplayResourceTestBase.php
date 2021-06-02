<?php

namespace Drupal\Tests\layoutbuilder\Functional\Rest;

use Drupal\FunctionalTests\Rest\EntityViewDisplayResourceTestBase;
use Drupal\layoutbuilder\Plugin\SectionStorage\OverridesSectionStorage;

/**
 * Provides a base class for testing LayoutBuilderEntityViewDisplay resources.
 */
abstract class LayoutBuilderEntityViewDisplayResourceTestBase extends EntityViewDisplayResourceTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['layoutbuilder'];

  /**
   * {@inheritdoc}
   */
  protected function createEntity() {
    /** @var \Drupal\layoutbuilder\Entity\LayoutBuilderEntityViewDisplay $entity */
    $entity = parent::createEntity();
    $entity
      ->enableLayoutBuilder()
      ->setOverridable()
      ->save();
    $this->assertCount(1, $entity->getThirdPartySetting('layoutbuilder', 'sections'));
    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedNormalizedEntity() {
    $expected = parent::getExpectedNormalizedEntity();
    array_unshift($expected['dependencies']['module'], 'layoutbuilder');
    $expected['hidden'][OverridesSectionStorage::FIELD_NAME] = TRUE;
    $expected['third_party_settings']['layoutbuilder'] = [
      'enabled' => TRUE,
      'allow_custom' => TRUE,
    ];
    return $expected;
  }

}
