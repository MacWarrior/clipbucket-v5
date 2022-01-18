<?php
/**
 * File: Database Class
 * Description: All mysql function being called from one place. Simplifies things for developers 
 * @author : Arslan Hassan, Saqib Razzaq
 * @since : ClipBucket 2.7
 * @modified: ClipBucket 2.8.1 [ Saqib Razzaq ]
 * @functions: Various
 * @db_actions: connect, select, update, count, insert
 */

class Clipbucket_db
{
	/** @var mysqli $mysqli */
	var $mysqli = "";

    var $db_name = "";
    var $db_uname = "";
    var $db_pwd = "";
    var $db_host = "";

    var $total_queries_sql = array();
    var $total_queries = 0;

	/**
	 * Connect to mysqli Database
	 *
	 * @param $host
	 * @param $name
	 * @param $uname
	 * @param $pwd
	 *
	 * @return bool|void
	 *
	 * @internal param $ : { string } { $host } { your database host e.g localhost }
	 * @internal param $ : { string } { $name } { name of database to connect to }
	 * @internal param $ : { string } { $uname } { your database username }
	 * @internal param $ : { string } { $pwd } { password of database to connect to }
	 */
    function connect($host='', $name='', $uname='', $pwd='')
	{
        try
		{
            if(!$host){
            	$host = $this->db_host;
            } else {
            	$this->db_host = $host;
            }

            if(!$name){
            	$name = $this->db_name;
            } else {
				$this->db_name = $name;
            }

            if(!$uname){
            	$uname = $this->db_uname;
            } else {
				$this->db_uname = $uname;
            }

            if(!$pwd){
            	$pwd = $this->db_pwd;
            } else {
				$this->db_pwd = $pwd;
            }

            $this->mysqli = new mysqli($host,$uname, $pwd, $name);
            if($this->mysqli->connect_errno){
            	return false;
            }

            $this->execute('SET NAMES "utf8"');
        } catch(Exception $e) {
			error_log($e->getError());
        }
    }

	/**
	 * Select elements from database with query
	 *
	 * @param : { string } { $query } { mysql query to run }
	 *
	 * @return array : { array } { $data } { array of selected data }
	 */
    function _select($query): array
    {
		$this->ping();

        $result = $this->execute($query, 'select');

		$data = [];
		if( $result ) {
			while( $row = $result->fetch_assoc() ) {
				$data[] = $row;
			}
			$result->close();
		}
        return $data;
    }

	/**
	 * Select elements from database with numerous conditions
	 *
	 * @param : { string } { $tbl } { table to select data from }
	 * @param string $fields
	 * @param bool   $cond
	 * @param bool   $limit
	 * @param bool   $order
	 * @param bool   $ep
	 *
	 * @return array : { array } { $data } { array of selected data }
	 */
    function select($tbl,$fields='*', $cond=false, $limit=false, $order=false, $ep=false): array
    {
        $query_params = '';

		if($cond){
			$query_params .= ' WHERE '.$cond;
        }
        if($order){
            $query_params .= ' ORDER BY '.$order;
        }
        if($limit){
            $query_params .= ' LIMIT '.$limit;
        }

        $query = 'SELECT '.$fields.' FROM '.$tbl.$query_params.' '.$ep;

		return $this->_select($query);
    }

	/**
	 * Count values in given table using MySQL COUNT
	 *
	 * @param : { string }   { $tbl } { table to count data from }
	 * @param string $fields
	 * @param bool   $cond
	 *
	 * @return bool|int
	 */
    function count($tbl, $fields='*', $cond=false)
	{
		$condition = '';
        if ($cond){
            $condition = ' WHERE '.$cond;
        }
        $query = 'SELECT COUNT('.$fields.') FROM '.$tbl.$condition;

        $result = $this->_select($query);

        if( $result ){
            $fields = $result[0];
            foreach ($fields as $field){
                return $field;
            }
        }

        return false;
    }

	/**
	 * Get row using query
	 *
	 * @param : { string } { $query } { query to run to get row }
	 *
	 * @return mixed
	 */
    function GetRow($query)
    {
        $result = $this->_select($query);
        if($result){
        	return $result[0];
        }
    }

