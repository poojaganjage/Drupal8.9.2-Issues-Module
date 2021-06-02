<?php

namespace Drupal\layoutbuilder\Controller;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\layoutbuilder\SectionStorageInterface;

/**
 * Defines a controller to provide the Layout Builder admin UI.
 *
 * @internal
 *   Controller classes are internal.
 */
class LayoutBuilderController {

  use StringTranslationTrait;

  /**
   * Provides a title callback.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   *
   * @return string
   *   The title for the layout page.
   */
  public function title(SectionStorageInterface $section_storage) {
    return $this->t('Edit layout for %label', ['%label' => $section_storage->label()]);
  }

  /**
   * Renders the Layout UI.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   *
   * @return array
   *   A render array.
   */
  public function layout(SectionStorageInterface $section_storage) {
    return [
      '#type' => 'layoutbuilder',
      '#section_storage' => $section_storage,
    ];
  }

}
