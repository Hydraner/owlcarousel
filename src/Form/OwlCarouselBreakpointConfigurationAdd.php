<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselBreakpointConfigurationAdd.
 */

namespace Drupal\owlcarousel\Form;

use Drupal\breakpoint\BreakpointManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for Owl Carousel breakpoint addition form.
 */
class OwlCarouselBreakpointConfigurationAdd extends FormBase {

  protected $breakpointManager;

  protected $owlcarouselPreset;

  /**
   * {@inheritdoc}
   */
  public function __construct(BreakpointManagerInterface $breakpoint_manager) {
    $this->breakpointManager = $breakpoint_manager;
    $this->owlcarouselPreset = \Drupal::routeMatch()->getRawParameter('owlcarousel_preset');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('breakpoint.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = array();

    $breakpoints = $this->breakpointManager->getDefinitions();
    foreach ($breakpoints as $breakpoint_id => $breakpoint) {
      $options[$breakpoint['group']][$breakpoint_id] = $breakpoint['label'];
    }

    $owlcarousel_preset_entity = entity_load('owlcarousel_preset', $this->owlcarouselPreset);
    $breakpoints = $owlcarousel_preset_entity->get('breakpoints');
    if (!empty($breakpoints)) {
      foreach ($breakpoints as $delta => $data) {
        foreach ($options as $option_set => $blubb) {
          foreach ($blubb as $id => $data2) {
            if ($id == $data['id']) {
              unset($options[$option_set][$data['id']]);
            }
          }
        }
      }
    }


//
//    $form['id'] = array(
//      '#type' => 'value',
////      '#value' => $this->imageEffect->getPluginId(),
//    );

    $form['breakpoint'] = array(
      '#title' => $this->t('Breakpoint'),
      '#type' => 'select',
      '#options' => $options,
    );

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add breakpoint to preset'),
    );

    // @todo: Add remove method.
    $form['actions']['cancel'] = array(
      '#markup' => $this->l($this->t('Cancel'), Url::fromRoute('owlcarousel.preset_edit', ['owlcarousel_preset' => $this->owlcarouselPreset])),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'owl-carousel-breakpoint-add';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('owlcarousel.preset_edit', array('owlcarousel_preset' => $this->owlcarouselPreset));
    // TODO: Implement submitForm() method.

    $owlcarousel_preset_entity = entity_load('owlcarousel_preset', $this->owlcarouselPreset);
    $breakpoints = $owlcarousel_preset_entity->get('breakpoints');
    if (!empty($breakpoints)) {
      $owlcarousel_preset_entity->breakpoints[] = array(
        'id' => $form_state->getValue('breakpoint'),
        'data' => array()
      );
    }
    else {
      $owlcarousel_preset_entity->breakpoints[0] = array(
        'id' => $form_state->getValue('breakpoint'),
        'data' => array()
      );
    }
    $owlcarousel_preset_entity->save();
  }
}
