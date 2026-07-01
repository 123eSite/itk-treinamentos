<?php
get_header();
?>

	<div class="container py-5 default-index">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<section class="no-results not-found">
				<h1 class="entry-title">Nada encontrado</h1>
				<p>Não há conteúdo publicado ainda. Crie uma página e defina-a como página inicial em Configurações &gt; Leitura.</p>
			</section>
		<?php endif; ?>
	</div>

<?php
get_footer();
