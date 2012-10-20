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
		//print_r($projects);	
		
		$build_array = array();
		foreach($projects as $project) {
			$temp = array("project_name"=>$project["project_name"],"focus"=>$project["focus"],"image_url"=>$project["image_url"],"image_style"=>$project["image_style"],"fields"=>array());
			//print_r($temp);
			$build_array[] = $temp;
			$select_field->bindValue(":p_id"                  ,$project["p_id"]);
			
			if(!$select_field->execute()) {
                print "<h1>FAILURE</h1>";
			} else {
				print "<h1>SUCCESS</h1>";
			}
		
			$fields = $select_field->fetchAll();
			$last_proj = $temp;
			foreach($fields as $field) {
				$temp = array("field_name"=>$field["field_name"],"details"=>array());
				array_push($last_proj["fields"], $temp);

				$select_detail->bindValue(":f_id"                  ,$field["f_id"]);
				
				if(!$select_detail->execute()) {
					print "<h1>FAILURE</h1>";
				} else {
					print "<h1>SUCCESS</h1>";
				}
			
				$details = $select_detail->fetchAll();
				print_r($details[0]);
				$last_field = $temp;
				foreach($details[0] as $detail) {
					array_push($last_field["details"], $detail["detail_name"]);
				}
				
			}
		}
		$encode=json_encode($build_array);
		print($encode);
		
?>