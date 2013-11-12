<?php
/*--------------------EXAMPLES OF SQL WRAPPER USE------------------*/
	include("sql.class.php");
	//Defining the object.
	$db = new SQL;

	//Creating a table.
	$sql = "CREATE TABLE TestData
			(
			ID int,
			Test1 varchar(255),
			Test2 varchar(255),
			Test3 varchar(255),
			Test4 varchar(255)
			);";
	//Run straight query.
	$db->query($sql);
	//Table is now created, 

	/*-----------------------------------------------------------------------------------*/




	//Adding to that table.
	$ins = array(
		'Test1'=>'TESTSSS',
		'Test2'=>'TEST2 INFO',
		'Test3'=>'TEST3 INFO',
		'Test4'=>'TEST4 INFO'
				);
	//Insert into table.
	$db->insert("TestData",$ins);
	//Row is now entered into table.

	/*-----------------------------------------------------------------------------------*/





	//Pulling from a table.
	/*------------------------*/ 
	//Define the where clause. 
	$where = " ID=:id";
	//Define the bound elements
	$bind = array(":id",'1');
	//Define what fields you want to pull
	$fields = "Test1, Test2";
	//Run query and return results into $results array.
	$results = $db->select("TestData", $where, $bind, $fields);
	//Dump the results
	var_dump($results);

	/*-----------------------------------------------------------------------------------*/




	//Updating a row
	//Define table to update
	$table = "TestData";
	//Build where clause
	$where = " ID=:id";
	//Define bind parameters
	$bind = array(":id"=>'1');
	//Define the data to update.
	$data = array('Test1'=>'1','Test2'=>'2');
	//Run the update.
	$db->update($table,$data,$where,$bind);
	//Row has now been updated. 

	/*-----------------------------------------------------------------------------------*/





	//Deleting a row
	//Define table to delete from
	$table = "TestData";
	//Define where clause
	$where = " ID=:id";
	//Define bind array.
	$bind = array(":id"=>'1');
	//Run delete command.
	$db->delete($table,$where,$bind);
	//Row has now been deleted. 

/*--------------------END EXAMPLES OF SQL WRAPPER USE------------------*/


?>