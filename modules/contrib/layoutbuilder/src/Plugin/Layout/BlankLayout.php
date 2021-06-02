<?php

namespace Drupal\layoutbuilder\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;

/**
 * Provides a layout plugin that produces no output.
 *
 * @see \Drupal\layoutbuilder\Field\LayoutSectionItemList::removeSection()
 * @see \Drupal\layoutbuilder\SectionStorage\SectionStorageTrait::addBlankSection()
 * @see \Drupal\layoutbuilder\SectionStorage\SectionStorageTrait::hasBlankSection()
 *
 * @internal
 *   This layout plugin is intended for internal use by Layout Builder only.
 *
 * @Layout(
 *   id = "layoutbuilder_blank",
 * )
 */
class BlankLayout extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    // Return no output.
    return [];
  }

}
