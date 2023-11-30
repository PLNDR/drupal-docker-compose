<?php
/* Template Name: Full Width Page */
?>
<?php get_header(); ?>

<style type="text/css">
    /* Add your custom styles here to make the page full-width. */
    .full-width-container {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .kifu-sidebar {
        display: none;
    }

    #primary {
        display: flex !important;
    }

    h1 {
        text-align: center;
    }
</style>

<div class="full-width-container">

    <?php
    // Start the loop
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

            </article>

    <?php
        endwhile;
    endif;
    ?>

</div>

<?php get_footer(); ?>