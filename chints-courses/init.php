<?php
/*
Plugin Name: Best in class Courses
Description:
Version: 1.0.0
Author: Chints Solution
Author URI: http://chints.com
*/
// function to create the DB / Options / Defaults					
function ss_options_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . "course";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) CHARACTER SET utf8 NOT NULL,
			`description` TEXT NULL,
			`entry_price` INT(11) NOT NULL,
			`mid_price` INT(11) NOT NULL,
			`senior_price` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install');

//menu items
add_action('admin_menu','chints_courses_modifymenu');
function chints_courses_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Courses', //page title
	'Courses', //menu title
	'manage_options', //capabilities
	'chints_courses_list', //menu slug
	'chints_courses_list' //function
	);
	
	//this is a submenu
	add_submenu_page('chints_courses_list', //parent slug
	'Add New Course', //page title
	'Add New', //menu title
	'manage_options', //capability
	'chints_courses_create', //menu slug
	'chints_courses_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Course', //page title
	'Update', //menu title
	'manage_options', //capability
	'chints_courses_update', //menu slug
	'chints_courses_update'); //function
}

function online_form_course_fields_js($atts = []){
ob_start();
?>
<?php
global $wpdb;
$table_name = $wpdb->prefix . "course";

$rows = $wpdb->get_results("SELECT id,name,description,entry_price,mid_price,senior_price from $table_name");
foreach ($rows as $row) { ?>
	<input type="hidden" name="<?php echo $row->id."_1"; ?>" id="price_<?php echo $row->id."_1"; ?>" value="<?php echo (($row->entry_price) > 0 ? $row->entry_price : 'NA' ) ?>" />
	<input type="hidden" name="<?php echo $row->id."_2"; ?>" id="price_<?php echo $row->id."_2"; ?>" value="<?php echo (($row->mid_price) > 0 ? $row->mid_price : 'NA' ) ?>" />
	<input type="hidden" name="<?php echo $row->id."_3"; ?>" id="price_<?php echo $row->id."_3"; ?>" value="<?php echo (($row->senior_price) > 0 ? $row->senior_price : 'NA' ) ?>" />
<?php } 

$courses_data = json_encode($wpdb->get_results("SELECT id,name from $table_name"));
?>
<script>
jQuery(document).ready(function(){
	var price_field = '<?php echo $atts['price'] ?>';
	var course_field = '<?php echo $atts['course'] ?>';
	var type_field = '<?php echo $atts['type'] ?>';
	
	// for disabling price_field
	jQuery('#'+price_field).attr('readonly', '1');
	
	// for adding dynamic courses options
	var newOptions = <?php echo $courses_data ?> 
	var $el = jQuery('#'+course_field);
	$el.empty(); // remove old options
	jQuery.each(newOptions, function(key,value) {
	  $el.append(jQuery("<option></option>")
		 .attr("value", value.name).attr("data-value", value.id).text(value.name));
	});
	
	// for adding dynamic type options
	var newTypeOptions = {"1": "Entry Level (0-3 years)",
	  "2": "Mid Level (3.1-10 years)",
	  "3": "Senior Level (10 years & above)"
	};
	var $el = jQuery('#'+type_field);
	$el.empty(); // remove old options
	jQuery.each(newTypeOptions, function(key,value) {
	  $el.append(jQuery("<option></option>")
		 .attr("value", value).attr("data-value", key).text(value));
	});
	
	// for getting actual course price on change of course 
	jQuery('#'+course_field).change(function(){
		var courseId = jQuery('option:selected', this).attr('data-value');
		var typeId = jQuery('option:selected', '#'+type_field).attr('data-value');
		var courseFinalPrice = jQuery("#price_"+courseId+"_"+typeId).val();
		jQuery('#'+price_field).val(courseFinalPrice);
	});
	
	// for getting actual course price on change of course level
	jQuery('#'+type_field).change(function(){
		var courseId = jQuery('option:selected', '#'+course_field).attr('data-value');
		var typeId = jQuery('option:selected', this).attr('data-value');
		var courseFinalPrice = jQuery("#price_"+courseId+"_"+typeId).val();
		jQuery('#'+price_field).val(courseFinalPrice);
	});
})
</script>
<?php
return ob_get_clean();
}
add_shortcode('online_form_course_fields', 'online_form_course_fields_js');

function service_pricing_table_html(){
ob_start();
?>
<?php
        global $wpdb;
        $table_name = $wpdb->prefix . "course";

        $rows = $wpdb->get_results("SELECT id,name,description,entry_price,mid_price,senior_price from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <!--<th class="manage-column ss-list-width">ID</th>-->
                <th class="manage-column ss-list-width">Experience /Level Services</th>
				<th class="manage-column ss-list-width">Entry Level (0-3 years) USD ($)</th>
				<th class="manage-column ss-list-width">Mid Level (3.1-10 years) USD ($)</th>
				<th class="manage-column ss-list-width">Senior Level (10 years & above) USD ($)</th>
                <th class="manage-column ss-list-width">Product Description</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <!--<td class="manage-column ss-list-width"><?php echo $row->id; ?></td>-->
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->entry_price) > 0 ? $row->entry_price : 'NA' ) ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->mid_price) > 0 ? $row->mid_price : 'NA' ) ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->senior_price) > 0 ? $row->senior_price : 'NA' ) ?></td>
					<td class="manage-column ss-list-width"><?php echo $row->description; ?></td>
				</tr>
            <?php } ?>
        </table>
<?php
return ob_get_clean();
}
add_shortcode('service_pricing_table', 'service_pricing_table_html');


define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'courses-list.php');
require_once(ROOTDIR . 'courses-create.php');
require_once(ROOTDIR . 'courses-update.php');
