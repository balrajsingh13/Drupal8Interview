<?php
/**
 * @file
 * Contains \Drupal\user_form\Form\UserForm.
 */
namespace Drupal\user_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an user form.
 */

class UserForm extends FormBase {
/**
 * {@inheritdoc}
 */ 
    public function getFormId() {
        return 'user_entry_form';
    }

/**
 * {@inheritdoc}
 */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['first_name'] = [
            '#type' => 'textfield',
            '#placeholder' => 'Balraj',
            '#maxlength' => 255,
            '#required' => TRUE,
          ];
        $form['last_name'] = [
            '#type' => 'textfield',
            '#placeholder' => 'Singh',
            '#maxlength' => 255,
            '#required' => TRUE,
          ];
        $form['email'] = [
            '#type' => 'email',
            '#placeholder' => 'balra.singh@kelltontech.com',
            '#maxlength' => 255,
            '#required' => TRUE,
          ];
        $form['phone_number'] = [
            '#type' => 'tel',
            '#placeholder' => '8527117990',
            '#maxlength' => 10,
            '#required' => TRUE,
          ];           
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
          ];      
        return $form;
    }
/**
 * {@inheritdoc}
 */    
    public function validateForm(array &$form, FormStateInterface $form_state) {
      if ( strpos($form_state->getValue('email'), "gmail") != TRUE  ) {
        $form_state->setErrorByName('email', $this->t('The email does not contains gmail.'));
      }

      $array_emails = array();
      $array_phone = array();

      $database = \Drupal::database();
      $query = $database->select('user_entries', 'u');
      $query->condition('u.uid', 1, '=');
      $query->fields('u', ['uid', 'email', 'phone_number']);
      $result = $query->execute();
      while ($row = $result->fetchAssoc()) {
        // array_push($array_emails, $row['email']);
        // array_push($array_phone, $row['phone_number']);
        $array_emails[] = $row['email'];
        $array_phone[] = $row['phone_number'];
      }

      foreach (array_combine($array_emails, $array_phone) as $email => $phone) {
        if ( $email == $form_state->getValue('email') ) {
          $form_state->setErrorByName($form_state->getValue('email'), $this->t('This email already exists.'));
        }
        if ( $phone == $form_state->getValue('phone_number') ) {
          $form_state->setErrorByName($form_state->getValue('phone_number'), $this->t('This phone number already exists.'));
        }
      }
      return $form;
    }
/**
 * {@inheritdoc}
 */
    public function submitForm(array &$form, FormStateInterface $form_state) {

      $uid = \Drupal::currentUser()->id();
      \Drupal::database()->insert('user_entries')
      ->fields([
        'uid',
        'first_name',
        'last_name',
        'email',
        'phone_number',        
      ])
      ->values(array(
        $uid,
        $form_state->getValue('first_name'),		
        $form_state->getValue('last_name'),
        $form_state->getValue('email'),
        $form_state->getValue('phone_number'),
      ))
      ->execute();

      drupal_set_message(t('Information has been saved'));
      $rendered_message = \Drupal\Core\Render\Markup::create("
      <div>First Name : ".$form_state->getValue('first_name')."</div>
      <div>Last Name : ".$form_state->getValue('last_name')."</div>
      <div>Emai : ".$form_state->getValue('email')."</div>
      <div>Phone Number : ".$form_state->getValue('phone_number')."</div>
      ");
      drupal_set_message($rendered_message); 
    }
}

/*
* Implements hook_form_alter().
* {@inheritdoc}
*/
function user_form_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  die();
  $form['#attached']['library'][] = 'dlp_common/dlp_commonjs';
}