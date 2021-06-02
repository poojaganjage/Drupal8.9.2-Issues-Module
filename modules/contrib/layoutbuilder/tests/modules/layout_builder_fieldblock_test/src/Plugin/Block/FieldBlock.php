<?php

namespace Drupal\layoutbuilder_fieldblock_test\Plugin\Block;

use Drupal\layoutbuilder\Plugin\Block\FieldBlock as LayoutBuilderFieldBlock;

/**
 * Provides test field block to test with Block UI.
 *
 * \Drupal\Tests\layoutbuilder\FunctionalJavascript\FieldBlockTest provides
 * test coverage of complex AJAX interactions within certain field blocks.
 * layoutbuilder_plugin_filter_block__block_ui_alter() removes certain blocks
 * with 'layoutbuilder' as the provider. To make these blocks available during
 * testing, this plugin uses the same deriver but each derivative will have a
 * different provider.
 *
 * @Block(
 *   id = "field_block_test",
 *   deriver = "\Drupal\layoutbuilder\Plugin\Derivative\FieldBlockDeriver",
 * )
 *
 * @see \Drupal\Tests\layoutbuilder\FunctionalJavascript\FieldBlockTest
 * @see layoutbuilder_plugin_filter_block__block_ui_alter()
 */
class FieldBlock extends LayoutBuilderFieldBlock {

}
