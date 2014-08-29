<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselPresetFormBase.
 */

// @todo Preset: form base

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base form for image style add and edit forms.
 */
abstract class OwlCarouselPresetFormBase extends EntityForm {

  /**
   * The entity being used by this form.
   *
   * @var \Drupal\image\ImageStyleInterface
   */
  protected $entity;

  /**
   * The image style entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $owlCarouselStorage;

  protected $owlcarouselPreset;

  /**
   * Constructs a base class for image style add and edit forms.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $owlcarousel_preset_storage
   *   The owlcarousel_preset_storage entity storage.
   */
  public function __construct(EntityStorageInterface $owlcarousel_preset_storage) {
    $this->owlCarouselStorage = $owlcarousel_preset_storage;

    $this->owlcarouselPreset = \Drupal::routeMatch()->getRawParameter('owlcarousel_preset');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('owlcarousel_preset')
    );
  }

  private function getFormArray(&$form, $delta, $data) {

    $form['breakpoints'][$delta] = array(
      '#type' => 'details',
      '#title' => $data['id'],
      '#open' => TRUE,
      '#group' => 'breakpoints_group',
    );


    $form['breakpoints'][$delta]['base'] = array(
      '#type' => 'details',
      '#title' => $this->t('Base'),
      '#open' => TRUE,
      '#parents' => array('breakpoints', $delta),
    );

    $form['breakpoints'][$delta]['advanced'] = array(
      '#type' => 'details',
      '#title' => $this->t('Advanced'),
      '#open' => FALSE,
      '#parents' => array('breakpoints', $delta),
    );


    $form['breakpoints'][$delta]['id'] = array(
      '#type' => 'value',
      '#value' => $data['id'],
    );
    $form['breakpoints'][$delta]['base']['data']['items'] = array(
      '#type' => 'number',
      '#title' => $this->t('Items'),
      '#description' => $this->t('The number of items you want to see on the screen.'),
      '#default_value' => $this->entity->getData('items', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['loop'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Loop'),
      '#description' => $this->t('Inifnity loop. Duplicate last and first items to get loop illusion.'),
      '#default_value' => $this->entity->getData('loop', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['center'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Center'),
      '#description' => $this->t('Center item. Works well with even an odd number of items.'),
      '#default_value' => $this->entity->getData('center', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['nav'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Navigation'),
      '#description' => $this->t('Show next/prev buttons.'),
      '#default_value' => $this->entity->getData('nav', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['nav_text_next'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Nav text next'),
      '#description' => $this->t('HTML allowed.'),
      '#default_value' => $this->entity->getData('nav_text_next', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['nav_text_prev'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Nav text prev'),
      '#description' => $this->t('HTML allowed.'),
      '#default_value' => $this->entity->getData('nav_text_prev', $delta),
    );
    $form['breakpoints'][$delta]['base']['data']['dots'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Dots'),
      '#description' => $this->t('Show dots navigation.'),
      '#default_value' => $this->entity->getData('dots', $delta),
    );

    $form['breakpoints'][$delta]['advanced']['data']['mouseDrag'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Mouse Drag'),
      '#description' => $this->t('Mouse drag enabled.'),
      '#default_value' => $this->entity->getData('mouseDrag', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['touchDrag'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Touch drag'),
      '#description' => $this->t('Touch drag enabled.'),
      '#default_value' => $this->entity->getData('touchDrag', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['pullDrag'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Pull Drag'),
      '#description' => $this->t('Stage pull to edge.'),
      '#default_value' => $this->entity->getData('pullDrag', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['freeDrag'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Free Drag'),
      '#description' => $this->t('Item pull to edge.'),
      '#default_value' => $this->entity->getData('freeDrag', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['stagePadding'] = array(
      '#type' => 'number',
      '#title' => $this->t('Stage Padding'),
      '#description' => $this->t('Padding left and right on stage (can see neighbours).'),
      '#default_value' => $this->entity->getData('stagePadding', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['merge'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Merge'),
      '#description' => $this->t('Merge items. Looking for data-merge={number} inside item.'),
      '#default_value' => $this->entity->getData('merge', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['mergeFit'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Merge Fit'),
      '#description' => $this->t('Fit merged items if screen is smaller than items value.'),
      '#default_value' => $this->entity->getData('mergeFit', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['autoWidth'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Auto Width'),
      '#description' => $this->t('Set non grid content. Try using width style on divs.'),
      '#default_value' => $this->entity->getData('autoWidth', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['autoHeight'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Auto height'),
      '#description' => $this->t('Automatically adjust the height.'),
      '#default_value' => $this->entity->getData('autoHeight', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['navRewind'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Nav Rewind'),
      '#description' => $this->t('Go to first/last.'),
      '#default_value' => $this->entity->getData('navRewind', $delta),
    );

    $form['breakpoints'][$delta]['advanced']['data']['slideBy'] = array(
      '#type' => 'number',
      '#title' => $this->t('Slide By'),
      '#description' => $this->t('Navigation slide by x. page textfield can be set to slide by page.'),
      '#default_value' => $this->entity->getData('slideBy', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['dotsEach'] = array(
      '#type' => 'number',
      '#title' => $this->t('Dots Each'),
      '#description' => $this->t('Show dots each x item.'),
      '#default_value' => $this->entity->getData('dotsEach', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['autoplay'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Autoplay'),
      '#description' => $this->t('Autoplay carousel.'),
      '#default_value' => $this->entity->getData('autoplay', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['autoplayTimeout'] = array(
      '#type' => 'number',
      '#title' => $this->t('Autoplay Timeout'),
      '#description' => $this->t('Autoplay interval timeout.'),
      '#default_value' => $this->entity->getData('autoplayTimeout', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['smartSpeed'] = array(
      '#type' => 'number',
      '#title' => $this->t('Smart Speed'),
      '#description' => $this->t('Speed Calculate. More info to come.'),
      '#default_value' => $this->entity->getData('smartSpeed', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['fluidSpeed'] = array(
      '#type' => 'number',
      '#title' => $this->t('Fluid Speed'),
      '#description' => $this->t('Speed Calculate. More info to come.'),
      '#default_value' => $this->entity->getData('fluidSpeed', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['autoplaySpeed'] = array(
      '#type' => 'number',
      '#title' => $this->t('Autoplay Speed'),
      '#description' => $this->t('Autoplay speed.'),
      '#default_value' => $this->entity->getData('autoplaySpeed', $delta),
    );

    $form['breakpoints'][$delta]['advanced']['data']['navSpeed'] = array(
      '#type' => 'number',
      '#title' => $this->t('Navigation Speed'),
      '#description' => $this->t('Navigation speed.'),
      '#default_value' => $this->entity->getData('navSpeed', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['dotsSpeed'] = array(
      '#type' => 'number',
      '#title' => $this->t('Dots Speed'),
      '#description' => $this->t('Pagination speed.'),
      '#default_value' => $this->entity->getData('dotsSpeed', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['dragEndSpeed'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Drag end speed'),
      '#description' => $this->t('Drag end speed.'),
      '#default_value' => $this->entity->getData('dragEndSpeed', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['responsiveRefreshRate'] = array(
      '#type' => 'number',
      '#title' => $this->t('Responsive refresh rate'),
      '#description' => $this->t('Responsive refresh rate.'),
      '#default_value' => $this->entity->getData('responsiveRefreshRate', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['animateOut'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Animate out'),
      '#description' => $this->t('CSS3 animation out.'),
      '#default_value' => $this->entity->getData('animateOut', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['animateIn'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Danimate in'),
      '#description' => $this->t('CSS3 animation in.'),
      '#default_value' => $this->entity->getData('animateIn', $delta),
    );
    $form['breakpoints'][$delta]['advanced']['data']['fallbackEasing'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Fallback easing'),
      '#description' => $this->t('Easing for CSS2 $.animate.'),
      '#default_value' => $this->entity->getData('fallbackEasing', $delta),
    );

//    items
//    loop
//    center
//    mouseDrag
//    touchDrag
//    pullDrag
//    freeDrag
//    margin
//    stagePadding
//    merge
//    mergeFit
//    autoWidth
//    autoHeight

//    nav
//    navRewind

//    slideBy
//    dots
//    dotsEach

//    autoplay
//    autoplayTimeout
//    smartSpeed
//    fluidSpeed
//    autoplaySpeed

//    navSpeed
//    dotsSpeed
//    dragEndSpeed

//    responsiveRefreshRate
//    animateOut
//    animateIn
//    fallbackEasing

  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

//    $breakpoints = entity_load_multiple('breakpoint_group');
//    if (!empty($breakpoints)) {
//      foreach ($breakpoints as $breakpoint) {
//        $bb[] = $breakpoint->getBreakpoints();
//      }
//    }
//
//    $bb = $bb;


    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Preset name'),
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    );
    $form['name'] = array(
      '#type' => 'machine_name',
      '#machine_name' => array(
        'exists' => array($this->owlCarouselStorage, 'load'),
      ),
      '#default_value' => $this->entity->id(),
      '#required' => TRUE,
    );

//dsm($this->entity->get('breakpoints'));

    $form['breakpoints_group'] = array(
      '#type' => 'vertical_tabs',
      '#tree' => TRUE,
    );

    $form['breakpoints'] = array(
      '#type' => 'value',
      '#tree' => TRUE,
    );

    $this->getFormArray($form, 'default', array('id' => 'Default'));

    $breakpoints = $this->entity->get('breakpoints');
    if (!empty($breakpoints)) {
      foreach ($breakpoints as $delta => $data) {
//        dsm($delta);

        $this->getFormArray($form, $delta, $data);
        if ($delta !== 'default') {
          $form['breakpoints'][$delta]['cancel'] = array(
            '#markup' => $this->l($this->t('Remove'), 'owlcarousel.breakpoint.remove', array('owlcarousel_preset' => $this->owlcarouselPreset, 'owlcarousel_breakpoint' => $data['id'])),
          );
        }
      }
    }

//    dsm($this->entity->get('breakpoints'));

//
//    $form['basic'] = array(
//      '#type' => 'details',
//      '#title' => t('Basic'),
//      '#open' => TRUE,
//    );
//    $form['basic']['items'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Items'),
//      '#description' => $this->t('The number of items you want to see on the screen.'),
//      '#default_value' => $this->entity->get('items'),
//    );


//    items : 5,
//    itemsCustom : false,
//    itemsDesktop : [1199,4],
//    itemsDesktopSmall : [980,3],
//    itemsTablet: [768,2],
//    itemsTabletSmall: false,
//    itemsMobile : [479,1],
//    singleItem : false,
//    itemsScaleUp : false,
//
//    $form['margin'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Margin'),
//      '#description' => $this->t('Margin-right(px) on item.'),
//      '#default_value' => $this->entity->get('margin'),
//    );
//    $form['loop'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Loop'),
//      '#description' => $this->t('Inifnity loop. Duplicate last and first items to get loop illusion.'),
//      '#default_value' => $this->entity->get('loop'),
//    );
//
//
//    $form['center'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Center'),
//      '#description' => $this->t('Center item. Works well with even an odd number of items.'),
//      '#default_value' => $this->entity->get('center'),
//    );
//    $form['mouse_drag'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Mouse Drag'),
//      '#description' => $this->t('Mouse drag enabled.'),
//      '#default_value' => $this->entity->get('mouse_drag'),
//    );
//    $form['touch_drag'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('#touch Drag'),
//      '#description' => $this->t('#touch drag enabled.'),
//      '#default_value' => $this->entity->get('touch_drag'),
//    );
//    $form['pull_drag'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Pull Drag'),
//      '#description' => $this->t('Stage pull to edge.'),
//      '#default_value' => $this->entity->get('pull_drag'),
//    );
//    $form['free_drag'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Free Drag'),
//      '#description' => $this->t('Item pull to edge.'),
//      '#default_value' => $this->entity->get('free_drag'),
//    );
//    $form['stage_padding'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Stage Padding'),
//      '#description' => $this->t('Padding left and right on stage (can see neighbours).'),
//      '#default_value' => $this->entity->get('stage_padding'),
//    );
//    $form['merge'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Merge'),
//      '#description' => $this->t('Merge items. Looking for data-merge={number} inside item.'),
//      '#default_value' => $this->entity->get('merge'),
//    );
//    $form['merge_fit'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Merge Fit'),
//      '#description' => $this->t('Fit merged items if screen is smaller than items value.'),
//      '#default_value' => $this->entity->get('merge_fit'),
//    );
//    $form['auto_width'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Auto Width'),
//      '#description' => $this->t('Set non grid content. Try using width style on divs.'),
//      '#default_value' => $this->entity->get('auto_width'),
//    );
//    $form['start_position'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Start Position'),
//      '#description' => $this->t('Start position or URL Hash textfield like #id.'),
//      '#default_value' => $this->entity->get('start_position'),
//    );
//    $form['url_hash_listener'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('URL Hash Listener'),
//      '#description' => $this->t('Listen to url hash changes. data-hash on items is required.'),
//      '#default_value' => $this->entity->get('url_hash_listener'),
//    );
//    $form['navigation'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Navigation'),
//      '#description' => $this->t('Show next/prev buttons.'),
//      '#default_value' => $this->entity->get('nav'),
//    );
//    $form['nav_rewind'] = array(
//      '#title' => $this->t('Nav Rewind'),
//      '#description' => $this->t('Go to first/last.'),
//      '#default_value' => $this->entity->get('nav_rewind'),
//    );
//    $form['nav_prev'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Navigation text form prev'),
//      '#description' => $this->t('Cusomize your own text for navigation.'),
//      '#default_value' => $this->entity->get('nav_prev'),
//    );
//    $form['nav_next'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Navigation text for next'),
//      '#description' => $this->t('Cusomize your own text for navigation.'),
//      '#default_value' => $this->entity->get('nav_next'),
//    );
//    $form['slide_by'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Slide By'),
//      '#description' => $this->t('Navigation slide by x. page textfield can be set to slide by page.'),
//      '#default_value' => $this->entity->get('slide_by'),
//    );
//    $form['dots'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Dots'),
//      '#description' => $this->t('Show dots navigation.'),
//      '#default_value' => $this->entity->get('dots'),
//    );
//    $form['dots_each'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Dots Each'),
//      '#description' => $this->t('Show dots each x item.'),
//      '#default_value' => $this->entity->get('dots_each'),
//    );
//    $form['dot_data'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Dot Data'),
//      '#description' => $this->t('Used by data-dot content.'),
//      '#default_value' => $this->entity->get('dot_data'),
//    );
//    $form['lazyLoad'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Lazy Load'),
//      '#description' => $this->t('Lazy load images. data-src and data-src-retina for highres. Also load images into background inline style if element is not <img>.'),
//      '#default_value' => $this->entity->get('lazy_load'),
//    );
//    $form['lazy_content'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Lazy Content'),
//      '#description' => $this->t('lazyContent was introduced during beta tests but i removed it from the final release due to bad implementation. It is a nice options so i will work on it in the nearest feature.'),
//      '#default_value' => $this->entity->get('lazy_content'),
//    );
//    $form['autoplay'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Autoplay'),
//      '#description' => $this->t('Autoplay carousel.'),
//      '#default_value' => $this->entity->get('autoplay'),
//    );
//    $form['autoplay_timeout'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Autoplay Timeout'),
//      '#description' => $this->t('Autoplay interval timeout.'),
//      '#default_value' => $this->entity->get('autoplay_timeout'),
//    );
//    $form['autoplay_hover_pause'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Autoplay Hover Pause'),
//      '#description' => $this->t('Pause on mouse hover.'),
//      '#default_value' => $this->entity->get('autoplay_hover_pause'),
//    );
//    $form['smart_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Smart Speed'),
//      '#description' => $this->t('Speed Calculate. More info to come.'),
//      '#default_value' => $this->entity->get('smart_speed'),
//    );
//    $form['fluid_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Fluid Speed'),
//      '#description' => $this->t('Speed Calculate. More info to come.'),
//      '#default_value' => $this->entity->get('fluid_speed'),
//    );
//    $form['autoplay_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Autoplay Speed'),
//      '#description' => $this->t('Autoplay speed.'),
//      '#default_value' => $this->entity->get('autoplay_speed'),
//    );
//    $form['nav_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Navigation Speed'),
//      '#description' => $this->t('Navigation speed.'),
//      '#default_value' => $this->entity->get('nav_speed'),
//    );
//    $form['dots_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Dots Speed'),
//      '#description' => $this->t('Pagination speed.'),
//      '#default_value' => $this->entity->get('dots_speed'),
//    );
//    $form['drag_end_speed'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Drag End Speed'),
//      '#description' => $this->t('Drag end speed.'),
//      '#default_value' => $this->entity->get('drag_end_speed'),
//    );
//    $form['callbacks'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Callbacks'),
//      '#description' => $this->t('Enable callback events.'),
//      '#default_value' => $this->entity->get('callbacks'),
//    );
//    // @todo, responsive option.
////    for ($i = 0; $i < variable_get('responsive', 3); $i++) {
////      $form['responsive_' . $i . '_[itemwidth_part]'] = array(
////        '#type' => 'multiple',
////        '#title' => $this->t('Responsive @number', array('@number' => $i), $options),
////        '#description' => $this->t('Responsive width & item options can be used for setting media queries breakpoints.'),
////        'repeat' => array(
////          '#type' => 'width_items',
////          'default' => array(
////            'width' => t(480),
////            'items' => t(2),
////          ),
////        ),
////        '#default_value' => array(
////          'width' => t(480),
////          'items' => t(2),
////        ),
////      );
////    }
//    $form['responsive_refresh_rate'] = array(
//      '#type' => 'number',
//      '#title' => $this->t('Responsive Refresh Rate'),
//      '#description' => $this->t('Responsive refresh rate.'),
//      '#default_value' => $this->entity->get('responsive_refresh_rate'),
//    );
//    $form['responsive_base_element'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Responsive Base Element'),
//      '#description' => $this->t('Set on any DOM element. If you care about non responsive browser (like ie8) then use it on main wrapper. This will prevent from crazy resizing.'),
//      '#default_value' => $this->entity->get('responsive_base_element'),
//    );
//    $form['responsive_class'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Responsive Class'),
//      '#description' => t("Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element. Can be used to stylize content on given breakpoint."),
//      '#default_value' => $this->entity->get('responsive_class'),
//    );
//    $form['video'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Video'),
//      '#description' => $this->t('Enable fetching YouTube/Vimeo videos.'),
//      '#default_value' => $this->entity->get('video'),
//    );
//    $form['video_height'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Video Height'),
//      '#description' => $this->t('Set height for videos.'),
//      '#default_value' => $this->entity->get('video_height'),
//    );
//    $form['video_width'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('Video Width'),
//      '#description' => $this->t('Set width for videos.'),
//      '#default_value' => $this->entity->get('video_width'),
//    );
//    $form['animate_out'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Animate Out'),
//      '#description' => $this->t('CSS3 animation out.'),
//      '#default_value' => $this->entity->get('animate_out'),
//    );
//    $form['animate_in'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Animate In'),
//      '#description' => $this->t('CSS3 animation in.'),
//      '#default_value' => $this->entity->get('animate_in'),
//    );
//    $form['fallback_easing'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Fallback Easing'),
//      '#description' => $this->t('Easing for CSS2 $.animate.'),
//      '#default_value' => $this->entity->get('fallback_easing'),
//    );
//    $form['info'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Info'),
//      '#description' => $this->t('Callback to retrieve basic information (current item/pages/widths). Info function second parameter is Owl DOM object reference.'),
//      '#default_value' => $this->entity->get('info'),
//    );
//    $form['nested_item_selector'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Nested Item Selector'),
//      '#description' => t("Use it if owl items are deep nasted inside some generated content. E.g 'youritem'. Dont use dot before class name."),
//      '#default_value' => $this->entity->get('nested_item_selector'),
//    );
//    $form['item_element'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Item Element'),
//      '#description' => $this->t('DOM element type for owl-item.'),
//      '#default_value' => $this->entity->get('item_element'),
//    );
//    $form['stage_element'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Stage Element'),
//      '#description' => $this->t('DOM element type for owl-stage.'),
//      '#default_value' => $this->entity->get('stage_element'),
//    );
//    $form['nav_container'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Navigation Container'),
//      '#description' => $this->t('Set your own container for nav.'),
//      '#default_value' => $this->entity->get('nav_container'),
//    );
//    $form['dots_container'] = array(
//      '#type' => 'textfield',
//      '#title' => $this->t('Pagination Container'),
//      '#description' => $this->t('Set your own container for pagination.'),
//      '#default_value' => $this->entity->get('dots_container'),
//    );

    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();
    $form_state['redirect_route'] = $this->entity->urlInfo('edit-form');
  }

}
