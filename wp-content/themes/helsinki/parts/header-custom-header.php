<?php
/**
 * Custom Header Stuff
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */

if ( ! is_front_page() && ! is_home() )
	return;

// load the header, but keep the things clean
$custom_header = get_custom_header();
if ( empty( $custom_header->url ) )
	return;
?>

<header id="header">
	<div class="wrapper">
		<?php if ( display_header_text() ) : ?>
			<div class="header-text-container">
				<h1><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<div id="description"><?php bloginfo( 'description' ); ?></div>
			</div>
		<?php endif; ?>
	</div>
</header>
