<?php

namespace Drupal\layoutbuilder\Controller;

use Drupal\Core\Ajax\AjaxHelperTrait;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface;
use Drupal\layoutbuilder\Section;
use Drupal\layoutbuilder\SectionStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines a controller to add a new section.
 *
 * @internal
 *   Controller classes are internal.
 */
class AddSectionController implements ContainerInjectionInterface {

  use AjaxHelperTrait;
  use LayoutRebuildTrait;

  /**
   * The layout tempstore repository.
   *
   * @var \Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface
   */
  protected $layoutTempstoreRepository;

  /**
   * AddSectionController constructor.
   *
   * @param \Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface $layout_tempstore_repository
   *   The layout tempstore repository.
   */
  public function __construct(LayoutTempstoreRepositoryInterface $layout_tempstore_repository) {
    $this->layoutTempstoreRepository = $layout_tempstore_repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('layoutbuilder.tempstore_repository')
    );
  }

  /**
   * Adds the new section.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   * @param int $delta
   *   The delta of the section to splice.
   * @param string $plugin_id
   *   The plugin ID of the layout to add.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The controller response.
   */
  public function build(SectionStorageInterface $section_storage, $delta, $plugin_id) {
    $section_storage->insertSection($delta, new Section($plugin_id));

    $this->layoutTempstoreRepository->set($section_storage);

    if ($this->isAjax()) {
      return $this->rebuildAndClose($section_storage);
    }
    else {
      $url = $section_storage->getLayoutBuilderUrl();
      return new RedirectResponse($url->setAbsolute()->toString());
    }
  }

}
