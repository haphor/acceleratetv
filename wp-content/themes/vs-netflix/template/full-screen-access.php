<?php
$create_account = get_option('rvs_create_account_page');
$rvs_redirect_page = get_option('rvs_redirect_page', $create_account);
$create_account_link = get_permalink($rvs_redirect_page);
$login_args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
	'form_id'        => 'vsform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => 'Username/Email',
	'label_password' => 'Password',
	'label_remember' => __( 'Remember Me', 'vs-netflix' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
);
?>

<div class="wpvs-login-form">
    <div class="wpvs-login-labels">
        <label class="wpvs-login-label border-box active" data-show="wpvs-signin"><?php _e('Sign In', 'vs-netflix'); ?></label>
        <label class="wpvs-login-label border-box" data-show="wpvs-create-account"><?php _e('Create Account', 'vs-netflix'); ?></label>
    </div>
    <div id="wpvs-signin" class="wpvs-login-section active">
        <?php echo rvs_check_login_errors(); ?>
        <?php wp_login_form($login_args); ?>
        <div id="vs-login-buttons">
            <a class="rvs-forgot-password" href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e('Forgot Password', 'vs-netflix'); ?>"><?php _e('Forgot Password', 'vs-netflix'); ?></a>
        </div>
    </div>
    <div id="wpvs-create-account" class="wpvs-login-section">
        <?php echo do_shortcode('[rvs_create_account]');?>
    </div>
</div>