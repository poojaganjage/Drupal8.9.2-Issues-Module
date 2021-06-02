<?php
/**
  * @file
  * Contains \Drupal\layoutbuilder\Form\LayoutBuilderSettingsForm
  */
namespace Drupal\layoutbuilder\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symphony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
  * Defines a form to configure LayoutBuilder module settings
  */

class LayoutBuilderSettingsForm extends ConfigFormBase {
  /**
    * {@inheritdoc}
    */
  public function getFormID() {
  	return 'layoutbuilder_admin_settings';
  }
  /**
    * {@inheritdoc}
    */
  protected function getEditableConfigNames() {
  	return [
  		'layoutbuilder.settings'
  	];
  }
  /**
    * {@inheritdoc}
    */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
  	 $types = node_type_get_names();
  	// $config = $this->config('rsvplist.settings');
  	// $form['rsvplist_types'] = array(
   //    '#type' => 'checkboxes',
   //    '#title' => $this->t('The content types to enable RSVP collection for'),
   //    '#default_value' => $config->get('allowed_types'),
   //    '#options' => $types,
   //    '#description' => t('On the specified node types, an RSVP option will be available and can be enabled while that node is being edited.'),
  	// );
  	// $form['array_filter'] = array(
  	//   '#type' => 'value',
  	//   '#value' => TRUE,
  	// );

    // $entity_options = [];
    // $entities = $this->entityTypeManager->getDefinitions();
    $config = $this->config('layoutbuilder.settings');
    // foreach ($entities as $entity_type => $entity_info) {
    //   if ($entity_info->get('field_ui_base_route') || $entity_type == 'ds_views') {
    //     $entity_options[$entity_type] = Unicode::ucfirst(str_replace('_', ' ', $entity_type));
    //   }
    // }
    $form['entities'] = [
      '#title' => $this->t('Entities'),
      '#description' => $this->t('Select the entities for which this field will be made available.'),
      '#type' => 'checkboxes',
      '#required' => TRUE,
      '#options' => $types,
      '#default_value' => $config->get('allowed_types'),
    ];
  	return parent::buildForm($form, $form_state);
  }
  /**
    * {@inheritdoc}
    */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  	$allowed_types = array_filter($form_state->getValue('entities'));
  	sort($allowed_types);
  	$this->config('layoutbuilder.settings')
  	  ->set('allowed_types', $allowed_types)
  	  ->save();
  	  parent::submitForm($form, $form_state);
  }
}