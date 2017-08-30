<?php

function chints_courses_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/chints-courses/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Courses</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=chints_courses_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "course";

        $rows = $wpdb->get_results("SELECT id,name,entry_price,mid_price,senior_price from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <!--<th class="manage-column ss-list-width">ID</th>-->
                <th class="manage-column ss-list-width">Course Name</th>
				<th class="manage-column ss-list-width">Entry Price (in USD ($))</th>
				<th class="manage-column ss-list-width">Mid Price (in USD ($))</th>
				<th class="manage-column ss-list-width">Senior Price (in USD ($))</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <!--<td class="manage-column ss-list-width"><?php echo $row->id; ?></td>-->
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->entry_price) > 0 ? $row->entry_price : 'NA' ) ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->mid_price) > 0 ? $row->mid_price : 'NA' ) ?></td>
					<td class="manage-column ss-list-width"><?php echo (($row->senior_price) > 0 ? $row->senior_price : 'NA' ) ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=chints_courses_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}