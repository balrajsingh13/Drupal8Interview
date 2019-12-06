<?php
/**
 * @file
 * Contains \Drupal\user_form\Plugin\Block\UserFormBlock.
 */

namespace Drupal\user_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'user_form' block.
 *
 * @Block(
 *   id = "user_form_block",
 *   admin_label = @Translation("User Form block"),
 *   category = @Translation("Custom User Form block example")
 * )
 */
class UserFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\user_form\Form\UserForm');

    return $form;
   }
}