<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselPresetDeleteForm.
 */

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Url;

/**
 * Creates a form to delete an Owl Carousel preset.
 */
class OwlCarouselPresetDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Optionally select a preset before deleting %preset', array('%preset' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('owlcarousel.preset_list');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('If this preset is in use on the site, you may select another preset to replace it.');
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, array &$form_state) {
    // @todo Preset: 'Delete' form
    /*
    $replacement_styles = array_diff_key(image_style_options(), array($this->entity->id() => ''));
    $form['replacement'] = array(
      '#title' => $this->t('Replacement preset'),
      '#type' => 'select',
      '#options' => $replacement_styles,
      '#empty_option' => $this->t('No replacement, just delete'),
    );*/

    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {
    $this->entity->set('replacementID', $form_state['values']['replacement']);
    $this->entity->delete();
    drupal_set_message($this->t('Preset %name was deleted.', array('%name' => $this->entity->label())));
    $form_state['redirect_route'] = $this->getCancelUrl();
  }

}
