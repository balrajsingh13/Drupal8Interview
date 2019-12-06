<?php
/**
 * @file
 * Contains \Drupal\mymodule\Controller\HelloController.
 */
namespace Drupal\mymodule\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class ContactController extends ControllerBase {
  public function getContacts() {
    // return array(
    //   '#type' => 'markup',
    //   '#markup' => t('Show Contacts'),
    // );
    $user_role = "admin";
    return ['#theme' => 'contacts_show',
			'#user_role' => $user_role,
		];
  }
}