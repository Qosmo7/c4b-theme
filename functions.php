<?php

add_action( 'wp_enqueue_scripts', 'c4b_scripts' );

function c4b_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_script( 'c4b-script', get_template_directory_uri() . '/js/c4b-script.js');
}

add_action( 'wp_enqueue_scripts', 'c4b_ajax_data', 99 );

function c4b_ajax_data(){
  wp_localize_script( 'c4b-script', 'c4b_ajax',
    array(
      'url' => admin_url('admin-ajax.php')
    )
  );
}

add_action( 'init', 'c4b_register_taxonomies' );

function c4b_register_taxonomies(){
  register_taxonomy( 'type', array('dishes'), array(
    'hierarchical'  => true,
    'labels'        => array(
      'name'              => 'Types',
      'singular_name'     => 'type',
      'search_items'      => 'Search type',
      'all_items'         => 'All Types',
      'parent_item'       => 'Parent type',
      'parent_item_colon' => 'Parent type:',
      'edit_item'         => 'Edit type',
      'update_item'       => 'Update type',
      'add_new_item'      => 'Add new type',
      'new_item_name'     => 'Add new type name',
      'menu_name'         => 'Types',
    ),
    'rewrite'       => array( 'slug' => 'dishess' ),
        'has_archive'   => true,
    'show_ui'       => true,
    'query_var'     => true,
  ) );

  register_taxonomy( 'difficulty', array('dishes'), array(
    'hierarchical'  => true,
    'labels'        => array(
      'name'              => 'Difficulty',
      'singular_name'     => 'difficulty',
      'search_items'      => 'Search difficulty',
      'all_items'         => 'All Difficulty',
      'parent_item'       => 'Parent difficulty',
      'parent_item_colon' => 'Parent difficulty:',
      'edit_item'         => 'Edit difficulty',
      'update_item'       => 'Update difficulty',
      'add_new_item'      => 'Add new difficulty',
      'new_item_name'     => 'Add new difficulty name',
      'menu_name'         => 'Difficulty',
    ),
    'rewrite'       => false,
        'has_archive'   => true,
    'show_ui'       => true,
    'query_var'     => true,
  ) );
}

add_action( 'init', 'c4b_register_post_types' );

function c4b_register_post_types(){

  register_post_type( 'dishes', [
    'label'  => 'Dishes',
    'labels' => [
      'name'               => 'Dishes',
      'singular_name'      => 'Dish',
      'add_new'            => 'Add dish',
      'add_new_item'       => 'Adding a dish',
      'edit_item'          => 'Edit a dish',
      'new_item'           => 'New dish',
      'view_item'          => 'View dish',
      'search_items'       => 'Search dish',
      'not_found'          => 'Не найдено',
      'not_found_in_trash' => 'Не найдено в корзине',
      'parent_item_colon'  => '',
      'menu_name'          => 'Dishes',
    ],
    'description'            => '',
    'public'                 => true,
    'show_in_menu'           => true,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => null,
    'menu_icon'           => null,
    'hierarchical'        => false,
    'supports'            => [ 'title', 'editor', 'thumbnail' ],
    'taxonomies'          => [],
    'has_archive'         => true,
    'rewrite'             => true,
    'query_var'           => true,
  ] );

}

add_shortcode( 'dishes_filter', 'c4b_dishes_filter_shortcode' );

function c4b_dishes_filter_shortcode( $atts ){
    $dishes_types = get_terms( [
        'taxonomy' => 'type',
        'hide_empty' => false,
    ] );

    $dishes_difficulty = get_terms( [
        'taxonomy' => 'difficulty',
        'hide_empty' => false,
    ] );

    ob_start();

    ?> 
    <div class="filter">
        <div class="filter__col">
            <div class="types__wrap">
                Types :
                <?php foreach( $dishes_types as $item ) : ?>
                    <a href="<?=get_term_link( $item->slug, $item->taxonomy ) ?>" class="types__item"><?=$item->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="filter__col">
            <form class="difficulty-form" method="get">
                <fieldset class="difficulty-form__fieldset">
                    Difficulty :
                    <?php foreach( $dishes_difficulty as $item ) : ?>
                        <label class="difficulty-form__label">
                            <input type="checkbox" name="difficulty[]" class="difficulty-form__checkbox" value="<?=$item->slug ?>" <?php isset( $_GET['difficulty'] ) ? checked( in_array( $item->slug, $_GET['difficulty'] ) ) : null ?>>
                            <?=$item->name ?>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
                <button type="submit">Go</button>
            </form>
        </div>
    </div>
    <?php

	return ob_get_clean();
}

add_action( 'wp_ajax_c4b_filtering', 'c4b_filtering_callback' );
add_action( 'wp_ajax_nopriv_c4b_filtering', 'c4b_filtering_callback' );

function c4b_filtering_callback(){
  $args = array(
    'post_type'      => 'dishes',
    'posts_per_page' => -1,
  );

  if( isset( $_POST['difficulty'] ) ){
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'difficulty',
        'field'    => 'slug',
        'terms'    => $_POST['difficulty']
      )
    );
  }

  $query = new WP_Query( $args );

  if( $query->have_posts() ){
    while( $query->have_posts() ){
      $query->the_post();
      ?>
      <div class="post">
        <h2>
            <a href="<?=get_permalink( $post->ID ) ?>"><?php the_title(); ?></a>
        </h2>

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
    }
  }

  wp_die();
}

?>