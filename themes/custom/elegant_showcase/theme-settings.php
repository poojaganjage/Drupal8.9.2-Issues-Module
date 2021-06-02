<?php

/**
 * @file
 * Implementation of hook_form_system_theme_settings_alter()
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Theme settings alter for elegant showcase theme form.
 */
function elegant_showcase_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state, $form_id = NULL) {

  $form['theme_settings']['theme'] = [
    '#type' => 'details',
    '#title' => t('Elegant Showcase Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#weight' => 1,
  ];

  $form['theme_settings']['theme']['header'] = [
    '#type' => 'details',
    '#title' => t('Header Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];

  $form['theme_settings']['theme']['header']['header_contact'] = [
    '#type' => 'tel',
    '#title' => t('Contact Number'),
    '#default_value' => theme_get_setting('header_contact'),
    '#description' => t('Enter header contact number.'),
  ];
  $form['theme_settings']['theme']['header']['header_email'] = [
    '#type' => 'textfield',
    '#title' => t('Email ID'),
    '#default_value' => theme_get_setting('header_email'),
    '#description' => t('Enter header email id.'),
  ];

  $form['theme_settings']['theme']['header']['header_social_facebook'] = [
    '#type' => 'textfield',
    '#title' => t('facebook URL'),
    '#default_value' => theme_get_setting('header_social_facebook'),
    '#description' => t('Enter facebook url.'),
  ];
  $form['theme_settings']['theme']['header']['header_social_twitter'] = [
    '#type' => 'textfield',
    '#title' => t('Twitter URL'),
    '#default_value' => theme_get_setting('header_social_twitter'),
    '#description' => t('Enter twitter url.'),
  ];
  $form['theme_settings']['theme']['header']['header_social_linkedin'] = [
    '#type' => 'textfield',
    '#title' => t('Linkedin URL'),
    '#default_value' => theme_get_setting('header_social_linkedin'),
    '#description' => t('Enter linkedin url.'),
  ];
  $form['theme_settings']['theme']['header']['header_social_youtube'] = [
    '#type' => 'textfield',
    '#title' => t('Youtube URL'),
    '#default_value' => theme_get_setting('header_social_youtube'),
    '#description' => t('Enter youtube url.'),
  ];

  $form['theme_settings']['theme']['banner'] = [
    '#type' => 'details',
    '#title' => t('Banner Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];

  $form['theme_settings']['theme']['banner']['banner_checkbox'] = [
    '#type' => 'checkbox',
    '#title' => t('Show Banners Text'),
    '#default_value' => theme_get_setting('banner_checkbox'),
    '#description' => t('Check this option if you like to show the Banner text.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_one'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('banner_one'),
  ];
  $form['theme_settings']['theme']['banner']['banner_one_title'] = [
    '#type' => 'textfield',
    '#title' => t('Banner One Title'),
    '#default_value' => theme_get_setting('banner_one_title'),
    '#description' => t('Enter Banner one title.'),
  ];
  $form['theme_settings']['theme']['banner']['banner_one_description'] = [
    '#type' => 'textfield',
    '#title' => t('Banner one decription'),
    '#default_value' => theme_get_setting('banner_one_description'),
    '#description' => t('Enter Banner one description.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_one_linkLabel'] = [
    '#type' => 'textfield',
    '#title' => t('Banner one Link Title'),
    '#default_value' => theme_get_setting('banner_one_linkLabel'),
    '#description' => t('Enter Banner one Link description.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_one_link'] = [
    '#type' => 'textfield',
    '#title' => t('URL to Redirect'),
    '#default_value' => theme_get_setting('banner_one_link'),
    '#description' => t('Enter Banner one URL.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_two'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('banner_two'),
  ];
  $form['theme_settings']['theme']['banner']['banner_two_title'] = [
    '#type' => 'textfield',
    '#title' => t('Banner Two Title'),
    '#default_value' => theme_get_setting('banner_two_title'),
    '#description' => t('Enter Banner two title.'),
  ];
  $form['theme_settings']['theme']['banner']['banner_two_description'] = [
    '#type' => 'textfield',
    '#title' => t('Banner two decription'),
    '#default_value' => theme_get_setting('banner_two_description'),
    '#description' => t('Enter Banner two description.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_two_linkLabel'] = [
    '#type' => 'textfield',
    '#title' => t('Banner two Link Title'),
    '#default_value' => theme_get_setting('banner_two_linkLabel'),
    '#description' => t('Enter Banner two Link description.'),
  ];

  $form['theme_settings']['theme']['banner']['banner_two_link'] = [
    '#type' => 'url',
    '#title' => t('URL to Redirect'),
    '#default_value' => theme_get_setting('banner_two_link'),
    '#description' => t('Enter Banner two URL.'),
  ];

  $form['theme_settings']['theme']['block_one'] = [
    '#type' => 'details',
    '#title' => t('Block One Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['theme_settings']['theme']['block_one']['block_one_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('block_one_image'),
  ];
  $form['theme_settings']['theme']['block_one']['block_section_title'] = [
    '#type' => 'textfield',
    '#title' => t('Block Section Title'),
    '#default_value' => theme_get_setting('block_section_title'),
    '#description' => t('Enter block section title.'),
  ];

  $form['theme_settings']['theme']['block_one']['block_one_title'] = [
    '#type' => 'textfield',
    '#title' => t('Block One Title'),
    '#default_value' => theme_get_setting('block_one_title'),
    '#description' => t('Enter block one title.'),
  ];
  $form['theme_settings']['theme']['block_one']['block_one_description'] = [
    '#type' => 'textarea',
    '#title' => t('Block One Description'),
    '#default_value' => theme_get_setting('block_one_description'),
    '#description' => t('Enter Block one description.'),
  ];
  $form['theme_settings']['theme']['block_one']['block_one_link'] = [
    '#type' => 'textfield',
    '#title' => t('Block One Link'),
    '#default_value' => theme_get_setting('block_one_link'),
    '#description' => t('Enter block one url to redirect.'),
  ];

  $form['theme_settings']['theme']['block_two'] = [
    '#type' => 'details',
    '#title' => t('Block Two Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['theme_settings']['theme']['block_two']['block_two_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('block_two_image'),
  ];
  $form['theme_settings']['theme']['block_two']['block_two_title'] = [
    '#type' => 'textfield',
    '#title' => t('Block two Title'),
    '#default_value' => theme_get_setting('block_two_title'),
    '#description' => t('Enter block two title.'),
  ];
  $form['theme_settings']['theme']['block_two']['block_two_description'] = [
    '#type' => 'textarea',
    '#title' => t('Block Two Description'),
    '#default_value' => theme_get_setting('block_two_description'),
    '#description' => t('Enter Block two description.'),
  ];
  $form['theme_settings']['theme']['block_two']['block_two_link'] = [
    '#type' => 'textfield',
    '#title' => t('Block Two Link'),
    '#default_value' => theme_get_setting('block_two_link'),
    '#description' => t('Enter block two url to redirect.'),
  ];

  $form['theme_settings']['theme']['block_three'] = [
    '#type' => 'details',
    '#title' => t('Block Three Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['theme_settings']['theme']['block_three']['block_three_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('block_three_image'),
  ];
  $form['theme_settings']['theme']['block_three']['block_three_title'] = [
    '#type' => 'textfield',
    '#title' => t('Block Three Title'),
    '#default_value' => theme_get_setting('block_three_title'),
    '#description' => t('Enter block three title.'),
  ];
  $form['theme_settings']['theme']['block_three']['block_three_description'] = [
    '#type' => 'textarea',
    '#title' => t('Block Three Description'),
    '#default_value' => theme_get_setting('block_three_description'),
    '#description' => t('Enter Block three description.'),
  ];
  $form['theme_settings']['theme']['block_three']['block_three_link'] = [
    '#type' => 'textfield',
    '#title' => t('Block Three Link'),
    '#default_value' => theme_get_setting('block_three_link'),
    '#description' => t('Enter block three url to redirect.'),
  ];

  $form['theme_settings']['theme']['feature_section'] = [
    '#type' => 'details',
    '#title' => t('Feature Section Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['theme_settings']['theme']['feature_section']['feature_section_title'] = [
    '#type' => 'textfield',
    '#title' => t('Feature Section Title'),
    '#default_value' => theme_get_setting('feature_section_title'),
    '#description' => t('Enter Feature Section title.'),
  ];
  $form['theme_settings']['theme']['feature_section']['feature_section_description'] = [
    '#type' => 'textarea',
    '#title' => t('Feature Section Description'),
    '#default_value' => theme_get_setting('feature_section_description'),
    '#description' => t('Enter Feature Section description.'),
  ];

  $form['theme_settings']['theme']['testimonial'] = [
    '#type' => 'details',
    '#title' => t('testimonial Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['theme_settings']['theme']['testimonial']['testimonial_section_title'] = [
    '#type' => 'textfield',
    '#title' => t('Testimonial Section Title'),
    '#default_value' => theme_get_setting('testimonial_section_title'),
    '#description' => t('Enter testimonial Section title.'),
  ];

  $form['theme_settings']['theme']['testimonial']['first_testimonial_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Testimonial Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('first_testimonial_image'),
  ];
  $form['theme_settings']['theme']['testimonial']['first_testimonial_name'] = [
    '#type' => 'textfield',
    '#title' => t('First Testimonial Name'),
    '#default_value' => theme_get_setting('first_testimonial_name'),
    '#description' => t('Enter first testimonial name.'),
  ];
  $form['theme_settings']['theme']['testimonial']['first_testimonial_description'] = [
    '#type' => 'textarea',
    '#title' => t('First Testimonial Description'),
    '#default_value' => theme_get_setting('first_testimonial_description'),
    '#description' => t('Enter First Testimonial description.'),
  ];

  $form['theme_settings']['theme']['testimonial']['second_testimonial_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Testimonial Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('second_testimonial_image'),
  ];
  $form['theme_settings']['theme']['testimonial']['second_testimonial_name'] = [
    '#type' => 'textfield',
    '#title' => t('Second Testimonial Name'),
    '#default_value' => theme_get_setting('second_testimonial_name'),
    '#description' => t('Enter Second testimonial name.'),
  ];
  $form['theme_settings']['theme']['testimonial']['second_testimonial_description'] = [
    '#type' => 'textarea',
    '#title' => t('Second Testimonial Description'),
    '#default_value' => theme_get_setting('second_testimonial_description'),
    '#description' => t('Enter Second Testimonial description.'),
  ];

  $form['theme_settings']['theme']['testimonial']['third_testimonial_image'] = [
    '#type' => 'managed_file',
    '#title' => 'Upload Testimonial Image',
    '#upload_location' => 'public://',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
      'file_validate_size' => [5242880],
    ],
    '#progress_indicator' => 'bar',
    '#default_value' => theme_get_setting('third_testimonial_image'),
  ];
  $form['theme_settings']['theme']['testimonial']['third_testimonial_name'] = [
    '#type' => 'textfield',
    '#title' => t('Third Testimonial Name'),
    '#default_value' => theme_get_setting('third_testimonial_name'),
    '#description' => t('Enter third testimonial name.'),
  ];
  $form['theme_settings']['theme']['testimonial']['third_testimonial_description'] = [
    '#type' => 'textarea',
    '#title' => t('Third Testimonial Description'),
    '#default_value' => theme_get_setting('third_testimonial_description'),
    '#description' => t('Enter Third Testimonial description.'),
  ];

  $form['theme_settings']['theme']['social_icons'] = [
    '#type' => 'details',
    '#title' => t('Social Icons Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];

  $form['theme_settings']['theme']['social_icons']['footer_facebook'] = [
    '#type' => 'textfield',
    '#title' => t('Facebook URL'),
    '#default_value' => theme_get_setting('footer_facebook'),
    '#description' => t('Enter facebook url'),
  ];

  $form['theme_settings']['theme']['social_icons']['footer_linkedin'] = [
    '#type' => 'textfield',
    '#title' => t('Linkedin URL'),
    '#default_value' => theme_get_setting('footer_linkedin'),
    '#description' => t('Enter linkedin url'),
  ];

  $form['theme_settings']['theme']['social_icons']['footer_twitter'] = [
    '#type' => 'textfield',
    '#title' => t('Twitter URL'),
    '#default_value' => theme_get_setting('footer_twitter'),
    '#description' => t('Enter twitter url.'),
  ];

  $form['theme_settings']['theme']['social_icons']['youtube'] = [
    '#type' => 'textfield',
    '#title' => t('Youtube URL'),
    '#default_value' => theme_get_setting('youtube'),
    '#description' => t('Enter youtube url.'),
  ];
}
