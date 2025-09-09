<?php

namespace Drupal\mess_inventory\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EditMemberForm extends FormBase {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function getFormId() {
    return 'mess_inventory_edit_member_form';
  }

  /**
   * Build the edit form.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    // Fetch record by ID.
    $record = $this->database->select('mess_inventory', 'm')
      ->fields('m')
      ->condition('id', $id)
      ->execute()
      ->fetchObject();

    if (!$record) {
      $form['message'] = [
        '#markup' => $this->t('Record not found.'),
      ];
      return $form;
    }

    // Hidden ID field.
    $form['id'] = [
      '#type' => 'hidden',
      '#value' => $record->id,
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $record->name,
      '#required' => TRUE,
      '#attributes' => ['class' => ['form-control']],
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#default_value' => $record->message,
      '#attributes' => ['class' => ['form-control']],
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#default_value' => $record->age,
      '#required' => TRUE,
      '#attributes' => ['class' => ['form-control']],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
      '#attributes' => ['class' => ['btn', 'btn-primary', 'mt-3']],
    ];

    return $form;
  }

  /**
   * Submit handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->database->update('mess_inventory')
      ->fields([
        'name' => $form_state->getValue('name'),
        'message' => $form_state->getValue('message'),
        'age' => $form_state->getValue('age'),
      ])
      ->condition('id', $form_state->getValue('id'))
      ->execute();

    \Drupal::messenger()->addMessage($this->t('Member updated successfully.'));
    $form_state->setRedirect('mess_inventory.list');
  }

}
