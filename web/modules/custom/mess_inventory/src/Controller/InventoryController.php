<?php

namespace Drupal\mess_inventory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InventoryController extends ControllerBase {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /* public function list() {
    $limit = 2; // Number of items per page

    // Query with pager.
    $query = $this->database->select('mess_inventory', 'm')
      ->fields('m')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit($limit);

    $results = $query->execute()->fetchAll();

    return [
      '#theme' => 'mess_inventory_list',
      '#members' => $results,
      '#pager' => [
        '#type' => 'pager',
      ],
      '#cache' => ['max-age' => 0], // Don’t cache while testing
    ];
  } */

  public function list() {
    $limit = 5; // number of rows per page

    // Use PagerSelectExtender
    $query = $this->database->select('mess_inventory', 'm')
      ->fields('m')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit($limit);

    $results = $query->execute()->fetchAll();

    return [
      '#theme' => 'mess_inventory_list',
      '#members' => $results,
      '#pager' => [
        '#type' => 'pager',
      ],
      '#cache' => ['max-age' => 0],
    ];
  }
}
