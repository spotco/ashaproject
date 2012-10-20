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
        
		
		
		//Query to insert given project
		$select_proj = $DB->prepare('SELECT * from details join fields on f_id=for_key_f_id join projects on p_id=for_key_p_id ORDER BY project_name asc, p_id, field_name, f_id, detail_name, d_id');

		if(!$select_proj->execute()) {
                print "<h1>FAILURE</h1>";
        } else {
                print "<h1>SUCCESS</h1>";
        }
		
		$result = $DB->fetchAll();
		
		$last_proj = 0;
		$last_field = 0;
		$build_array = array();
		foreach($result as $row) {
			if($last_proj!=$row["p_id"]) {
				$build_array[] = array("project_name"=>$row["project_name"],"focus"=>$row["focus"],"image_url"=>$row["image_url"],"img_style"=>$row["img_style"],"fields"=>array());
				$last_proj = $row["p_id"];
			}
			
			if($last_field!=$row["f_id"]) {
				end(end($build_array))[]=array("field_name"=>$row["field_name"],"details"=>array());
				$build_array["fields"]["field_name"] = $row["field_name"];
				$last_field = $row["f_id"];
			}
			end(end(end(end($build_array))))=array("detail_name"=>$row["detail_name"]);
		}
		$encode=json_encode($build_array);
		print($encode);
		
?>