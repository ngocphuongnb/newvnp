<?php

/**
 * DB Wrapper Class
 *
 * DB Wrapper Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Wrapper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class DBWrapper
{
	public $ThrowExceptions = true;
	public $ErrorDesc		= '';
	public $Error			= array();
	
	public $Adapter		= '';
	
	/**
	 * @Where - Storage variable for search condition with group name
	 */
	public $Where			= array();
	
	/**
	 * @GroupWhere - Storage variable for search condition with group format
	 */
	public $GroupWhere		= array();
	
	public $SQL				= '';
	public $FullSQL			= '';
	public $WhereInGroup	= false;
	public $Table			= '';
	public $Limit			= array(0,0);
	public $Columns			= array('*');
	public $Order			= '';
	private $IsCache		= false;
	private $CachePath		= '';
	
	/**
	 * @BindedParams - variable for binded param
	 */
	public $BindedParams 	= array('');
	public $WhereBindedParams = array('');
	
	/**
	 * @Result - Arrat varible for storage query result
	 */
	public $Result			= array(
									'status'		=> false,
									'total_rows'	=> 0,
									'num_rows'		=> 0,
									'affected_rows'	=> 0,
									'insert_id'		=> 0,
									);
									
	
	public $Log				= array(
								'total_query'	=> 0,
								'query'			=> array()
							);
	private $DBConfig	= array(
								'host'		=> 'localhost',
								'user'		=> NULL,
								'pass'		=> NULL,
								'name'		=> NULL,
								'port'		=> NULL,
								'charset'	=> 'utf8',
								'prefix'	=> '',
								'debug'		=> 1
								);
	private $Obj;
	private $stmt;
	private	$IsConnected = false;
	
	public function __construct($DBConfig = array())
	{
		$this->DBConfig = array_merge($this->DBConfig,$DBConfig);
		if(isset($this->DBConfig['prefix']) && $this->DBConfig['prefix'] != '') {
			$this->DBConfig['prefix'] = $this->DBConfig['prefix'] . '_';
		}
		else $this->DBConfig['prefix'] = '';
	}
	
	/**
	 * Connect to a database
	 *
	 * @param  HostInfo $HostInfo Database host information
	 * @return no
	 */
	public function Connect()
	{
		$this->Obj = new mysqli(
						$this->DBConfig['host'],
						$this->DBConfig['user'],
						$this->DBConfig['pass'],
						$this->DBConfig['name'],
						$this->DBConfig['port']
					) or die('Cannot connect to db server');
					
		if( $this->Obj->connect_errno ) $this->SetError( $this->Obj->connect_errno, $this->Obj->connect_error );
		else {
			$this->Obj->set_charset($this->DBConfig['charset']);
			$this->Obj->query('SET NAMES utf8');
		}
	}
	
	/**
	 * Check of connection existed
	 *
	 * @return connection status
	 */
	public function IsConnected()
	{
		if($this->IsConnected) return true;
		else
			if(method_exists($this->Obj, 'ping') && $this->Obj->ping()) return $this->IsConnected = true;
			else return false;
	}
	
	/**
	 * Set database error
	 *
	 * @param  ErrorNo $ErrorNo Error code
	 * @param  Error $Error Error content
	 * @return no
	 */
	private function SetError($ErrorNo = 0, $Error = '')
	{
		try {
			if( strlen($Error) > 0 || $ErrorNo > 0) Error::Set($ErrorNO, $Error);	
			if($this->is_connected()) Error::Set($this->obj->errno, $this->obj->error);
		}
		catch( Exception $e ) {
			$this->ErrorDesc = $e->getMessage();
			$this->ErrorDesc = -999;
		}
		if( $this->ThrowExceptions && isset($this->ErrorDesc) && $this->ErrorDesc  != NULL )
			throw new Exception( $this->ErrorDesc . ' (' . __LINE__ . ')');
	}
	
	/**
	 * Reset last query object
	 *
	 * @return no
	 */
	public function Reset()
	{
		$this->ErrorDesc		= '';
		$this->Error			= array();
		$this->Where			= array();
		$this->SQL				= '';
		$this->GroupWhere		= array();
		$this->Table			= '';
		$this->Columns			= array('*');
		$this->BindedParams 	= array('');
		$this->WhereBindedParams = array('');
		$this->Result			= array(
										'status'		=> false,
										'total_rows'	=> 0,
										'num_rows'		=> 0,
										'affected_rows'	=> 0,
										'insert_id'		=> 0,
										);
		$this->Log				= array(
									'total_query' => 0,
									'query' => array()
								);
		$this->Obj = NULL;
	}
	
	/**
	 * Detect database param type
	 *
	 * @param  Value $Value input param value
	 * @return Database param bind symbol
	 */
	protected function DetectParamType($Value)
	{
		switch(gettype($Value)) {
            case 'NULL':
            case 'string':
                return 's';break;
            case 'integer':
                return 'i';break;
            case 'blob':
                return 'b';break;
            case 'double':
                return 'd';break;
        }
        return '';
	}
	
	/**
	 * Build get field query
	 *
	 * @param Fields $Fields raw format of get fields
	 * @return formated get field query `column1`, `column2`, `column3`
	 */
	protected function BuildGetFields($Fields = '*')
	{		
		if( $Fields == '*' ) return $Fields;
		
		$return = array();
		if( is_array($Fields) ) foreach( $Fields as $Field ) $return[] = '`' . trim($Field) . '`';
		if($Fields != '' && is_string($Fields) && $_Fields = explode(',', $Fields))
			$Fields = array_map(function($_Field){ return '`' . trim($_Field) . '`'; }, $Fields);
		return implode( ', ', $Fields );
	}
	
	
	/** Query working table
	 *
	 *  @param TableName $TableName table name
	 *  @return $this Class object
	 */
	public function Query($TableName)
	{
		$this->Reset();
		$this->Table = $this->DBConfig['prefix'] . $TableName;
		return $this;
	}
	
	/** Prepare columns for select
	 *
	 *  @param Columns $Columns List of columns to get
	 *  @param ColumnRef $ColumnRef Column prefix type: 0 - none, 1 - table name (user.), 2 - nice name (n.)
	 */
	public function Columns($Columns = '', $ColumnRef = 0, $Prefix = '')
	{
		if( ($ColumnRef == 2 && $Prefix == '') || $ColumnRef == 1) $Prefix = $this->Table . '.';
		elseif( $ColumnRef == 2 && $Prefix != '' ) $Prefix = $Prefix . '.';
		
		if($Columns == '*' || $Columns == '' || $Columns == array())
		{
			$this->Columns = $Prefix . '*';
			return $this;
		}
		
		if( is_string($Columns) && $Columns != '*' ) $Columns = explode(',', $Columns);
		if( is_array($Columns) && !empty($Columns) )
		$this->Columns = array_map(function($ColumnName) use ($Prefix) {return '`' . $Prefix . trim($ColumnName) . '`';}, $Columns);
		//$this->Columns = implode(',', $Columns);
		return $this;
	}
	
	/**
	 * AND condition logic
	 *
	 * @return $this Class object
	 */
	public function _AND()
	{
		$this->Where[] = 'AND';
		return $this;
	}
	
	/**
	 * OR condition logic
	 *
	 * @return $this Class object
	 */
	public function _OR()
	{
		$this->Where[] = 'OR';
		return $this;
	}
	
	public function Cache($Status = false)
	{
		if($Status != false) {
			$this->IsCache = true;
			$this->CachePath = $Status;
		}
		return $this;
	}
	
	/**
	 * Where clause handler
	 *
	 * @param ColumnName $ColumnName raw format of get fields
	 * @param CompareClause $CompareClause Compare type
	 * @param SearchValue $SearchValue Column value to compare
	 * @param ParamType $VariableType param value type
	 * @return $this Class object
	 */
	public function Where($ColumnName, $CompareClause, $SearchValue, $ParamType = NULL, $MultiParamRelationShip = DB::ONEOF )
	{
		if(!in_array($ParamType, DB::$PARAM_TYPES)) $ParamType = $this->DetectParamType($SearchValue);
		
		if(!is_string($ColumnName) || $ColumnName == '')
		{
			Error::Set('Where Invalid ColumnName ' . $CompareClause . ' ' . $SearchValue . ' - ' . $ParamType);
			return $this;
		}
		$where = '';
		if( strtoupper($CompareClause) == 'IN' )
			$where = $this->WhereIn($ColumnName, $SearchValue, $ParamType);
		elseif( strtoupper($CompareClause) == 'INCLUDE' )
			$where = $this->WhereInclude($ColumnName, $SearchValue, $ParamType, $MultiParamRelationShip);
		else 
		{
			$this->WhereBindedParams[0] .= $ParamType;
			array_push($this->WhereBindedParams, $this->Escape($SearchValue));
			$where = '`' . $ColumnName . '` ' . $CompareClause . ' ? ';
		}
		if($this->WhereInGroup) return $where;
		else
		{
			$this->Where[] = $where;
			return $this;
		}
	}
	
	public function Adapter($Adapter)
	{
		$this->Adapter = $Adapter;
		return $this;
	}
	
	/**
	 * Group conditions for custom logic
	 *
	 * @param GroupName $GroupName
	 * @param CallBackFunction $CallBackFunction Anonymous function for inside function working
	 * @return $this Class object
	 */
	public function GroupWhere($GroupName, $CallBackFunction)
	{
		$this->Where[] = '(';
		call_user_func($CallBackFunction, $this);
		$this->Where[] = ')';
		return $this;
	}
	
	public function WhereGroupOpen()
	{
		$this->Where[] = '(';
		return $this;
	}
	public function WhereGroupClose()
	{
		$this->Where[] = ')';
		return $this;
	}
	
	/**
	 * Where condition with IN array clause
	 *
	 * @param ColumnName $ColumnName raw format of get fields
	 * @param ParamType $VariableType param value type
	 * @return $this Class object
	 */
	public function WhereIn($ColumnName, $SearchValue, $ParamType)
	{
		$PreparedValues = array();
			
		if(is_string($SearchValue)) $SearchValue = explode(',', $SearchValue);
		if(!is_array($SearchValue) || empty($SearchValue))
		{
			Error::Set('Where ' . $ColumnName . ' IN (invalid SearchValue) - ' . $ParamType);
			return '';
		}
		
		$InClause = '`' . $ColumnName . '` IN (';
		foreach($SearchValue as $val)
		{
			$_PType = $this->DetectParamType($val);
			$this->WhereBindedParams[0] .= $_PType;
			array_push($this->WhereBindedParams, $this->Escape($val));
			$PreparedValues[] = '?';
		}
		return $InClause . implode(',', $PreparedValues) . ')';
	}
	
	/**
	 * Where condition with REGULAR EXPRESSION support
	 *
	 * @param ColumnName $ColumnName raw format of get fields
	 * @param ParamType $VariableType param value type
	 * @param MultiParamRelationShip $MultiParamRelationShip Relation for array variable
	 * @return $this Class object
	 */
	public function WhereInclude($ColumnName, $SearchValue, $ParamType, $MultiParamRelationShip)
	{
		$PreparedValues = array();
			
		if(is_string($SearchValue)) $SearchValue = explode(',', $SearchValue);
		if(!is_array($SearchValue) || empty($SearchValue))
		{
			Error::Set('Where ' . $ColumnName . ' INCLUDE (invalid SearchValue) - ' . $ParamType);
			return '';
		}
		
		$SearchValue = $this->ParamTrueType($SearchValue, $ParamType);
		$RegExpClause = array();
		
		foreach($SearchValue as $_SearchItem)
		{
			$_Value = $this->Escape($_SearchItem);
			
			if(in_array($MultiParamRelationShip, array(DB::ONEOF, DB::ALLOF)))
				$RegExpClause[] = "(`" . $ColumnName . "`=? OR `" . $ColumnName . "` REGEXP '^" . $_Value . "\\\,' OR `" . $ColumnName . "` REGEXP '\\\," . $_Value . "\\\,' OR `" . $ColumnName . "` REGEXP '\\\," . $_Value . "\$')";
			
			$this->WhereBindedParams[0] .= $ParamType;
			array_push($this->WhereBindedParams, $this->Escape($_Value));
		}
		
		if($MultiParamRelationShip == DB::ONEOF) return implode(' OR ', $RegExpClause);
		elseif($MultiParamRelationShip == DB::ALLOF) return implode(' AND ', $RegExpClause);
		else return '';
	}
	
	/**
	 * Set Limit data
	 *
	 * Offset @Offset Offset Number of start rows to exclude
	 * Offset @Length Length Number of rows to get
	 * @return $this Class object
	 */ 
	public function Limit($Offset = 0, $Length = 0)
	{
		$this->Limit = array($Offset,$Length);
		return $this;
	}
	
	public function BuildLimit()
	{
		$Length = $this->Limit[0];
		$Offset = $this->Limit[1];
		if($Length == 0 && $Offset == 0) return '';
		if($Length != 0) $_limit = 'LIMIT ' . $Offset . ', ' . $Length;
		else $_limit = 'LIMIT ' . $Offset;
		return $_limit;
	}
	
	/**
	 * Set order clause
	 *
	 * Offset @Orderby Orderby Column to sort
	 * Offset @Order
	 * @return $this Class object
	 */
	public function Order($Orderby = '', $Order = 'ASC')
	{
		if($Orderby != '') $this->Order = 'ORDER BY ' . $Orderby . ' ' . $Order;
		return $this;
	}
	
	function mres($value)
	{
		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	
		return str_replace($search, $replace, $value);
	}
	
	public function Escape($str, $escape = false)
    {
		$str = $this->nl2br( $str );
		
        //if( $escape ) $str = $this->Obj->real_escape_string($str);
		if($escape) $str = mysql_escape_string($this->mres($str));
		return $str;
    }
	
	public function nl2br($text, $replacement = '')
	{
		if(empty( $text )) return '';
	
		return strtr( $text, array(
			"\r\n" => $replacement,
			"\r" => $replacement,
			"\n" => $replacement
		) );
	}
	
	/**
	 * Format value array into true type provided
	 *
	 * @param ValueArray $ValueArray Array of param
	 * @param type $type Provided value type
	 * @return true type param array
	 */
	public function ParamTrueType($ValueArray, $type)
	{
		if(in_array($type, DB::$PARAM_NUMBER) ) return array_map(function($val){ return intval($val); }, $ValueArray);
		elseif(in_array($type, DB::$PARAM_STRING) ) return array_map(function($val){ return (string)$val; }, $ValueArray);
		else return array();
	}
	
	
	//////*********************** MYSQLI Functions **********************///////
	/**
	 * Mysqli Prepare method
	 *
	 * @return prepare status
	 */
	protected function Prepare()
	{
		if($this->stmt = $this->Obj->prepare($this->SQL) ) $this->Result['status'] = true;
		else $this->Result['status'] = false;
		
		if( $this->DBConfig['debug'] == 1 )
		{
			DB::$Log['total_query']++;
			DB::$Log['query'][] = array('status'	=> $this->Result['status'],
										'sql'		=> $this->SQL,
										'error'		=> $this->Obj->error,
										'params'	=> array_merge($this->BindedParams, $this->WhereBindedParams));
		}
		return $this->Result['status'];
	}
	
	/**
	 * Mysqli bind_param method
	 *
	 * @return No return
	 */
	protected function BindParam()
	{
		$this->BindedParams[0] .= $this->WhereBindedParams[0];
		unset($this->WhereBindedParams[0]);
		$this->BindedParams = array_merge($this->BindedParams, $this->WhereBindedParams);
		return call_user_func_array( array($this->stmt, 'bind_param'), $this->refValues($this->BindedParams) );
	}
	
	/**
	 * Build reference values array
	 *
	 * @param Array $Array Input array
	 * @return Refered values array
	 */
	protected function refValues($Array)
    {
        //Reference is required for PHP 5.3+
        if(strnatcmp(phpversion(), '5.3') >= 0 )
		{
            $refs = array();
            foreach($Array as $key => $value)
			{
                $refs[$key] = &$Array[$key];
            }
            return $refs;
        }
        return $Array;
    }
	
	protected function Execute()
	{
		if( $this->stmt->execute() )
		{
			$this->stmt->store_result();
			return true;
		}
		return false;
	}
	
	protected function DoQuery()
	{
		if( $this->Prepare() )
		{
			$CanExecute = true;
			if( (sizeof($this->BindedParams) > 1 || sizeof($this->WhereBindedParams) > 1 )
				&& !$this->BindParam())
				$CanExecute = false;
			if($CanExecute)
				if($this->Execute()) return true;
				else return false;
			else return false;
		}
		else return false;
	}
	
	public function CustomQuery($sql)
	{
		$sql = str_replace(PHP_EOL, ' ', $sql);
		$sql = preg_replace('/\s+/', ' ', $sql);
		if(!$this->IsConnected) $this->Connect();

		$_qr = $this->Obj->query($sql);
		if( $this->Obj->errno == 0 ) $this->Result['status'] = true;
		else $this->Result['status'] = false;
		
		if( $this->DBConfig['debug'] == 1 )
		{
			DB::$Log['total_query']++;
			DB::$Log['query'][] = array('status' => $this->Result['status'], 'sql' => $sql, 'error' => $this->Obj->error);
		}
		
		if( $this->Result['status'] ) return $_qr;
		else return false;
	}
	
	protected function BindResult($FieldKey = '')
	{
		$results = $row = array();
		$meta = $this->stmt->result_metadata();
		while( $Field = $meta->fetch_field() )
		{
			$row[$Field->name] = NULL;
			$parameters[] = &$row[$Field->name];
		}	
		call_user_func_array(array($this->stmt, 'bind_result'), $parameters);	
		$this->stmt->store_result();
		
		while( $this->stmt->fetch() )
		{
			$x = array();
			//foreach( $row as $key => $val ) $x[$key] =  stripslashes($val);
			foreach( $row as $key => $val )
				$x[$key] =  html_entity_decode(stripslashes($val), ENT_QUOTES,'UTF-8');
			
			if(!empty($this->Adapter)) $x = call_user_func($this->Adapter, $x);
			if( $FieldKey != '' && isset($x[$FieldKey ])) $results[$x[$FieldKey]] = $x;
			else array_push($results, $x);
		}
		return $results;
	}
	
	//////*********************** User functions **********************///////
	/**
	 * Get rows from a table
	 * @param FieldKey $FieldKey Field name for result array key
	 * @param Ispaged $Ispaged Check for pagination
	 * @return Object - Object of found rows and query result
	 */
	public function Get($FieldKey = '', $IsPaged = false)
	{
		if($IsPaged !== false)
		{
			$CalcFoundRow = 'SQL_CALC_FOUND_ROWS ';
			$this->Limit = array($this->Limit[0],$this->Limit[0]*$IsPaged);
		}
		else $CalcFoundRow = ' ';
		
		$this->SQL = 'SELECT ' . $CalcFoundRow . implode(',', $this->Columns) . ' FROM `' . $this->Table . '`';
		if(!empty($this->Where)) $this->SQL .= ' WHERE ' . implode(' ',$this->Where) . ' ';
		$this->SQL .= $this->Order . ' ' . $this->BuildLimit();
		
		$CacheFile = '';
		if($this->IsCache) {
			$CacheFile = md5($this->SQL . serialize($this->WhereBindedParams));
			if(file_exists($this->CachePath . 'db/' . $CacheFile))
				return unserialize(file_get_contents($this->CachePath . 'db/' . $CacheFile));
		}
		
		if(!$this->IsConnected())
		{
			$this->Connect();
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['insert_id']		= $this->stmt->insert_id;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
				if($IsPaged !== false)
				{
					$result = $this->CustomQuery('SELECT FOUND_ROWS()');
					$rowData = $result->fetch_row();
					$this->Result['total_rows'] = $rowData[0];
					Output::$Paging['total_pages'] = ceil($this->Result['total_rows']/$this->Limit[0]);
				}
				$GetReturn = $this->Result;
				$GetReturn['Result'] = $this->BindResult($FieldKey);
				if($this->IsCache) {
					file_put_contents($this->CachePath . 'db/' . $CacheFile, serialize((object) $GetReturn));
				}
					
				return (object) $GetReturn;
			}
			else return false;
		}
		else
		{
			return false;
			trigger_error('Cannot connect to database');
		}
	}
	
	/**
	 * Insert row to a table
	 * @param TableData $TableData Insert data
	 * @return Object - Query result
	 */
	public function Insert($TableData = array())
	{		
		if(!$this->IsConnected())
		{
			$this->Connect();
			$PreparedFields = $PreparedValues = array();
			
			foreach($TableData as $FieldName => $FieldValue )
			{
				$PreparedFields[] = '`' . $FieldName . '`';
				$PreparedValues[] = '?';
				
				$this->BindedParams[0] .= $this->DetectParamType($FieldValue);
				array_push($this->BindedParams, $this->Escape($FieldValue));
			}
			$this->SQL = 'INSERT INTO `' . $this->Table . '` (' . implode(',', $PreparedFields) . ') VALUES (' . implode(',', $PreparedValues) . ')';
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['insert_id']		= $this->stmt->insert_id;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
		else
		{
			return false;
			trigger_error('Cannot connect to database');
		}
	}
	
	/**
	 * Replace table rows
	 * @param TableData $TableData Replace data
	 * @return Object - Query result
	 */
	public function Replace( $TableData = array() )
	{		
		if(!$this->IsConnected())
		{
			$this->Connect();
			$PreparedFields = $PreparedValues = array();
			
			foreach($TableData as $FieldName => $FieldValue )
			{
				$PreparedFields[] = '`' . $FieldName . '`';
				$PreparedValues[] = '?';
				
				$this->BindedParams[0] .= $this->DetectParamType($FieldValue);
				array_push($this->BindedParams, $this->Escape($FieldValue));
			}
			$this->SQL = 'REPLACE INTO `' . $this->Table . '` (' . implode(',', $PreparedFields) . ') VALUES (' . implode(',', $PreparedValues) . ')';
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['insert_id']		= $this->stmt->insert_id;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
		else
		{
			return false;
			trigger_error('Cannot connect to database');
		}
	}
	
	/**
	 * Update table rows
	 * @param TableData $TableData Update data
	 * @return Object - Query result
	 */
	public function Update( $TableData = array() )
	{
		if(!$this->IsConnected())
		{
			$this->Connect();
			$PreparedFields = $PreparedValues = $PreparedBindParam = array();
		
			foreach($TableData as $FieldName => $FieldValue )
			{
				$PreparedField[] = '`' . $FieldName . '`=?';	
				$this->BindedParams[0] .= $this->DetectParamType($FieldValue);
				array_push($this->BindedParams, $this->Escape($FieldValue));
			}
						
			$this->SQL = 'UPDATE `' . $this->Table . '` SET ' . implode(',', $PreparedField);
			if(!empty($this->Where)) $this->SQL .= ' WHERE ' . implode(' ',$this->Where);
			
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['insert_id']		= $this->stmt->insert_id;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
	}
	
	/**
	 * Delete table rows
	 * @return Object - Query result
	 */
	public function Delete()
	{	
		if(!$this->IsConnected())
		{
			$this->Connect();
			$this->SQL = 'DELETE FROM `' . $this->Table . '`';
			if(!empty($this->Where)) $this->SQL .= ' WHERE ' . implode(' ',$this->Where);
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
	}
	
	/**
	 * Drop columns of a table
	 * @return Object - Query result
	 */
	public function DropColumns($Columns)
	{
		if($this->IsConnected())
		{
			$this->Connect();
			$DropColumnsQuery = array_map(function($Column) { return 'DROP ' . $Column; }, $Columns);
			$this->SQL = "ALTER TABLE `" . $this->Table . "` " . implode(',', $DropColumnsQuery);
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
	}
	
	/**
	 * Add columns to a table
	 * @return Object - Query result
	 */
	public function AddColumns($Columns = array())
	{
		$DataType = array(	'text'			=> ' VARCHAR(255) NOT NULL',
							'title'			=> ' VARCHAR(255) NOT NULL',
							'meta_title'	=> ' VARCHAR(255) NOT NULL',
							'password'		=> ' VARCHAR(255) NOT NULL',
							'image'			=> ' VARCHAR(255) NOT NULL',
							'file'			=> ' VARCHAR(255) NOT NULL',
							'hidden'		=> ' VARCHAR(255) NOT NULL',
							'single_value'	=> ' INT(11) NOT NULL',
							'multi_value'	=> ' VARCHAR(255) NOT NULL',
							'number'		=> ' INT(11) NOT NULL',
							'referer'		=> ' VARCHAR(255) NOT NULL',
							'textarea'		=> ' MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL',
							'html'			=> ' MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL',
							'meta_description'		=> ' MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL',
							'multi_image'		=> ' MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL',
							'attribute'		=> ' MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL',
							'hidden_tinytext'		=> ' TINYTEXT COLLATE utf8_unicode_ci NOT NULL',
						);
						
		if($this->IsConnected())
		{	
			$this->Connect();
			$AddColumnsQuery = array_map(
								function($Column) use ($DataType) {
									return 'ADD COLUMN `' . $Column['name'] . '` ' . $DataType[$Column['type']]; 
								}, $Columns);
			
			$this->SQL = "ALTER TABLE `" . $this->Table . "` " . implode(',',$AddColumnsQuery);
			if( $this->DoQuery() )
			{
				$this->Result['affected_rows']	= $this->stmt->affected_rows;
				$this->Result['num_rows']		= $this->Result['total_rows'] = $this->stmt->num_rows;
				$this->Result['status']			= true;
			}
			return (object) $this->Result;
		}
	}
	
	/**
	 * Get AutoIncreament index
	 * @return AutoIncreament index
	 */
	public function NextInsertID()
	{
		if($this->IsConnected())
		{
			$this->Connect();
			$result = $this->CustomQuery("SHOW TABLE STATUS FROM `" . DB::$Config['name'] . "` LIKE '" . $this->Table . "'");
			$rowData = $result->fetch_assoc();
			return $rowData['Auto_increment'];
		}
	}
	
	/**
	 * Close connection
	 *
	 * @return no
	 */
	 
	public function Close()
	{
		$this->Obj->close();
	}
	
	/**
	 * Class destructor
	 * Close current connection
	 *
	 * @return no
	 */
	public function __destruct()
	{
	}
}

?>