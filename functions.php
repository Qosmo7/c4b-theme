<?php

add_filter( 'term_description', 'shortcode_unautop' );
add_filter( 'term_description', 'do_shortcode' );
remove_filter( 'pre_term_description', 'wp_filter_kses' );

add_action( 'after_setup_theme', function(){
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
} );

/**
 * Added main scripts and localize additional data
 */
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

/**
 * Register taxonomies for custom post type
 */
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

	register_taxonomy( 'ingredients', array( 'dishes' ), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => 'Ingredients',
			'singular_name'     => 'ingredients',
			'search_items'      => 'Search ingredients',
			'all_items'         => 'All ingredients',
			'parent_item'       => 'Parent ingredients',
			'parent_item_colon' => 'Parent ingredients:',
			'edit_item'         => 'Edit ingredients',
			'update_item'       => 'Update ingredients',
			'add_new_item'      => 'Add new ingredients',
			'new_item_name'     => 'Add new ingredients name',
			'menu_name'         => 'Ingredients',
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

/**
 * Register custom post type
 */
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

/**
 * Register filter shortcode
 * @param array<string> $atts Shortcode params
 * @return string
 */
function c4b_taxonomies_filter_shortcode( $atts ){
	$atts = shortcode_atts(
		array(
			'post_type'         => 'post',
			'taxonomies'        => '',
			'meta_fields'       => '',
			'wrapper'           => '',
			'number_of_posts'   => '',
			'loadmore_selector' => '',
		),
		$atts
	);

	if( empty( $atts['taxonomies'] ) ){
		return 'Taxonomies attribute is empty.';
	}

	$taxonomies = explode( ',', $atts['taxonomies'] );
	$meta_fields = explode( ',', $atts['meta_fields'] );

	foreach( $taxonomies as $taxonomy ){
		if( ! taxonomy_exists( $taxonomy ) ){
			return 'Taxonomy is incorrect.';
		}
	}

	$all_terms = array();
	foreach( $taxonomies as $taxonomy ){
		$all_terms[$taxonomy] = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);
	}

	foreach( $meta_fields as $field ){
		$meta_values[$field] = get_unique_meta_values( $field );
	}

	$config = array();
	foreach( $atts as $key => $value ){
		$config[$key] = $key == 'wrapper' ? htmlspecialchars( $value ) : $value;
	}

	$config['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$config['max_pages'] = $GLOBALS['wp_query']->max_num_pages;

	ob_start();

	?> 
	<div class="filter" data-config='<?php echo json_encode( $config ); ?>'>
		<div class="filter__col">
			<form class="form filtering-form" method="get">
				<fieldset class="filtering-form__fieldset">
					<?php foreach( $all_terms as $taxonomy => $terms ) : ?>
						<div class="filtering-form__taxonomy">
							<b><?php echo ucfirst( $taxonomy ); ?></b> :
							<?php foreach( $terms as $term ) : ?>
								<?php if( ! empty( $_GET[$taxonomy] ) ) :
									foreach( $_GET[$taxonomy] as $item ) :
										$is_active = str_contains( $item, $term->slug );
										if( $is_active ){
											break;
										}
									endforeach;
								endif; ?>
								<label class="filtering-form__label">
									<input type="checkbox" name="<?php echo $taxonomy; ?>[]" class="filtering-form__checkbox" value="<?php echo $term->slug; ?>" <?php ! empty( $_GET[$taxonomy] ) ? checked( $is_active ) : null ?>>
									<?php echo $term->name; ?>
								</label>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
					<?php foreach( $meta_values as $key => $values ) : ?>
						<div class="filtering-form__meta">
							<b><?php echo ucfirst( $key ); ?></b> :
							<?php foreach( $values as $value ) : ?>
								<label class="filtering-form__label">
									<input type="checkbox" name="<?php echo $key; ?>[]" class="filtering-form__checkbox" value="<?php echo $value; ?>">
									<?php echo $value; ?>
								</label>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</fieldset>
				<button type="submit">Go</button>
			</form>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'taxonomies_filter', 'c4b_taxonomies_filter_shortcode' );

/**
 * Register taxonomies links shortcode
 * @param array<string> $atts Shortcode params
 * @return string
 */
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
		<?php echo $taxonomy . ':'; ?>
		<?php foreach( $taxonomies_terms as $term ) : ?>
			<a href="<?php echo get_term_link( $term->slug, $term->taxonomy ); ?>" class="taxonomies-links__item"><?php echo $term->name; ?></a>
		<?php endforeach; ?>
	</div>
	<?php

	return ob_get_clean();
}

add_shortcode( 'taxonomies_links', 'c4b_taxonomies_links_shortcode' );

