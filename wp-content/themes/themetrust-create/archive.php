<?php
/**
 * The template for displaying Archive pages.
 * @package create
 */


			get_header(); ?>

				<div id="primary" class="content-area">

					<header class="main entry-header">
						<h1 class="entry-title">
							<?php
								if ( is_category() ) :
									single_cat_title();

								elseif ( is_tag() ) :
									single_tag_title();

								elseif ( is_author() ) :
									printf( __( 'Author: %s', 'create' ), '<span class="vcard">' . get_the_author() . '</span>' );

								elseif ( is_day() ) :
									printf( __( 'Day: %s', 'create' ), '<span>' . get_the_date() . '</span>' );

								elseif ( is_month() ) :
									printf( __( 'Month: %s', 'create' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'create' ) ) . '</span>' );

								elseif ( is_year() ) :
									printf( __( 'Year: %s', 'create' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'create' ) ) . '</span>' );

								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									_e( 'Asides', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
									_e( 'Galleries', 'create');

								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									_e( 'Images', 'create');

								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									_e( 'Videos', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									_e( 'Quotes', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									_e( 'Links', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
									_e( 'Statuses', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
									_e( 'Audios', 'create' );

								elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
									_e( 'Chats', 'create' );

								else :
									_e( 'Archives', 'create' );

								endif;
							?>
						</h1>
						<?php // Show an optional term description.
						$term_description = term_description();

						if ( ! empty( $term_description ) ) {
						?>
						<span class="meta">
							<?php echo $term_description; ?>
						</span>
						<?php } ?>
						<span class="overlay"></span>
					</header><!-- .entry-header -->

					<?php $archive_layout = get_theme_mod( 'create_archive_layout', 'standard' ); ?>
					<?php get_template_part( 'templates/archive', $archive_layout ); ?>

				</div><!-- #primary -->
			<?php get_footer(); ?>
