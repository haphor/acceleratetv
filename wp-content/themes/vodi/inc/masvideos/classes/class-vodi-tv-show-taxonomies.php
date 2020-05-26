<?php
/**
 * Class to setup Taxonomies metabox customizations
 *
 * @package Vodi/MasVideos
 */

class Vodi_TV_Show_Taxonomies {

    public function __construct() {
        // Add options for TV Show Tag
        add_action( "tv_show_tag_add_form_fields",         array( $this, 'add_tv_show_tag_fields' ), 10 );
        add_action( "tv_show_tag_edit_form_fields",        array( $this, 'edit_tv_show_tag_fields' ), 10, 2 );
        add_action( 'create_tv_show_tag',                  array( $this, 'save_tv_show_tag_fields' ), 10, 3 );
        add_action( 'edited_tv_show_tag',                  array( $this, 'save_tv_show_tag_fields' ), 10, 3 );
    }

    /**
     * Loads WP Media Files
     *
     * @return void
     */
    public function load_wp_media_files() {
        wp_enqueue_media();
    }

    /**
     * TV_Show Tag metabox fields.
     *
     * @return void
     */
    public function add_tv_show_tag_fields() {
        ?>
        <div class="form-field">
            <label for="tv_show_tag_icon"><?php esc_html_e( 'Icon Class', 'vodi' ); ?></label>
            <input type="text" name="tv_show_tag_icon" id="tv_show_tag_icon" value autocomplete="off">
            <p class="description"><?php esc_html_e( 'This is alternative for font based icons','vodi' ); ?></p>
        </div>
        <?php
    }

    /**
     * Edit TV_Show Tag metabox fields.
     *
     * @param mixed $term Term (tv_show_tag) being edited
     */
    public function edit_tv_show_tag_fields( $term ) {
        $icon = get_term_meta( $term->term_id, 'icon', true );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="tv_show_tag_icon"><?php esc_html_e( 'Icon Class', 'vodi' ); ?></label></th>
            <td>
                <input type="text" name="tv_show_tag_icon" id="tv_show_tag_icon" value="<?php echo esc_attr( $icon ); ?>">
                <p class="description"><?php esc_html_e( 'This is alternative for font based icons','vodi' ); ?></p>
            </td>
        </tr>
        <?php
    }

    /**
     * Save TV_Show Tag metabox fields.
     *
     * @param mixed $term_id Term ID being saved
     * @return void
     */
    public function save_tv_show_tag_fields( $term_id ) {
        if ( isset( $_POST['tv_show_tag_icon'] ) ) {
            update_term_meta( $term_id, 'icon', $_POST['tv_show_tag_icon'] );
        }
    }
}

new Vodi_TV_Show_Taxonomies;