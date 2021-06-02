<?php

namespace Drupal\layoutbuilder_fieldblock_test\ContextProvider;

use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;

/**
 * Provides a global context for view_mode for testing purposes.
 *
 * @group layoutbuilder
 */
class FakeViewModeContext implements ContextProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    return ['view_mode' => new Context(new ContextDefinition('string'), 'default')];
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    return $this->getRuntimeContexts([]);
  }

}
