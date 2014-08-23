<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselPresetAddForm.
 */

namespace Drupal\owlcarousel\Form;
use Drupal\Core\Form\FormStateInterface;

/**
 * Controller for Owl Carousel preset addition forms.
 */
class OwlCarouselPresetAddForm extends OwlCarouselPresetFormBase {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    drupal_set_message($this->t('Preset %name was created.', array('%name' => $this->entity->label())));
  }

  /**
   * {@inheritdoc}
   */
  public function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Create new preset');

    return $actions;
  }

}
