<?php 
get_header();

echo do_shortcode( '[taxonomies_links post_type="dishes" taxonomy="type"]' );
echo do_shortcode( '[taxonomies_filter post_type="dishes" taxonomy="difficulty" selector=".posts-wrap"]' );

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
                    <img src="<?= the_post_thumbnail_url() ?>" alt="post image">
                <?php endif; ?>

                <?php the_content(); ?>

                <?php $post_taxonomies = get_post_taxonomies(); ?>

                <?php $post_terms = get_the_terms( $post->ID, $post_taxonomies ); ?>
                <?php if( is_array( $post_terms ) ) : ?>
                    <?php foreach( $post_terms as $term ) : ?>
                        <p><?=$term->taxonomy . ' : ' . $term->name ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php
        } ?>
    </div>

    <?php echo do_shortcode( '[load_more load_type="scroll"]' ); ?>

<?php } else {
	echo '<p>Empty :(</p>';
}

get_footer();