<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselBreakpointConfigurationAdd.
 */

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for Owl Carousel breakpoint addition form.
 */
class OwlCarouselBreakpointConfigurationAdd extends FormBase {

  protected $container;

  protected $owlcarousel_preset;

  /**
   * {@inheritdoc}
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->owlcarousel_preset = \Drupal::routeMatch()->getRawParameter('owlcarousel_preset');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = array();

    $breakpoints = entity_load_multiple('breakpoint_group');
    if (!empty($breakpoints)) {
      foreach ($breakpoints as $breakpoint) {
        $breakpoint_options = array();
        foreach ($breakpoint->getBreakpoints() as $definition) {
          $breakpoint_options[$definition->id] = $definition->label;
        }
        $options[$breakpoint->id()] = $breakpoint_options;
      }
    }


    $owlcarousel_preset_entity = entity_load('owlcarousel_preset', $this->owlcarousel_preset);
    $breakpoints = $owlcarousel_preset_entity->get('breakpoints');
    foreach ($breakpoints as $delta => $data) {
      foreach ($options as $option_set => $blubb) {
        foreach ($blubb as $id => $data2) {
          if ($id == $data['id']) {
            unset($options[$option_set][$data['id']]);
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
      '#markup' => $this->l($this->t('Cancel'), 'owlcarousel.preset_edit', array('owlcarousel_preset' => $this->owlcarousel_preset)),
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
    $form_state->setRedirect('owlcarousel.preset_edit', array('owlcarousel_preset' => $this->owlcarousel_preset));
    // TODO: Implement submitForm() method.

    $owlcarousel_preset_entity = entity_load('owlcarousel_preset', $this->owlcarousel_preset);
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
