<?php
/* Do not remove this line. Add your functions below. */
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'shorten_post_title');

function shorten_post_title() {
	$post_url = get_permalink();
	$old_title = get_the_title();
	$new_title = preg_match('/^[^,\d?!;]*/', $old_title, $matches);
	$new_short_title = $matches[0];
	echo '<h1><a href="' . $post_url . '">' . $new_short_title . '</a></h1>';
}