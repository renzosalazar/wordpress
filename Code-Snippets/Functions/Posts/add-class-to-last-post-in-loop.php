<?php
	// Add a class to the last post in a loop
	// source: http://wpdaily.co/top-10-snippets/

function so_last_post_class($classes){
	global $wp_query;
	if(($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'last';
	return $classes;
}
add_filter('post_class', 'so_last_post_class');

/**
 * Add "end" to last Post in the Loop
 * For example when using Foundation for Sites
 * 
 * @source: //wordpress.stackexchange.com/a/7382/2015
 */

add_filter('post_class', function($classes){
  global $wp_query;

  if(($wp_query->current_post + 1) == $wp_query->post_count)
    $classes[] = 'end';

  return $classes;
});
