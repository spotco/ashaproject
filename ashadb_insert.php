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
        // check authentication
        $auth = isset($_SERVER["AUTH_TYPE"]) && $_SERVER["AUTH_TYPE"] == "UWNetID" && isset($_SERVER["PHP_AUTH_USER"]);
        
		$json = $_POST["output"];
		
		$decoded = json_decode($json,true);
		
		
		//Query to insert given project
		$insert_proj = $DB->prepare('INSERT INTO '.DBNAME.'.projects (name,focus,image) VALUES (:name,:focus,:image)');
        $insert_proj->bindValue(":name"            ,$decoded["project_name"]);
        $insert_proj->bindValue(":focus"            ,$decoded["focus"]);
		$insert_proj->bindValue(":image"            ,$decoded["image"]);
		if(!$insert_proj->execute()) {
                print "<h1>FAILURE</h1>";
        } else {
                print "<h1>SUCCESS</h1>";
        }
		
		$query_proj = $DB->prepare('Select id from '.DBNAME.'.projects where name=:name and focus=:focus');
		$query_proj->bindValue(":name"            ,$decoded["project_name"]);
        $query_proj->bindValue(":focus"            ,$decoded["focus"]);
		$query_proj->execute();
		$proj_row = $query_proj->fetch(PDO::FETCH_ASSOC);
		$p_id=$proj_row[id];
		
		$insert_head = $DB->prepare('INSERT INTO '.DBNAME.'.headers (name,p_id) VALUES (:name,'.$p_id.')');
		$insert_bull = $DB->prepare('INSERT INTO '.DBNAME.'.bullets (name,h_id) VALUES (:name,:h_id)');
		foreach ($decoded["fields"] as $field) {
			
			$insert_head->bindValue(":name"            ,$field["name"]);
			if(!$insert_head->execute()) {
					print "<h1>FAILURE</h1>";
			} else {
					print "<h1>SUCCESS</h1>";
			}
			
			$query_head = $DB->prepare('Select h_id from '.DBNAME.'.headers where name=:name and p_id=:p_id');
			$query_head->bindValue(":name"            ,$field["name"]);
			$query_head->bindValue(":p_id"            ,$p_id);
			$query_head->execute();
			$head_row = $query_head->fetch(PDO::FETCH_ASSOC);
			$h_id=$head_row[h_id];
			
			
			foreach ($field["details"] as $detail) {
				
				$insert_bull->bindValue(":name"            ,$detail);
				$insert_bull->bindValue(":h_id"            ,$h_id);
				if(!$insert_bull->execute()) {
						print "<h1>FAILURE</h1>";
				} else {
						print "<h1>SUCCESS</h1>";
				}
			}
		}
?>