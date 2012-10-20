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
		
		//Query to insert given project
		$insert_proj = $DB->prepare('INSERT INTO '.DBNAME.'.projects (project_name,focus,image) VALUES (:project_name,:focus,:image)');
        $insert_proj->bindValue(":project_name"            ,$decoded["project_name"]);
        $insert_proj->bindValue(":focus"            ,$decoded["focus"]);
		$insert_proj->bindValue(":image"            ,$decoded["image"]);

		if(!$insert_proj->execute()) {
                print "<h1>FAILURE</h1>";
        } else {
                print "<h1>SUCCESS</h1>";
        }
		

		$p_id=$DB->lastInsertId();;
		
		$insert_field = $DB->prepare('INSERT INTO '.DBNAME.'.fields (field_name,for_key_p_id) VALUES (:field_name,'.$p_id.')');
		$insert_detail = $DB->prepare('INSERT INTO '.DBNAME.'.details (detail_name,for_key_f_id) VALUES (:detail_name,:f_id)');
		foreach ($decoded["fields"] as $field) {
			if($field!="") {
				$insert_field->bindValue(":field_name"            ,$field["field_name"]);
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
?>