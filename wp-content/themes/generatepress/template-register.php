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
    Template Name: Template Register
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

?>
    <style>
        @-moz-keyframes spin{
            0%{ transform: rotate(0deg) }
            100%{ transform: rotate(360deg) }
        }

        @-webkit-keyframes spin{
            0%{ transform: rotate(0deg) }
            100%{ transform: rotate(360deg) }
        }

        @-ms-keyframes spin{
            0%{ transform: rotate(0deg) }
            100%{ transform: rotate(360deg) }
        }

        @keyframes spin{
            0%{ transform: rotate(0deg) }
            100%{ transform: rotate(360deg) }
        }
        #register_ label{
            display: block;
        }
        .main-title{
            margin: 20px auto;
            font-size: 32px;
            font-weight: 600;
            color: #4a4a4a;
            text-transform: uppercase;
        }
        .error{
            margin: 5px 0;
            color: red !important;
            display: none;
        }
        .btn{
            width: 30%;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
        }
        .btn span{
            margin-right: 10px;
        }
        .btn i{
            font-size: 17px;
        }

        #modal_success .modal-content{
            margin: 110px auto;
        }
        #modal_success .modal-body{
            padding: 60px 0 40px;
        }
        #modal_success img{
            width: 120px;
        }
        #modal_success h1{
            margin: 20px 0 10px;
            text-transform: uppercase;
            font-size: 32px;
        }
        #modal_success p{
            font-size: 14px;
            color: #4a4a4a;
        }
        #modal_success a{
            text-decoration: none;
        }
        #modal_success button{
            margin-top: 30px;
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
            <div id="register_" class="row justify-content-md-center">
                <div class="col-lg-6">
                    <h2 class="main-title">Form Registrasi</h2>
                    <form id="register_form" method="POST">
                        <input type="hidden" name="action" value="custom_register">
                        <div class="form-group">
                            <input type="text" class="form-control" name="company_name" placeholder="Company Name *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Address *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="person_in_charge_name" placeholder="Person In Charge Name *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="pic_title" placeholder="PIC Title * Ex: Procurement, GA, HR, Marketing, etc.">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="person_in_charge_phone" placeholder="Person In Charge Phone Number *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="person_in_charge_email" placeholder="Person In Charge Email *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password *">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="referral_code" placeholder="Referral Code">
                        </div>
                        <div class="form-group text-left px-4 py-4 border border-gray">
                            <p>Pilih Kerjasama *</p>
                            <hr>
                            <label>
                                <input type="radio" name="cooperation" value="Kerjasama Royalti" required>
                                <span>Kerjasama Royalti</span>
                            </label>
                            <label>
                                <input type="radio" name="cooperation" value="Kerjasama Beli Naskah" required>
                                <span>Kerjasama Beli Naskah</span>
                            </label>
                            <label>
                                <input type="radio" name="cooperation" value="Kerjasama Penulis Mengeluarkan Anggaran" required>
                                <span>Kerjasama Penulis Mengeluarkan Anggaran</span>
                            </label>
                            <p class="error"></p>
                        </div>
                        <?php wp_nonce_field( 'custom_action_nonce', 'name_of_nonce_field' ); ?>
                        <center>
                            <button id="submit_btn" type="submit" class="btn btn-primary">
                                <span>Daftar</span>
                                <i class="ion-android-checkmark-circle"></i>
                            </button>
                        </center>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modal_success">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal body -->
                        <div class="modal-body">
                            <center>
                                <img src="https://res.cloudinary.com/dw1zug8d6/image/upload/v1563695335/Email%20Launching/email.svg" alt="">
                                <h1 class="text-primary">Registrasi Berhasil!</h1>
                                <p>Silahkan cek email anda untuk verifikasi</p>
                                <a href="<?php echo home_url(); ?>">
                                    <button class="btn btn-primary">
                                        Lanjutkan
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

