<?php
/**
 * Created by IntelliJ IDEA.
 * User: sholahudin
 * Date: 20-Jul-19
 * Time: 9:44 PM
 */

function script_enqueue(){
    wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', '4.0.0', true );
    wp_enqueue_style('ionicons-style', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css', '2.0.1', true );

    wp_enqueue_script('ValidatorJs', get_template_directory_uri() . '/js/lib/validatorjs/validator.js', array(), '3.15.0', true);
    wp_enqueue_script('ValidatorIDJs', get_template_directory_uri() . '/js/lib/validatorjs/id.js', array(), '3.15.0', true);
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), '4.0.0', true );
    wp_enqueue_script( 'lodash-js', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js', array(), '4.17.15', true );
    wp_enqueue_script('myScript', get_template_directory_uri() . '/js/custom-js.js', array('jquery'), rand(111, 9999), true);
}
add_action('wp_enqueue_scripts', 'script_enqueue');

function get_excerpt($limit, $source = null){

    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
//     <a href="'.get_permalink($post->ID).'">more</a>
    return $excerpt;
}

// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
add_shortcode( 'list-posts', 'list_posts_shortcode' );
function list_posts_shortcode( $atts ) {
    ob_start();

    // define attributes and their defaults
    extract( shortcode_atts( array (
        'type' => 'katalog_buku',
        'order' => 'date',
        'orderby' => 'ASC',
        'posts' => -1,
        'category' => '',
        'taxname' => '',
        'taxfield' => 'slug',
        'taxterms' => '',
    ), $atts ) );

    // define query parameters based on attributes
    $args = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category,
        'tax_query' => array(
            array(
                'taxonomy' => $taxname,
                'field'    => $taxfield,
                'terms'    => $taxterms,
            ),
        ),
    );
    $listQuery = new WP_Query( $args );
    // run the loop based on the query
    if ( $listQuery->have_posts() ) { ?>
        <ul class="list-post">
        <?php while( $listQuery->have_posts() ) {
            $listQuery->the_post();
            $penulis = get_field('penulis');
            $ukuran = get_field( "ukuran" );
            $ketebalan = get_field( "ketebalan" );
            $harga = get_field( "harga" );
            $terbit = get_field( "terbit" );
            $isbn = get_field( "isbn" );
            ?>

            <li id="post-<?php echo get_the_ID(); ?>">
                <div class="book-thumb">
                    <a href="<?php echo get_permalink($post->ID)?>">
                        <?php the_post_thumbnail('large')?>
                    </a>
                </div>
                <div class="book-desc">
                    <h3><?php echo get_the_title(); ?></h3>
                    <p>Penulis : <?php echo $penulis->post_title; ?></p>
                    <p>Ukuran : <?php echo $ukuran;?></p>
                    <p>Ketebalan : <?php echo $ketebalan;?></p>
                    <p>Harga : <?php echo $harga;?></p>
                    <p>Terbit : <?php echo $terbit;?></p>
                    <p>ISBN : <?php echo $isbn;?></p>
                    <p class="desc"><?php echo get_excerpt(120, 'content'); ?></p>
                </div>
                <div class="wrap-button">
                    <a class="btn btn-primary" href="<?php echo get_permalink($post->ID)?>">Detail Buku</a>
                </div>
            </li>
        <?php } ?>
        </ul>
    <?php
        $myvariable = ob_get_clean();
        return $myvariable;
    }
}

add_shortcode( 'show-post', 'show_post_shortcode' );
function show_post_shortcode( $atts ) {
    ob_start();

    // define attributes and their defaults
    extract( shortcode_atts( array (
        'type' => 'post',
        'order' => 'date',
        'orderby' => 'ASC',
        'posts' => -1,
        'category' => ''
    ), $atts ) );

    // define query parameters based on attributes
    $args = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category
    );
    $showPost = new WP_Query( $args );
    // run the loop based on the query
    if ( $showPost->have_posts() ) { ?>
        <ul class="show-post">
        <?php while( $showPost->have_posts() ) {
            $showPost->the_post();
            ?>

            <li id="post-<?php echo get_the_ID(); ?>">
                <div class="post-thumb">
                    <a href="<?php echo get_permalink($post->ID)?>">
                        <?php the_post_thumbnail('large')?>
                    </a>
                </div>
                <div class="post-content">
                    <a class="title" href="<?php echo get_permalink($post->ID)?>">
                        <h3><?php echo get_the_title(); ?></h3>
                    </a>
                    <span class="date"><?php the_time('d M Y') ?></span>
                    <p class="desc"><?php echo get_excerpt(120, 'content'); ?></p>
                </div>
                <div class="wrap-button">
                    <a class="btn btn-primary" href="<?php echo get_permalink($post->ID)?>">Detail</a>
                </div>
            </li>
        <?php } ?>
        </ul>
    <?php
        return ob_get_clean();
    }
}

