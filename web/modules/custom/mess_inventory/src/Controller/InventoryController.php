<?php

namespace Drupal\mess_inventory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Controller for inventory listing.
 */
class InventoryController extends ControllerBase {

  /**
   *
   */
  public function list() {
    $header = ['ID', 'Name', 'Message', 'Age', 'Actions'];

    $rows = [];
    $results = \Drupal::database()->select('mess_inventory', 'm')
      ->fields('m', ['id', 'name', 'age', 'contact_no', 'parent_name', 'parent_contact_no', 'address'])
      ->execute()
      ->fetchAll();

    foreach ($results as $row) {
      $edit_url = Url::fromRoute('mess_inventory.edit_member', ['id' => $row->id]);
      $rows[] = [
        $row->id,
        $row->name,
        $row->age,
        $row->contact_no,
        $row->parent_name,
        $row->parent_contact_no,
        $row->address,
        Link::fromTextAndUrl('Edit', $edit_url)->toString(),
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No entries found.'),
    ];
  }

}
