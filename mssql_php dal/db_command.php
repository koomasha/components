<?php
class DBcommand{
	

	public static function ExecuteNonQuery($session,$sql,$params){
		$stmt = sqlsrv_query($session->GetConnection(),$sql,DBcommand::ParamsToSqlParams($params));
		if( $stmt === false ) throw new Exception('Error while ExecuteNonQuery on "$sql" :\n'.json_encode(sqlsrv_errors(), TRUE));

		return  sqlsrv_rows_affected($stmt);			
	}
	
	public static function ExecuteQuery($session,$sql,$params = array()){
			
		$stmt = sqlsrv_query($session->GetConnection(),$sql,DBcommand::ParamsToSqlParams($params));
		if( $stmt === false ) throw new Exception('Error while ExecuteQuery on "$sql" :\n'.json_encode(sqlsrv_errors(), TRUE));
		
		$col_num = sqlsrv_num_fields($stmt); 
		$result = array();
		
		$field_names = array();
		
		foreach( sqlsrv_field_metadata($stmt ) as $fieldMetadata ) { 
			$field_names[] =  strtolower($fieldMetadata['Name']);
		}
		
		while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
		{
			$data =array();
			for($i=0;$i<$col_num ;$i++) 
			{
				$data[$field_names[$i]] = $row[$i];
			}
			$result[] = $data;
		}
		return  $result;	   		
	}
	

	private static function ParamsToSqlParams($arr){

            $refs = array();
            foreach($arr as $key => $value)
            {
			    $refs[] = array($arr[$key]);
			}
            
            return $refs;

    }	

}
?>