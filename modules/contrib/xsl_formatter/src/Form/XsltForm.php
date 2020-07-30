<?php

namespace Drupal\xsl_formatter\Form;

use DOMDocument;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for the XSLT add and edit forms.
 */
class XsltForm extends EntityForm {

  /**
   * Constructs an ExampleForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var $xslt \Drupal\xsl_formatter\Entity\Xslt */
    $xslt = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#description' => $this->t("Label of the XSLT entity."),
      '#maxlength' => 255,
      '#default_value' => $xslt->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $xslt->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$xslt->isNew(),
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $xslt->description,
      '#rows' => 5,
    ];

    if ($xslt->isNew()) {
      $form['file'] = [
        '#type' => 'managed_file',
        '#title' => $this->t('XSL file'),
        '#description' => $this->t("If a file is given, it's content will overwrite the content of the textarea below."),
        '#upload_location' => 'private://xslt',
        '#upload_validators' => [
          'file_validate_extensions' => ['xsl', 'xslt'],
        ],
      ];
    }

    $form['xsl'] = [
      '#type' => 'textarea',
      '#title' => $this->t('XSL'),
      '#description' => $xslt->isNew()
      ? $this->t("Copy and paste the XSL content here. This will only be used if no XSL file is given.")
      : $this->t("Editable XSL content"),
      '#default_value' => $xslt->getXsl(),
      '#rows' => '24',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\xsl_formatter\Entity\Xslt $xslt */
    $xslt = $this->entity;

    $formFile = $form_state->getValue('file', 0);
    if (isset($formFile[0]) && !empty($formFile[0])) {
      $file = File::load($formFile[0]);
      $xmlDocument = new DOMDocument();
      $xmlDocument->load($file->getFileUri());
      $xslt->xsl = $xmlDocument->saveXml();
    }

    $status = $xslt->save();

    if ($status === SAVED_NEW) {
      $this->messenger()->addMessage($this->t('XSLT %label created.', [
        '%label' => $xslt->label(),
      ]));
    }
    else {
      $this->messenger()->addMessage($this->t('XSLT %label updated.', [
        '%label' => $xslt->label(),
      ]));
    }

    $form_state->setRedirect('entity.xslt.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $xslFile = $form_state->getValue('file', 0);
    $xslField = $form_state->getValue('xsl');
    if (empty($xslFile) && empty($xslField)) {
      $form_state->setErrorByName('file',
        $this->t('A XSL file or string is mandatory!'));
    }
  }

  /**
   * Helper function to check whether an XSLT entity already exists.
   */
  public function exist($id) {
    $entity = $this->entityTypeManager->getStorage('xslt')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
