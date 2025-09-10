<?php

declare(strict_types=1);

namespace Drupal\mess_inventory\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Mess inventory form.
 */
final class AddNewMemeber extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'mess_inventory_add_new_memeber';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['#attached']['library'][] = 'mess_inventory/mess_inventory_styles';

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Please enter your name'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your name'),
        'class' => ['custom-input'],
      ],
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Your Age'),
      '#description' => $this->t('Please enter your age'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 35,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your age'),
        'class' => ['custom-input'],
      ],
    ];

    $form['phone'] = [
      '#type' => 'number',
      '#title' => $this->t('Contact No.'),
      /* '#description' => $this->t('Please enter your contact No'), */
      '#required' => TRUE,
      '#min' => 0000000000,
      '#max' => 9999999999,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your contact No'),
        'class' => ['custom-input'],
      ],
    ];

    $form['parent_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Please enter your parent name'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your parent name'),
        'class' => ['custom-input'],
      ],
    ];

    $form['parent_phone'] = [
      '#type' => 'number',
      '#title' => $this->t('Parent Contact No.'),
      /* '#description' => $this->t('Please enter your parent contact No'), */
      '#required' => TRUE,
      '#min' => 0000000000,
      '#max' => 9999999999,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your parent contact No'),
        'class' => ['custom-input'],
      ],
    ];

    $form['address'] = [
      '#type' => 'textarea',
      /* '#title' => $this->t('Please enter your address'), */
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Please enter your address'),
        'class' => ['custom-input'],
      ],
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Add Member'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $age = $form_state->getValue('age');

    if ($age > 35) {
      $form_state->setErrorByName('age', $this->t('Age must not be greater than 35.'));
    }
    elseif ($age < 1) {
      $form_state->setErrorByName('age', $this->t('Age must be at least 1.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {

    // Dump all submitted values for debugging.
    /* echo '<pre>';
    var_dump($form_state->getValues());
    echo '</pre>';
    exit; */

    $values = $form_state->getValues();

    // Insert into DB.
    \Drupal::database()->insert('mess_inventory')
      ->fields([
        'name' => $values['name'],
        'age' => $values['age'],
        'contact_no' => $values['phone'],
        'parent_name' => $values['parent_name'],
        'parent_contact_no' => $values['parent_phone'],
        'address' => $values['address'],
      ])
      ->execute();

    // Show success message.
    \Drupal::messenger()->addMessage($this->t('Member added successfully.'));

    // Redirect to listing page (optional).
    /* $form_state->setRedirect('mess_inventory.list'); */
    $form_state->setRedirect('mess_inventory.add_new_memeber');

  }

}
