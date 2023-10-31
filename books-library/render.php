<?php
/**
 * Block default vars $attributes; $content;  $block;
 *
 * @package WordPress
 */

if ( ! function_exists( 'nls_get_taxonomy_hierarchy' ) ) {
	/**
	 * Recursively get given taxonomies' terms as complete hierarchies.
	 *
	 * @param string|array $taxonomy Taxonomy slugs.
	 * @param int          $parent - Starting parent term id.
	 *
	 * @return array
	 */
	function nls_get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
		ob_start();
			$combined_terms     = false;
			$nls_book_authors   = ( isset( $_GET['nls-book-authors'] ) && ! empty( trim( $_GET['nls-book-authors'] ) ) ) ? explode( '-', sanitize_text_field(  wp_unslash( $_GET['nls-book-authors'] )  ) ) : array(); // phpcs:ignore
			$nls_book_publisher = ( isset( $_GET['nls-book-publisher'] ) && ! empty( trim( $_GET['nls-book-publisher'] ) ) ) ? explode( '-', sanitize_text_field( wp_unslash( $_GET['nls-book-publisher']) ) ) : array(); // phpcs:ignore
		if ( ! empty( $nls_book_authors ) || ! empty( $nls_book_publisher ) ) {
			$combined_terms = array_merge( $nls_book_authors, $nls_book_publisher );
		}
		$terms = get_terms(
			$taxonomy,
			array(
				'parent'     => $parent,
				'hide_empty' => false,
			)
		);
		if ( ! empty( $terms ) ) :
			echo "<ul class='nls-parent-term' >";
			foreach ( $terms as $term ) {
					$checked = ( ! empty( $combined_terms ) && in_array( $term->term_id, $combined_terms, false ) ) ? " checked='checked' " : ' '; //phpcs:ignore
					echo "<li class='nls-child-term' > <label>" . "<input type='checkbox' name='nls[$taxonomy]' value='" . $term->term_id . "' $checked >" . $term->name . '</label></li>'; // phpcs:ignore
					// echo nls_get_taxonomy_hierarchy( $taxonomy, $term->term_id ); uncomment if you want to display hierarchical.
			}
				echo '</ul>';
		endif;
		return ob_get_clean();
	}
}
$nls_book_authors   = ( isset( $_GET['nls-book-authors'] ) && ! empty( trim( $_GET['nls-book-authors'] ) ) ) ? explode( '-', sanitize_text_field(  wp_unslash( $_GET['nls-book-authors'] )  ) ) : array();// phpcs:ignore
$nls_book_publisher = ( isset( $_GET['nls-book-publisher'] ) && ! empty( trim( $_GET['nls-book-publisher'] ) ) ) ?  explode( '-', sanitize_text_field( wp_unslash( $_GET['nls-book-publisher']) ) ) : array();// phpcs:ignore
$check              = 0;
$clear_check        = 1;
$posts_count        = ( isset( $attributes['pagination_number'] ) && $attributes['pagination_number'] >= 1 && $attributes['pagination_number'] <= 100 ) ? (int) sanitize_text_field( $attributes['pagination_number'] ) : 3;
$paginate_type      = ( isset( $attributes['pagination_type'] ) && 0 === $check || ( 'nm' === $attributes['pagination_type'] || 'ajx' === $attributes['pagination_number'] ) ) ? sanitize_text_field( $attributes['pagination_type'] ) : 'nm';
$paged              = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // phpcs:ignore 
$book_qry_args      = array(
	'post_type'      => 'books',
	'post_status'    => 'publish',
	'posts_per_page' => $posts_count,
	'paged'          => $paged,
	'order'          => 'ASC',
	'orderby'        => 'post_title ID',
);
$taxonomies_qry     = array();
if ( isset( $nls_book_authors ) && ! empty( $nls_book_authors ) ) {
	$taxonomies_qry[] =
		array(
			'taxonomy' => 'book-author',
			'field'    => 'term_id',
			'terms'    => $nls_book_authors,
		);
}
if ( isset( $nls_book_publisher ) && ! empty( $nls_book_publisher ) ) {
	$taxonomies_qry[] =
		array(
			'taxonomy' => 'book-publisher',
			'field'    => 'term_id',
			'terms'    => $nls_book_publisher,
		);
}
$clear_filter_btn = '';
if ( isset( $nls_book_authors ) && ! empty( $nls_book_authors ) && isset( $nls_book_publisher ) && ! empty( $nls_book_publisher ) ) {
	$taxonomies_qry['relation'] = ( 'nd' === $attributes['and_or_condition'] ) ? 'AND' : 'OR';
}
if ( isset( $nls_book_authors ) && ! empty( $nls_book_authors ) && 1 === $clear_check || isset( $nls_book_publisher ) && ! empty( $nls_book_publisher ) ) {
	$clear_filter_btn = ( isset( $_SERVER['REQUEST_URI'] ) ) ? "<p> <b>x</b> <a href='" . strtok( $_SERVER['REQUEST_URI'], '?' ) . "'> " . __( 'Clear Filters', 'master-book-lib' ) . '  </a><p>' : ''; // phpcs:ignore
}
if ( ! empty( $taxonomies_qry ) ) {
	$book_qry_args['tax_query'] = $taxonomies_qry; // phpcs:ignore 
}
$book_query    = new WP_Query( $book_qry_args );
$max_num_pages = $book_query->max_num_pages;
?>
<div class="nls-book-block-container">
	<div class="nls-book-library-container" >
		<?php echo ( isset( $attributes['content'] ) && ! empty( trim( $attributes['content'] ) ) ) ? "<div class='nls-block-title'>$attributes[content]</div>" : ''; // phpcs:ignore?>
		<div class="options-form" >
			<form id="nls_option_post_form">
				<input type="hidden" id="nls-book-authors" name="nls-book-authors" <?php echo ( ! empty( $nls_book_authors ) ) ? " value='" . esc_html( implode( '-', $nls_book_authors ) ) . "' " : ''; ?> >
				<input type="hidden" id="nls-book-publisher" name="nls-book-publisher" <?php echo ( ! empty( $nls_book_publisher ) ) ? " value='" . esc_html( implode( '-', $nls_book_publisher ) ) . "'" : ''; ?> >
				<input type="hidden" id="nls_posts_per_page" value="<?php echo esc_html( $posts_count ); ?>" >
				<input type="hidden" id="nls_and_or_condition" value="<?php echo esc_html( $attributes['and_or_condition'] ); ?>">
				<input type="hidden" id="nls_next_page_number" value="2">
				<input type="hidden" id="nls_max_number_pages" value="<?php echo esc_html( $max_num_pages ); ?>">
			</form>
			<?php if ( isset( $attributes['check_filters'] ) && 'y' === $attributes['check_filters'] ) : ?>
				<div class='nls-book-filters'>
					<div class="book-author-filters">
						<p class="filter-title"> <?php esc_html_e( 'Book Authors', 'master-book-lib' ); ?> </p>
						<?php echo nls_get_taxonomy_hierarchy( 'book-author' ); // phpcs:ignore ?>
					</div>
					<div class="book-publisher-filters">
						<p class="filter-title"> <?php esc_html_e( 'Book Publisher', 'master-book-lib' ); ?> </p>
						<?php echo nls_get_taxonomy_hierarchy( 'book-publisher' ); // phpcs:ignore  ?>
					</div>
					<?php echo $clear_filter_btn;  // phpcs:ignore ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="nls_books_listing wrapper listing-section" >
			<?php
			if ( $book_query->have_posts() ) :
				while ( $book_query->have_posts() ) :
					$book_query->the_post();
					$auth_list       = get_the_term_list( get_the_ID(), 'book-author', '', ',', '' );
					$publishers_list = get_the_term_list( get_the_ID(), 'book-publisher', '', ',', '' );
					?>
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
									<?php echo ( ! empty( $publishers_list ) ) ? "<b>Publisher: </b> $publishers_list" : ''; // phpcs:ignore ?>
								</p>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				else :
					echo '<h3>' . esc_html__( 'Sorry! The result you are searching for is not found. :(', 'master-book-lib' ) . '</h3>';
				endif;
				?>
		</div>
	</div>
</div>
<div class="nls-book-pagination-container" >
	<?php if ( $max_num_pages > 1 ) : ?>
		<div class="pagination_container">
			<?php if ( 'ajx' === $paginate_type ) : ?>
				<div class="nls-ajax-load-more-btn" >
					<div class='nls-loading-image' style="display: none;" >
						<div class="nls-loading-disc">
							<div class="loading-mini-divs">
								<div><div></div><div></div></div>
							</div>
						</div>
					</div>
					<button type="button">
						<?php echo esc_html( $attributes['load_more_btn_txt'] ); ?>
					</button>
				</div>
				<?php
			else :
				$paginate_args = array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $max_num_pages,
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'format'       => '?page=%#%',
					'show_all'     => false,
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1,
					'prev_next'    => true,
					'prev_text'    => sprintf( '<i></i> %1$s', '<' ),
					'next_text'    => sprintf( '%1$s <i></i>', '>' ),
					'add_args'     => true,
					'add_fragment' => '',
				);
				echo "<div class='nls-normal-pagination' >" . paginate_links( $paginate_args ) . '</div>'; // phpcs:ignore ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>