	/**
	 * Execute a MYSQL query directly without processing
	 *
	 * @param : { string } { $query } { query that you want to execute }
	 *
	 * @return bool|array
	 */
    function execute($query, $type = 'execute')
    {
		$this->ping();

        try {
            if( in_dev() ) {
                $start = microtime(true);
                $data = $this->mysqli->query($query);
                $end = microtime(true);
                $timetook = $end - $start;
                devWitch($query, $type, $timetook);
            } else {
                $data = $this->mysqli->query($query);
            }
			$this->handleError($query);
			return $data;
        } catch(Exception $e) {
			$this->handleError($query);
        }
        return false;
    }

	/**
	 * Update database fields { table, fields, values style }
	 *
	 * @param      $tbl
	 * @param      $flds
	 * @param      $vls
	 * @param      $cond
	 * @param null $ep
	 *
	 * @internal param $ : { string } { $tbl } { table to ujpdate values in }
	 * @internal param $ : { array } { $flds } { array of fields you want to update }
	 * @internal param $ : { array } { $vls } { array of values to update against fields }
	 * @internal param $ : { string } { $cond } { mysql condition for query }
	 * @internal param $ : { string } { $ep } { extra parameter after condition }
	 */
    function update($tbl,$flds,$vls,$cond,$ep=NULL)
	{
		$this->ping();

        $total_fields = count($flds);
        $count = 0;
        $fields_query = '';
        for($i=0;$i<$total_fields;$i++) {
            $count++;
            $val = ($vls[$i]);
            preg_match('/\|no_mc\|/',$val,$matches);
            if($matches) {
                $val = preg_replace('/\|no_mc\|/','',$val);
            } else {
                $val = $this->clean_var($val);
            }

            $needle = substr($val,0,3);
            if($needle != '|f|') {
                $fields_query .= $flds[$i]."='".$val."'";
            } else {
                $val = substr($val,3,strlen($val));
                $fields_query .= $flds[$i].'='.$val.'';
            }
            if($total_fields!=$count)
                $fields_query .= ',';
        }
        //Complete Query
        $query = 'UPDATE '.$tbl.' SET '.$fields_query.' WHERE '.$cond.' '.$ep;

        $this->execute($query, 'update');
    }

	/**
	 * Update database fields { table, associative array style }
	 *
	 * @param      $tbl
	 * @param      $fields
	 * @param      $cond
	 * @param null $ep
	 *
	 * @return bool : { boolean }
	 *
	 * @internal param $ : { string } { $tbl } { table to update values in }
	 * @internal param $ : { array } { $fields } { associative array with fields and values }
	 * @internal param $ : { string } { $cond } { mysql condition for query }
	 */
    function db_update($tbl, $fields, $cond, $ep=null)
	{
		$this->ping();

        $count = 0;
		$fields_query = '';
        foreach ($fields as $field => $val)
        {
            if ($count > 0)
                $fields_query .= ',';
            $needle = substr($val, 0, 2);
            if ($needle != '{{') {
                $value = "'" . mysql_clean($val) . "'";
            } else {
                $val = substr($val, 2, strlen($val) - 4);
                $value = mysql_clean($val);
            }

            $fields_query .= $field . "=$value ";
            $count += $count;
        }
        //Complete Query
        $query = 'UPDATE '.$tbl.' SET '.$fields_query.' WHERE '.$cond.' '.$ep;
        $this->execute($query, 'update');
        return true;
    }

	/**
	 * Delete an element from database
	 *
	 * @param      $tbl
	 * @param      $flds
	 * @param      $vls
	 * @param null $ep
	 *
	 * @internal param $ : { string } { $tbl } { table to delete value from }
	 * @internal param $ : { array } { $flds } { array of fields to update }
	 * @internal param $ : { array } { $vlds } { array of values to update against fields }
	 * @internal param $ : { string } { $ep } { extra parameters to consider }
	 */
    function delete($tbl,$flds,$vls,$ep=NULL)
	{
		$this->ping();

        $total_fields = count($flds);
        $fields_query = '';
        $count = 0;
        for($i=0;$i<$total_fields;$i++) {
            $count++;
            $val = $this->clean_var($vls[$i]);
            $needle = substr($val,0,3);
            if($needle != '|f|') {
                $fields_query .= $flds[$i]."='".$val."'";
            } else {
                $val = substr($val,3,strlen($val));
                $fields_query .= $flds[$i].'='.$val.'';
            }
            if($total_fields!=$count) {
                $fields_query .= ' AND ';
            }
        }
        //Complete Query
        $query = 'DELETE FROM '.$tbl.' WHERE '.$fields_query.' '.$ep;
        if(isset($this->total_queries)) $this->total_queries++;
        $this->total_queries_sql[] = $query;

        $this->execute($query, 'delete');
    }

