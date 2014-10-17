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
use Drupal\Core\Url;
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

  private function getDefaultFormArray(&$form, $delta, $data) {

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
      '#type' => 'integer',
      '#title' => $this->t('Drag end speed'),
      '#description' => $this->t('Drag endsmartSpeed speed.'),
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

  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

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

        $this->getFormArray($form, $delta, $data);
        if ($delta !== 'default') {
          $form['breakpoints'][$delta]['cancel'] = array(
            '#markup' => $this->l($this->t('Remove'), Url::fromRoute('owlcarousel.breakpoint.remove', ['owlcarousel_preset' => $this->owlcarouselPreset, 'owlcarousel_breakpoint' => $data['id']])),
          );
        }
        else {
          $this->getDefaultFormArray($form, $delta, $data);
        }
      }
    }


    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();
    $form_state->setRedirectUrl($this->entity->urlInfo('edit-form'));
  }

}
