<?php

namespace Drupal\Tests\layoutbuilder\Functional\Jsonapi;

use Drupal\layoutbuilder\Plugin\SectionStorage\OverridesSectionStorage;
use Drupal\Tests\jsonapi\Functional\EntityViewDisplayTest;

/**
 * JSON:API integration test for the "EntityViewDisplay" config entity type.
 *
 * @group jsonapi
 * @group layoutbuilder
 */
class LayoutBuilderEntityViewDisplayTest extends EntityViewDisplayTest {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['layoutbuilder'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

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
  protected function getExpectedDocument() {
    $document = parent::getExpectedDocument();
    array_unshift($document['data']['attributes']['dependencies']['module'], 'layoutbuilder');
    $document['data']['attributes']['hidden'][OverridesSectionStorage::FIELD_NAME] = TRUE;
    $document['data']['attributes']['third_party_settings']['layoutbuilder'] = [
      'enabled' => TRUE,
      'allow_custom' => TRUE,
    ];
    return $document;
  }

}