?>
<script type="application/javascript">
    jQuery(function( $ ) {
        let submitValidation = function (props, callback) {
            let self = this;
            self.isPending = _.debounce(function (form_data) {
                Validator.useLang('id');
                let validation = new Validator(form_data, props.form_rules);
                validation.passes(function () {
                    callback({
                        status: 'complete',
                        form_data: form_data,
                        error: {},
                    });
                });
                validation.fails(function () {
                    let newError = {};
                    if (validation.errors.errors != null) {
                        for (let key in validation.errors.errors) {
                            newError[key] = validation.errors.errors[key][0];
                        }
                        callback({
                            status: 'error',
                            form_data: form_data,
                            error: newError,
                        });
                    } else {
                        callback({
                            status: 'valid',
                            form_data: form_data,
                            error: newError,
                        });
                    }
                })
            }, 100)
            self.isPending(props.form_data);
        }
        let inputTextValidation = function (wrapperTarget, props, callback) {
            let self = this;
            let theDom = $(wrapperTarget);
            theDom = theDom.find(props.element_target);
            theDom.each(function (index, dom) {
                $(dom).on('keyup blur focus', function (e) {
                    if (self.isPending != null) {
                        if (e.type != 'blur') {
                            self.isPending.cancel();
                        }
                    }
                    self.isPending = _.debounce(function (key, value) {
                        let newObject = {};
                        newObject[key] = value;
                        props.form_data = _.assign(props.form_data, newObject);
                        Validator.useLang('id');
                        let validation = new Validator(props.form_data, props.form_rules);
                        validation.passes(function () {
                            callback({
                                status: 'complete',
                                form_data: props.form_data,
                                error: {},
                                message: ''
                            }, e);
                        })
                        validation.fails(function () {
                            let newError = {};
                            if (validation.errors.errors[key]) {
                                newError[key] = validation.errors.errors[
                                    key][0];
                                callback({
                                    status: 'error',
                                    form_data: props.form_data,
                                    error: newError,
                                    message: validation.errors.errors[
                                        key][0]
                                }, e);
                            } else {
                                callback({
                                    status: 'valid',
                                    form_data: props.form_data,
                                    error: newError,
                                    message: ''
                                }, e);
                            }
                        })
                    }, 100)
                    self.isPending(e.target.name, e.target.value)
                })
            })
        }
        let pendingTyping = null;
        let theTypingValue = null;


        inputTextValidation('#register_form', {
            form_rules: {
                company_name: 'required',
                address: 'required',
                person_in_charge_name: 'required',
                person_in_charge_phone: 'required',
                person_in_charge_email: 'required|email',
                password: 'required',
                confirm_password: 'required|same:password'
            },
            form_data: theTypingValue,
            element_target: 'input[type=text],input[type=number],input[type=email],input[type=password]'
        },
        function (res, e) {
            let form_data = theTypingValue;
            theTypingValue = _.merge(res.form_data, form_data);
            let parent = $(e.target).siblings('.error');
            switch (res.status) {
                case 'error':
                    return parent.css('display', 'block').text(res.message);
                case 'valid':
                case 'complete':
                    return parent.css('display', 'block').text('');
            }
        });

        $("#register_form").on("submit", function (e) {
            e.preventDefault();
            let self = $(this);
            submitValidation({
                form_rules: {
                    company_name: 'required',
                    address: 'required',
                    person_in_charge_name: 'required',
                    person_in_charge_phone: 'required',
                    person_in_charge_email: 'required|email',
                    password: 'required',
                    confirm_password: 'required|same:password'
                },
                form_data: theTypingValue,
            },
            function (res) {
                for (var key in res.error) {
                    var parent = $('input[name=' + key + ']');
                    parent.siblings('.error').css('display', 'block').text(res.error[key]);
                }
                for (var key in res.form_data) {
                    switch (true) {
                        case res.form_data[key] != "":
                            var parent = $('input[name=' + key + ']');
                            parent.siblings('.error').css('display', 'block').text('');
                            break;
                        default:
                            break;
                    }
                }

                if (res.status == 'complete') {
                    $(self).find('#submit_btn').css({
                        'opacity': 0.7,
                        'pointer-events': 'none'
                    });
                    $(self).find('#submit_btn i').attr('class', 'ion-load-c').css({
                        'font-size': '17px',
                        'animation': 'spin 1s infinite linear'
                    });

                    // Disini Ajax nya
                    var formData = $('#register_form').serializeArray();
                    var data = {};
                    $(formData).each(function (i, val) {
                        data[val.name] = val.value;
                    });
                    $.ajax({
                        method: "POST",
                        url: "<?php echo admin_url('admin-ajax.php')?>",
                        data: formData,
                    })
                    .done(function( msg ) {
                        $('#modal_success').modal('show');
                    })
                    .error(function (xhr, ajaxOptions, thrownError) {
                        alert ('Request failed: ' + thrownError) ;
                        console.log("Error nya ==> ",thrownError);
                    });
                }
            })
            return false;
        });

    });
</script>