/**
 * Ajax filtering callback
 */
function c4b_filtering_callback(){
	$query_vars = json_decode( stripcslashes( $_POST['query_vars'] ), true );
	$config = json_decode( stripslashes( $_POST['config'] ), true );

	$taxonomies = array();
	foreach( explode( ',', $config['taxonomies'] ) as $taxonomy ){
		if( $_POST[$taxonomy] ){
			$taxonomies[$taxonomy] = $_POST[$taxonomy];
		}
	}

	if( $taxonomies ){
		$query_vars['tax_query'] = array();

		foreach( $taxonomies as $taxonomy => $terms ){
			array_push(
				$query_vars['tax_query'],
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms
				)
			);
		}
		if( count( $taxonomies ) > 1 ){
			array_push(
				$query_vars['tax_query'],
				array(
					'relation'   => 'AND'
				)
			);
		}
	}

	if( ! empty( $config['number_of_posts'] ) ){
		$query_vars['posts_per_page'] = $config['number_of_posts'];
	}

	$query = new WP_Query( $query_vars );

	ob_start();

	if( $query->have_posts() ){
		while( $query->have_posts() ){
			$query->the_post();
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
		}
	}

	$data = array(
		'html'       => ob_get_clean(),
		'query_vars' => wp_json_encode( $query->query_vars ),
		'paged'      => $query->query_vars['paged'] ? $query->query_vars['paged'] : 1,
		'max_pages'  => $query->max_num_pages
	);

	wp_send_json( $data );
}

add_action( 'wp_ajax_c4b_filtering', 'c4b_filtering_callback' );
add_action( 'wp_ajax_nopriv_c4b_filtering', 'c4b_filtering_callback' );

/**
 * Ajax loadmore callback
 */
function c4b_loadmore_callback(){
	$query_vars = json_decode( stripcslashes( $_POST['query_vars'] ), true );

	$paged = ! empty( $_POST['paged'] ) ? $_POST['paged'] : 1;
	$paged++;

	$query_vars['paged'] = $paged;

	$query = new WP_Query( $query_vars );

	ob_start();

	if( $query->have_posts() ){
		while( $query->have_posts() ){
			$query->the_post();
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
		}
	}

	$data = array(
		'html'       => ob_get_clean(),
		'query_vars' => wp_json_encode( $query->query_vars ),
		'paged'      => $query->query_vars['paged'] ? $query->query_vars['paged'] : 1,
		'max_pages'  => $query->max_num_pages
	);

	wp_send_json( $data );
}

add_action( 'wp_ajax_loadmore', 'c4b_loadmore_callback' );
add_action( 'wp_ajax_nopriv_loadmore', 'c4b_loadmore_callback' );

/**
 * Added custom metabox
 */
function c4b_add_metabox() {
	add_meta_box(
		'rating_metabox',
		'Rating',
		'c4b_metabox_callback',
		'dishes',
		'normal',
		'default'
	);
}

add_action( 'add_meta_boxes', 'c4b_add_metabox' );

/**
 * Callback for custom metabox
 * @param object $post Post
 */
function c4b_metabox_callback( $post ) {
	$rating = get_post_meta( $post->ID, 'rating', true );

	echo '<div>
		<label>Rating <input type="text" id="rating" name="rating" value="' . esc_attr( $rating ) . '" class="rating"></label>
	</div>';
}

/**
 * Save data in custom metabox
 * @param int $post_id Post id
 * @param object $post Post
 * @return int
 */
function c4b_save_meta( $post_id, $post ) {
	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}
 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
 
	if( 'dishes' !== $post->post_type ) {
		return $post_id;
	}
 
	if( isset( $_POST['rating'] ) ) {
		update_post_meta( $post_id, 'rating', sanitize_text_field( $_POST['rating'] ) );
	} else {
		delete_post_meta( $post_id, 'rating' );
	}
 
	return $post_id;
}

add_action( 'save_post', 'c4b_save_meta', 10, 2 );

/**
 * Get post rating value
 * @return string
 */
function get_post_rating(){
	return get_post_meta( get_the_ID(), 'rating', true );
}

/**
 * Get all unique meta values by key
 * @param string $key Meta key
 * @return array
 */
function get_unique_meta_values( $key ){
	global $wpdb;

	$data = $wpdb->get_results(
		$wpdb->prepare("
		SELECT * FROM `wp_postmeta`
		WHERE `meta_key` LIKE %s",
		$key
		)
	);

	$values = array();
	foreach( $data as $value ){
		$values[] = $value->meta_value;
	}

	return array_unique( $values );
}

// http://cooking4beginners/dishes/?difficulty%5B%5D=simple