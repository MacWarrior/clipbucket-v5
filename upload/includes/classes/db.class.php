<?php
class Clipbucket_db
{
    private $mysqli = '';
    private $db_name = '';
    private $db_uname = '';
    private $db_pwd = '';
    private $db_host = '';
    private $db_port = '3306';
    private $total_queries_sql = [];
    private $total_queries = 0;

    private static $db;

    public static function getInstance(): self
    {
        if( empty(self::$db) ){
            self::$db = new self();
        }
        return self::$db;
    }

    public function __construct(){
        global $DBHOST, $DBNAME, $DBUSER, $DBPASS, $DBPORT;
        $this->connect($DBHOST, $DBNAME, $DBUSER, $DBPASS, $DBPORT);
    }

    /**
     * Connect to mysqli Database
     *
     * @param string $host
     * @param string $name
     * @param string $uname
     * @param string $pwd
     * @param string $port
     * @return bool|void
     *
     * @throws Exception
     */
    function connect(string $host = '', string $name = '', string $uname = '', string $pwd = '', string $port = '3306')
    {
        try {
            if (empty($host)) {
                $host = $this->db_host;
            } else {
                $this->db_host = $host;
            }

            if (empty($name)) {
                $name = $this->db_name;
            } else {
                $this->db_name = $name;
            }

            if (empty($uname)) {
                $uname = $this->db_uname;
            } else {
                $this->db_uname = $uname;
            }

            if (empty($pwd)) {
                $pwd = $this->db_pwd;
            } else {
                $this->db_pwd = $pwd;
            }

            if (empty($port)) {
                $port = $this->db_port;
            } else {
                $this->db_port = $port;
            }

            $this->mysqli = new mysqli($host, $uname, $pwd, $name, $port);
            if ($this->mysqli->connect_errno) {
                return false;
            }

            $this->execute('SET NAMES "utf8mb4"');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            error_log($error);
            if (in_dev()) {
                DiscordLog::sendDump($error);
                throw new Exception($e);
            } else {
                redirect_to('maintenance.php');
            }
        }
    }

