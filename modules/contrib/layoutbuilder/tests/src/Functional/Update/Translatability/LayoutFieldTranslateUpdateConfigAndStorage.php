<?php

namespace Drupal\Tests\layoutbuilder\Functional\Update\Translatability;

/**
 * A test case that updates both bundles' fields.
 *
 * @group layoutbuilder
 * @group legacy
 */
class LayoutFieldTranslateUpdateConfigAndStorage extends MakeLayoutUntranslatableUpdatePathTestBase {

  /**
   * {@inheritdoc}
   */
  protected $layoutBuilderTestCases = [
    'article' => [
      'has_translation' => TRUE,
      'has_layout' => FALSE,
      'nid' => 1,
      'vid' => 2,
    ],
    'page' => [
      'has_translation' => FALSE,
      'has_layout' => TRUE,
      'nid' => 4,
      'vid' => 5,
    ],
  ];

  /**
   * {@inheritdoc}
   */
  protected $expectedBundleUpdates = [
    'article' => TRUE,
    'page' => TRUE,
  ];

  /**
   * {@inheritdoc}
   */
  protected $expectedFieldStorageUpdate = TRUE;

}
