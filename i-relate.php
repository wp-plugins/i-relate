<?php
/*
 * Plugin Name: i Relate
 * Plugin URI:  http://www.rareinput.com
 * Description: Simple WordPress Plugin to add 3 related posts at the end of the blog post from same category.
 * Version: 1.0
 * Author: Apoorv Dwivedi
 * Author URI: http://www.rareinput.com
 * License: GPL2
 */

add_filter( 'the_content', 'irelate_add_posts');

/**
* add links of the related post at the bottom of the posts.
*/

function irelate_add_posts($content){
 if(!is_singular('post')){
	return $content;
}

$categories = get_the_terms(get_the_ID(), 'category');
$categoriesIds[] = array();

foreach($categories as $category){
	$categoriesIds[] = $category->term_id;
}

$loop = new WP_Query(array(
	'category_in' => $categoriesIds,
	'posts_per_page' => 3,
	'post__not_in' => array(get_the_Id()),
	'orderby' => 'rand'
	));

if($loop->have_posts()){
	$content .= 'Related Posts:<br/><ul>';
	while($loop->have_posts()){
	$loop->the_post();
	$content .='<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
	}

$content .= '</ul>';
}

wp_reset_query();

return $content;
}
?>