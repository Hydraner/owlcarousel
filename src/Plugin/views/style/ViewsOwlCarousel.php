<?php

/**
 * @file
 * Definition of Drupal\owlcarousel\Plugin\views\style\ViewsOwlCarousel.
 */

namespace Drupal\owlcarousel\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * OWL Carousel style plugin to render rows in a jquery plugin.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "owl_carousel",
 *   title = @Translation("OWL Carousel"),
 *   help = @Translation("Displays rows as OWL Carousel elements."),
 *   theme = "views_owl_carousel",
 *   display_types = {"normal"}
 * )
 */
class ViewsOwlCarousel extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  protected $usesRowClass = TRUE;

  /**
   * {@inheritdoc}
   */
  protected $usesGrouping = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['owlcarousel_preset'] = array('default' => '');

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $options = array();
    foreach (entity_load_multiple('owlcarousel_preset') as $delta => $entity) {
      $options[$entity->id()] = $entity->getLabel();
    }
    $form['owlcarousel_preset'] = array(
      '#type' => 'select',
      '#title' => t('OWL Carousel preset'),
      '#options' => $options,
      '#default_value' => $this->options['type'],
    );
  }

  /**
   * {@inheritdoc}
   */
  public function preRender($result) {
    parent::preRender($result);

    // Attach owlcarousel library to view element.
    $this->view->element['#attached']['library'][] = 'owlcarousel/owlcarousel.jquery';
    $this->view->element['#attached']['library'][] = 'owlcarousel/owlcarousel';

    // Load configured configuration entity.
    // $settings = entity_load('owlcarousel_preset', $this->options['owlcarousel_preset']);


    // Load configured configuration entity.
    $owlcarousel_preset = entity_load('owlcarousel_preset', $this->options['owlcarousel_preset']);

    $settings = array(
      'responsiveClass' => true,
    );
    if (isset($owlcarousel_preset->breakpoints)) {
      foreach ($owlcarousel_preset->breakpoints as $delta => $breakpoint_configuration) {
        $breakpoint = entity_load('breakpoint', $breakpoint_configuration['id']);
        $settings['responsive'][$breakpoint->mediaQuery] = $breakpoint_configuration['data'];
      }
    }

    // Attach entity data and views dom id to drupal settings.
    $this->view->element['#attached']['js'][] = array(
      'data' => array(
        'owlcarousel' => array(
          'view-dom-id-' . $this->view->dom_id => $settings,
        ),
      ),
      'type' => 'setting',
    );
  }

}
