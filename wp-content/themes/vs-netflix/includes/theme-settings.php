<div class="wrap">
    <?php include('admin-menu.php'); ?>
    <div class="vimeosync">
        <div class="rvsPadding">
        <?php if(wpvs_this_theme_is_active()) { ?>
        <div class="net-theme-settings">
            <h3><?php _e('Theme Styling', 'vs-netflix'); ?></h3>
            <p><?php _e('Use the WordPress Customizer to change theme styling.', 'vs-netflix'); ?></p>
            <p><?php _e('Options for <strong>Single Video Pages</strong>, <strong>Video Browsing Pages</strong>, <strong>Horizontal Sliders</strong>, etc. can be found in the WordPress Customizer.', 'vs-netflix'); ?></p>
            <a id="vs-netflix-customize-button" class="rvs-button" href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customize My Theme', 'vs-netflix'); ?></a>
        </div>
        <?php } else {
            get_template_part('template/missing-license');
        } ?>
        </div>
    </div>
</div>