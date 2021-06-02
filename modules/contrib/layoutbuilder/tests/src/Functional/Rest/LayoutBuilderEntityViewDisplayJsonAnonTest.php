<?php

namespace Drupal\Tests\layoutbuilder\Functional\Rest;

use Drupal\Tests\rest\Functional\AnonResourceTestTrait;

/**
 * @group layoutbuilder
 * @group rest
 */
class LayoutBuilderEntityViewDisplayJsonAnonTest extends LayoutBuilderEntityViewDisplayResourceTestBase {

  use AnonResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $format = 'json';

  /**
   * {@inheritdoc}
   */
  protected static $mimeType = 'application/json';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

}
