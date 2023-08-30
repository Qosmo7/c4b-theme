<?php

add_filter( 'term_description', 'shortcode_unautop' );
add_filter( 'term_description', 'do_shortcode' );
remove_filter( 'pre_term_description', 'wp_filter_kses' );

add_action( 'after_setup_theme', function(){
	add_theme_support( 'post-thumbnails' );
} );

function c4b_scripts() {
	wp_enqueue_style( 'c4b-style', get_stylesheet_uri() );
	wp_enqueue_script( 'c4b-script', get_template_directory_uri() . '/js/c4b-script.js' );

	wp_localize_script( 'c4b-script', 'c4b_localize_data',
		array(
			'url'        => admin_url( 'admin-ajax.php' ),
			'query_vars' => wp_json_encode( $GLOBALS['wp_query']->query_vars )
		)
	);
}

add_action( 'wp_enqueue_scripts', 'c4b_scripts' );

function c4b_register_taxonomies(){
	register_taxonomy( 'type', array( 'dishes' ), array(
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

	register_taxonomy( 'difficulty', array( 'dishes' ), array(
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

	register_taxonomy( 'alcohol', array( 'cocktails' ), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => 'Alcohol',
			'singular_name'     => 'alcohol',
			'search_items'      => 'Search alcohol',
			'all_items'         => 'All alcohol',
			'parent_item'       => 'Parent alcohol',
			'parent_item_colon' => 'Parent alcohol:',
			'edit_item'         => 'Edit alcohol',
			'update_item'       => 'Update alcohol',
			'add_new_item'      => 'Add new alcohol',
			'new_item_name'     => 'Add new alcohol name',
			'menu_name'         => 'Alcohol',
		),
		'rewrite'       => array( 'slug' => 'cocktailss' ),
		'has_archive'   => true,
		'show_ui'       => true,
		'query_var'     => true,
	) );

	register_taxonomy( 'country', array( 'cocktails' ), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => 'Country',
			'singular_name'     => 'country',
			'search_items'      => 'Search country',
			'all_items'         => 'All Country',
			'parent_item'       => 'Parent country',
			'parent_item_colon' => 'Parent country:',
			'edit_item'         => 'Edit country',
			'update_item'       => 'Update country',
			'add_new_item'      => 'Add new country',
			'new_item_name'     => 'Add new country name',
			'menu_name'         => 'Country',
		),
		'rewrite'       => false,
		'has_archive'   => true,
		'show_ui'       => true,
		'query_var'     => true,
	) );
}

add_action( 'init', 'c4b_register_taxonomies' );

