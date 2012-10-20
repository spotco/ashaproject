<?php  
/*This file takes input from submit and stores it into the database, with SQL injection protection*/

	include('db_connect.php');
        
		$json = $_POST["output"]; //take the JSON data to be stored
		
		$decoded = json_decode($json,true); //turn into PHP data
		print_r($decoded);

		//Query to insert given project
		$insert_proj = $DB->prepare('INSERT INTO '.DBNAME.'.projects (project_name,focus,image_url,image_style,video) VALUES (:project_name,:focus,:img_url, :img_style, :video)');
       	$insert_proj->bindValue(":project_name"            ,$decoded["project_name"]);
      		$insert_proj->bindValue(":focus"            ,$decoded["focus"]);
		$insert_proj->bindValue(":img_url"            ,$decoded["img_url"]);
		$insert_proj->bindValue(":img_style"            ,$decoded["img_style"]);
		$insert_proj->bindValue(":video"            ,$decoded["video"]);

		if(!$insert_proj->execute()) {
                print "<h1>Query could not store to database</h1>";
        }
		

		$p_id=$DB->lastInsertId(); //get the last id to map it to foreign keys
		
		//prepare two statements for fields and details outside of the loops to reduce overhead
		$insert_field = $DB->prepare('INSERT INTO '.DBNAME.'.fields (field_name,for_key_p_id) VALUES (:field_name, :p_id)');
		$insert_detail = $DB->prepare('INSERT INTO '.DBNAME.'.details (detail_name,for_key_f_id) VALUES (:detail_name,:f_id)');

		//loop through each field item, storing it and associated details
		foreach ($decoded["fields"] as $field) {
			if($field!="") {
				$insert_field->bindValue(":field_name"            ,$field["field_name"]);
				$insert_field->bindValue(":p_id"            ,$p_id);
				if(!$insert_field->execute()) {
						print "<h1>FAILURE</h1>";
				} else {
						print "<h1>SUCCESS</h1>";
				}
				

				$f_id=$DB->lastInsertId();;
				
				//loop through details and store them
				foreach ($field["details"] as $detail) {
					if($detail!="") {
						$insert_detail->bindValue(":detail_name"            ,$detail);
						$insert_detail->bindValue(":f_id"            ,$f_id);
						if(!$insert_detail->execute()) {
								print "<h1>FAILURE</h1>";
						} else {
								print "<h1>SUCCESS</h1>";
						}
					}
				}
			}
		}
		

?>