<?php

namespace Drupal\Tests\layoutbuilder\Functional\Hal;

use Drupal\FunctionalTests\Hal\EntityViewDisplayHalJsonAnonTest;
use Drupal\Tests\rest\Functional\BasicAuthResourceTestTrait;

/**
 * @group layoutbuilder
 * @group rest
 */
class LayoutBuilderEntityViewDisplayHalJsonBasicAuthTest extends EntityViewDisplayHalJsonAnonTest {

  use BasicAuthResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['basic_auth'];

  /**
   * {@inheritdoc}
   */
  protected static $auth = 'basic_auth';

}