// Post without description
add_shortcode( 'list-posts-no-desc', 'list_posts_no_desc_shortcode' );
function list_posts_no_desc_shortcode( $atts ) {
    ob_start();

    // define attributes and their defaults
    extract( shortcode_atts( array (
        'type' => 'katalog_buku',
        'order' => 'date',
        'orderby' => 'ASC',
        'posts' => 1,
        'category' => '',
        'taxname' => '',
        'taxfield' => 'slug',
        'taxterms' => '',
    ), $atts ) );

    // define query parameters based on attributes
    $args = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category,
        'tax_query' => array(
            array(
                'taxonomy' => $taxname,
                'field'    => $taxfield,
                'terms'    => $taxterms,
            ),
        ),
    );
    $listQueryNoDesc = new WP_Query( $args );
    // run the loop based on the query
    if ( $listQueryNoDesc->have_posts() ) { ?>
        <ul class="list-posts-no-desc">
        <?php while( $listQueryNoDesc->have_posts() ) {
            $listQueryNoDesc->the_post();
            ?>

            <li id="post-<?php echo get_the_ID(); ?>">
                <div class="book-thumb">
                    <a href="<?php echo get_permalink($post->ID)?>">
                        <?php the_post_thumbnail('large')?>
                    </a>
                </div>
                <div class="book-desc">
                    <a href="<?php echo get_permalink($post->ID)?>">
                        <h3><?php echo get_the_title(); ?></h3>
                    </a>
                </div>
            </li>
        <?php } ?>
        </ul>
    <?php
        $myvariable = ob_get_clean();
        return $myvariable;
    }
}

function my_admin_scripts() {
    $localize = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    );

    wp_enqueue_script( 'my_js', get_template_directory_uri() . '/js/custom-js.js', array( 'jquery' ) );

    wp_localize_script( 'my_js', 'myVar', $localize);
    
}

add_action( 'wp_enqueue_scripts', 'my_admin_scripts' );
// Custom Register
add_action('user_register', 'save_custom_user_profile_fields', 10, 1);
add_action('profile_update', 'save_custom_user_profile_fields');
// Save value of custom field
function save_custom_user_profile_fields($user_id){
    // get user data
    $user_info = get_userdata($user_id);
    // create md5 code to verify later
    $code = md5(time());
    // make it into a code to send it to user via email
    $string = array('id'=>$user_id, 'code'=>$code);
    // create the activation code and activation status
    update_user_meta($user_id, 'account_activated', 0);
    update_user_meta($user_id, 'activation_code', $code);
    // create the url
    $url = get_site_url(). '/verifikasi/?act=' .base64_encode( serialize($string));
    // basically we will edit here to make this nicer
    // send an email out to user

    $to = $user_info->user_email;
    $subject = "Aktivasi Akun";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    ob_start();
        verfication_email($url);
        $content = ob_get_contents();
    ob_end_clean();
    wp_mail( $to, $subject, $content, $headers);

    # again do this only if you can
    if(!current_user_can('manage_options'))
        return false;

    # save my custom field
    update_user_meta( $user_id, 'company_name', $_POST['company_name'] );
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'pic_title', $_POST['pic_title'] );
    update_user_meta( $user_id, 'referral_code', $_POST['referral_code'] );
    update_user_meta( $user_id, 'cooperation', $_POST['cooperation'] );
}

