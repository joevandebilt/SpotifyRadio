<?php
	
	header('Content-Type: application/json; charset=utf-8');

	require_once($_SERVER['DOCUMENT_ROOT']."/Classes/Class.Main.php");

	// $area = $_POST['Area'];
	// $action = $_POST['Action'];
	// $payload = $_POST['Payload'];

	var_dump($_POST);

	$response = new Response(400, null, "API Request was not processed correctly");

	if ($area == "Admin") 
	{
		if ($action == "Create")
		{

		}
		else if ($action == "Update")
		{
			
		}
	}
	else if ($area == "Room")
	{
		
	}


	echo json_encode($response);
?>

