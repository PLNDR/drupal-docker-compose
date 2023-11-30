<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); 
remove_filter( 'excerpt_more', 'twenty_twenty_one_continue_reading_link_excerpt' );

$description = get_the_archive_description();
$defaultDescription = 'A legfrissebb hírek a globális eseményektől a helyi fejleményekig számos témát érintenek. A politikától és a tudománytól a szórakoztatásig és a sportig a hírek alapvető információkkal szolgálnak a minket körülvevő világról.';

if(!$description && is_home()) {
	$description = $defaultDescription;
}

?>

<div class="kifu-page-title-and-description">
	<header class="page-header alignwide">
		<h1 class="page-title">
			<?php 
				echo empty(single_post_title()) ? 'Hírek' : single_post_title();
			?>
		</h1>
	</header><!-- .page-header -->
		
	<?php if ( $description ) : ?>
		<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
	<?php endif; ?>
</div>


<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {

		the_post();

		get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
	}

	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

}

get_footer();
