<?php
/**
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */

/*
    Template Name: Template Verification
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
    <style>
        .card{
            margin: 50px auto;
        }
        .card-body i{
            font-size: 55px;
        }
    </style>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			?>

            <div id="verification" class="row justify-content-md-center">
                <div class="col-lg-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <center>
                                <i class="ion-checkmark-circled text-success"></i>
                                <h2 class="card-title">Selamat!</h2>
                                <p class="card-text">Registrasi anda sudah berhasil</p>
                                <a href="<?php echo home_url(); ?>">
                                    <button class="btn btn-primary">
                                        <span>Lanjutkan</span>
                                    </button>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <?php

            /**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

get_footer();
