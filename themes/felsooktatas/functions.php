<?php

use PHPMailer\PHPMailer\PHPMailer;

/* enqueue scripts and style from parent theme */






function twentytwentyone_styles()
{
	wp_enqueue_style(
		'child-style',
		get_stylesheet_uri(),
		array('twenty-twenty-one-style'),
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'twentytwentyone_styles');







// function enqueue_child_theme_styles()
// {
// 	// wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
// 	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
// }
// add_action('wp_enqueue_scripts', 'enqueue_child_theme_styles', 11);


global $kifuData;
$kifuData = new \stdClass;
$kifuData->isInsideSidebar = false;
$kifuData->isEvent = false;




if (!function_exists('twenty_twenty_one_post_thumbnail')) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_post_thumbnail()
	{
		// if (!twenty_twenty_one_can_show_post_thumbnail()) {
		// 	return;
		// }
?>

		<?php if (is_singular()) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail('post-thumbnail', array('loading' => false));
				?>
				<?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail('post-thumbnail'); ?>
				</a>
				<?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php endif; ?>
	<?php
	}
}



if (!function_exists('twenty_twenty_one_posted_on')) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date())
		);
		echo '<span class="posted-on">';
		printf(
			/* translators: %s: Publish date. */
			esc_html__('%s', 'twentytwentyone'),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput
		);
		echo '</span>';
	}
}


if (!function_exists('twenty_twenty_one_posted_by')) {
	/**
	 * Prints HTML with meta information about theme author.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_posted_by()
	{

		if (post_type_supports(get_post_type(), 'author')) {
			echo '<span class="byline">';
			printf(
				/* translators: %s: Author name. */
				esc_html__('%s', 'twentytwentyone'),
				'<a class="kifu-post-author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author">' . esc_html(get_the_author()) . '</a>'
			);
			echo '</span>';
		}
	}
}


function kifu_get_event_timestamp()
{

	$acfDateFieldId = 'field_64f9354eceaea';
	$dateField = get_field($acfDateFieldId, false);

	try {
		$dateTime = new DateTime($dateField);
		return $dateTime->getTimeStamp();
	} catch (Exception $e) {
		return '';
	}
}

function kifu_event_hour()
{

	$eventTimestamp = kifu_get_event_timestamp();
	$timeOfDay = date_i18n('H:i', $eventTimestamp);

	echo "<div class='kifu-event-hour'>$timeOfDay</div>";
}

function kifu_event_location()
{
	$acfDateFieldId = 'field_64f960ba5b02a';
	$location = get_field($acfDateFieldId, false);

	echo "<div class='kifu-event-location'>$location</div>";
}


function kifuDateAndAuthor()
{

	global $kifuData;

	echo '<div class="kifu-date-and-author">';

	if ($kifuData->isEvent) {
		kifu_event_hour();
		kifu_event_location();
	} else {
		twenty_twenty_one_posted_on();

		if (!$kifuData->isInsideSidebar) {
			echo "<span class='separator-dot'> • </span>";
			twenty_twenty_one_posted_by();
		}
	}


	echo '</div>';
}




function kifu_category_list()
{

	$categories_list = get_the_category_list(', ');
	if ($categories_list) {
		printf(
			/* translators: %s: List of categories. */
			'<span class="cat-links">' . esc_html__('%s', 'twentytwentyone') . ' </span>',
			$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
		);
	}
}

function kifu_event_datetime()
{
	$timestamp = kifu_get_event_timestamp();

	$humanReadableDate = date_i18n('Y M d H:i', $timestamp);
	$machineReadableDate = date_i18n(DATE_W3C, $timestamp);


	$html = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$html = sprintf(
		$html,
		$machineReadableDate,
		$humanReadableDate,
	);

	echo $html;

	// var_dump(esc_attr(get_the_date(DATE_W3C)));
}

