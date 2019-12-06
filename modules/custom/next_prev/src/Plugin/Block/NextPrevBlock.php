<?php
/**
 * @file
 * Contains \Drupal\next_prev\Plugin\Block\NextPrevBlock.
 */

namespace Drupal\next_prev\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'next_prev' block.
 *
 * @Block(
 *   id = "next_prev_block",
 *   admin_label = @Translation("Next Prev Block"),
 *   category = @Translation("Custom Next Prev Block")
 * )
 */
class NextPrevBlock extends BlockBase {
/**
* {@inheritdoc}
*/
  public function build() {
    $next_prev = [];
  	$node = \Drupal::routeMatch()->getParameter('node');
  	if ($node instanceof \Drupal\node\NodeInterface) {
  	  $nid = $node->id(); //current nid
  	}
  	$entity = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
  	$current_nid_created_date = $entity->get('created')->value;
    $record = next_prev_get_nids(); //include sorted nids of gallery nodes
    //Creating associted aray with elements as key, nid, created_date
    foreach ($record as $key => $row) {
      if($current_nid_created_date == $row['created']) {
        //Case for last record
        if(sizeof($record)-1 == $key){
          $next_prev["prev"] = $key-1;   //Storing prevous key
          $next_prev["next"] = 0;   //Storing next key  
        }
        //Case for first record
        elseif($key == 0){
          $next_prev["prev"] = sizeof($record)-1;   //Storing prevous key
          $next_prev["next"] = 1;   //Storing next key  
        }
        else{
          $next_prev["prev"] = $key-1;   //Storing prevous key
          $next_prev["next"] = $key+1;   //Storing next key
        }   
      }
    }
    foreach ($record as $key => $row) {
      if ($next_prev["next"] == $key){
        $next_node = $row['nid'];
      }
      if ($next_prev["prev"] == $key){
        $prev_node = $row['nid'];
      }
    }
    $next_node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/drupal8/node/'.$next_node);
    $prev_node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/drupal8/node/'.$prev_node);

    $buttons = "<span class='prev-button'><a href=".$prev_node_alias."> << </a></span><span class='next-button'><a href=".$next_node_alias."> >> </a></span>";
    return array(
      '#type' => 'markup',
      '#markup' => $buttons,
    );
  }
}