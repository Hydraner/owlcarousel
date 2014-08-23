<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\OwlCarouselPresetInterface.
 */

namespace Drupal\owlcarousel;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an Owl Carousel preset entity.
 */
interface OwlCarouselPresetInterface extends ConfigEntityInterface {

  /**
   * Returns the Owl Carousel preset.
   *
   * @return string
   *   The name of the Owl Carousel preset.
   */
  public function getName();

  /**
   * Returns the replacement ID.
   *
   * @return string
   *   The name of the Owl Carousel preset to use as replacement upon delete.
   */
  public function getReplacementID();

  /**
   * Sets the name of the Owl Carousel preset.
   *
   * @param string $name
   *   The name of the Owl Carousel preset.
   *
   * @return \Drupal\owlcarousel\OwlCarouselPresetInterface
   *   The class instance this method is called on.
   */
  public function setName($name);

}
