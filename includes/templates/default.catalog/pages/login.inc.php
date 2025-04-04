<div class="fourteen-forty">
    <main id="content">
        {snippet:notices}
        {snippet:breadcrumbs}

        <div class="row">
            <div id="box-login" class="card col-sm-6 col-md-4">

                <div class="card-header">
                    <h2 class="card-title"><?php echo language::translate('title_sign_in', 'Sign In'); ?></h2>
                </div>

                <div class="card-body">

                    <?php echo functions::form_draw_form_begin('login_form', 'post', document::ilink('login'), false, 'style="max-width: 480px;"'); ?>
                    <?php echo functions::form_draw_hidden_field('redirect_url', true); ?>

                    <div class="form-group">
                        <?php echo functions::form_draw_email_field('email', true, 'required autofocus placeholder="' . language::translate('title_email_address', 'Email Address') . '" autocomplete="email"'); ?>
                    </div>

                    <div class="form-group">
                        <?php echo functions::form_draw_password_field('password', '', 'required placeholder="' . language::translate('title_password', 'Password') . '" autocomplete="current-password"'); ?>
                    </div>

                    <div class="checkbox">
                        <label><?php echo functions::form_draw_checkbox('remember_me', '1'); ?> <?php echo language::translate('title_remember_me', 'Remember Me'); ?></label>
                    </div>

                    <p>
                        <?php echo functions::form_draw_button('login', language::translate('title_sign_in', 'Sign In')); ?>
                    </p>

                    <p>
                        <a href="<?php echo document::ilink('reset_password', ['email' => !empty($_POST['email']) ? $_POST['email'] : '']); ?>"><?php echo language::translate('text_lost_your_password', 'Lost your password?'); ?></a>
                    </p>

                    <?php echo functions::form_draw_form_end(); ?>
                </div>
            </div>

            <div id="box-login-create" class="card col-sm-6 col-md-8">

                <div class="card-header">
                    <h2 class="card-title"><?php echo language::translate('title_create_an_account', 'Create an Account'); ?></h2>
                </div>

                <div class="card-body">

                    <ul>
                        <li><?php echo language::translate('description_get_access_to_all_order_history', 'Get access to all your order history.'); ?></li>
                        <li><?php echo language::translate('description_save_your_cart_items', 'Save your shopping cart for a later visit.'); ?></li>
                        <li><?php echo language::translate('description_access_your_cart_simultaneously', 'Access your shopping cart from different computers. Even simultaneously!'); ?></li>
                        <li><?php echo language::translate('description_faster_checkout_with_prefilled_details', 'Faster checkout with prefilled customer details.'); ?></li>
                        <li><?php echo language::translate('description_receive_new_offers', 'Receive information about new offers and great deals.'); ?></li>
                    </ul>

                    <p>
                        <a class="btn btn-default" href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('title_register_now', 'Register Now'); ?></a>
                    <p>
                </div>
            </div>

        </div>
    </main>
</div>