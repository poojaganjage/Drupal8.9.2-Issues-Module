<?php

namespace Drupal\layoutbuilder\Routing;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface;
use Drupal\layoutbuilder\SectionStorage\SectionStorageManagerInterface;
use Symfony\Component\Routing\Route;

/**
 * Loads the section storage from the layout tempstore.
 *
 * @internal
 *   Tagged services are internal.
 */
class LayoutTempstoreParamConverter implements ParamConverterInterface {

  /**
   * The layout tempstore repository.
   *
   * @var \Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface
   */
  protected $layoutTempstoreRepository;

  /**
   * The section storage manager.
   *
   * @var \Drupal\layoutbuilder\SectionStorage\SectionStorageManagerInterface
   */
  protected $sectionStorageManager;

  /**
   * Constructs a new LayoutTempstoreParamConverter.
   *
   * @param \Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface $layout_tempstore_repository
   *   The layout tempstore repository.
   * @param \Drupal\layoutbuilder\SectionStorage\SectionStorageManagerInterface $section_storage_manager
   *   The section storage manager.
   */
  public function __construct(LayoutTempstoreRepositoryInterface $layout_tempstore_repository, SectionStorageManagerInterface $section_storage_manager) {
    $this->layoutTempstoreRepository = $layout_tempstore_repository;
    $this->sectionStorageManager = $section_storage_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    // If no section storage type is specified or if it is invalid, return.
    if (!isset($defaults['section_storage_type']) || !$this->sectionStorageManager->hasDefinition($defaults['section_storage_type'])) {
      return NULL;
    }

    $type = $defaults['section_storage_type'];
    // Load an empty instance and derive the available contexts.
    $contexts = $this->sectionStorageManager->loadEmpty($type)->deriveContextsFromRoute($value, $definition, $name, $defaults);
    // Attempt to load a full instance based on the context.
    if ($section_storage = $this->sectionStorageManager->load($type, $contexts)) {
      // Pass the plugin through the tempstore repository.
      return $this->layoutTempstoreRepository->get($section_storage);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return !empty($definition['layoutbuilder_tempstore']);
  }

}
