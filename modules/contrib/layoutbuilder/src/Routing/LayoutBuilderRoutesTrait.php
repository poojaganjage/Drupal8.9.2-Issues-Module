<?php

namespace Drupal\layoutbuilder\Routing;

use Drupal\Component\Utility\NestedArray;
use Drupal\layoutbuilder\DefaultsSectionStorageInterface;
use Drupal\layoutbuilder\OverridesSectionStorageInterface;
use Drupal\layoutbuilder\SectionStorage\SectionStorageDefinition;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Provides a trait for building routes for a Layout Builder UI.
 */
trait LayoutBuilderRoutesTrait {

  /**
   * Builds the layout routes for the given values.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection.
   * @param \Drupal\layoutbuilder\SectionStorage\SectionStorageDefinition $definition
   *   The definition of the section storage.
   * @param string $path
   *   The path patten for the routes.
   * @param array $defaults
   *   (optional) An array of default parameter values.
   * @param array $requirements
   *   (optional) An array of requirements for parameters.
   * @param array $options
   *   (optional) An array of options.
   * @param string $route_name_prefix
   *   (optional) The prefix to use for the route name.
   * @param string $entity_type_id
   *   (optional) The entity type ID, if available.
   */
  protected function buildLayoutRoutes(RouteCollection $collection, SectionStorageDefinition $definition, $path, array $defaults = [], array $requirements = [], array $options = [], $route_name_prefix = '', $entity_type_id = '') {
    $type = $definition->id();
    $defaults['section_storage_type'] = $type;
    // Provide an empty value to allow the section storage to be upcast.
    $defaults['section_storage'] = '';
    // Trigger the layout builder access check.
    $requirements['_layoutbuilder_access'] = 'view';
    // Trigger the layout builder RouteEnhancer.
    $options['_layoutbuilder'] = TRUE;
    // Trigger the layout builder param converter.
    $parameters['section_storage']['layoutbuilder_tempstore'] = TRUE;
    // Merge the passed in options in after Layout Builder's parameters.
    $options = NestedArray::mergeDeep(['parameters' => $parameters], $options);

    if ($route_name_prefix) {
      $route_name_prefix = "layoutbuilder.$type.$route_name_prefix";
    }
    else {
      $route_name_prefix = "layoutbuilder.$type";
    }

    $main_defaults = $defaults;
    $main_options = $options;
    if ($entity_type_id) {
      $main_defaults['_entity_form'] = "$entity_type_id.layoutbuilder";
    }
    else {
      $main_defaults['_controller'] = '\Drupal\layoutbuilder\Controller\LayoutBuilderController::layout';
    }
    $main_defaults['_title_callback'] = '\Drupal\layoutbuilder\Controller\LayoutBuilderController::title';
    $route = (new Route($path))
      ->setDefaults($main_defaults)
      ->setRequirements($requirements)
      ->setOptions($main_options);
    $collection->add("$route_name_prefix.view", $route);

    $discard_changes_defaults = $defaults;
    $discard_changes_defaults['_form'] = '\Drupal\layoutbuilder\Form\DiscardLayoutChangesForm';
    $route = (new Route("$path/discard-changes"))
      ->setDefaults($discard_changes_defaults)
      ->setRequirements($requirements)
      ->setOptions($options);
    $collection->add("$route_name_prefix.discard_changes", $route);

    if (is_subclass_of($definition->getClass(), OverridesSectionStorageInterface::class)) {
      $revert_defaults = $defaults;
      $revert_defaults['_form'] = '\Drupal\layoutbuilder\Form\RevertOverridesForm';
      $route = (new Route("$path/revert"))
        ->setDefaults($revert_defaults)
        ->setRequirements($requirements)
        ->setOptions($options);
      $collection->add("$route_name_prefix.revert", $route);
    }
    elseif (is_subclass_of($definition->getClass(), DefaultsSectionStorageInterface::class)) {
      $disable_defaults = $defaults;
      $disable_defaults['_form'] = '\Drupal\layoutbuilder\Form\LayoutBuilderDisableForm';
      $disable_options = $options;
      unset($disable_options['_admin_route'], $disable_options['_layoutbuilder']);
      $route = (new Route("$path/disable"))
        ->setDefaults($disable_defaults)
        ->setRequirements($requirements)
        ->setOptions($disable_options);
      $collection->add("$route_name_prefix.disable", $route);
    }
  }

}
