<?php
// add script to contact template and translations
wp_enqueue_script('contact-form-script', get_stylesheet_directory_uri() . '/template-parts/contact/contact-form-script.js', array('jquery'), '1.0', true);

$translation_array = array(
	'enter_name' => __('Please enter your name.', 'twentytwentyonechild'),
	'enter_email' => __('Please enter a valid email.', 'twentytwentyonechild'),
	'enter_message' => __('Please enter a message.', 'twentytwentyonechild')
);

wp_localize_script('contact-form-script', 'localizedText', $translation_array);
?>

<form action="" method="post" id="contact_form" novalidate>
	<?php wp_nonce_field('handle_contact_form_submission', 'contact_form_nonce'); ?>

	<label for="<?php _e('Name', 'twentytwentyonechild'); ?>"><?php _e('Name', 'twentytwentyonechild'); ?></label>
	<input id="<?php _e('Name', 'twentytwentyonechild'); ?>" required type="text" name="name" aria-label="<?php _e('Name', 'twentytwentyonechild'); ?>">

	<label for="<?php _e('Email', 'twentytwentyonechild'); ?>"><?php _e('Email', 'twentytwentyonechild'); ?></label>
	<input id="<?php _e('Email', 'twentytwentyonechild'); ?>" required type="email" name="email" aria-label="<?php _e('Email', 'twentytwentyonechild'); ?>">

	<label for="<?php _e('Message', 'twentytwentyonechild'); ?>"><?php _e('Message', 'twentytwentyonechild'); ?></label>
	<textarea id="<?php _e('Message', 'twentytwentyonechild'); ?>" required name="message" aria-label="<?php _e('Message', 'twentytwentyonechild'); ?>"></textarea>

	<input type="submit" value="<?php _e('Submit', 'twentytwentyonechild'); ?>">
	<input type="hidden" name="contact_form_submit" value="1">
</form>