function kifu_post_detail_meta_info()
{

	global $kifuData;
	$separatorHtml = "<span class='separator-dot'> • </span>";


	echo '<div class="kifu-date-and-author">';

	if (get_post()->post_type === 'event') {
		kifu_event_datetime();
		echo $separatorHtml;

		kifu_event_location();
	} else {
		twenty_twenty_one_posted_on();
	}



	if (!$kifuData->isInsideSidebar) {
		echo $separatorHtml;
		twenty_twenty_one_posted_by();
	}

	$categories_list = get_the_category_list(', ');

	if ($categories_list) {
		echo $separatorHtml;
	}

	kifu_category_list();

	echo '</div>';
}


if (!function_exists('twenty_twenty_one_entry_meta_footer')) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * Footer entry meta is displayed differently in archives and single posts.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_entry_meta_footer()
	{

		global $kifuData;

		// Early exit if not a post.
		if ('post' !== get_post_type()) {
			// return;
		}

		// Hide meta information on pages.
		if (!is_single()) {

			if (is_sticky()) {
				echo '<p>' . esc_html_x('Featured post', 'Label for sticky posts', 'twentytwentyone') . '</p>';
			}


			if (has_category() || has_tag()) {

				echo '<div class="post-taxonomies">';

				kifu_category_list();

				$tags_list = get_the_tag_list('', wp_get_list_item_separator());
				if ($tags_list) {
					printf(
						/* translators: %s: List of tags. */
						'<span class="tags-links">' . esc_html__('%s', 'twentytwentyone') . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}

			the_title(sprintf('<h2 class="entry-title default-max-width kifu-post-thumbnail-title"><a href="%s">', esc_url(get_permalink())), '</a></h2>');


			$post_format = get_post_format();
			if ('aside' === $post_format || 'status' === $post_format) {
				echo '<p><a class="kifu-read-more-link" href="' . esc_url(get_permalink()) . '">' . twenty_twenty_one_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			kifuDateAndAuthor();

			if (!$kifuData->isInsideSidebar && !$kifuData->isEvent) {
				// read more link:
				echo '<p><a class="kifu-read-more-link" href="' . esc_url(get_permalink()) . '" aria-label="' . get_the_title() . '">Tovább <span class="dashicons dashicons-arrow-right-alt"></span></a></p>'; // 
			}

			// Edit post link.
			// edit_post_link(
			// 	sprintf(
			// 		/* translators: %s: Post title. Only visible to screen readers. */
			// 		esc_html__( 'Edit %s', 'twentytwentyone' ),
			// 		'<span class="screen-reader-text">' . get_the_title() . '</span>'
			// 	),
			// 	'<span class="edit-link">',
			// 	'</span><br>'
			// );

		} else {

			if (has_category() || has_tag()) {

				echo '<div class="post-taxonomies">';

				$tags_list = get_the_tag_list('', wp_get_list_item_separator());
				if ($tags_list) {

					printf(
						/* translators: %s: List of tags. */
						'<span class="tags-links"><span class="dashicons dashicons-tag"></span>' . esc_html__('%s', 'twentytwentyone') . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}
		}
	}
}



if (!function_exists('twenty_twenty_one_the_posts_navigation')) {
	/**
	 * Print the next and previous posts navigation.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_the_posts_navigation()
	{
		the_posts_pagination(
			array(
				'after_page_number' => esc_html__('. oldal', 'twentytwentyone') . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_right') : twenty_twenty_one_get_icon_svg('ui', 'arrow_left'),
					wp_kses(
						__('Újabb <span class="nav-short">bejegyzések</span>', 'twentytwentyone'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__('Korábbi <span class="nav-short">bejegyzések</span>', 'twentytwentyone'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_left') : twenty_twenty_one_get_icon_svg('ui', 'arrow_right')
				),
			)
		);
	}
}

// Render and create contact form shortcode
function render_contact_form()
{
	ob_start();

	// Display success message if form was submitted successfully
	if (isset($_GET['form_submitted']) && $_GET['form_submitted'] === 'true') {
		echo '<div id="submit-message" class="success-message" role="alert" aria-live="polite">';
		_e('Thank you for your message!', 'twentytwentyonechild');
		echo '</div>';
	}

	include(locate_template('template-parts/contact/contact-form-template.php'));

	return ob_get_clean();
}

add_shortcode('contact_form', 'render_contact_form');

// Create contact page upon theme activation
function create_contact_page()
{
	$existing_pages = get_posts(
		array(
			'post_type' => 'page',
			'post_status' => 'publish',
			's' => __('Contact', 'twentytwentyonechild'),
			'numberposts' => 1
		)
	);

	if (empty($existing_pages)) {
		// Create the post object
		$new_page = array(
			'post_title'    => __('Contact', 'twentytwentyonechild'),
			'post_content'  => '[contact_form]',
			'post_status'   => 'publish',
			'post_type'     => 'page'
		);

		// Insert the post into the database
		$post_id = wp_insert_post($new_page);

		if ($post_id) {
			update_post_meta($post_id, '_wp_page_template', 'page-full-width.php');
		}
	}
}
add_action('after_setup_theme', 'create_contact_page');

// Create accessibility statement page
function create_accessibility_page()
{
	$accessibility_page_title = 'Akadálymentesítési Nyilatkozat';
	$existing_pages = get_posts(array(
		'post_type' => 'page',
		'title' => $accessibility_page_title,
		'numberposts' => 1
	));

	if (empty($existing_pages)) {
		$content = '<div>
			<p><!-- Kitöltéshez lásd az „Útmutató az Akadálymentesítési nyilatkozat kitöltéséhez” című dokumentumot. --><br>
			<!-- A szögletes zárójellel, illetve … karakterrel jelölt szövegrészeket helyettesítse be. --></p>
			<h2>Akadálymentesítési nyilatkozat</h2>
			<p>[Közszférabeli szervezet neve] elkötelezett amellett, hogy honlapját a közszférabeli szervezetek honlapjainak és mobilalkalmazásainak akadálymentesítéséről szóló 2018. évi LXXV. törvény szerint akadálymentessé tegye.</p>
			<p>Ezen akadálymentesítési nyilatkozat a [honlap neve, amelyre a nyilatkozat vonatkozik]-ra/-re vonatkozik.</p>
			<h3>Megfelelőségi státusz</h3>
			<p>…</p>
			<h3>Nem akadálymentes tartalom</h3>
			<p>Az alábbiakban felsorolt tartalom a következő ok(ok) miatt nem akadálymentes:</p>
			<h4>A 2018. évi LXXV. törvénynek való meg nem felelés</h4>
			<p>…</p>
			<h4>Aránytalan teher</h4>
			<p>…</p>
			<h4>A tartalom nem tartozik az alkalmazandó jogszabályok hatálya alá</h4>
			<p>…</p>
			<h3>Az akadálymentesítési nyilatkozat elkészítése</h3>
			<p>E nyilatkozat [az első változat publikálásának dátuma]-án/-én készült.</p>
			<p>E nyilatkozat … alapján készült.</p>
			<p>A nyilatkozatot legutóbb [a legutóbbi felülvizsgálat dátuma]-án/én vizsgálták felül.</p>
			<h3>Visszajelzés és elérhetőségek …</h3>
			<p>Az akadálymentesítésért és a kérések feldolgozásért felelős: …</p>
			<h3>Végrehajtási eljárás</h3>
			<p>…</p>
			<p>Jelen akadálymentesítési nyilatkozatot jóváhagyta<br>
			[Név, beosztás]</p>
			</div>';

		$page_details = array(
			'post_title'    => $accessibility_page_title,
			'post_content'  => $content,
			'post_status'   => 'publish',
			'post_type'     => 'page'
		);

		$accessibility_page_id = wp_insert_post($page_details);
	}
}
add_action('after_setup_theme', 'create_accessibility_page');

// Append the accessibility statement page link to default footer widget
function append_accessibility_link_to_widget($index)
{
	if ('footer-1' === $index) {
		$args = array(
			'post_type' => 'page',
			'name' => 'akadalymentesitesi-nyilatkozat',
			'posts_per_page' => 1,
		);
		$query = new WP_Query($args);

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				echo '<div class="footer-link-block">';
				echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
				echo '</div>';
			}
			wp_reset_postdata();
		}
	}
}
add_action('dynamic_sidebar_before', 'append_accessibility_link_to_widget');




// Hook for adding admin menu
add_action('admin_menu', 'submitted_forms_menu');

// Action function for the above hook
function submitted_forms_menu()
{
	add_menu_page(__('Submitted Forms', 'twentytwentyonechild'), __('Submitted Forms', 'twentytwentyonechild'), 'manage_options', 'submitted_forms', 'render_submitted_forms_page', 'dashicons-email');
	global $contact_page_slug;
	$contact_page_slug = 'submitted_forms';
}

// Render Submitted Forms Page
function render_submitted_forms_page()
{
	global $contact_page_slug;
	global $wpdb;
	$table_name = $wpdb->prefix . 'contact_forms';

	wp_enqueue_script('submitted-forms', get_stylesheet_directory_uri() . '/assets/js/submitted-forms.js', array('jquery'), null, true);
	wp_enqueue_style('submitted-forms', get_stylesheet_directory_uri() . '/assets/css/submitted-forms.css');

	// Check if delete action is triggered
	if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_contact_form')) {
		$wpdb->delete($table_name, array('id' => $_GET['id']), array('%d'));
	}

	$per_page = 10; // Number of rows to display per page
	$current_page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
	$offset = ($current_page - 1) * $per_page;

	$total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
	$total_pages = ceil($total_rows / $per_page);

	$rows = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $per_page", ARRAY_A);
	?>
	<div class="wrap">
		<h1><?php echo __('Submitted Forms', 'twentytwentyonechild') ?></h1>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Message</th>
					<th>Submission Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rows as $row) : ?>
					<tr>
						<td><?php echo esc_html($row['id']); ?></td>
						<td><?php echo esc_html($row['name']); ?></td>
						<td><?php echo esc_html($row['email']); ?></td>
						<td>
							<div class="clipped-text message-container"><?php echo esc_html($row['message']); ?></div><button class="button toggle-button"><?php echo __('Show More', 'twentytwentyonechild') ?></button>
						</td>
						<td><?php echo esc_html($row['submission_date']); ?></td>
						<td>
							<a href="<?php echo wp_nonce_url(admin_url('admin.php?page=' . $contact_page_slug . '&action=delete&id=' . $row['id']), 'delete_contact_form'); ?>" class="delete-button"><?php echo __('Delete', 'twentytwentyonechild') ?></a>

						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="tablenav bottom">
			<div class="tablenav-pages">
				<span class="displaying-num"><?php printf(_n('%s item', '%s items', $total_rows, 'text-domain'), $total_rows); ?></span>
				<?php
				echo paginate_links(array(
					'base' => add_query_arg('paged', '%#%'),
					'format' => '',
					'prev_text' => __('&laquo;', 'text-domain'),
					'next_text' => __('&raquo;', 'text-domain'),
					'total' => $total_pages,
					'current' => $current_page,
				));
				?>
			</div>
		</div>
	</div>


<?php

	$translation_array = array(
		'show_more' => __('Show More', 'twentytwentyonechild'),
		'show_less' => __('Show Less', 'twentytwentyonechild'),
	);

	wp_localize_script('submitted-forms', 'localizedText', $translation_array);
}

// Load Hungarian translations
function twentytwentyonechild_theme_setup()
{
	load_child_theme_textdomain('twentytwentyonechild', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'twentytwentyonechild_theme_setup');
add_action('init', 'handle_contact_form_submission');

// Contact form submission processing
function handle_contact_form_submission()
{

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form_submit'])) {

		// Verify nonce for security
		if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'handle_contact_form_submission')) {
			return; // nonce didn't verify
		}

		// Get and sanitize form fields
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

		// Insert into database
		global $wpdb;
		$table_name = $wpdb->prefix . 'contact_forms';

		$wpdb->insert(
			$table_name,
			array(
				'name' => $name,
				'email' => $email,
				'message' => $message,
				'submission_date' => current_time('mysql'),
			)
		);

		// Prepare email content
		$email_subject = 'Contact Form Submission';
		$email_body = "Név: {$name}\nEmail: {$email}\nÜzenet:\n{$message}";
		$email_headers = ['Content-Type: text/plain', 'From: ' . $email];

		// Send the email using wp_mail function
		$to = get_option('admin_email');  // This will send the email to the website's admin email
		$is_sent = wp_mail($to, $email_subject, $email_body, $email_headers);

		wp_redirect(add_query_arg('form_submitted', 'true', get_the_permalink()));
		exit;
	}
}

// Create contact form table
function create_contact_form_table()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'contact_forms';
	$charset_collate = $wpdb->get_charset_collate();

	if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {

		$sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            email text NOT NULL,
            message text NOT NULL,
            submission_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}

add_action('after_setup_theme', 'create_contact_form_table');

add_action('acf/include_fields', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key' => 'group_64f9354e68e72',
		'title' => 'Esemény opciók',
		'fields' => array(
			array(
				'key' => 'field_64f9354eceaea',
				'label' => 'Dátum',
				'name' => 'datum',
				'aria-label' => '',
				'type' => 'date_time_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd/m/Y g:i a',
				'return_format' => 'Y-m-d H:i:s',
				'first_day' => 1,
			),
			array(
				'key' => 'field_64f960ba5b02a',
				'label' => 'Helyszín',
				'name' => 'helyszin',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'event',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
});

/**
 * Load dashicons for non-loggedin users
 */
function ww_load_dashicons()
{
	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'ww_load_dashicons');




function cptui_register_my_cpts_event()
{

	// Post Type: Események.

	$labels = [
		"name" => esc_html__("Események", "twentytwentyonechild"),
		"singular_name" => esc_html__("Esemény", "twentytwentyonechild"),
		"all_items" => esc_html__("Összes esemény", "twentytwentyonechild"),
	];

	$args = [
		"label" => esc_html__("Események", "twentytwentyonechild"),
		"labels" => $labels,
		"description" => "Tekintsd meg az eseményeket, válassz ki egyet vagy többet, és töltsd el minőségi időt a kedvenc programjaidon. Ne maradj le a legizgalmasabb eseményekről, és tartsd magad naprakészen ezen az esemény listán!",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => "esemenyek",
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => ["slug" => "event", "with_front" => true],
		"query_var" => true,
		"supports" => ["title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats"],
		"taxonomies" => ["category", "post_tag"],
		"show_in_graphql" => false,
	];

	register_post_type("event", $args);
}

add_action('init', 'cptui_register_my_cpts_event');




// The filter callback function.
function add_logo_alt_text($attrs)
{
	$attrs['alt'] = esc_html(get_bloginfo('name'));
	return $attrs;
}
add_filter('get_custom_logo_image_attributes', 'add_logo_alt_text', 10, 3);

function kifuSubMenuToggler($output, $item, $depth, $args)
{

	if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {

		if ($item->object == 'page') {
			$page = get_post($item->object_id);
			$label = $page->post_title;
		} elseif ($item->object == 'post') {
			$label = $item->post_title;
		} elseif ($item->object == 'custom') {
			$label = $item->title; // for custom links
		} elseif ($item->object == 'category') {
			$cat = get_category($item->object_id);
			$label = $cat->name;
		} else {
			// Handle other cases or set a default
			$label = $item->title;
		}

		$screenReaderText = esc_html__('Menü megnyitása', 'twentytwentyone') . ': ' . $label;


		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="twentytwentyoneExpandSubMenu(this)">';
		$output .= '<span class="icon-plus">' . twenty_twenty_one_get_icon_svg('ui', 'plus', 18) . '</span>';
		$output .= '<span class="icon-minus">' . twenty_twenty_one_get_icon_svg('ui', 'minus', 18) . '</span>';
		/* translators: Hidden accessibility text. */
		$output .= '<span class="screen-reader-text">' .  $screenReaderText . '</span>';
		$output .= '</button>';
	}
	return $output;
}


function removeLateFilters()
{
	remove_filter('walker_nav_menu_start_el', 'twenty_twenty_one_add_sub_menu_toggle', 10);
}
add_action('wp', 'removeLateFilters');


add_filter('walker_nav_menu_start_el', 'kifuSubMenuToggler', 10, 4);
