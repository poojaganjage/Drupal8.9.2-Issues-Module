<?php

namespace Drupal\layoutbuilder\Cache;

use Drupal\Core\Cache\Context\RouteNameCacheContext;

/**
 * Determines if an entity is being viewed in the Layout Builder UI.
 *
 * Cache context ID: 'route.name.is_layoutbuilder_ui'.
 *
 * @internal
 *   Tagged services are internal.
 */
class LayoutBuilderUiCacheContext extends RouteNameCacheContext {

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('Layout Builder user interface');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    return 'is_layoutbuilder_ui.' . (int) (strpos($this->routeMatch->getRouteName(), 'layoutbuilder.') !== 0);
  }

}
