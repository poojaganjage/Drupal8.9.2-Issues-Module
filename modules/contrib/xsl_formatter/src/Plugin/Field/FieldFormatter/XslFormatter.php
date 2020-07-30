<?php

namespace Drupal\xsl_formatter\Plugin\Field\FieldFormatter;

use DOMDocument;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\xsl_formatter\Entity\Xslt;
use Drupal\xsl_formatter\Utility\XmlUtilities;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the XSL Formatter.
 *
 * @FieldFormatter(
 *   id = "xsl_formatter",
 *   label = @Translation("Transformed by XSL"),
 *   field_types = {
 *     "file",
 *     "link",
 *     "string_long",
 *   }
 * )
 */
class XslFormatter extends FormatterBase {

  /**
   * Guzzle client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Drupal entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a FormatterBase object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Drupals entity type manager.
   */
  public function __construct($plugin_id,
                              $plugin_definition,
                              FieldDefinitionInterface $field_definition,
                              array $settings,
                              $label,
                              $view_mode,
                              array $third_party_settings,
                              EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($plugin_id,
      $plugin_definition,
      $field_definition,
      $settings,
      $label,
      $view_mode,
      $third_party_settings);
    $this->httpClient = \Drupal::httpClient();
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'xsl' => '',
      'xsl_params' => '',
      'debug' => FALSE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $xslList = $this->enumerateXsls();
    $element['xsl'] = [
      '#title' => $this->t('XSL'),
      '#type' => 'select',
      '#default_value' => $settings['xsl'],
      '#description' => $this->t('List of configured XSLs'),
      '#options' => $xslList,
    ];

    $eg_json = Json::encode([
      'indent-elements' => TRUE,
      'css-stylesheet' => 'sites/all/modules/xsl_formatter/xsl/xmlverbatim.css',
    ]);
    $element['xsl_params'] = [
      '#title' => $this->t('Additional parameters'),
      '#type' => 'textarea',
      '#rows' => 2,
      '#cols' => 24,
      '#description' => $this->t('Additional parameters that the transformation stylesheet may expect. Use JSON format, e.g. <pre>%eg_json</pre>',
        ['%eg_json' => $eg_json]),
      '#default_value' => $settings['xsl_params'],
      '#element_validate' => [[$this, 'validateXslParams']],
    ];

    $element['debug'] = [
      '#title' => $this->t('Show XML parsing warnings'),
      '#type' => 'checkbox',
      '#description' => $this->t('Bad XML data input will trigger warnings that may show on screen. Disable this for a public site.'),
      '#default_value' => $settings['debug'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    if (!empty($settings['xsl'])) {
      $xslt = Xslt::load($settings['xsl']);
      $summary[] = $this->t('Using XSL %xsl',
        ['%xsl' => $xslt->label()]);
    }
    else {
      $summary[] = $this->t('No XSL chosen');
    }
    if (!empty($settings['xsl_params'])) {
      $summary[] = $this->t('Additional XSL parameters set');
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $settings = $this->getSettings();
    $fieldType = $this->fieldDefinition->getType();

    foreach ($items as $delta => $item) {
      $result = "Can't parse the XML input";
      $data = '';

      switch ($fieldType) {
        case 'string_long':
          $data = $item->getValue()['value'];
          break;

        case 'link':
          $uri = $item->getValue()['uri'];
          $response = $this->httpClient->request('GET', $uri, ['timeout' => 5]);
          if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
          }
          break;

        case 'file':
          $fileId = $item->getValue()['target_id'];
          $file = File::load($fileId);
          $data = file_get_contents($file->getFileUri());
          break;

        default:
          \Drupal::logger('xsl_formatter')->error($this->t(
            'Unsupported field type: %fieldType',
            ['%fieldType' => $fieldType]
          ));
      }
      $xmlDoc = new DOMDocument();

      try {
        // Tricky to catch errors.
        // Do this to toggle debug mode.
        if ($settings['debug']) {
          // Warnings may go to the screen.
          $xmlDoc->loadXML($data);
        }
        else {
          // Suppress warnings.
          @$xmlDoc->loadXML($data);
        }

        // XML Loaded OK. Now load the stylesheet.
        /** @var \Drupal\xsl_formatter\Entity\Xslt $xslt */
        $xslt = Xslt::load($settings['xsl']);
        // Using loadXML to load an unavailable xsl produces an
        // uncatchable fatal error(!) Use a more careful wrapper instead.
        $xslDoc = XmlUtilities::getXmlDoc($xslt);
        // Pass through any params that the XSLT may want.
        $params = (array) Json::decode($settings['xsl_params']);
        // Transform!
        $result = XmlUtilities::xmldocPlusXsldoc($xmlDoc, $xslDoc, $params);
      }
      catch (Exception $e) {
        \Drupal::logger('xsl_formatter')->error($this->t(
          'Unable to parse the XML data or transform it. Probably invalid XML. %message',
          ['%message' => $e->getMessage()]
        ));
      }

      $elements[$delta] = [
        '#theme' => 'xsl_formatter',
        '#item' => $item,
        '#settings' => $settings,
        '#result' => $result,
      ];
    }

    return $elements;
  }

  /**
   * Ensure the named path exists. This includes a small search lookup.
   */
  public function validateXslPath($element, FormStateInterface &$form_state, $form) {
    try {
      $xsl_doc = XmlUtilities::getXmlDoc($element['#value']);
      unset($xsl_doc);
    }
    catch (Exception $e) {
      $element_id = implode('][', $element['#parents']);
      $form_state->setErrorByName($element_id, $e->getMessage());
    }
  }

  /**
   * Ensure the params are valid. Checks that the JSON parses into something.
   */
  public function validateXslParams($element, FormStateInterface &$form_state, $form) {
    // json_decode doesn't throw many parse errors, so look at the results.
    $value = trim($element['#value']);
    $params = Json::decode($value);
    if (!empty($value) && $params == NULL) {
      // This means some sort of failure.
      $element_id = implode('][', $element['#parents']);
      $form_state->setErrorByName($element_id,
        'Failed to parse the JSON. Check your syntax. You must quote all strings with double-quotes.');
    }
  }

  /**
   * Set newly uploaded file as permanent and as the selected XSL file.
   */
  public function validateXslUpload($element, FormStateInterface &$form_state, $form) {
    /** @var \Drupal\file\Entity\File $file */
    $file = array_pop($element['#files']);
    if (isset($file)) {
      $file->setPermanent();
      $keyArray = $element['#parents'];
      array_pop($keyArray);
      $keyArray[] = 'xsl_path';
      $form_state->setValue($keyArray, $file->getFileUri());
    }
  }

  /**
   * Loads the configured XSLs/XSLTs and returns it as an array.
   *
   * @return array
   *   An array of XSLT entities.
   */
  public function enumerateXsls() {
    $result = [];
    try {
      $entityIds = $this->entityTypeManager->getStorage('xslt')
        ->getQuery()
        ->execute();
      $entities = $xslt = Xslt::loadMultiple($entityIds);
      foreach ($entities as $xslt) {
        $result[$xslt->id()] = $xslt->label();
      }
    }
    catch (InvalidPluginDefinitionException | PluginNotFoundException $e) {
      $this->messenger()
        ->addError('Cannot enumerate XSLs becauce of: ' . $e->getMessage());
    }
    return $result;
  }

}
