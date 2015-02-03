<?php
class DBsession 
	{
		//$connection - connection variable which needs to come from the calling page
		private $connection;
		//database connection details
		private $server = '';
		private $user = '';
		private $password = '';
		//Create connection and construct the db object
		public function __construct($database) {
		
			$connectionInfo = array( "Database"=>$database, "UID"=>$this->user, "PWD"=>$this->password);
			$this->connection = sqlsrv_connect( $this->server, $connectionInfo );
			if (! $this->connection )
			{
				throw new Exception('connection is null');
			}
		}
		//closing connection 
		function __destruct() {
			if($this->connection != null)
				sqlsrv_close( $this->connection );
		}
		//Transaction open with the option to rollback
		public function BeginTransaction(){
			sqlsrv_begin_transaction( $this->connection); 
		}
		//Transaction commit
		public function Commit(){
			sqlsrv_commit( $this->connection); ;
		} 
		//Transaction rollback
		public function Rollback(){
			sqlsrv_rollback( $this->connection); 
		}
		//Pull connection
		public  function GetConnection() {
		   if (! $this->connection )
			{
				throw new Exception('connection is null');
			}
			return $this->connection;
		}
	}
?>