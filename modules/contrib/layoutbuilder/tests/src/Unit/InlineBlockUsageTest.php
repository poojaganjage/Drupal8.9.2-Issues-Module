<?php

namespace Drupal\Tests\layoutbuilder\Unit;

use Drupal\Core\Database\Connection;
use Drupal\layoutbuilder\InlineBlockUsage;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\layoutbuilder\InlineBlockUsage
 *
 * @group layoutbuilder
 */
class InlineBlockUsageTest extends UnitTestCase {

  /**
   * Tests calling deleteUsage() with empty array.
   *
   * @covers ::deleteUsage
   */
  public function testEmptyDeleteUsageCall() {
    $connection = $this->prophesize(Connection::class);
    $connection->delete('inline_block_usage')->shouldNotBeCalled();

    (new InlineBlockUsage($connection->reveal()))->deleteUsage([]);
  }

}
