<?php

namespace Drupal\Tests\layoutbuilder\Kernel;

use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\layoutbuilder\Section;
use Drupal\layoutbuilder\SectionStorage\SectionStorageDefinition;
use Drupal\layoutbuilder_test\Plugin\SectionStorage\SimpleConfigSectionStorage;

/**
 * Tests the test implementation of section storage.
 *
 * @coversDefaultClass \Drupal\layoutbuilder_test\Plugin\SectionStorage\SimpleConfigSectionStorage
 *
 * @group layoutbuilder
 */
class SimpleConfigSectionStorageTest extends SectionStorageTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'layoutbuilder_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getSectionStorage(array $section_data) {
    $config = $this->container->get('config.factory')->getEditable('layoutbuilder_test.test_simple_config.foobar');
    $section_data = array_map(function (Section $section) {
      return $section->toArray();
    }, $section_data);
    $config->set('sections', $section_data)->save();

    $definition = new SectionStorageDefinition(['id' => 'test_simple_config']);
    $plugin = SimpleConfigSectionStorage::create($this->container, [], 'test_simple_config', $definition);
    $plugin->setContext('config_id', new Context(new ContextDefinition('string'), 'foobar'));
    return $plugin;
  }

}
