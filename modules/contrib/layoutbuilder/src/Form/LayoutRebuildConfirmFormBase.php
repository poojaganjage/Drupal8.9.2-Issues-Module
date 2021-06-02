<?php

namespace Drupal\layoutbuilder\Form;

use Drupal\Core\Ajax\AjaxFormHelperTrait;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\layoutbuilder\Controller\LayoutRebuildTrait;
use Drupal\layoutbuilder\LayoutBuilderHighlightTrait;
use Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface;
use Drupal\layoutbuilder\SectionStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a base class for confirmation forms that rebuild the Layout Builder.
 *
 * @internal
 *   Form classes are internal.
 */
abstract class LayoutRebuildConfirmFormBase extends ConfirmFormBase {

  use AjaxFormHelperTrait;
  use LayoutBuilderHighlightTrait;
  use LayoutRebuildTrait;

  /**
   * The layout tempstore repository.
   *
   * @var \Drupal\layoutbuilder\LayoutTempstoreRepositoryInterface
   */
  protected $layoutTempstoreRepository;

  /**
   * The section storage.
   *
   * @var \Drupal\layoutbuilder\SectionStorageInterface
   */
  protected $sectionStorage;

  /**
   * The field delta.
   *
   * @var int
   */
  protected $delta;

  /**
   * Constructs a new RemoveSectionForm.
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
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return $this->sectionStorage->getLayoutBuilderUrl();
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, SectionStorageInterface $section_storage = NULL, $delta = NULL) {
    $this->sectionStorage = $section_storage;
    $this->delta = $delta;

    $form = parent::buildForm($form, $form_state);

    if ($this->isAjax()) {
      $form['actions']['submit']['#ajax']['callback'] = '::ajaxSubmit';
      $form['actions']['cancel']['#attributes']['class'][] = 'dialog-cancel';
      $target_highlight_id = !empty($this->uuid) ? $this->blockUpdateHighlightId($this->uuid) : $this->sectionUpdateHighlightId($delta);
      $form['#attributes']['data-layout-builder-target-highlight-id'] = $target_highlight_id;
    }

    // Mark this as an administrative page for JavaScript ("Back to site" link).
    $form['#attached']['drupalSettings']['path']['currentPathIsAdmin'] = TRUE;
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->handleSectionStorage($this->sectionStorage, $form_state);

    $this->layoutTempstoreRepository->set($this->sectionStorage);

    $form_state->setRedirectUrl($this->getCancelUrl());
  }

  /**
   * {@inheritdoc}
   */
  protected function successfulAjaxSubmit(array $form, FormStateInterface $form_state) {
    return $this->rebuildAndClose($this->sectionStorage);
  }

  /**
   * Performs any actions on the section storage before saving.
   *
   * @param \Drupal\layoutbuilder\SectionStorageInterface $section_storage
   *   The section storage.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  abstract protected function handleSectionStorage(SectionStorageInterface $section_storage, FormStateInterface $form_state);

}
