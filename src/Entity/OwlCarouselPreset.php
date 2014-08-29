<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Entity\OwlCarouselPreset.
 */

namespace Drupal\owlcarousel\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\owlcarousel\OwlCarouselPresetInterface;

/**
 * Defines an Owl Carousel preset configuration entity.
 *
 * @ConfigEntityType(
 *   id = "owlcarousel_preset",
 *   label = @Translation("Owl Carousel preset"),
 *   handlers = {
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

  public $breakpoints = array();

  /**
   * @param FormStateInterface $form_state
   */
  public function setBreakpoints(FormStateInterface $form_state) {
    foreach ($form_state->getValue('breakpoints') as $delta => $data) {
      $this->breakpoints[$delta]['id'] = $data['id'];
      $this->breakpoints[$delta]['data'] = $data['data'];
    }
//    $this->breakpoints[] = array(
//      'id' => $form_state->getValue('breakpoint'),
//      'data' => array()
//    );
//    dsm($form_state->getValues());
//    $this->breakpoints[0]['id'] = 'custom.id';
//    $this->breakpoints[0]['data']['items'] = $form_state->getValue('items');
//    $this->breakpoints[1]['id'] = 'custom.id.2';
//    $this->breakpoints[1]['data']['items'] = $form_state->getValue('items');
  }


  /**
   * {@inheritdoc}
   */
  public function getData($property_name, $delta) {
    if ($property_name != 'name' && $property_name != 'label') {
      if (isset($this->breakpoints[$delta]['data'][$property_name])) {
        return $this->breakpoints[$delta]['data'][$property_name];
      }
      else if ($default_value = $this->getDefaultValue($property_name)) {
        return $default_value;
      }
      return NULL;
    }
//    return isset($this->$property_name) ? $this->$property_name : NULL;
  }

  public function getDefaultValue($property_name) {
    $values = array(
      'items' => 3,
      'loop' => false,
      'center' => false,
      'rewind' => false,
      'mouseDrag' => true,
      'touchDrag' => true,
      'pullDrag' => true,
      'freeDrag' => false,
      'margin' => 0,
      'stagePadding' => 0,
      'merge' => false,
      'mergeFit' => true,
      'autoWidth' => false,
      'autoHeight' => false,
      'nav' => false,
      'nav_text_next' => 'next',
      'nav_text_prev' => 'prev',
      'navRewind' => false,
      'slideBy' => 1,
      'dots' => true,
      'dotsEach' => false,
      'startPosition' => 0,
      'rtl' => false,
      'animateOut' => false,
      'animateIn' => false,
      'autoplay' => false,
      'autoplayTimeout' => 5000,
      'autoplaySpeed' => false,
      'navSpeed' => false,
      'dotsSpeed' => false,
      'smartSpeed' => 250,
      'fluidSpeed' => false,
      'dragEndSpeed' => false,
      'responsiveRefreshRate' => 200,
      'fallbackEasing' => 'swing',
      'nestedItemSelector' => false,
      'itemElement' => 'div',
      'stageElement' => 'div',
      'refreshClass' => 'owl-refresh',
      'loadedClass' => 'owl-loaded',
      'loadingClass' => 'owl-loading',
      'rtlClass' => 'owl-rtl',
      'dragClass' => 'owl-drag',
      'itemClass' => 'owl-item',
      'stageClass' => 'owl-stage',
      'stageOuterClass' => 'owl-stage-outer',
      'grabClass' => 'owl-grab'
    );

    return isset($values[$property_name]) ? $values[$property_name] : FALSE;
  }

//  public $items = 3;
//  public $margin = 0;
//  public $mouse_drag = TRUE;
//  public $touch_drag = TRUE;
//  public $pull_drag = TRUE;
//  public $stage_padding = 0;
//  public $merge_fit = TRUE;
//  public $start_position = 0;
//  public $nav_rewind = TRUE;
//  public $nav_prev = 'prev';
//  public $nav_next = 'next';
//  public $slide_by = 1;
//  public $dots = TRUE;
//  public $dots_each = 0;
//  public $autoplay_timeout = 5000;
//  public $smart_speed = 250;
//  public $fluid_speed = 250;
//  public $autoplay_speed = 0;
//  public $nav_speed = 0;
//  public $dots_speed = 0;
//  public $responsive_refresh_rate = 200;
//  public $responsive_base_element = 'window';
//  public $fallback_easing = 'swing';
//  public $item_element = 'div';
//  public $stage_element = 'div';

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
