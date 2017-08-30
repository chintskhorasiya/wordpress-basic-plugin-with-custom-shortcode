<?php

function chints_courses_create() {
    $id = $_POST["id"];
    $name = $_POST["name"];
	$description = $_POST["description"];
	//$type = $_POST["type"];
	$entry_price = $_POST["entry_price"];
	$mid_price = $_POST["mid_price"];
	$senior_price = $_POST["senior_price"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "course";
		
		if(/*!empty($id) &&*/ !empty($name) /*&& !empty($entry_price) && !empty($mid_price) && !empty($senior_price)*/){
			
			$wpdb->insert(
					$table_name, //table
					array(/*'id' => $id, */'name' => $name, 'description' => $description, 'entry_price' => $entry_price, 'mid_price' => $mid_price, 'senior_price' => $senior_price), //data
					array(/*'%s',*/'%s', '%s', '%s', '%s', '%s') //data format			
			);
			$message.="Course inserted";
		
		} else {
			
			/*if(empty($id)){
				$error .= "Please enter id<br>";
			}*/
			
			if(empty($name)){
				$error .= "Please enter Course Name<br>";
			}
			
			/*if(empty($type)){
				$error .= "Please select Type<br>";
			}*/
			
			/*if(empty($entry_price)){
				$error .= "Please enter Entry Level Price<br>";
			}
			
			if(empty($mid_price)){
				$error .= "Please enter Mid Level Price<br>";
			}
			
			if(empty($senior_price)){
				$error .= "Please enter Senior Level Price<br>";
			}*/
			
		}

    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/chints-courses/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Course</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
		<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <!--<tr>
                    <th class="ss-th-width">ID</th>
                    <td><input type="text" name="id" value="<?php echo $id; ?>" class="required ss-field-width" /></td>
                </tr>-->
                <tr>
                    <th class="ss-th-width">Course</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="required ss-field-width" /></td>
                </tr>
				
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
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
    </div>
    <?php
}