<?php

wp_enqueue_style('sidebar', get_stylesheet_directory_uri() . '/sidebar.css', false, '1.28', 'all');

function kifuSidebarRecentPosts(){
  
  rewind_posts();

  $nrPosts = 0;
  $nrMaxPosts = 4;

  global $kifuData;
  $kifuData->isInsideSidebar = true;

  $posts = query_posts("posts_per_page=$nrMaxPosts");
  // var_dump($test);
  
  while ( have_posts() && $nrPosts < $nrMaxPosts ) {
    the_post();
    get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ));
    $nrPosts++;
  }
  
  rewind_posts();
  $kifuData->isInsideSidebar = false;

}

?>


<aside id="kifu-sidebar" class="kifu-sidebar">
  
  <nav class="kifu-sidebar-inner" aria-label="Oldalsáv">

    <section class="kifu-sidebar-widget kifu-sidebar-thumbnails-widget">
      <p class="kifu-sidebar-widget-title">Újdonságok</p>
      <div class="kifu-sidebar-thumbnails"><?php kifuSidebarRecentPosts(); ?></div>
      <a class="kifu-read-more-link" href="<?php echo home_url(); ?>" class="kifu-sidebar-widget-link">Összes <span class="dashicons dashicons-arrow-right-alt"></a>
    </section>

    <section class="kifu-sidebar-widget kifu-sidebar-thumbnails-widget">
      
      <p class="kifu-sidebar-widget-title">Kategóriák</p>
      
      <ul class="kifu-sidebar-category-links">
        <?php 

          $someCategories = get_categories(array(
            "hide_empty" => 0,
            "type"      => "post",      
            "orderby"   => "name",
            "order"     => "ASC"
          ));

          foreach( $someCategories as $category ) {
            $category_link = sprintf( 
              '<li><a class="kifu-sidebar-category-link" href="%1$s" alt="%2$s">%3$s</a></li>',
              esc_url( get_category_link( $category->term_id ) ),
              esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
              esc_html( $category->name )
            );
            echo $category_link;
          }
        ?>
		  </ul>

    </section>

  </nav>

</aside>
