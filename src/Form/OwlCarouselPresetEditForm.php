<?php

/**
 * @file
 * Contains \Drupal\owlcarousel\Form\OwlCarouselPresetEditForm.
 */

// @todo Preset: edit form

namespace Drupal\owlcarousel\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\image\ConfigurableImageEffectInterface;
use Drupal\Component\Utility\String;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for image style edit form.
 */
class OwlCarouselPresetEditForm extends OwlCarouselPresetFormBase {
  /**
   * @var EntityStorageInterface
   */
  private $owl_carouse_preset;

  /**
   * Constructs an ImageStyleEditForm object.
   */
  public function __construct(EntityStorageInterface $owl_carouse_preset) {
    parent::__construct($owl_carouse_preset);
    $this->owl_carouse_preset = $owl_carouse_preset;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('owlcarousel_preset')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    return parent::form($form, $form_state);
  }

  /**
   * Validate handler for image effect.
   */
  public function effectValidate(array $form, FormStateInterface $form_state) {
    if (!$form_state['values']['new']) {
      $this->setFormError('new', $form_state, $this->t('Select an effect to add.'));
    }
  }

  /**
   * Submit handler for image effect.
   */
  public function effectSave(array $form, FormStateInterface $form_state) {

    // Update image effect weights.
    if (!empty($form_state['values']['effects'])) {
      $this->updateEffectWeights($form_state['values']['effects']);
    }

    $this->entity->set('name', $form_state['values']['name']);
    $this->entity->set('label', $form_state['values']['label']);

    $status = parent::save($form, $form_state);

    if ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('Changes to the style have been saved.'));
    }

    // Check if this field has any configuration options.
    $effect = $this->imageEffectManager->getDefinition($form_state['values']['new']);

    // Load the configuration form for this option.
    if (is_subclass_of($effect['class'], '\Drupal\image\ConfigurableImageEffectInterface')) {
      $form_state['redirect_route'] = array(
        'route_name' => 'image.effect_add_form',
        'route_parameters' => array(
          'image_style' => $this->entity->id(),
          'image_effect' => $form_state['values']['new'],
        ),
        'options' => array(
          'query' => array('weight' => $form_state['values']['weight']),
        ),
      );
    }
    // If there's no form, immediately add the image effect.
    else {
      $effect = array(
        'id' => $effect['id'],
        'data' => array(),
        'weight' => $form_state['values']['weight'],
      );
      $effect_id = $this->entity->addImageEffect($effect);
      $this->entity->save();
      if (!empty($effect_id)) {
        drupal_set_message($this->t('The image effect was successfully applied.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    // Update image effect weights.
    if (!empty($form_state['values']['effects'])) {
      $this->updateEffectWeights($form_state['values']['effects']);
    }

    parent::save($form, $form_state);
    drupal_set_message($this->t('Changes to the style have been saved.'));
  }

  /**
   * {@inheritdoc}
   */
  public function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Update style');

    return $actions;
  }

  /**
   * Updates image effect weights.
   *
   * @param array $effects
   *   Associative array with effects having effect uuid as keys and and array
   *   with effect data as values.
   */
  protected function updateEffectWeights(array $effects) {
    foreach ($effects as $uuid => $effect_data) {
      if ($this->entity->getEffects()->has($uuid)) {
        $this->entity->getEffect($uuid)->setWeight($effect_data['weight']);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    foreach ($form_state['values'] as $key => $value) {
      // Do not copy effects here, see self::updateEffectWeights().
      if ($key != 'effects') {
        $entity->set($key, $value);
      }
    }
  }

}
