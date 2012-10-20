<?php   

function delete_data($p_id) {
		$SERVER = "localhost";
        $USER = "spotco_sql";
        $PASSWORD = "dododo";
        $DBNAME = "spotco_ashaproject";
        define("DBNAME", $DBNAME, true);
		
        try {
                $DB = new PDO("mysql:dbname=$DBNAME;host=$SERVER", $USER, $PASSWORD);
        } catch (PDOException $err) {
                die("Connection to database failed: ".$err->getMessage());
        }
        
		$delete_proj = $DB->prepare('delete from projects where p_id = :p_id');
		$select_field = $DB->prepare('select * from fields  where for_key_p_id=:p_id');
		$delete_field = $DB->prepare('delete from fields  where for_key_p_id=:p_id');

		$delete_detail = $DB->prepare('delete from details where for_key_f_id=:f_id');
		
		$delete_proj->bindValue(":p_id"                  ,$p_id);

		
		
		$delete_field->bindValue(":p_id"                  ,$p_id);
		$select_field->bindValue(":p_id"                  ,$p_id);
		
		if(!$select_field->execute()) {
			return false;
		}
		$fields = $select_field->fetchAll();
		

		
		foreach($fields as $field) {
			$delete_detail->bindValue(":f_id"                  ,$field["f_id"]);
			
			if(!$delete_detail->execute()) {
				return false;
			}
		
			
		}
			
		if(!$delete_field->execute()) {
			return false;
		}
		
		if(!$delete_proj->execute()) {
            return false;
        }
		
		return true;
		}
		delete_data(24);
		delete_data(26);

?>