<?php

/**
 * @file
 * Definition of Drupal\views_slideshow\Plugin\views\style\ViewsSlideshow.
 */

namespace Drupal\owlcarousel\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * OWL carousel style plugin to render rows in a jquery plugin.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "owl_carousel",
 *   title = @Translation("OWL carousel"),
 *   help = @Translation("Displays rows as OWL carousel elements."),
 *   theme = "views_owl_carousel",
 *   display_types = {"normal"}
 * )
 */
class ViewsOwlCarousel extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

}
