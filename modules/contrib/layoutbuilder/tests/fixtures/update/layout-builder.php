<?php

/**
 * @file
 * Test fixture.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

// Set the schema version.
$connection->merge('key_value')
  ->fields([
    'value' => 'i:8000;',
    'name' => 'layoutbuilder',
    'collection' => 'system.schema',
  ])
  ->condition('collection', 'system.schema')
  ->condition('name', 'layoutbuilder')
  ->execute();

// Update core.extension.
$extensions = $connection->select('config')
  ->fields('config', ['data'])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute()
  ->fetchField();
$extensions = unserialize($extensions);
$extensions['module']['layoutbuilder'] = 0;
$extensions['module']['layout_discovery'] = 0;
$extensions['module']['layout_test'] = 0;
$connection->update('config')
  ->fields([
    'data' => serialize($extensions),
    'collection' => '',
    'name' => 'core.extension',
  ])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute();
