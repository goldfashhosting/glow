<?
//[wpb-random-posts]
function header_rand_posts() { 

$args = array(
	'post_type' => 'post',
	'orderby'	=> 'rand',
	'posts_per_page' => 1, 
	);

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {

$string .= '<!-- Start Random Article --!>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$string .= '<a href="'. get_permalink() .'">Random Article</a>';
	}
	$string .= '<!-- End Random Article --!>';
	/* Restore original Post Data */
	wp_reset_postdata();
} else {

$string .= 'no posts found';
}

return $string; 
} 

add_shortcode('wpb-random-posts','header_rand_posts');
add_filter('widget_text', 'do_shortcode'); 
//