	/**
	 * Function used to insert values in database { table, fields, values style }
	 *
	 * @param      $tbl
	 * @param      $flds
	 * @param      $vls
	 * @param null $ep
	 *
	 * @return mixed|void : { integer } { $insert_id } { id of inserted element }
	 *
	 * @internal param $ : { string } { $tbl } { table to insert values in }
	 * @internal param $ : { array } { $flds } { array of fields to update }
	 * @internal param $ : { array } { $vlds } { array of values to update against fields }
	 * @internal param $ : { string } { $ep } { extra parameters to consider }
	 */
    function insert($tbl, $flds, $vls, $ep=NULL)
	{
		$this->ping();

        $total_fields = count($flds);
        $count = 0;
        $fields_query = '';
        $values_query = '';
        foreach($flds as $field) {
            $count++;
            $fields_query .= $field;
            if($total_fields!=$count)
                $fields_query .= ',';
        }
        $total_values = count($vls);
        $count = 0;
        foreach($vls as $value)
        {
            $count++;
            preg_match('/\|no_mc\|/',$value,$matches);
            if($matches) {
                $val = preg_replace('/\|no_mc\|/','',$value);
            } else {
                $val = $this->clean_var($value);
            }
            if( $val == 'NULL' ){
				$values_query .= 'NULL';
			} else {
				$needle = substr($val,0,3);
				if($needle != '|f|') {
					$values_query .= "'".$val."'";
				} else {
					$val = substr($val,3,strlen($val));
					$values_query .= "'".$val."'";
				}
			}

            if($total_values!=$count) {
                $values_query .= ',';
            }
        }
        $query = "INSERT INTO $tbl ($fields_query) VALUES ($values_query) $ep";
        $this->total_queries_sql[] = $query;
        if(isset($this->total_queries)){
        	$this->total_queries++;
        }

        try {
            $this->mysqli->query($query);
			$this->handleError($query);
            return $this->insert_id();
        } catch(Exception $e) {
			$this->handleError($query);
        }

    }

	/**
	 * Function used to insert values in database { table, associative array style }
	 *
	 * @param $tbl
	 * @param $fields
	 *
	 * @return mixed : { integer } { $insert_id } { id of inserted element }
	 *
	 * @internal param $ : { string } { $tbl } { table to insert values in }
	 * @internal param $ : { array } { $flds } { array of fields and values to update (associative array) }
	 */
    function db_insert($tbl, $fields)
    {
		$this->ping();

        $count = 0;
        $query_fields = array();
        $query_values = array();
        foreach ($fields as $field => $val)
        {
            $query_fields[] = $field;
            $needle = substr($val, 0, 2);
            if ($needle != '{{') {
                $query_values[] = "'" . mysql_clean($val) . "'";
            } else {
                $val = substr($val, 2, strlen($val) - 4);
                $query_values[] = mysql_clean($val);
            }

            $count += $count;
        }

        $fields_query = implode(',', $query_fields);
        $values_query = implode(',', $query_values);
        //Complete Query
        $query = "INSERT INTO $tbl ($fields_query) VALUES ($values_query) $ep";
        $this->total_queries++;
		$this->total_queries_sql[] = $query;
        try {
			$this->mysqli->query($query);

			$this->handleError($query);
			return $this->insert_id();
        } catch(Exception $e) {
			$this->handleError($query);
        }
    }

    /**
     * Returns last insert id.
     *
     * Always use this right after calling insert method or before
     * making another mysqli query.
     *
     * @return mixed
     */
    function insert_id() {
        return $this->mysqli->insert_id;
    }

	/**
	 * Clean variable for mysql
	 *
	 * @param $var
	 *
	 * @return mixed
	 */
    function clean_var($var)
    {
    	$this->ping();
        return $this->mysqli->real_escape_string($var);
    }

    private function handleError($query)
	{
		if( $this->mysqli->error != '' ) {
			if( in_dev() ) {
				e( 'SQL : '.$query);
				e( 'ERROR : '.$this->mysqli->error );
				error_log('SQL : '.$query);
				error_log('ERROR : '.$this->mysqli->error );
			} else {
				e( lang('technical_error') );
			}
		}
	}

	private function ping()
	{
		if( !$this->mysqli->ping() ) {
			error_log("SQL ERROR : ".$this->mysqli->error);
			$this->connect();
		}
	}

    /**
     * Get effect rows
     */
    function Affected_Rows()
    {
        return $this->mysqli->affected_rows;
    }

}
