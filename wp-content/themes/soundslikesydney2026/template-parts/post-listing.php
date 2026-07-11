<?php
/**
 * Reusable post listing: sort toolbar + three-up grid + query-string pagination.
 *
 * Shared by the News and Reviews page templates. Because the site runs on plain
 * permalinks, paging/sorting travel as query-string args (?paged=N&orderby=…)
 * and the loop runs its own WP_Query.
 *
 * Query vars:
 *   sls_list_category  — category slug to scope the loop to (empty = all posts).
 *   sls_list_per_page  — posts per page (default 9, a 3×3 grid).
 *
 * @package SoundsLikeSydney2026
 */

$sls_page_id  = get_queried_object_id();
$sls_category = (string) get_query_var( 'sls_list_category' );
$sls_per_page = (int) get_query_var( 'sls_list_per_page' );
if ( $sls_per_page < 1 ) {
	$sls_per_page = 9;
}

// -------------------------------------------------------------------------
// Sorting — whitelist of options mapped to WP_Query order args.
// -------------------------------------------------------------------------
$sls_sorts = array(
	'latest'    => array(
		'label'   => __( 'Newest first', 'soundslikesydney2026' ),
		'orderby' => 'date',
		'order'   => 'DESC',
	),
	'oldest'    => array(
		'label'   => __( 'Oldest first', 'soundslikesydney2026' ),
		'orderby' => 'date',
		'order'   => 'ASC',
	),
	'title'     => array(
		'label'   => __( 'Title (A–Z)', 'soundslikesydney2026' ),
		'orderby' => 'title',
		'order'   => 'ASC',
	),
	'commented' => array(
		'label'   => __( 'Most discussed', 'soundslikesydney2026' ),
		'orderby' => 'comment_count',
		'order'   => 'DESC',
	),
);

$sls_sort = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'latest'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( ! isset( $sls_sorts[ $sls_sort ] ) ) {
	$sls_sort = 'latest';
}

// Current page (query-string based; plain permalinks).
$sls_paged = isset( $_GET['paged'] ) ? max( 1, absint( wp_unslash( $_GET['paged'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// -------------------------------------------------------------------------
// The query.
// -------------------------------------------------------------------------
$sls_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $sls_per_page,
	'paged'               => $sls_paged,
	'orderby'             => $sls_sorts[ $sls_sort ]['orderby'],
	'order'               => $sls_sorts[ $sls_sort ]['order'],
	'ignore_sticky_posts' => true,
);
if ( '' !== $sls_category ) {
	$sls_args['category_name'] = $sls_category;
}

$sls_query = new WP_Query( $sls_args );

$sls_total = (int) $sls_query->found_posts;
$sls_first = $sls_total ? ( ( $sls_paged - 1 ) * $sls_per_page ) + 1 : 0;
$sls_last  = min( $sls_total, $sls_paged * $sls_per_page );
?>

<div class="sls-container sls-listing">

	<div class="sls-listing__toolbar">
		<p class="sls-listing__count">
			<?php
			if ( $sls_total ) {
				printf(
					/* translators: 1: first result, 2: last result, 3: total. */
					esc_html__( 'Showing %1$s–%2$s of %3$s', 'soundslikesydney2026' ),
					esc_html( number_format_i18n( $sls_first ) ),
					esc_html( number_format_i18n( $sls_last ) ),
					esc_html( number_format_i18n( $sls_total ) )
				);
			} else {
				esc_html_e( 'No stories yet', 'soundslikesydney2026' );
			}
			?>
		</p>

		<form class="sls-sort" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" name="page_id" value="<?php echo esc_attr( $sls_page_id ); ?>">
			<label class="sls-sort__label" for="sls-sort-by"><?php esc_html_e( 'Sort by', 'soundslikesydney2026' ); ?></label>
			<select id="sls-sort-by" class="sls-sort__select" name="orderby" data-autosubmit>
				<?php foreach ( $sls_sorts as $sls_key => $sls_opt ) : ?>
					<option value="<?php echo esc_attr( $sls_key ); ?>" <?php selected( $sls_sort, $sls_key ); ?>>
						<?php echo esc_html( $sls_opt['label'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<button type="submit" class="sls-sort__submit sls-btn"><?php esc_html_e( 'Sort', 'soundslikesydney2026' ); ?></button>
		</form>
	</div>

	<?php if ( $sls_query->have_posts() ) : ?>

		<div class="sls-post-grid sls-post-grid--3">
			<?php
			while ( $sls_query->have_posts() ) :
				$sls_query->the_post();
				get_template_part( 'template-parts/content/content', get_post_format() );
			endwhile;
			?>
		</div>

		<?php
		// Query-string pagination that preserves the sort arg.
		$sls_base = esc_url_raw( remove_query_arg( 'paged' ) );
		$sls_glue = ( false === strpos( $sls_base, '?' ) ) ? '?' : '&';

		$sls_links = paginate_links(
			array(
				'base'      => $sls_base . $sls_glue . 'paged=%#%',
				'format'    => '',
				'current'   => $sls_paged,
				'total'     => (int) $sls_query->max_num_pages,
				'mid_size'  => 1,
				'end_size'  => 1,
				'prev_text' => '&lsaquo;',
				'next_text' => '&rsaquo;',
				'type'      => 'plain',
			)
		);

		if ( $sls_links ) {
			echo '<nav class="pagination" aria-label="' . esc_attr__( 'Posts pagination', 'soundslikesydney2026' ) . '">' . $sls_links . '</nav>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links() escapes each link.
		}
		?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

	<?php endif; ?>

</div>

<?php
wp_reset_postdata();
