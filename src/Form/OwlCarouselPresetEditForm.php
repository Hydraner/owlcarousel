<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselPresetEditForm.
 */

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for image style edit form.
 */
class OwlCarouselPresetEditForm extends OwlCarouselPresetFormBase {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    drupal_set_message($this->t('Changes to the preset have been saved.'));
  }

  /**
   * {@inheritdoc}
   */
  public function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Update preset');

    return $actions;
  }

}
