<?php

namespace Drupal\layoutbuilder\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CloseDialogCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\layoutbuilder\SectionStorageInterface;

/**
 * Provides AJAX responses to rebuild the Layout Builder.
 */
trait LayoutRebuildTrait {

  /**
   * Rebuilds the layout.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   An AJAX response to either rebuild the layout and close the dialog, or
   *   reload the page.
   */
  protected function rebuildAndClose(SectionStorageInterface $section_storage) {
    $response = $this->rebuildLayout($section_storage);
    $response->addCommand(new CloseDialogCommand('#drupal-off-canvas'));
    return $response;
  }

  /**
   * Rebuilds the layout.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   An AJAX response to either rebuild the layout and close the dialog, or
   *   reload the page.
   */
  protected function rebuildLayout(SectionStorageInterface $section_storage) {
    $response = new AjaxResponse();
    $layout = [
      '#type' => 'layoutbuilder',
      '#section_storage' => $section_storage,
    ];
    $response->addCommand(new ReplaceCommand('#layout-builder', $layout));
    return $response;
  }

}
