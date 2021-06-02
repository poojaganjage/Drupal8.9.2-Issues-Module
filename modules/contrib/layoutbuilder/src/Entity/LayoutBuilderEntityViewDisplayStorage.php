<?php

namespace Drupal\layoutbuilder\Entity;

use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\Core\Entity\EntityInterface;
use Drupal\layoutbuilder\Section;

/**
 * Provides storage for entity view display entities that have layouts.
 *
 * @internal
 *   Entity handlers are internal.
 */
class LayoutBuilderEntityViewDisplayStorage extends ConfigEntityStorage {

  /**
   * {@inheritdoc}
   */
  protected function mapToStorageRecord(EntityInterface $entity) {
    $record = parent::mapToStorageRecord($entity);

    if (!empty($record['third_party_settings']['layoutbuilder']['sections'])) {
      $record['third_party_settings']['layoutbuilder']['sections'] = array_map(function (Section $section) {
        return $section->toArray();
      }, $record['third_party_settings']['layoutbuilder']['sections']);
    }
    return $record;
  }

  /**
   * {@inheritdoc}
   */
  protected function mapFromStorageRecords(array $records) {
    foreach ($records as $id => &$record) {
      if (!empty($record['third_party_settings']['layoutbuilder']['sections'])) {
        $sections = &$record['third_party_settings']['layoutbuilder']['sections'];
        $sections = array_map([Section::class, 'fromArray'], $sections);
      }
    }
    return parent::mapFromStorageRecords($records);
  }

}
