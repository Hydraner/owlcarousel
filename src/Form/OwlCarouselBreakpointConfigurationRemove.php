<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselBreakpointConfigurationRemove.
 */

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Controller for OWL Carousel breakpoint configuration remove form.
 */
class OwlCarouselBreakpointConfigurationRemove extends ConfirmFormBase {

  /**
   * The OWL Carousel preset id.
   *
   * @var string
   */
  protected $owlcarouselPreset;

  /**
   * The OWL Carousel breakpoint config id.
   *
   * @var string
   */
  protected $breakpointConfigId;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->owlcarouselPreset = \Drupal::routeMatch()->getRawParameter('owlcarousel_preset');
    $this->breakpointConfigId = \Drupal::routeMatch()->getRawParameter('owlcarousel_breakpoint');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you really want to delete the configuration for this breakpoint?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('owlcarousel.preset_edit', array('owlcarousel_preset' => $this->owlcarouselPreset));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'owl-carousel-breakpoint-remove';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('owlcarousel.preset_edit', array('owlcarousel_preset' => $this->owlcarouselPreset));

    $owlcarousel_preset_entity = entity_load('owlcarousel_preset', $this->owlcarouselPreset);
    $breakpoints = $owlcarousel_preset_entity->get('breakpoints');
    foreach ($breakpoints as $delta => $breakpoint_config) {
      if ($breakpoint_config['id'] == $this->breakpointConfigId) {
        unset($owlcarousel_preset_entity->breakpoints[$delta]);
      }
    }

    $owlcarousel_preset_entity->save();
  }
}
