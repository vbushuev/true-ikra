<?php
/**
 * The template part used for displaying the Latest News in static Home page
 *
 * @package WordPress
 * @subpackage Pizzaland
 * @since Pizzaland 1.0
 */

//Get number of latest posts to display on the front page from the Customizer option
$pizzaland_num_posts = get_theme_mod( 'pizzaland_frontpage_numberofposts', 3 );

if( $pizzaland_num_posts == 2 ):

?>

<section class="latest-homepage-posts medium-thumbs">
    <?php the_post_thumbnail( 'medium' ); ?>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php the_excerpt(); ?>
</section>


<?php else: ?>


<section class="latest-homepage-posts">
    <?php the_post_thumbnail( 'thumb' ); ?>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php the_excerpt(); ?>
</section>


<?php endif; ?>