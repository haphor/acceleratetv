<?php $vs_screen = $_GET['page']; $wpvs_theme_updates = get_option('wpvs-theme-updates-seen'); ?>

<label id="rvs-dropdown-menu" for="rvs-menu-checkbox"><span class="dashicons dashicons-menu"></span> Menu</label>
<div id="rvs-admin-menu" class="border-box">
    <a href="<?php echo admin_url('admin.php?page=net-theme-settings'); ?>" title="API Keys" class="rvs-tab <?=($vs_screen == "net-theme-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-star-filled"></span> <?php _e('Theme Styling', 'vs-netflix'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=net-google-tracking'); ?>" title="Google Tracking" class="rvs-tab <?=($vs_screen == "net-google-tracking") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-chart-line"></span> <?php _e('Google Tracking', 'vs-netflix'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=net-social-options'); ?>" title="Social Media" class="rvs-tab <?=($vs_screen == "net-social-options") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-share"></span> <?php _e('Social Media', 'vs-netflix'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=net-shortcodes'); ?>" title="Shortcodes" class="rvs-tab <?=($vs_screen == "net-shortcodes") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-editor-code"></span> <?php _e('Shortcodes', 'vs-netflix'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-theme-updates'); ?>" title="Updates" class="rvs-tab <?=($vs_screen == "wpvs-theme-updates") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-update"></span> <?php _e('Updates', 'vs-netflix'); ?><?=(!$wpvs_theme_updates) ? '<span class="dashicons dashicons-warning wpvs-update-needed"></span>' : ''?></a>
</div>