<?php

namespace Drupal\Tests\layoutbuilder\Functional\Hal;

use Drupal\Tests\layoutbuilder\Functional\Rest\LayoutBuilderEntityViewDisplayResourceTestBase;
use Drupal\Tests\rest\Functional\AnonResourceTestTrait;

/**
 * @group layoutbuilder
 * @group rest
 */
class LayoutBuilderEntityViewDisplayHalJsonAnonTest extends LayoutBuilderEntityViewDisplayResourceTestBase {

  use AnonResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['hal'];

  /**
   * {@inheritdoc}
   */
  protected static $format = 'hal_json';

  /**
   * {@inheritdoc}
   */
  protected static $mimeType = 'application/hal+json';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

}
