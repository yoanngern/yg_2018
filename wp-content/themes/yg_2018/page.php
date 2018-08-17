<?php get_header(); ?>

<section id="content">


	<?php if ( get_field( 'bg_image' ) ): ?>

        <article class="title">
            <div class="image"
                 style="background-image: url('<?php echo get_field( 'bg_image' )['sizes']['header']; ?>')"></div>
            <div class="title">


                <h1 class="page-title">
                    <span class="txt"><?php echo get_field( 'subtitle' ); ?></span>
                    <span class="underline"></span>
                </h1>

            </div>

        </article>

	<?php else: ?>

        <div class="spacer"></div>

	<?php endif; ?>

    <div class="platter">

		<?php
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
            <article class="content-page">

				<?php
				echo '<div class="content">';
				the_content();
				echo '</div>';
				?> <!-- Page Content -->

            </article><!-- .entry-content-page -->


		<?php
		endwhile; //resetting the page loop
		wp_reset_query(); //resetting the page query
		?>

		<?php if ( have_rows( 'sections' ) ): ?>
			<?php while ( have_rows( 'sections' ) ): the_row();

				$title   = get_sub_field( 'title' );
				$content = get_sub_field( 'content' );
				$button  = get_sub_field( 'button' );
				$image   = get_sub_field( 'image' )['sizes']['section'];

				set_query_var( 'title', $title );
				set_query_var( 'content', $content );
				set_query_var( 'button', $button );
				set_query_var( 'image', $image );
				get_template_part( 'template-parts/divers/section' );

				?>

			<?php endwhile; ?>
		<?php endif; ?>


    </div>


</section>


<?php get_footer(); ?>

