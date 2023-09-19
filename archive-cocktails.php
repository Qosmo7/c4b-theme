<?php 
get_header();

echo do_shortcode( '[taxonomies_links post_type="cocktails" taxonomy="alcohol"]' );
echo do_shortcode( '[taxonomies_filter post_type="cocktails" taxonomy="country"]' );

if ( have_posts() ) { ?> 
    <div class="posts-wrap" id="posts">
        <?php while ( have_posts() ) {
            the_post();
            ?>
            <div class="post">
                <h2>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <?php if( has_post_thumbnail() ) : ?>
                    <img src="<?php echo the_post_thumbnail_url(); ?>" alt="post image">
                <?php endif; ?>

                <?php the_content(); ?>

                <?php echo get_post_rating() ? 'Rating : ' . get_post_rating() : null; ?>

                <?php $post_taxonomies = get_post_taxonomies(); ?>

                <?php $post_terms = get_the_terms( $post->ID, $post_taxonomies ); ?>
                <?php if( is_array( $post_terms ) ) : ?>
                    <?php foreach( $post_terms as $term ) : ?>
                        <p><?php echo $term->taxonomy . ' : ' . $term->name; ?></p>
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