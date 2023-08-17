<?php 
get_header();

$taxonomy_name = get_queried_object()->taxonomy;
$term_name = get_queried_object()->name;

global $post;

$args = [
	'posts_per_page' => -1,
    'post_type'      => 'dishes',
    'tax_query'      => array(
        array(
            'taxonomy' => $taxonomy_name,
            'field'    => 'slug',
			'terms'    => $term_name
        ),
    ),
];

if( isset( $_GET['difficulty'] ) ){
    $relation = array( 'relation' => 'AND' );
    $difficulty = array(
        'taxonomy' => 'difficulty',
        'field'    => 'slug',
        'terms'    => $_GET['difficulty']
    );

    array_push( $args['tax_query'], $relation );
    array_push( $args['tax_query'], $difficulty );
}

$query = new WP_Query( $args );

echo do_shortcode( '[dishes_filter]' );

if ( $query->have_posts() ) { ?>
    <div class="posts-wrap">
        <?php while ( $query->have_posts() ) {
            $query->the_post();
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

wp_reset_postdata();

get_footer(); ?>