function verfication_email($link){
    ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Professionnalisez la Communication de Votre Club!</title>
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
            <style>
                body{
                    margin: 0 !important;
                    padding: 0 !important;
                    font-family:'Source Sans Pro', sans-serif !important;
                }

                .wp-post-image{
                    width: 100% !important;
                    height: auto !important;
                }


                @media screen and (max-width: 600px) {

                    table[class="responsive-table"] {
                        width: 100% !important;
                        padding: 10px 5%;
                    }

                    table[class="responsive-table-2"] {
                        width: 100% !important;
                    }
                    table[class="center"] {
                        text-align: center !important;
                        margin: auto !important;
                    }
                    img[class="full-width"] {
                        width: 100% !important;
                    }
                    td[class="remove-vertical-padding"] {
                        padding-top: 50px !important;
                        padding-bottom: 0 !important;
                    }
                    td[class="height-auto"] {
                        height: auto !important;
                    }
                }
            </style>
        </head>
        <body bgcolor="#f4f7f8">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td align="center" bgcolor="#f4f7f8">

                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#f4f7f8">

                                    <table width="600" cellspacing="0" cellpadding="0" border="0" class="responsive-table">

                                        <tr>
                                            <td>
                                                <table bgcolor="#fff" width="600" cellspacing="0" cellpadding="0" border="0" class="responsive-table" style="margin: 40px auto; -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; padding: 40px 120px;">
                                                    <tr>
                                                        <td>
                                                            <center>
                                                                <img width="130" src="https://res.cloudinary.com/dw1zug8d6/image/upload/v1563862464/Email%20Launching/new-email-verification-dark-interface-symbol.png" alt="">
                                                                <h1>Selamat Datang</h1>
                                                                <p>Silahkan verifikasi email anda dengan menekan tombol di bawah ini..</p>
                                                                <a target="_blank" href="<?php echo $link?>" style="border-radius: 100px;background: #007bff;color: #fff;text-decoration: none;padding: 7px 40px;font-size: 14px;margin: 20px 0 0;display: inline-block;">
                                                                    Verifikasi
                                                                </a>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 20px 0 30px;" >
                                                <center>
                                                    <p class="medium-text" style="color:#4a4a4a;font-size:0.82em;font-family:'Source Sans Pro', sans-serif;letter-spacing:0.2px;line-height:140%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >Copyright © 2019 Pilarpublisher. All Right Reserved.</p>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
    <?php
}

add_action( 'init', 'verify_user_code' );
function verify_user_code(){
    if(isset($_GET['act'])){
        $data = unserialize(base64_decode($_GET['act']));
        $code = get_user_meta($data['id'], 'activation_code', true);
        // verify whether the code given is the same as ours
        if($code == $data['code']){
            // update the user meta
            update_user_meta($data['id'], 'is_activated', 1);
            update_user_meta($data['id'], 'pw_user_status', 'approved');
        }
    }
}

// Register User with Ajax
add_action('wp_ajax_custom_register', 'custom_register');
add_action('wp_ajax_nopriv_custom_register', 'custom_register');
function custom_register() {
    $new_user_name = stripcslashes($_POST['person_in_charge_name']);
    $new_user_email = stripcslashes($_POST['person_in_charge_email']);
    $new_user_password = $_POST['password'];
    $user_nice_name = strtolower($_POST['person_in_charge_name']);
    $user_data = array(
        'user_login' => $new_user_email,
        'user_email' => $new_user_email,
        'user_pass' => $new_user_password,
        'user_nicename' => $user_nice_name,
        'display_name' => $new_user_name,
        'role' => 'subscriber'
    );
    $user_id = wp_insert_user($user_data);
    update_user_meta( $user_id, 'company_name', $_POST['company_name'] );
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'pic_title', $_POST['pic_title'] );
    update_user_meta( $user_id, 'referral_code', $_POST['referral_code'] );
    update_user_meta( $user_id, 'cooperation', $_POST['cooperation'] );

    if (!is_wp_error($user_id)) {
        echo 'we have Created an account for you.';
    } else {
        print_r($user_id);
        if (isset($user_id->errors['empty_user_login'])) {
            echo json_encode(array('empty' => 1));
        } elseif (isset($user_id->errors['existing_user_login'])) {
            echo json_encode(array('email_exist' => 1));
        } else {
            echo json_encode(array('empty' => 1));
        }
    }
    die;
}