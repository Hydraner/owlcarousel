<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Entity\OwlCarouselPreset.
 */

// @todo preset entity

namespace Drupal\owlcarousel\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\owlcarousel\OwlCarouselPresetInterface;

/**
 * Defines an Owl Carousel preset configuration entity.
 *
 * @ConfigEntityType(
 *   id = "owlcarousel_preset",
 *   label = @Translation("Owl Carousel preset"),
 *   controllers = {
 *     "form" = {
 *       "add" = "Drupal\owlcarousel\Form\OwlCarouselPresetAddForm",
 *       "edit" = "Drupal\owlcarousel\Form\OwlCarouselPresetEditForm",
 *       "delete" = "Drupal\owlcarousel\Form\OwlCarouselPresetDeleteForm",
 *     },
 *     "list_builder" = "Drupal\owlcarousel\OwlCarouselPresetListBuilder",
 *   },
 *   admin_permission = "administer owl carousel presets",
 *   config_prefix = "preset",
 *   entity_keys = {
 *     "id" = "name",
 *     "label" = "label"
 *   },
 *   links = {
 *     "edit-form" = "owlcarousel.preset_edit",
 *     "delete-form" = "owlcarousel.preset_delete"
 *   }
 * )
 */
class OwlCarouselPreset extends ConfigEntityBase implements OwlCarouselPresetInterface {

  use StringTranslationTrait;

  /**
   * The Owl Carousel preset label.
   *
   * @var string
   */
  public $label;

  /**
   * The name of the Owl Carousel preset.
   *
   * @var string
   */
  public $name;

  /**
   * The name of the Owl Carousel preset to use as replacement upon delete.
   *
   * @var string
   */
  protected $replacementID;

  public $items = 3;
  public $margin = 0;
  public $mouse_drag = TRUE;
  public $touch_drag = TRUE;
  public $pull_drag = TRUE;
  public $stage_padding = 0;
  public $merge_fit = TRUE;
  public $start_position = 0;
  public $nav_rewind = TRUE;
  public $nav_prev = 'prev';
  public $nav_next = 'next';
  public $slide_by = 1;
  public $dots = TRUE;
  public $dots_each = 0;
  public $autoplay_timeout = 5000;
  public $smart_speed = 250;
  public $fluid_speed = 250;
  public $autoplay_speed = 0;
  public $nav_speed = 0;
  public $dots_speed = 0;
  public $responsive_refresh_rate = 200;
  public $responsive_base_element = 'window';
  public $fallback_easing = 'swing';
  public $item_element = 'div';
  public $stage_element = 'div';

  /**
   * Overrides Drupal\Core\Entity\Entity::id().
   */
  public function id() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->get('label');
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name');
  }

  /**
   * {@inheritdoc}
   */
  public function getReplacementID() {
    return $this->get('replacementID');
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

}
