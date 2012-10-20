<?php
//delete from projects;delete from fields; delete from details;

$SERVER = "localhost";
$USER = "spotco_sql";
$PASSWORD = "dododo";
$DBNAME = "spotco_ashaproject";
$DB = new PDO("mysql:dbname=$DBNAME;host=$SERVER", $USER, $PASSWORD);
$select_proj = $DB->prepare('SELECT * from projects');
$select_proj->execute();
$projects = $select_proj->fetchAll();

$projects_o = array();

foreach ($projects as $projects_array_index => $project) {
	$project_name = $project["project_name"];
	$focus = $project["focus"];
	$img_url = $project["image_url"];
	$img_style = $project["image_style"];
	$date = $project["date"];

	$project_o = array();
	$project_o["project_name"] = $project_name;
	$project_o["focus"] = $focus;
	$project_o["img_url"] = $img_url;
	$project_o["img_style"] = $img_style;
	$project_o["date"] = $date;
	$project_o_fields = array();	

	$p_id = $project["p_id"];

	$select_fields = $DB->prepare("SELECT * FROM fields WHERE for_key_p_id = $p_id");
	$select_fields->execute();
	$fields = $select_fields->fetchAll();

	foreach ($fields as $fields_array_index => $field) {
		$field_name = $field["field_name"];
		$f_id = $field["f_id"];

		$field_o = array();
		$field_o["name"] = $field_name;
		$field_o_details = array();

		$select_details = $DB->prepare("SELECT * FROM details WHERE for_key_f_id = $f_id");
		$select_details->execute();
		$details = $select_details->fetchAll();

		foreach ($details as $detail_array_index => $detail) {
			$detail_name = $detail["detail_name"];
			array_push($field_o_details,$detail_name);
		}

		$field_o["details"] = $field_o_details;
		array_push($project_o_fields,$field_o);

	}
	$project_o["fields"] = $project_o_fields;
	array_push($projects_o, $project_o);
}

$jsout = json_encode($projects_o);
echo $jsout;

?>