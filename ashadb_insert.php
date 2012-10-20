<?php   $SERVER = "localhost";
        $USER = "spotco_sql";
        $PASSWORD = "dododo";
        $DBNAME = "spotco_ashaproject";
        define("DBNAME", $DBNAME, true);
		
        try {
                $DB = new PDO("mysql:dbname=$DBNAME;host=$SERVER", $USER, $PASSWORD);
        } catch (PDOException $err) {
                die("Connection to database failed: ".$err->getMessage());
        }
        
		$json = $_POST["output"];
		
		$decoded = json_decode($json,true);
		print_r($decoded);
		//Query to insert given project
		$insert_proj = $DB->prepare('INSERT INTO '.DBNAME.'.projects (project_name,focus,image_url,image_style) VALUES (:project_name,:focus,:image_url, :image_style)');
        $insert_proj->bindValue(":project_name"            ,$decoded["project_name"]);
        $insert_proj->bindValue(":focus"            ,$decoded["focus"]);
		$insert_proj->bindValue(":image_url"            ,$decoded["image_url"]);
		$insert_proj->bindValue(":image_style"            ,$decoded["image_style"]);

		if(!$insert_proj->execute()) {
                print "<h1>FAILURE</h1>";
        } else {
                print "<h1>SUCCESS</h1>";
        }
		

		$p_id=$DB->lastInsertId();;
		
		$insert_field = $DB->prepare('INSERT INTO '.DBNAME.'.fields (field_name,for_key_p_id) VALUES (:field_name, :p_id)');
		$insert_detail = $DB->prepare('INSERT INTO '.DBNAME.'.details (detail_name,for_key_f_id) VALUES (:detail_name,:f_id)');
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
		
		$select_proj = $DB->prepare('SELECT * from projects order by project_name');
		$select_field = $DB->prepare('SELECT * from fields join projects on p_id=for_key_p_id where for_key_p_id=:p_id order by field_name');
		$select_detail = $DB->prepare('SELECT * from details join fields on f_id=for_key_f_id where for_key_f_id=:f_id order by detail_name');
		//details join fields on f_id=for_key_f_id join projects on p_id=for_key_p_id ORDER BY project_name asc, p_id, field_name, f_id, detail_name, d_id');

		if(!$select_proj->execute()) {
                print "<h1>FAILURE</h1>";
        } else {
                print "<h1>SUCCESS</h1>";
        }
		
		$projects = $select_proj->fetchAll();
		
		
		$build_array = array();
		foreach($projects as $project) {
			$build_array[] = array("project_name"=>$row["project_name"],"focus"=>$row["focus"],"image_url"=>$row["image_url"],"img_style"=>$row["img_style"],"fields"=>array());

			$select_field->bindValue(":p_id"                  ,$row["p_id"]);
			
			if(!$select_field->execute()) {
                print "<h1>FAILURE</h1>";
			} else {
				print "<h1>SUCCESS</h1>";
			}
		
			$fields = $select_field->fetchAll();
			$last_proj = end($build_array);
			foreach($fields as $field) {
				
				array_push($last_proj["fields"], array("field_name"=>$row["field_name"],"details"=>array()));

				$select_detail->bindValue(":f_id"                  ,$row["f_id"]);
				
				if(!$select_details->execute()) {
					print "<h1>FAILURE</h1>";
				} else {
					print "<h1>SUCCESS</h1>";
				}
			
				$details = $select_field->fetchAll();
				$last_field = end($last_proj["fields"]);
				foreach($details as $detail) {
					array_push($last_field["details"], "detail_name"=>$row["detail_name"]);
				}
				
			}
		}
		$encode=json_encode($build_array);
		print($encode);
?>