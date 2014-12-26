<?php

/*
	
	$db = new db_session();
	$sql = 'select * from usr where usrid in(2,4)';
	$params = array();
	
	
	//$res = db_command::ExecuteQuery($db,$sql,$params);
	//$res = db_command::ExecuteNonQuery($db,$sql,$params);
	//$res = db_command::PerformInsert($db,$sql,$params);
	var_dump($res);
	
*/


require_once ('DB_session.php');
require_once ('DB_command.php');

DoSomething();
echo "<br/>finished";


function DoSomething()
{
	$db = new DBsession('africainv'); //session obj creation. 


	$db->BeginTransaction(); //begins transaction. not necessary, only for example
	
	$data = DBcommand::ExecuteQuery($db, 'select * from dst where dstcompanyid  = ? and dstid = ?',array(4,46)); // PerformInsert returns id of inserted row and this is what currently saved in $data variable
	echo $data[0]['dstID'] .' '.$data[0]['dstName'].'<br><br>';
	
	$data = DBcommand::ExecuteQuery($db, 'select * from dst where dstcompanyid  = ?',array(4)); // PerformInsert returns id of inserted row and this is what currently saved in $data variable
	for($i = 0; $i < count($data); $i++)
	{
		echo $data[$i]['dstID'] .' '.$data[$i]['dstName'].'<br>';
	}
	
		
	echo "inserted";
	
	$data = DBcommand::PerformInsert($db, 'af',array("afactive"=>true,"afcontent"=>'testAF',"afcompanyid"=>20,"afaftid"=>123, "afblack"=>true, "afrealtime"=>true, "aftransid"=>0));	
	$data = DBcommand::ExecuteQuery($db, 'select * from af where afid = ?',array($data)); // PerformInsert returns id of inserted row and this is what currently saved in $data variable	
	print_table($data);
	
	$data = DBcommand::ExecuteQuery($db, 'exec FLT_totals_per_segment @fltid= ?',array(603924)); //example for calling SP with some id
	print_table($data);
	
	
	echo 'updated:'. DBcommand::PerformUpdate($db, 'af',array("afactive"=>false),"afid < ?",array(10) ); //performUpdate returns number of updated rows
	$data = DBcommand::ExecuteQuery($db, 'select top 10 * from af order by afid asc');
	print_table($data);
	
	echo 'deleted:'. DBcommand::ExecuteNonQuery($db, "delete from af where afid < ?",array(2) ); //executenonquery returns number of affected fields
	$data = DBcommand::ExecuteQuery($db, 'select top 30 * from af order by afid asc');
	print_table($data); 
		
	$db->Commit(); //  commit transaction (example)
}



function print_table($data)
{
  echo "<table border=\"1\"><tr>"; 
  //print field name 
  $colName = Count($data[0]); 
	foreach( $data[0] as $key=>$value ) { 
		echo "<th>"; 
		echo $key; 
		echo "</th>"; 
	  } 

    echo "</tr>"; 
  
  //fetch tha data from the database 
  foreach ($data as $i=>$row ) 
  { 
  
    echo "<tr>";
	
    foreach( $row as $key=>$value ) { 
     
      echo "<td>"; 
      $o = $value; 
	  if ($o instanceof DateTime) {
             echo  $o->format('Y-m-d H:i:s'); 
	  }
	  else
	  {
			echo $o;
	  }
      echo "</td>"; 
    } 
    echo "</tr>"; 
  } 

  echo "</table >"; 
}



 



?>