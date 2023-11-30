<?php
wp_enqueue_script('header-script', get_stylesheet_directory_uri() . '/template-parts/header/header-script.js', array('jquery'), '1.0', true);
?>
<header class="kifu-header" id="kifu-header">

  <div class="kifu-header-inner">

    <div class="kifu-site-logo-and-texts">

      <?php if (has_custom_logo()) : ?><div class="kifu-site-logo">
          <?php the_custom_logo(); ?>
        </div><?php endif; ?>

      <div class="kifu-site-name-and-description">
        <!-- TODO: sometimes h1 is not appropriate for site name -->
        <h1 class="kifu-site-name">
          <?php echo esc_html(get_bloginfo('name')); ?>
        </h1>
        <p class="kifu-site-description">
          <?php echo esc_html(get_bloginfo('description')); ?>
        </p>
      </div>

    </div>

    <?php get_template_part('template-parts/header/site-nav'); ?>


  </div>


</header>