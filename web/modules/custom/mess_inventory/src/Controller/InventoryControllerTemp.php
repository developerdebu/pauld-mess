<?php

namespace Drupal\mess_inventory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InventoryControllerTemp extends ControllerBase {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function list() {
    $limit = 3; // rows per page

    // Use PagerSelectExtender
    $query = $this->database->select('mess_inventory', 'm')
      ->fields('m')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit($limit);

    $results = $query->execute()->fetchAll();

    // Define table header
    $header = [
      'id' => $this->t('ID'),
      'name' => $this->t('Name'),
      'age' => $this->t('Age'),
      'contact_no' => $this->t('Contact'),
      'actions' => $this->t('Actions'),
    ];

    // Build rows
    $rows = [];
    foreach ($results as $row) {
      $rows[] = [
        'id' => $row->id,
        'name' => $row->name,
        'age' => $row->age,
        'contact_no' => $row->contact_no,
        'actions' => [
          'data' => [
            '#type' => 'link',
            '#title' => $this->t('Edit'),
            '#url' => \Drupal\Core\Url::fromRoute('mess_inventory.edit_member', ['id' => $row->id]),
            '#attributes' => ['class' => ['btn', 'btn-sm', 'btn-warning']],
          ],
        ],
      ];
    }

    // Build render array
    $build = [
      'table' => [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        '#empty' => $this->t('No members found.'),
        '#attributes' => ['class' => ['table', 'table-striped', 'table-hover']],
      ],
      'pager' => [
        '#type' => 'pager',
      ],
    ];

    return $build;
  }

}
