<?php

namespace Drupal\layoutbuilder;

/**
 * Defines an interface for an object that stores layout sections for overrides.
 */
interface OverridesSectionStorageInterface extends SectionStorageInterface {

  /**
   * Returns the corresponding defaults section storage for this override.
   *
   * @return \Drupal\layoutbuilder\DefaultsSectionStorageInterface
   *   The defaults section storage.
   *
   * @todo Determine if this method needs a parameter in
   *   https://www.drupal.org/project/drupal/issues/2907413.
   */
  public function getDefaultSectionStorage();

  /**
   * Indicates if overrides are in use.
   *
   * @return bool
   *   TRUE if this overrides section storage is in use, otherwise FALSE.
   */
  public function isOverridden();

}
