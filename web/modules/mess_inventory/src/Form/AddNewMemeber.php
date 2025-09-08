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

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Your Age'),
      '#description' => $this->t('Please enter your age'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 35,
    ];

    $form['phone'] = [
      '#type' => 'number',
      '#title' => $this->t('Contact No.'),
      '#description' => $this->t('Please enter your contact No'),
      '#required' => TRUE,
      '#min' => 0000000000,
      '#max' => 9999999999,
    ];

    $form['parent_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Parent name'),
      '#required' => TRUE,
    ];

    $form['parent_phone'] = [
      '#type' => 'number',
      '#title' => $this->t('Parent Contact No.'),
      '#description' => $this->t('Please enter your parent contact No'),
      '#required' => TRUE,
      '#min' => 0000000000,
      '#max' => 9999999999,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Your Age'),
      '#description' => $this->t('Please enter your age'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 120,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode




  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
  /*   $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>'); */



  }

}
