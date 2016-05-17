<?php
/**
 * Feature Name: MarketPress Comment Stuff
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Count amount of pingbacks + trackbacks for a post.
 *
 * @link	http://wordpress.stackexchange.com/a/96596/23011
 *
 * @param	int $post_id Post ID for comment query. Default is current post.
 * @return	int
 */
function helsinki_get_count_pings( $post_id = NULL ) {
	global $wp_query;

	$pings	  = 0;
	$comments = FALSE;

	if ( $post_id !== NULL )
		$comments = get_comments( array (
			'post_id' => $post_id, # Note: post_ID will not work!
			'status'  => 'approve'
		) );
	else if ( ! empty ( $wp_query->comments ) )
		$comments = $wp_query->comments;

	if ( ! $comments )
		return 0;

	foreach ( $comments as $comment )
		if ( in_array ( $comment->comment_type, array ( 'pingback', 'trackback' ) ) )
			$pings += 1;

	return $pings;
}

/**
 * Callback for wp_list_comments( array ( 'type' => 'pings' ) );
 * pings is pingback and trackback together
 *
 * @link	http://wordpress.stackexchange.com/a/96596/23011
 * @link	http://codex.wordpress.org/Function_Reference/wp_list_comments#Parameters
 *
 * @param	object $comment
 * @return	void
 */
function helsinki_the_pings( $comment ) {

	$url       = esc_url( $comment->comment_author_url );
	$icon_args = array( 'url' => $url );
	$icon      = helsinki_get_external_favicon( $icon_args );
	$name      = esc_html( $comment->comment_author );

	printf(
		'<li><a href="%s">%s %s</a>',
		$url,
		$icon,
		$name
	);
}

/**
 * Get an img element for a favicon from Google.
 *
 * @link    http://wordpress.stackexchange.com/a/96596/23011
 *
 * @param   array $args array( 'url' => string, 'class' => string, 'size' => integer, 'alt' => string )
 * @return  string
 */
function helsinki_get_external_favicon( Array $args = array()  ) {

	$default_args = array(
		'url'   => '',
		'class' => 'icon',
		'size'  =>  '16',
		'alt'   => ''
	);

	$rtn = apply_filters( 'pre_helsinki_get_external_favicon', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'helsinki_get_external_favicon_args', $args );

	$output = '';

	if ( $args[ 'url' ] !== '' ) {
		$host     = parse_url( $args[ 'url' ],  PHP_URL_HOST );
		$icon_url = 'https://plus.google.com/_/favicon?domain=' . $host;

		$output   = sprintf(
			'<img class="%s" width="%d" height="%d" alt="%s" src="%s" />',
			$args[ 'class' ],
			esc_attr( $args[ 'size' ] ),
			esc_attr( $args[ 'size' ] ),
			esc_attr( $args[ 'alt' ] ),
			$icon_url
		);
	}

	return apply_filters( 'helsinki_get_external_favicon', $output, $args );
}
