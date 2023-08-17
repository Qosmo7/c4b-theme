<?php 
get_header();

echo do_shortcode( '[dishes_filter]' );

if ( have_posts() ) { ?>
    <div class="posts-wrap">
        <?php while ( have_posts() ) {
            the_post();
            ?>
            <div class="post">
                <h2><?php the_title(); ?></h2>

                <?php if( has_post_thumbnail() ) : ?>
                    <img src="<?= the_post_thumbnail_url() ?>" alt="post image">
                <?php endif; ?>

                <?php the_content(); ?>

                <?php $post_taxonomies = get_post_taxonomies(); ?>

                <?php $post_terms = get_the_terms( $post->ID, $post_taxonomies ); ?>
                <?php if( is_array( $post_terms ) ) : ?>
                    <?php foreach( $post_terms as $term ) : ?>
                        <?='<p>' . $term->taxonomy . ' : ' . $term->name . '</p>' ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php
        } ?>
    </div>
<?php } else {
	echo '<p>Empty :(</p>';
}

get_footer();