    /**
     * Select elements from database with query
     *
     * @param : { string } { $query } { mysql query to run }
     *
     * @return array : { array } { $data } { array of selected data }
     * @throws Exception
     */
    function _select($query, $cached_time = -1, $cached_key = ''): array
    {
        try {
            $redis = CacheRedis::getInstance();
            if ($redis->isEnabled() && $cached_time != -1) {
                if (in_dev()) {
                    $start = microtime(true);
                    $return = $redis->get($cached_key . ':' . $query);
                    $end = microtime(true);
                    $timetook = $end - $start;
                    if (!empty($return)) {
                        devWitch($query, 'select', $timetook, true);
                    }
                } else {
                    $return = $redis->get($cached_key . ':' . $query);
                }

                if (!empty($return)) {
                    return $return;
                }
            }
            $result = $this->execute($query, 'select');
            $data = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $result->close();
            }

            if ($redis->isEnabled() && $cached_time != -1 && !empty($data)) {
                $redis->set($cached_key.':'.$query, $data, $cached_time);
            }
        } catch (\Exception $e) {
            if ($e->getMessage() == 'lang_not_installed' || $e->getMessage() == 'version_not_installed') {
                throw $e;
            }
            $this->handleError($query);
        }
        return $data;
    }

    /**
     * Select elements from database with numerous conditions
     *
     * @param : { string } { $tbl } { table to select data from }
     * @param string $fields
     * @param bool $cond
     * @param bool $limit
     * @param bool $order
     * @param bool $ep
     *
     * @return array : { array } { $data } { array of selected data }
     * @throws Exception
     */
    function select($tbl, $fields = '*', $cond = false, $limit = false, $order = false, $ep = false, $cached_time = -1, $cached_key = ''): array
    {
        $query_params = '';

        if ($cond) {
            $query_params .= ' WHERE ' . $cond;
        }
        if ($order) {
            $query_params .= ' ORDER BY ' . $order;
        }
        if ($limit) {
            $query_params .= ' LIMIT ' . $limit;
        }

        $query = 'SELECT ' . $fields . ' FROM ' . $tbl . $query_params . ' ' . $ep;
        return $this->_select($query, $cached_time, $cached_key);
    }

    /**
     * Count values in given table using MySQL COUNT
     *
     * @param : { string }   { $tbl } { table to count data from }
     * @param string $fields
     * @param bool $cond
     *
     * @return bool|int
     * @throws Exception
     */
    function count($tbl, $fields = '*', $cond = false, $ep = '',$cached_time = -1, $cached_key = '')
    {
        $condition = '';
        if ($cond) {
            $condition = ' WHERE ' . $cond;
        }
        $query = 'SELECT COUNT(' . $fields . ') FROM ' . $tbl . $condition . $ep;

        $result = $this->_select($query, $cached_time, $cached_key);

        if ($result) {
            $fields = $result[0];
            foreach ($fields as $field) {
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
     * @return array|void
     * @throws Exception
     */
    function GetRow($query)
    {
        $result = $this->_select($query);
        if ($result) {
            return $result[0];
        }
    }

    /**
     * Execute a MYSQL query directly without processing
     *
     * @param : { string } { $query } { query that you want to execute }
     *
     * @return bool|mysqli_result
     * @throws Exception
     */
    function execute($query, $type = 'execute')
    {
        $this->ping();

        try {
            if (in_dev()) {
                $start = microtime(true);
                $data = $this->mysqli->query($query);
                $end = microtime(true);
                $timetook = $end - $start;
                devWitch($query, $type, $timetook, false);
            } else {
                $data = $this->mysqli->query($query);
            }
            $this->handleError($query);
            return $data;
        } catch (Exception $e) {
            if ($e->getMessage() == 'lang_not_installed' || $e->getMessage() == 'version_not_installed') {
                throw $e;
            }
            $this->handleError($query);
        }
        return false;
    }

    /**
     * @param $sql
     * @return void
     * @throws Exception
     */
    public function executeThrowException($sql)
    {
        try{
            $this->mysqli->query($sql);
        }
        catch(mysqli_sql_exception $e){
            if( in_dev() ){
                e('SQL : ' . $sql);
                DiscordLog::sendDump('SQL : ' . $sql);
            }
            throw $e;
        }

        if ($this->mysqli->error != '') {
            throw new Exception('SQL : ' . $sql . "\n" . 'ERROR : ' . $this->mysqli->error);
        }
    }

    /**
     * Update database fields { table, fields, values style }
     *
     * @param      string $tbl
     * @param      array $flds
     * @param      array $vls
     * @param      string $cond
     * @param null $ep
     *
     * @throws Exception
     * @internal param $ : { string } { $tbl } { table to ujpdate values in }
     * @internal param $ : { array } { $flds } { array of fields you want to update }
     * @internal param $ : { array } { $vls } { array of values to update against fields }
     * @internal param $ : { string } { $cond } { mysql condition for query }
     * @internal param $ : { string } { $ep } { extra parameter after condition }
     */
    function update($tbl, $flds, $vls, $cond, $ep = null)
    {
        $this->ping();

        $total_fields = count($flds);
        $count = 0;
        $fields_query = '';
        for ($i = 0; $i < $total_fields; $i++) {
            $count++;
            $val = ($vls[$i]);
            preg_match('/\|no_mc\|/', $val, $matches);
            if ($matches) {
                $val = preg_replace('/\|no_mc\|/', '', $val);
            } else {
                $val = $this->clean_var($val);
            }

            if (strtoupper($val) == 'NULL') {
                $fields_query .= $flds[$i] . '= NULL';
            } else {
                $needle = substr($val, 0, 3);
                if ($needle != '|f|') {
                    $fields_query .= $flds[$i] . "='" . $val . "'";
                } else {
                    $val = substr($val, 3, strlen($val));
                    $fields_query .= $flds[$i] . '=' . $val;
                }
            }

            if ($total_fields != $count) {
                $fields_query .= ',';
            }
        }
        //Complete Query
        $query = 'UPDATE ' . $tbl . ' SET ' . $fields_query . ' WHERE ' . $cond . ' ' . $ep;

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
     * @throws Exception
     * @internal param $ : { array } { $fields } { associative array with fields and values }
     * @internal param $ : { string } { $cond } { mysql condition for query }
     * @internal param $ : { string } { $tbl } { table to update values in }
     */
    function db_update($tbl, $fields, $cond, $ep = null): bool
    {
        $this->ping();

        $count = 0;
        $fields_query = '';
        foreach ($fields as $field => $val) {
            if ($count > 0) {
                $fields_query .= ',';
            }
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
        $query = 'UPDATE ' . $tbl . ' SET ' . $fields_query . ' WHERE ' . $cond . ' ' . $ep;
        $this->execute($query, 'update');
        return true;
    }

    /**
     * Delete an element from database
     *
     * @param string $tbl
     * @param array $flds
     * @param array $vls
     * @param null $ep
     *
     * @throws Exception
     * @internal param $ : { array } { $flds } { array of fields to update }
     * @internal param $ : { array } { $vlds } { array of values to update against fields }
     * @internal param $ : { string } { $ep } { extra parameters to consider }
     * @internal param $ : { string } { $tbl } { table to delete value from }
     */
    function delete(string $tbl, array $flds, array $vls, $ep = null)
    {
        $this->ping();

        $total_fields = count($flds);
        $fields_query = '';
        $count = 0;
        for ($i = 0; $i < $total_fields; $i++) {
            $count++;
            $val = $this->clean_var($vls[$i]);
            $needle = substr($val, 0, 3);
            if ($needle != '|f|') {
                $fields_query .= $flds[$i] . "='" . $val . "'";
            } else {
                $val = substr($val, 3, strlen($val));
                $fields_query .= $flds[$i] . '=' . $val;
            }
            if ($total_fields != $count) {
                $fields_query .= ' AND ';
            }
        }
        //Complete Query
        $query = 'DELETE FROM ' . $tbl . ' WHERE ' . $fields_query . ' ' . $ep;
        if (isset($this->total_queries)) {
            $this->total_queries++;
        }
        $this->total_queries_sql[] = $query;
        $this->execute($query, 'delete');
    }

    /**
     * Function used to insert values in database { table, fields, values style }
     *
     * @param string $tbl
     * @param array $flds
     * @param array $vls
     * @param null $ep
     *
     * @return mixed|void : { integer } { $insert_id } { id of inserted element }
     *
     * @throws Exception
     * @internal param $ : { string } { $tbl } { table to insert values in }
     * @internal param $ : { array } { $flds } { array of fields to update }
     * @internal param $ : { array } { $vlds } { array of values to update against fields }
     * @internal param $ : { string } { $ep } { extra parameters to consider }
     */
    function insert(string $tbl, array $flds, array $vls, $ep = null)
    {
        $this->ping();

        $total_fields = count($flds);
        $count = 0;
        $fields_query = '';
        $values_query = '';
        foreach ($flds as $field) {
            $count++;
            $fields_query .= $field;
            if ($total_fields != $count) {
                $fields_query .= ',';
            }
        }
        $total_values = count($vls);
        $count = 0;
        foreach ($vls as $value) {
            $count++;
            preg_match('/\|no_mc\|/', $value, $matches);
            if ($matches) {
                $val = preg_replace('/\|no_mc\|/', '', $value);
            } else {
                $val = $this->clean_var($value);
            }
            if (strtoupper($val) == 'NULL') {
                $values_query .= 'NULL';
            } else {
                $needle = substr($val, 0, 3);
                if ($needle == '|f|') {
                    $val = substr($val, 3, strlen($val));
                    $values_query .=  $val ;
                } else {
                    $values_query .= "'" . $val . "'";
                }
            }

            if ($total_values != $count) {
                $values_query .= ',';
            }
        }
        $query = "INSERT INTO $tbl ($fields_query) VALUES ($values_query) $ep";
        $this->total_queries_sql[] = $query;
        if (isset($this->total_queries)) {
            $this->total_queries++;
        }

        try {
            $this->mysqli->query($query);
            $this->handleError($query);
            return $this->insert_id();
        } catch (\Exception $e) {
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
    function insert_id()
    {
        return $this->mysqli->insert_id;
    }

    /**
     * Clean variable for mysql
     *
     * @param $var
     *
     * @return string
     */
    function clean_var($var): string
    {
        $this->ping();
        return $this->mysqli->real_escape_string($var);
    }

    /**
     * @param $query
     * @return void
     * @throws Exception
     */
    private function handleError($query)
    {
        if ($this->getError() != '') {
            //customize exceptions
            if (preg_match('/language.*doesn\'t exist/', $this->getError())) {
                throw new \Exception('lang_not_installed');
            }
            if (preg_match('/version.*doesn\'t exist/', $this->getError())) {
                throw new \Exception('version_not_installed');
            }
            if (preg_match('/doesn\'t exist/', $this->getError())) {
                error_log('SQL : ' . $query);
                error_log('ERROR : ' . $this->getError());
                DiscordLog::sendDump('SQL : ' . $query);
                DiscordLog::sendDump('ERROR : ' . $this->getError());
                throw new \Exception('missing_table');
            }

            if (in_dev()) {
                e('SQL : ' . $query);
                e('ERROR : ' . $this->getError());
                error_log('SQL : ' . $query);
                error_log('ERROR : ' . $this->getError());
                error_log(debug_backtrace_string());
                DiscordLog::sendDump('SQL : ' . $query);
                DiscordLog::sendDump('ERROR : ' . $this->getError());
                DiscordLog::sendDump(debug_backtrace_string());
            } else {
                e(lang('technical_error'));
            }
        }
    }

    private function ping()
    {
        try{
            $this->mysqli->ping();
        }
        catch(Exception $e){
            error_log('SQL ERROR : ' . $this->mysqli->error);
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

    function getError()
    {
        return $this->mysqli->error;
    }

    /**
     * @return void
     */
    function rollback()
    {
        $this->mysqli->rollback();
    }

    /**
     * @return void
     */
    function commit()
    {
        $this->mysqli->commit();
    }

    /**
     * @return void
     */
    function begin_transaction()
    {
        $this->mysqli->begin_transaction();
    }

    public function getTableName(): string
    {
        return $this->db_name;
    }

}
