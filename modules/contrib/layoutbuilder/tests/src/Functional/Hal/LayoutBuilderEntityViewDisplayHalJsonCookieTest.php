<?php

namespace Drupal\Tests\layoutbuilder\Functional\Hal;

use Drupal\Tests\rest\Functional\CookieResourceTestTrait;

/**
 * @group layoutbuilder
 * @group rest
 */
class LayoutBuilderEntityViewDisplayHalJsonCookieTest extends LayoutBuilderEntityViewDisplayHalJsonAnonTest {

  use CookieResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $auth = 'cookie';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

}
