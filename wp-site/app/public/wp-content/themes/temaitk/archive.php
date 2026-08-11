<?php
get_header();

// Página Blog (template blog.php) — não usa page_for_posts do WP
$blog_page_id = (int) get_option( 'page_for_posts' );
if ( ! $blog_page_id ) {
	$blog_pages = get_posts( array(
		'post_type'      => 'page',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'blog.php',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	$blog_page_id = ! empty( $blog_pages ) ? (int) $blog_pages[0] : 24;
}

$banner_bg_image  = get_field( 'banner_bg_image', $blog_page_id );
$banner_watermark = get_field( 'banner_watermark', $blog_page_id );
$archive_title    = get_the_archive_title();
?>

<!-- page-banner9 -->
<section class="bread-crums-section">
	<div class="container2">
		<div class="page-banner11">
			<?php if ( ! empty( $banner_bg_image ) ): ?>
				<img class="bg" src="<?php echo esc_url( $banner_bg_image['sizes']['banner-internas'] ); ?>"
					alt="<?php echo esc_attr( $banner_bg_image['alt'] ); ?>">
			<?php else: ?>
				<img class="bg" src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-blog.webp" alt="">
			<?php endif; ?>

			<div class="shape"></div>
			<div class="shape3"></div>

			<?php if ( $banner_watermark ): ?>
				<div class="staff-text"><?php echo esc_html( $banner_watermark ); ?></div>
			<?php else: ?>
				<div class="staff-text">ITK</div>
			<?php endif; ?>

			<div class="page-content">
				<h1 class="title"><?php echo wp_kses_post( $archive_title ); ?></h1>
			</div>
			<ul class="breadcrumbs">
				<li><a href="<?php echo home_url(); ?>" title="Home">Home</a></li>
				<li>/</li>
				<li><a href="<?php echo get_permalink( $blog_page_id ); ?>" title="Blog">Blog</a></li>
				<li>/</li>
				<li><?php echo wp_strip_all_tags( $archive_title ); ?></li>
			</ul>
		</div>
	</div>
</section>
<!-- End page-banner9 -->

<!-- blog-sec -->
<section class="blog-sec v2 ibt-section-gap">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ):
				while ( have_posts() ):
					the_post(); ?>
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="blog-card h-100">
							<div class="blog-img<?php echo ! has_post_thumbnail() ? ' no-thumb' : ''; ?>">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'thumb-blog', array( 'alt' => get_the_title() ) );
									}
									?>
								</a>
								<span class="blog-meta"><?php echo get_the_date( 'j \d\e F \d\e Y' ); ?></span>
							</div>
							<div class="blog-content">
								<h4 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?></a>
								</h4>
								<span>
									<?php
									$categories = get_the_category();
									if ( ! empty( $categories ) ) {
										echo esc_html( $categories[0]->name );
									}
									?>
								</span>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			<?php else: ?>
				<div class="col-12">
					<p>Nenhum post encontrado nesta seção.</p>
				</div>
			<?php endif; ?>
		</div>

		<?php
		global $wp_query;
		$paged = max( 1, get_query_var( 'paged' ) );
		if ( $wp_query->max_num_pages > 1 ):
			$pagination_links = paginate_links( array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'    => '',
				'current'   => $paged,
				'total'     => $wp_query->max_num_pages,
				'type'      => 'array',
				'mid_size'  => 2,
				'prev_text' => false,
				'next_text' => 'Próxima <i class="icon-arrow-top"></i>',
			) );

			if ( ! empty( $pagination_links ) ): ?>
				<nav aria-label="Paginação do arquivo">
					<ul class="pagination v2">
						<?php foreach ( $pagination_links as $index => $link ):
							$is_current = strpos( $link, 'current' ) !== false;
							$is_next    = strpos( $link, 'next' ) !== false;
							$li_class   = 'page-item';
							if ( $index === 0 ) {
								$li_class .= ' m-0';
							}
							if ( $is_current ) {
								$li_class .= ' active';
							}
							$link = str_replace( 'page-numbers', 'page-link', $link );
							if ( $is_next ) {
								$link = str_replace( 'class="next page-link"', 'class="page-link v1"', $link );
							}
							?>
							<li class="<?php echo esc_attr( $li_class ); ?>"><?php echo $link; ?></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif;
		endif; ?>
	</div>
</section>

<?php
get_footer();
