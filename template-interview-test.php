<?php 
/*
    Template Name: Interview Test
*/
get_header(); ?>
    <main>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div class="hero">
            <div class="wrapper clearfix">
                <div class="entry-content">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>

        <div class="wrapper main-wrapper clearfix">
            <?php the_content(); ?>
        </div>

        <?php endwhile; endif; ?>
    </main>

<?php get_footer(); ?>
