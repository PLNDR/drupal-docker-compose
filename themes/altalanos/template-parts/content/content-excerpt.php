<?php

/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */


global $kifuData;
$idPrefix = $kifuData->isInsideSidebar ? 'kifu-sidebar-' : '';

?>

<article id="post-<?php echo $idPrefix . get_the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part('template-parts/header/excerpt-header', get_post_format()); ?>

	<div class="kifu-thumbnail-texts-under-image">


		<?php

		global $kifuData;
		if ($kifuData->isEvent) {

			$eventTimestamp = kifu_get_event_timestamp();
			$day = date_i18n('d', $eventTimestamp);
			$month = date_i18n('M', $eventTimestamp);

			echo "
				<div class='kifu-event-thumbnail-date'>	
					<div class='kifu-event-thumbnail-date-day'>$day</div>
					<div class='kifu-event-thumbnail-date-month'>$month</div>
				</div>
			";
		}
		?>

		<!-- 
		<div class="entry-content">
			<?php get_template_part('template-parts/excerpt/excerpt', get_post_format()); ?>
		</div>
 -->

		<footer class="entry-footer default-max-width">
			<?php twenty_twenty_one_entry_meta_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>


</article><!-- #post-${ID} -->