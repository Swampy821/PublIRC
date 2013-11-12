<?php
class MySQL
{
	// {{{ properties

    /**
     * Holds the last error
     *
     *
     * @var string
     */
	var $Error; 
	/**
     * Holds the last query
     *
     *
     * @var string
     */
	var $lastQuery;
	/**
     * Holds the MySQL query result
     *
     *
     * @var string
     */  
	var $result; 
	/**
     * Holds the total number of records returned
     *
     *
     * @var string
     */
	var $records;  
	/**
     * Holds the total number of records affected
     *
     *
     * @var string
     */
	var $affected;  
	var $rawResults; // Holds raw 'arrayed' results
	var $arrayedResult; // Holds an array of the result
	var $hostname; // MySQL Hostname
	var $username; // MySQL Username
	var $password; // MySQL Password
	var $database; // MySQL Database
	var $databaseLink; // Database Connection Link
	var $databaseLink2;
	var $stmt;
	
	public $queryresults;
	public $dbarray;
	public $rs;
	// }}}
	/**
	 *Construct function to connect to database
	 *
	 *@name MySQL
	 *
	 *@author Steve Marsh
	 *
	 *@version v1.0.1 S.Marsh
	 *
	 */
	function __construct()
	{
		$this->database = "database.s3db";
	}
	private function Connect()
	{
		$this->databaseLink = new PDO("sqlite:".$this->database);
		return true;
	}
	/**
	 *Performs MySQL query and if results are available, returns the array of results
	 *
	 *@name nquery
	 *@param string $sql
	 *@author Steve Marsh
	 *
	 *@version v1.0.1 S.Marsh
	 *@return Array array(array(ITEM ROWS),array(ITEM_...
	 */
	public function nquery($sql)
	{
		/**
		* nquery
		*	Performs MySQL query and if results are available, returns the array of results;
		*
		* Parameters:
		* 		$sql (String) - Sql statement that is to be performed. 
		*
		* Return
		*	If there are no available records or query errors will return false, else will return a result array that matches iquery. 
		*/
		if(!$this->queryresults = $this->databaseLink->query($sql))
		{
			$this->Error = 'Query error: '.$this->databaseLink->errorInfo();	
			return false;
		}else{
			if(!$this->number_of_rows())
				return false;
			$results = array();
			while($rs=$this->fetch_array())
			{
				$cnt = count($results)+1;
				foreach($rs as $a=>$r)
					$results[$cnt][$a]=$r;
			}
			return $results;
		}
	
	}
	
	public function query($sql)
	{
		if(!$this->queryresults = mysqli_query($this->databaseLink,$sql))
		{
			$this->Error = 'Query error: '.mysqli_error($this->databaseLink);	
			return false;
		}else{
			return $this->queryresults;
		}
	}
	public function fetch_array($res = NULL)
	{
		if(!$this->rs=mysqli_fetch_assoc($this->queryresults))
		{
			return false;
		}
		else
		{
			return $this->rs;
		}
	}
	public function inumber_of_rows()
	{
		return mysqli_stmt_num_rows($this->stmt);
	}
	public function number_of_rows()
	{
		return mysqli_num_rows($this->queryresults);
	}
	public function insert($sql)
	{
		$this->query($sql);
		return mysqli_insert_id($this->databaseLink);	
	}
	public function multi_query($sql)
	{
		if(!$this->queryresults = mysqli_multi_query($this->databaseLink,$sql))
		{
			$this->Error = 'Query error: '.mysqli_error($this->databaseLink);	
			return false;
		}else{
			return $this->queryresults;
		}
	}
	public function iinsert($sql,$types,$args)
	{
			$ref = array();
		if(!$this->stmt = mysqli_stmt_init($this->databaseLink))
		{
			$this->Error = "You must close STMT prior to opening a new one!";
		}
		if(mysqli_stmt_prepare($this->stmt,$sql))
		{
			if(strlen($types)!=count($args))
			{
				$this->Error = "Error: Type count does not match parameter count.";
				return false;
			}
			array_unshift($args,$types);
			foreach($args as $a=>$b)
				$ref[$a] = &$args[$a];
			if(!call_user_func_array(array($this->stmt,"bind_param"),$ref))
			{
				$this->Error = "Error: Problem binding parameters.";
				return false;
			}
			if(!mysqli_stmt_execute($this->stmt))
			{
				$this->Error = "Error: Problem Executing Query.";
				return false;
			}
			$insert_id=mysqli_stmt_insert_id($this->stmt);
			if(!mysqli_stmt_close($this->stmt))
			{
				$this->Error = "Error: Failed Closing Query.";
				return false;
			}
			return $insert_id;
		}else{
			$this->Error = mysqli_stmt_error($this->stmt);
			return false;
		}
	}
	public function iquery($sql,$types,$args, $results=false)
	{
		$ref = array();
		if(!$this->stmt = mysqli_stmt_init($this->databaseLink))
		{
			$this->Error = "You must close STMT prior to opening a new one!";
		}
		if(mysqli_stmt_prepare($this->stmt,$sql))
		{
			if(strlen($types)!=count($args))
			{
				$this->Error = "Error: Type count does not match parameter count.";
				return false;
			}
			array_unshift($args,$types);
			foreach($args as $a=>$b)
				$ref[$a] = &$args[$a];
			if(!call_user_func_array(array($this->stmt,"bind_param"),$ref))
			{
				$this->Error = "Error: Problem binding parameters.";
				return false;
			}
			if(!mysqli_stmt_execute($this->stmt))
			{
				$this->Error = "Error: Problem Executing Query.";
				return false;
			}
			if($results)
				$return = $this->get_result_array($this->stmt);
			else
				$return = true;
			return $return;
		}else{
			$this->Error = mysqli_stmt_error($this->stmt);
			return false;
		}
	}
	public function iclose()
	{
		if(!mysqli_stmt_close($this->stmt))
			{
				$this->Error = "Error: Failed Closing Query.";
				return false;
			}
	}
	private function get_result_array($result)
	{    
		$array = array();
		if($result instanceof mysqli_stmt)
		{
			$result->store_result();
			$variables = array();
			$data = array();
			$meta = $result->result_metadata();
			while($field = $meta->fetch_field())
				$variables[] = &$data[$field->name]; // pass by reference
			call_user_func_array(array($result, 'bind_result'), $variables);
			$i=0;
			while($result->fetch())
			{
				$array[$i] = array();
				foreach($data as $k=>$v)
					$array[$i][$k] = $v;
				$i++;
			}
		}
		elseif($result instanceof mysqli_result)
		{
			while($row = $result->fetch_assoc())
				$array[] = $row;
		}
		return $array;
	}
	private function refValues($arr)
	{
		$refs = array();
		foreach($arr as $key => $value)
			$refs[$key] = &$arr[$key];
		return $refs;
	}
}?>