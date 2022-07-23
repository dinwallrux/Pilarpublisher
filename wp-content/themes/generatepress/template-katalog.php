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
    Template Name: Template Katalog
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
    <style>
        #right-sidebar{
            display: none;
        }
        .list-post{
            display: flex;
            flex-wrap: wrap;
        }
        .list-post h3{
            font-size: 17px;
            font-weight: bold;
            color: #4a4a4a;
            margin-bottom: 10px;
        }
        .list-post p{
            margin-bottom: 5px;
            color: #4a4a4a;
            font-size: 13px;
        }
        .list-post .desc{
            margin-top: 20px;
        }
        .list-post .btn{
            width: 50%;
            border-radius: 100px;
            background: #1f8efa;
            color: #ffff;
            text-decoration: none;
            padding: 7px 20px;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 20px;
            margin-top: 50px;
            margin: auto;
            text-align: center;
            font-size: 14px;
        }
        .list-post .book-desc{
            padding: 10px;
            min-height: 230px;
            padding-bottom: 110px;
        }
        .list-post li{
            width: 23%;
            margin: 10px;
            border-radius: 7px;
            position: relative;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 0 20px 0 rgba(203, 203, 203, 0.6);
        }
        .list-post img{
            width: 100%;
            height: auto;
        }
        @media only screen and (max-width: 581px) {
            .list-post{
                justify-content: center;
                padding: 0 30px;
            }
            .list-post li{
                width: 100%;
            }
            .title-section{
                margin-left: 30px;
            }
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

			$terms = get_terms( 'kategori_buku', array(
                'hide_empty' => true,
                'order' => 'date'
            ) );

			foreach ($terms as $term){
			    ?>

                <h2 class="title-section"><?php echo $term->name;?></h2>

                <?php echo do_shortcode("[list-posts type=katalog_buku taxname=kategori_buku taxterms=$term->slug]");
            }

            if ( comments_open() || '0' != get_comments_number() ) : ?>

                <div class="comments-area">
                    <?php comments_template(); ?>
                </div>

            <?php endif;

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
