<?php

function chints_courses_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "course";
    $id = $_GET["id"];
    $name = $_POST["name"];
	$description = $_POST["description"];
	//$type = $_POST["type"];
	$entry_price = $_POST["entry_price"];
	$mid_price = $_POST["mid_price"];
	$senior_price = $_POST["senior_price"];
//update
    if (isset($_POST['update'])) {
        
		if(!empty($name) /*&& !empty($type) && !empty($price)*/){
			
			$wpdb->update(
					$table_name, //table
					array('name' => $name, 'description' => $description, 'entry_price' => $entry_price, 'mid_price' => $mid_price, 'senior_price' => $senior_price), //data
					array('ID' => $id), //where
					array('%s', '%s', '%s', '%s', '%s'), //data format
					array('%s') //where format
			);
		
		} else {
			
			if(empty($name)){
				$error .= "Please enter Name<br>";
			}
			
			/*if(empty($type)){
				$error .= "Please select Type<br>";
			}
			
			if(empty($price)){
				$error .= "Please enter Price<br>";
			}*/
			
		}
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $courses = $wpdb->get_results($wpdb->prepare("SELECT id,name,description,entry_price,mid_price,senior_price from $table_name where id=%s", $id));
        foreach ($courses as $s) {
            $name = $s->name;
			$description = $s->description;
			$entry_price = (($s->entry_price) > 0 ? $s->entry_price : '' );
			$mid_price = (($s->mid_price) > 0 ? $s->mid_price : '' );
			$senior_price = (($s->senior_price) > 0 ? $s->senior_price : '' );
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/chints-courses/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Courses</h2>
		
		<?php if ($_POST['delete'] && !isset($error)) { ?>
            <div class="updated"><p>Course deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=chints_courses_list') ?>">&laquo; Back to courses list</a>

        <?php } else if ($_POST['update'] && !isset($error)) { ?>
            <div class="updated"><p>Course updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=chints_courses_list') ?>">&laquo; Back to courses list</a>

        <?php } else { ?>
		
			<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>
			
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Name</th><td><input type="text" name="name" value="<?php echo $name; ?>"/></td></tr>
					
					<tr>
						<th class="ss-th-width">Course Description</th>
						<td><textarea name="description" rows="5" cols="60"><?php echo $description; ?></textarea></td>
					</tr>
                
					<!--<tr>
                    <th class="ss-th-width">Course Type</th>
						<td>
							<select name="type">
								<option value="">Select Course Type</option>
								<option <?php if($type == 'Entry Level') echo 'selected="selected"'; ?> value="Entry Level">Entry Level</option>
								<option <?php if($type == 'Mid Level') echo 'selected="selected"'; ?> value="Mid Level">Mid Level</option>
								<option <?php if($type == 'Senior Level') echo 'selected="selected"'; ?> value="Senior Level">Senior Level</option>
							</select>
						</td>
					</tr>-->
					
					<tr>
						<th class="ss-th-width">Course Entry Level Price</th>
						<td><input type="number" name="entry_price" min="1" max="9999999" value="<?php echo $entry_price; ?>" class="required ss-field-width" /></td>
					</tr>
					
					<tr>
						<th class="ss-th-width">Course Mid Level Price</th>
						<td><input type="number" name="mid_price" min="1" max="9999999" value="<?php echo $mid_price; ?>" class="required ss-field-width" /></td>
					</tr>
					
					<tr>
						<th class="ss-th-width">Course Senior Level Price</th>
						<td><input type="number" name="senior_price" min="1" max="9999999" value="<?php echo $senior_price; ?>" class="required ss-field-width" /></td>
					</tr>
				</table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
            </form>
        <?php } ?>

    </div>
    <?php
}