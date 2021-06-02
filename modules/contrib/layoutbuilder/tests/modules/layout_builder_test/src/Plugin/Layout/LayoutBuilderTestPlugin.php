<?php

namespace Drupal\layoutbuilder_test\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;

/**
 * @Layout(
 *   id = "layoutbuilder_test_plugin",
 *   label = @Translation("Layout Builder Test Plugin"),
 *   regions = {
 *     "main" = {
 *       "label" = @Translation("Main Region")
 *     }
 *   },
 * )
 */
class LayoutBuilderTestPlugin extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['main']['#attributes']['class'][] = 'go-birds';
    return $build;
  }

}
