<?php

function my_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'my_scripts' );

add_action( 'init', 'create_dishes_type_taxonomies' );

function create_dishes_type_taxonomies(){
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
    'rewrite'       => array( 'slug' => 'dishess' ), //array( 'slug' => 'dishes' ) type
        'has_archive'   => true,
    'show_ui'       => true,
    'query_var'     => true,
  ) );
}

add_action( 'init', 'create_dishes_difficulty_taxonomies' );

function create_dishes_difficulty_taxonomies(){
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
    'rewrite'       => false, //array( 'slug' => 'dishes' ) difficulty
        'has_archive'   => true,
    'show_ui'       => true,
    'query_var'     => true,
  ) );
}

add_action( 'init', 'register_post_types' );

function register_post_types(){

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
    'supports'            => [ 'title', 'editor', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'taxonomies'          => [],
    'has_archive'         => true,
    'rewrite'             => true,
    'query_var'           => true,
  ] );

}

add_shortcode( 'dishes_filter', 'dishes_filter_shortcode' );

function dishes_filter_shortcode( $atts ){
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
                            <input type="checkbox" name="difficulty[]" class="difficulty-form__checkbox" value="<?=$item->slug ?>" <?php checkbox_checked( $item->slug ); ?>>
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

function checkbox_checked( $slug ){
  if( isset( $_GET['difficulty'] ) ){
    if( in_array( $slug, $_GET['difficulty'] ) ){
      echo 'checked';
    }
  }
}

?>