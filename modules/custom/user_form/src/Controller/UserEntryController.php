<?php
/**
 * @file
 * Contains \Drupal\user_form\Controller\UserEntryController.
 */
namespace Drupal\user_form\Controller;

use Drupal\Core\Controller\ControllerBase;
 
class UserEntryController extends ControllerBase {
  public function getEntries() {
    $database = \Drupal::database();
    $query = $database->select('user_entries', 'u');
    $query->fields('u', ['first_name', 'last_name', 'email', 'phone_number']);
    $result = $query->execute();
    while ($row = $result->fetchAssoc()) {
        $data_row[] = $row;
    }
    return ['#theme' => 'contacts_show',
            '#data_row' => $data_row,       
        ];
  }

  
}