function c4b_register_post_types(){
	register_post_type( 'dishes', array(
		'label'  => 'Dishes',
		'labels' => array(
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
		),
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => null,
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'          => array(),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	) );

	register_post_type( 'cocktails', array(
		'label'  => 'Cocktails',
		'labels' => array(
			'name'               => 'Cocktails',
			'singular_name'      => 'Cocktail',
			'add_new'            => 'Add cocktail',
			'add_new_item'       => 'Adding a cocktail',
			'edit_item'          => 'Edit a cocktail',
			'new_item'           => 'New cocktail',
			'view_item'          => 'View cocktail',
			'search_items'       => 'Search cocktail',
			'not_found'          => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'parent_item_colon'  => '',
			'menu_name'          => 'Cocktails',
		),
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => null,
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'          => array(),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	) );
}

add_action( 'init', 'c4b_register_post_types' );

function c4b_taxonomies_filter_shortcode( $atts ){
	$atts = shortcode_atts(
		array(
			'post_type'       => 'post',
			'taxonomy'        => '',
			'selector'        => '',
			'number_of_posts' => '',
		),
		$atts
	);

	if( empty( $atts['taxonomy'] ) || ! taxonomy_exists( $atts['taxonomy'] ) ){
		return 'Taxonomy is incorrect';
	} else {
		$taxonomy = $atts['taxonomy'];

		$taxonomy_terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);
	}

	ob_start();

	?> 
	<div class="filter">
		<div class="filter__col">
			<form class="form filtering-form" method="get" <?php if( ! empty( $atts['selector'] ) ){ echo 'data-selector="' . htmlspecialchars( $atts['selector'] ) . '"'; } ?>>
				<fieldset class="filtering-form__fieldset">
					<b><?=$taxonomy ?></b> :
					<?php foreach( $taxonomy_terms as $term ) : ?>
						<?php if( ! empty( $_GET[$taxonomy] ) ) :
							foreach( $_GET[$taxonomy] as $item ) :
								$is_active = str_contains( $item, $term->slug ) ? true : false;
								if( $is_active ){
									break;
								}
							endforeach;
						endif; ?>
						<label class="filtering-form__label">
							<input type="checkbox" name="<?=$taxonomy ?>[]" class="filtering-form__checkbox" value="<?=$term->slug ?>" <?php ! empty( $_GET[$taxonomy] ) ? checked( $is_active ) : null ?>>
							<?=$term->name ?>
						</label>
					<?php endforeach; ?>

					<input type="hidden" name="tax_name" value="<?=$taxonomy ?>">
					<?php if( ! empty( $atts['number_of_posts'] ) ) : ?>
						<input type="hidden" name="number_of_posts" value="<?=$atts['number_of_posts'] ?>">
					<?php endif; ?>
				</fieldset>
				<button type="submit">Go</button>
			</form>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'taxonomies_filter', 'c4b_taxonomies_filter_shortcode' );

function c4b_taxonomies_links_shortcode( $atts ){
	$atts = shortcode_atts(
		array(
			'post_type' => 'post',
			'taxonomy'  => '',
		),
		$atts
	);

	if( empty( $atts['taxonomy'] ) || ! taxonomy_exists( $atts['taxonomy'] ) ){
		return 'Taxonomy is incorrect';
	} else {
		$taxonomy = $atts['taxonomy'];

		$taxonomies_terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);
	}

	ob_start();

	?>
	<div class="taxonomies-links__wrap">
		<?=$taxonomy . ':' ?>
		<?php foreach( $taxonomies_terms as $term ) : ?>
			<a href="<?=get_term_link( $term->slug, $term->taxonomy ) ?>" class="taxonomies-links__item"><?=$term->name ?></a>
		<?php endforeach; ?>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'taxonomies_links', 'c4b_taxonomies_links_shortcode' );

function c4b_filtering_callback(){
	$query_vars = json_decode( stripcslashes( $_POST['query_vars'] ), true );

	if( ! empty( $_POST[$_POST['tax_name']] ) ){
		$query_vars['tax_query'] = array(
			array(
				'taxonomy' => $_POST['tax_name'],
				'field'    => 'slug',
				'terms'    => $_POST[$_POST['tax_name']]
			)
		);
	}

	if( ! empty( $_POST['number_of_posts'] ) ){
		$query_vars['posts_per_page'] = $_POST['number_of_posts'];
	}

	$query = new WP_Query( $query_vars );

	if( $query->have_posts() ){
		while( $query->have_posts() ){
			$query->the_post();
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
		}
	}

	wp_die();
}

add_action( 'wp_ajax_c4b_filtering', 'c4b_filtering_callback' );
add_action( 'wp_ajax_nopriv_c4b_filtering', 'c4b_filtering_callback' );

function loadmore_callback(){
	$query_vars = json_decode( stripcslashes( $_POST['query_vars'] ), true );

	$paged = ! empty( $_POST['paged'] ) ? $_POST['paged'] : 1;
	$paged++;

	$query_vars['paged'] = $paged;

	$query = new WP_Query( $query_vars );

	if( $query->have_posts() ){
		while( $query->have_posts() ){
			$query->the_post();
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
		}
	}

	wp_die();
}

add_action( 'wp_ajax_loadmore', 'loadmore_callback' );
add_action( 'wp_ajax_nopriv_loadmore', 'loadmore_callback' );

function c4b_load_more_shortcode( $atts ){
	$atts = shortcode_atts(
		array(
			'load_type' => 'button',
		),
		$atts
	);

	switch ( $atts['load_type'] ){
		case 'scroll' :
			$load_type = 'scroll';
			break;
		case 'button' :
			$load_type = 'button';
			break;
		default :
			$load_type = 'button';
	}

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$max_pages = $GLOBALS['wp_query']->max_num_pages;

	ob_start();
	?>

    <div class="loadmore" id="loadmore" data-max_pages="<?=$max_pages ?>" data-paged="<?=$paged ?>" data-load_type="<?=$load_type ?>">
        <?php if( $load_type == 'button' && $paged < $max_pages ) : ?>
            <div>
                <a href="#" class="btn">Load more</a>
            </div>
        <?php endif; ?>
    </div>

	<?php
	return ob_get_clean();
}

add_shortcode( 'load_more', 'c4b_load_more_shortcode' );

// http://cooking4beginners/dishes/?difficulty%5B%5D=simple