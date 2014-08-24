<?php

/**
 * @file
 * Definition of Drupal\views_slideshow\Plugin\views\style\ViewsSlideshow.
 */

namespace Drupal\owlcarousel\Plugin\views\style;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\views\ViewExecutable;

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
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);

    // Attach wolcarousel library to view element.
    $view->element['#attached']['library'][] = 'owlcarousel/owlcarousel.jquery';
    $view->element['#attached']['library'][] = 'owlcarousel/owlcarousel';

    // Load configured configuration entity.
    $prset = $view->display_handler->getOption('owlcarousel_preset');
    $my_data = entity_load('owlcarousel_preset', $options['owlcarousel_preset']);

    // Attach entity data and views dom id to drupal settings.
    $view->element['#attached']['js'][] = array(
      'data' => array(
        'owlcarousel_id' => 'view-dom-id-' . $view->dom_id,
        'owlcarousel' => $my_data
      ),
      'type' => 'setting',
    );
  }

  /**
   * Set default options.
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['owlcarousel_preset'] = array('default' => '');

    return $options;
  }

  /**
   * Render the given style.
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

}
