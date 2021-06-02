<?php

namespace Drupal\layoutbuilder;

/**
 * Defines events for the layoutbuilder module.
 *
 * @see \Drupal\layoutbuilder\Event\SectionComponentBuildRenderArrayEvent
 */
final class LayoutBuilderEvents {

  /**
   * Name of the event fired when a component's render array is built.
   *
   * This event allows modules to collaborate on creating the render array of
   * the SectionComponent object. The event listener method receives a
   * \Drupal\layoutbuilder\Event\SectionComponentBuildRenderArrayEvent
   * instance.
   *
   * @Event
   *
   * @see \Drupal\layoutbuilder\Event\SectionComponentBuildRenderArrayEvent
   * @see \Drupal\layoutbuilder\SectionComponent::toRenderArray()
   *
   * @var string
   */
  const SECTION_COMPONENT_BUILD_RENDER_ARRAY = 'section_component.build.render_array';

}
