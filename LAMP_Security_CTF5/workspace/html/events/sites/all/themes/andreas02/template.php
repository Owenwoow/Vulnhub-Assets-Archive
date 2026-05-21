<?php
/** Define the regions **/
function andreas02_regions() {
  return array(
        'sidebar' => t('sidebar'),
        'main_block' => t('main_block'),
        'content' => t('content'),
        'header' => t('header'),
        'footer' => t('footer'),
   );
}
//Hack to ensure primary menu (the active item) stays highlighted when a secondary item is selested
//see http://drupal.org/node/140491
function phptemplate_andreas02_primarylinks($links, $attributes = array('class' => 'links')) {
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = '';

      // Automatically add a class to each link and also to each LI
      if (isset($link['attributes']) && isset($link['attributes']['class'])) {
        $link['attributes']['class'] .= ' ' . $key;
        $class = $key;
      }
      else {
        $link['attributes']['class'] = $key;
        $class = $key;
      }

    $explode_array = explode('-',$link['attributes']['class']);
    if(count($explode_array)== 5)
    {
        array_push($explode_array,'active');
        $link['attributes']['class'] = implode('-',$explode_array);
        $pos = strrpos($link['attributes']['class'], "-");
        $link['attributes']['class'] = substr_replace($link['attributes']['class'], ' ', $pos, -6);
    }
      // Add first and last classes to the list of links to help out themers.
      $extra_class = '';
      if ($i == 1) {
        $extra_class .= 'first ';
      }
      if ($i == $num_links) {
        $extra_class .= 'last ';
      }
      $output .= '<li class="'. $extra_class . $class .'">';

      // Is the title HTML?
$html = isset($link['html']) && $link['html'];

      // Initialize fragment and query variables.
      $link['query'] = isset($link['query']) ? $link['query'] : NULL;
      $link['fragment'] = isset($link['fragment']) ? $link['fragment'] : NULL;

      if (isset($link['href'])) {
        //$output .= l($link['title'], $link['href'], $link['attributes'], $link['query'], $link['fragment'], FALSE, $html);
        $output .= l($link['title'], $link['href'], $link['attributes'], $link['query'], $link['fragment'], FALSE, true);
      }
      else if ($link['title']) {
        //Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (!$html) {
          $link['title'] = check_plain($link['title']);
        }
        $output .= '<span'. drupal_attributes($link['attributes']) .'>'. $link['title'] .'</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}
// split out taxonomy terms by vocabulary
//see http://drupal.org/node/133223
function andreas02_print_terms($nid) {
     $vocabularies = taxonomy_get_vocabularies();
     $output = '';
     foreach($vocabularies as $vocabulary) {
       if ($vocabularies) {
         $terms = taxonomy_node_get_terms_by_vocabulary($nid, $vocabulary->vid);
         if ($terms) {
           $links = array();
           //$output .= '' . $vocabulary->name . ': ';
           foreach ($terms as $term) {
             $links[] = l($term->name, taxonomy_term_path($term), array('rel' => 'tag', 'title' => strip_tags($term->description)));
           }
           $output .= implode(', ', $links);
         }
       }
     }

     return $output;
}
?>