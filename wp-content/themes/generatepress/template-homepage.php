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
    Template Name: Template Homepage
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
    <style>
        #right-sidebar{
            display: none;
        }
        .page-header-image{
            display: none;
        }
        .title-section{
            font-size: 23px;
            font-weight: bold;
            clear: both;
        }
        #homepage{
            padding-top: 20px;
        }
        #homepage h2:after{
            content: "";
            width: 100px;
            background: #4a4a4a;
            height: 2px;
            display: block;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        .show-post{
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 40px !important;
        }
        .show-post li{
            width: 23%;
            margin: 10px;
            border-radius: 7px;
            position: relative;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 0 20px 0 rgba(203, 203, 203, 0.6);
        }
        .show-post .post-content{
            padding: 10px;
            min-height: 230px;
            padding-bottom: 75px;
        }
        .show-post h3, .show-post .title{
            font-size: 17px;
            margin-bottom: 7px;
            font-weight: bold;
            color: #4a4a4a;
        }
        .show-post p{
            font-size: 13px;
        }
        .show-post .date{
            display: block;
            margin-bottom: 15px;
            color: #9b9b9b;
            font-weight: 300;
            font-size: 12px;
        }
        .show-post .btn{
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

        /*Book Style*/
        .wrap-list-posts{
            background: #fff;
            margin: 10px;
            width: 23%;
            border-radius: 7px;
            position: relative;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 0 20px 0 rgba(203, 203, 203, 0.6);
        }
        .wrap-list-posts p{
            margin: 0;
            font-size: 12px;
            padding: 0px 10px 10px;
        }
        .wrap-book-post{
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .wrap-book-post ul{
            margin: 0;
        }
        .list-posts-no-desc{
            display: flex;
            flex-wrap: wrap;
        }
        .list-posts-no-desc h3, .list-posts-no-desc .title{
            font-size: 17px;
            font-weight: bold;
            color: #4a4a4a;
            margin-bottom: 10px;
        }
        .list-posts-no-desc p{
            margin-bottom: 5px;
            color: #4a4a4a;
            font-size: 13px;
        }
        .list-posts-no-desc .desc{
            margin-top: 20px;
        }
        .list-posts-no-desc .btn{
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
        .list-posts-no-desc .book-desc{
            padding: 10px;
            padding-bottom: 10px;
        }
        .list-posts-no-desc img{
            width: 100%;
            height: auto;
        }

        .content-testimoni{
            display: flex;
            align-items: flex-start;
        }
        .video-testimoni{
            width: 47.9%;
            display: inline-block;
            margin: 10px;
            border-radius: 7px;
            position: relative;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 0 20px 0 rgba(203, 203, 203, 0.6);
            padding: 20px;
        }
        .video-testimoni video{
            width: 100%;
        }
        .list-testimoni{
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: inline-block;
            width: 51%;
        }
        .list-testimoni i{
            margin-bottom: 25px;
            font-size: 35px;
        }
        .list-testimoni p{
            font-size: 13px;
            color: #4a4a4a;
        }
        .list-testimoni .person{
            font-weight: bold;
            font-size: 14px;
        }
        .list-testimoni li{
            display: inline-block;
            width: 45.9%;
            margin: 10px;
            border-radius: 7px;
            position: relative;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 0 20px 0 rgba(203, 203, 203, 0.6);
            padding: 20px;
        }

        #alamat{
            list-style-type: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        #alamat li{
            width: 33.3%;
            margin-left: 10px;
            margin-right: 20px;
        }
        #alamat p{
            font-size: 13px;
        }

        @media only screen and (max-width: 581px) {
            .show-post, .wrap-book-post {
                justify-content: center;
                padding: 0 20px;
            }
            .show-post li, .wrap-list-posts, .list-testimoni{
                width: 100%;
            }
            .list-testimoni li{
                width: auto;
            }
            .content-testimoni{
                align-items: center;
                flex-direction: column;
                padding: 0 20px;
            }
            .video-testimoni{
                width: auto;
            }
            #alamat{
                flex-direction: column;
                align-items: center;
                padding: 0px 30px;
            }
            #alamat li{
                width: 100%;
                margin: 0;
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

			echo do_shortcode('[rev_slider alias="homepage1"]');

			?>

            <div id="homepage" class="wrapper">
                <center>
                    <h2>Melayani dengan sepenuh hati menciptakan buku-buku bermutu</h2>
                </center>
            </div>

            <h2 class="title-section">Event</h2>
			<?php
            echo do_shortcode("[show-post type=post category=event]");

            $terms = get_terms( 'kategori_buku', array(
                'hide_empty' => true,
                'order' => 'date'
            ) );

            ?>
            <h2 class="title-section">Buku Terbaru</h2>
            <div class="wrap-book-post">
            <?php
			foreach ($terms as $term){
                ?>
                <div class="wrap-list-posts">
                    <?php
                    echo do_shortcode("[list-posts-no-desc type=katalog_buku taxname=kategori_buku taxterms=$term->slug]");
                    ?>
                    <p class="cateory"><?php echo $term->name;?></p>
                </div>
                <?php
            } ?>
            </div>

            <h2 class="title-section">Testimony</h2>
            <div class="content-testimoni">
                <ul class="list-testimoni">
                    <li>
                        <i class="fas fa-quote-right"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, officia, quaerat. Asperiores dicta facilis itaque nam neque nisi numquam quas.</p>
                        <p class="person">Nick Bishop</p>
                    </li>
                    <li>
                        <i class="fas fa-quote-right"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, officia, quaerat. Asperiores dicta facilis itaque nam neque nisi numquam quas.</p>
                        <p class="person">Nick Bishop</p>
                    </li>
                    <li>
                        <i class="fas fa-quote-right"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, officia, quaerat. Asperiores dicta facilis itaque nam neque nisi numquam quas.</p>
                        <p class="person">Nick Bishop</p>
                    </li>
                    <li>
                        <i class="fas fa-quote-right"></i>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, officia, quaerat. Asperiores dicta facilis itaque nam neque nisi numquam quas.</p>
                        <p class="person">Nick Bishop</p>
                    </li>
                </ul>
                <div class="video-testimoni">
                    <video controls>
                        <source src="https://www.pilarpublisher.com/wp-content/uploads/2019/07/VID-20190714-WA0001.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <h2 class="title-section">Hubungi Kami</h2>
            <ul id="alamat">
                <li>
                    <p>
                        <span><b>Kantor Pusat :</b></span> <br>
                        Bekasi Griya Asri II Blok H6 No 42 <br>
                        RT.005/005 Desa Sumber Jaya, Kecamatan Tambun Selatan <br>
                        Jawa Barat
                    </p>
                </li>
                <li>
                    <p>
                        <span><b>Branch Office:</b></span> <br>
                        Jalan Pakisaji Gang 2A No 1 Denpasar – Bali <br>
                        Kode Pos 80239 <br>
                        Tel. +62 851 0122 4046, +62 8124662055 <br>
                        Email:pilarprintpilarprint@gmail.com <br>
                        www.pilarpublisher.com
                    </p>
                </li>
                <li>
                    <?php echo do_shortcode("[tuskcode-bing-map]") ?>
                </li>
            </ul>

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
