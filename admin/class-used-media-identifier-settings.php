<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.glorywebs.com
 * @since      1.0.0
 *
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/admin
 * @author     Glorywebs <ravi@glorywebsdev.com>
 */
class Used_Media_Identifier_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
        
        public function general_admin_notice(){
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/media_labels';
            
            if (! is_dir($upload_dir)) {
                $notice = __('Please make sure below folder exist and it has write permission. <br /><br /> '.$upload_dir);
                echo '<div class="notice notice-warning is-dismissible">
                    <p><strong>'.$notice.'</strong></p>
                </div>';
                die;
            }
        }

	public function media_file_admin_menu() {
            add_options_page(
                __('Media Identifier Settings', $this->plugin_name),
                __('Media Identifier Settings', $this->plugin_name),
                'manage_options',
                'media-identifier-settings',
                array(
                    $this,
                    'media_file_settings_page'
                )
            );
	}
        
        public function media_file_settings_page(){
            // display notice if media_labels folder not existed in uploads folder
            $this->general_admin_notice();
            
            // code for settings page
            
            $post_types = get_post_types();
            $upload = wp_upload_dir();
            $mediafileurl = $upload['baseurl']. '/media_labels/';
            $upload_dir = $upload['basedir']. '/media_labels/';
            $medialabelOptGet = get_option('media_file_label_images');
            if(isset($_POST['submit']) && $_POST['submit']!=""){
                $updateOpt = array();
                foreach($post_types as $posttype){
                    if(isset($_FILES["media_label"]["tmp_name"][$posttype]) && $_FILES["media_label"]["tmp_name"][$posttype]!=""){
                        $checkImg = getimagesize($_FILES["media_label"]["tmp_name"][$posttype]);
                        $uploadto = $upload_dir.$_FILES["media_label"]["name"][$posttype];
                        if($checkImg !== false) {
                            if (move_uploaded_file($_FILES["media_label"]["tmp_name"][$posttype], $uploadto)){
                                $msg = __('File uploaded successfully.', $this->plugin_name);
                                $notice = "notice-success";
                                $updateOpt[$posttype] = $_FILES["media_label"]["name"][$posttype];
                            }else{
                                $msg = __('Error uploading file', $this->plugin_name);
                                $notice = "notice-error";
                            }
                        } else {
                            $msg = __('File is not an image.', $this->plugin_name);
                            $notice = "notice-error";
                            $uploadOk = 0;
                        }
                    }else{
                        if (filter_var($_POST['prevlabel'][$posttype], FILTER_VALIDATE_URL) === FALSE) {
                            if($_POST['removelabel'][$posttype] != '1'){
                                $updateOpt[$posttype] = $_POST['prevlabel'][$posttype];
                            }else{
                                $msg = __('Image removed successfully.', $this->plugin_name);
                                $notice = "notice-success";
                            }
                        }
                    }
                }
                if($notice){
                    echo '<div class="notice '.$notice.' is-dismissible"><p>'.$msg.'</p></div>';
                }
                $medialabelOptSet = update_option('media_file_label_images',$updateOpt);
                update_option('hide_label_on_image',wp_unslash($_POST['hideonmedia']));
            }
            $medialabelOptGet = get_option('media_file_label_images');
            $hideOptGet = get_option('hide_label_on_image');
            $default = trailingslashit(plugin_dir_url('')).$this->plugin_name.'/images/badge.png';
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo _e('Media image label',$this->plugin_name)?></h1>
    <form name="media_file_label" id="media_file_label_settings" method="post" enctype="multipart/form-data" action="">
        <table class="wp-list-table widefat fixed striped posts" cellspacing="5" cellpadding="5">
            <thead>
                <tr>
                    <th><strong><?php echo _e('Post Type',$this->plugin_name); ?></strong></th>
                    <th><strong><?php echo _e('Icon',$this->plugin_name); ?></strong></th>
                    <th><strong><?php echo _e('Select Icon',$this->plugin_name); ?></strong></th>
                    <th><input type="checkbox" name="hideon" id="hideon" />&nbsp;<strong><?php echo _e('Hide label',$this->plugin_name); ?></strong></th>
                    <th><input type="checkbox" name="checkall" id="checkall" />&nbsp;<strong><?php echo _e('Remove Image',$this->plugin_name); ?></strong></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ( get_post_types( '', 'names' ) as $post_type ) { 
                $previmage = $labelimg = $default;
                if(is_array($medialabelOptGet) && in_array($post_type, array_keys($medialabelOptGet))){
                    $labelimg = $mediafileurl.$medialabelOptGet[$post_type];
                    $previmage = $medialabelOptGet[$post_type];
                }
                $checked = '';
                if(isset($hideOptGet[$post_type]) && $hideOptGet[$post_type]==1){
                    $checked = 'checked="checked"';
                }
            ?>
            <tr>
                <th scope="row"><?php echo $post_type; ?></th>
                <td><img src="<?php echo $labelimg; ?>" width="70" height="70" alt="<?php $post_type; ?>" /></td>
                <td><input type="file" name="media_label[<?php echo $post_type;?>]" value="Change image" /></td>
                <td><input type="checkbox" class="hideonmedia" name="hideonmedia[<?php echo $post_type;?>]" <?php echo $checked;?> value="1" /></td>
                <td><input type="checkbox" class="removelabel" name="removelabel[<?php echo $post_type;?>]" value="1" />
                    <input type="hidden" name="prevlabel[<?php echo $post_type;?>]" value="<?php echo $previmage; ?>" />
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="tablenav bottom">
        <input name="submit" id="submit" class="button button-primary" value="<?php echo __('Save Changes', $this->plugin_name)?>" type="submit">
        </div>
    </form>
</div>
<?php   
        }
}
