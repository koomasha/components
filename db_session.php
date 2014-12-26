<?php
class db_session {

	private $connection;
	
	public function __construct() {    
    	$dsn = 'mysql:dbname=worki723_shecodes;host=localhost';
		$user = 'worki723_shecode';
		$password = 'shecodes12345';
			
		try {
			$this->connection = new PDO($dsn, $user, $password);
   		}
		catch(PDOException $e)
		{
    		echo $e->getMessage();
    	}
	}
	

    public  function get_connection() {
       if (! $this->connection )
		{
			throw new Exception('connection is null');
		}
        return $this->connection;
    }
}
?>