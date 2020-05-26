<div class="wrap">
    <?php include('admin-menu.php'); ?>
    <div class="vimeosync">
        <div class="rvsPadding">
        <?php if(wpvs_this_theme_is_active()) { ?>
            <div class="net-theme-settings">
                <form method="post" action="options.php">
                    <?php settings_fields( 'net-theme-tracking' ); 
                        $google_tracking = get_option('google-tracking');
                        if( ! isset($google_tracking['meta-tag']) ) {
                            $google_tracking['meta-tag'] = "";
                        }
                        if( ! isset($google_tracking['analytics-id']) ) {
                            $google_tracking['analytics-id'] = "";
                        }
                        if( ! isset($google_tracking['tag-manager-id']) ) {
                            $google_tracking['tag-manager-id'] = "";
                        }
                        if( ! isset($google_tracking['cookie-notice']) ) {
                            $google_tracking['cookie-notice'] = 0;
                        }
                    ?>
                    <h3><?php _e('Google Tracking', 'vs-netflix'); ?></h3>
                    
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label><?php _e('Site Verification (Meta Tag)', 'vs-netflix'); ?></label></th>
                                <td>
                                    <input class="regular-text" id="google-tracking[meta-tag]" name="google-tracking[meta-tag]" type="text" value="<?php echo esc_attr( $google_tracking['meta-tag'] ); ?>" placeholder="23mag234dvIC5dv6J1Yadf220vnJIw" />
                                    <p class="description"><strong><?php _e('Meta tag', 'vs-netflix'); ?>:</strong> <?php _e('Paste the content section of the meta tag only', 'vs-netflix'); ?>. <span class="net-instructions">&lt;<?php _e('meta name="google-site-verification" content="', 'vs-netflix'); ?><strong><?php _e('PASTE PART THIS ONLY', 'vs-netflix'); ?></strong>" /&gt;</span></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php _e('Google Analytics ID', 'vs-netflix'); ?>:</label></th>
                                <td><input class="regular-text" id="google-tracking[analytics-id]" name="google-tracking[analytics-id]" type="text" value="<?php echo esc_attr( $google_tracking['analytics-id'] ); ?>" placeholder="UA-00000000-1"/></td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label><?php _e('Google Tag Manager ID', 'vs-netflix'); ?>:</label></th>
                                <td><input class="regular-text" id="google-tracking[tag-manager-id]" name="google-tracking[tag-manager-id]" type="text" value="<?php echo esc_attr( $google_tracking['tag-manager-id'] ); ?>" placeholder="GTM-XXXXXXX"/></td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label><?php _e('Cookie Notice Integration', 'vs-netflix'); ?>:</label></th>
                                <td>
                                    <input id="google-tracking[cookie-notice]" name="google-tracking[cookie-notice]" type="checkbox" value="1" <?php checked(1, $google_tracking['cookie-notice']); ?> />
                                    <label><?php echo sprintf(__('If you are using the %s plugin, this we recommend enabling this option', 'vs-netflix'), '<a href="https://en-ca.wordpress.org/plugins/cookie-notice/" target="_blank">Cookie Notice</a>'); ?>.</label>
                                </td>
                            </tr>

                       </tbody>
                    </table>

                <?php submit_button(); ?>
                </form>
            </div>
            <?php } else {
                get_template_part('template/missing-license');
            } ?>
        </div>
    </div>
</div>