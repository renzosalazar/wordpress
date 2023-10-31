<?php
/**
 * Plugin Name: Block Development
 * Description:       A library management tool, with filter and pagination ability.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Hardik Lakkad
 * Author URI:        https://github.com/h-lakkad1998
 * License:           GPL v2 or later
 * Text Domain:       master-book-lib
 *
 * @package WordPress
 */

/**
 * This function register block
 */
function nls_block_register() {
	register_block_type( __DIR__ );
}
add_action( 'init', 'nls_block_register' );

/**
 * Adding post type and taxonomy registration.
 */
function custom_post_type() {
	$labels = array(
		'name'               => _x( 'Books', 'Post Type General Name', 'nls-block-editor-demo' ),
		'singular_name'      => _x( 'Book', 'Post Type Singular Name', 'nls-block-editor-demo' ),
		'menu_name'          => __( 'Books', 'nls-block-editor-demo' ),
		'parent_item_colon'  => __( 'Parent Book', 'nls-block-editor-demo' ),
		'all_items'          => __( 'All Books', 'nls-block-editor-demo' ),
		'view_item'          => __( 'View Book', 'nls-block-editor-demo' ),
		'add_new_item'       => __( 'Add New Book', 'nls-block-editor-demo' ),
		'add_new'            => __( 'Add New', 'nls-block-editor-demo' ),
		'edit_item'          => __( 'Edit Book', 'nls-block-editor-demo' ),
		'update_item'        => __( 'Update Book', 'nls-block-editor-demo' ),
		'search_items'       => __( 'Search Book', 'nls-block-editor-demo' ),
		'not_found'          => __( 'Not Found', 'nls-block-editor-demo' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'nls-block-editor-demo' ),
	);
	$args   = array(
		'label'               => __( 'Books', 'nls-block-editor-demo' ),
		'description'         => __( 'Books  for your need!', 'nls-block-editor-demo' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-book',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => false,

	);
	register_post_type( 'books', $args );
}
add_action( 'init', 'custom_post_type' );

/**
 * Register custom taxonomy for books post type
 */
function nls_create_taxonomies_for_books_taxonomy() {
	$labels = array(
		'name'              => _x( 'Book authors', 'taxonomy general name', 'nls-block-editor-demo' ),
		'singular_name'     => _x( 'Book Author', 'taxonomy singular name', 'nls-block-editor-demo' ),
		'search_items'      => __( 'Search Book authors', 'nls-block-editor-demo' ),
		'all_items'         => __( 'All Book authors', 'nls-block-editor-demo' ),
		'parent_item'       => __( 'Parent Book Author', 'nls-block-editor-demo' ),
		'parent_item_colon' => __( 'Parent Book Author:', 'nls-block-editor-demo' ),
		'edit_item'         => __( 'Edit Book Author', 'nls-block-editor-demo' ),
		'update_item'       => __( 'Update Book Author', 'nls-block-editor-demo' ),
		'add_new_item'      => __( 'Add New Book Author', 'nls-block-editor-demo' ),
		'new_item_name'     => __( 'New Book Author Name', 'nls-block-editor-demo' ),
		'menu_name'         => __( 'Book authors', 'nls-block-editor-demo' ),
	);
	register_taxonomy(
		'book-author',
		array( 'books' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => false,
			'public'            => false,
			'rewrite'           => array( 'slug' => 'book-author' ),
		)
	);
	$labels_publisher = array(
		'name'              => _x( 'Book publishers', 'taxonomy general name', 'nls-block-editor-demo' ),
		'singular_name'     => _x( 'Book Publisher', 'taxonomy singular name', 'nls-block-editor-demo' ),
		'search_items'      => __( 'Search Book publishers', 'nls-block-editor-demo' ),
		'all_items'         => __( 'All Book publishers', 'nls-block-editor-demo' ),
		'parent_item'       => __( 'Parent Book Publisher', 'nls-block-editor-demo' ),
		'parent_item_colon' => __( 'Parent Book Publisher:', 'nls-block-editor-demo' ),
		'edit_item'         => __( 'Edit Book Publisher', 'nls-block-editor-demo' ),
		'update_item'       => __( 'Update Book Publisher', 'nls-block-editor-demo' ),
		'add_new_item'      => __( 'Add New Book Publisher', 'nls-block-editor-demo' ),
		'new_item_name'     => __( 'New Book Publisher Name', 'nls-block-editor-demo' ),
		'menu_name'         => __( 'Book publishers', 'nls-block-editor-demo' ),
	);
	register_taxonomy(
		'book-publisher',
		array( 'books' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels_publisher,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => false,
			'public'            => false,
			'rewrite'           => array( 'slug' => 'book-publisher' ),
		)
	);
}
add_action( 'init', 'nls_create_taxonomies_for_books_taxonomy' );
/**
 * This function for enqueuing script, styles for block.
 */
function nls_book_block_assets_enqueue() {
	wp_enqueue_script( 'nls_block_front_script', plugin_dir_url( __FILE__ ) . 'assets/js/block-front-script.js', array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'nls_block_front_script', 'frontend_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'enqueue_block_assets', 'nls_book_block_assets_enqueue' );
/**
 * This function is for pagination with AJAX
 */
function nls_load_more_books_func() {
	ob_start();
	$posts_count    = (int) ( isset( $_POST['no_of_counts'] ) ) ? $_POST['no_of_counts'] : false; // phpcs:ignore
	$paged          = (int) ( isset( $_POST['next_page_no'] ) ) ? $_POST['next_page_no'] : false; // phpcs:ignore
	$book_qry_args  = array(
		'post_type'      => 'books',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_count,
		'paged'          => $paged,
		'order'          => 'ASC',
		'orderby'        => 'post_title',
	);
	$taxonomies_qry = array();
	if ( ! empty( trim( $_POST['author'] ) ) ) { // phpcs:ignore
		$taxonomies_qry[] = array(
			'taxonomy' => 'book-author',
			'field'    => 'term_id',
			'terms'       => explode( '-', $_POST['author'] ), // phpcs:ignore
		);
	}
	if ( ! empty( trim( $_POST['publishers'] ) ) ) { // phpcs:ignore
		$taxonomies_qry[] = array(
			'taxonomy' => 'book-publisher',
			'field'    => 'term_id',
			'terms'    => explode( '-', $_POST['publishers'] ), // phpcs:ignore
		);
	}
	if ( ! empty( trim( $_POST['author'] ) ) && ! empty( trim( $_POST['publishers'] ) ) ) { // phpcs:ignore
		$taxonomies_qry['relation'] = ( $_POST['and_or_condition'] == 'nd' ) ? 'AND' : 'OR'; // phpcs:ignore
	}
	if ( ! empty( $taxonomies_qry ) ) {
		$book_qry_args['tax_query'] = $taxonomies_qry; // phpcs:ignore
	}
	$book_query = new WP_Query( $book_qry_args );
	if ( $book_query->have_posts() ) :
		while ( $book_query->have_posts() ) :
			$book_query->the_post();
			$auth_list       = get_the_term_list( get_the_ID(), 'book-author', '', ',', '' );
			$publishers_list = get_the_term_list( get_the_ID(), 'book-publisher', '', ',', '' );?>
				<div class="product">
					<div class="image-box">
					<div class="images" style="background-image: url(<?php the_post_thumbnail_url( 'full' ); ?>);" ></div>
					</div>
					<div class="text-details">
						<h4 class="item"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="cat-info" >
							<p class="cat-author">
									<?php echo ( ! empty( $auth_list ) ) ? "<b>Authors: </b> $auth_list" : ''; // phpcs:ignore ?>
							</p>
							<p class="cat-publisher">
									<?php echo ( ! empty( $publishers_list ) ) ? "<b>Publisher: </b> $publishers_list" : '' ; // phpcs:ignore ?>
							</p>
						</div>
					</div>
				</div>
			<?php
	endwhile;
		wp_reset_postdata();
	else :
		echo '<h3>' . __( 'Sorry! The result you are searching for is not found. :(', 'master-book-lib' ) . '</h3>';// phpcs:ignore
  endif;
	$result['html_text'] = ob_get_clean();
	wp_send_json( $result );
}
add_action( 'wp_ajax_nls_load_more_books', 'nls_load_more_books_func' );
add_action( 'wp_ajax_nopriv_nls_load_more_books', 'nls_load_more_books_func' );
