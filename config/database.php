<?php

class database {

    /** @var string Internal variable to hold the query sql */
    var $_sql = '';

    /** @var int Internal variable to hold the database error number */
    var $_errorNum = 0;

    /** @var string Internal variable to hold the database error message */
    var $_errorMsg = '';

    /** @var string Internal variable to hold the prefix used on all database tables */
    var $_table_prefix = '';

    /** @var Internal variable to hold the connector resource */
    var $_resource = '';

    /** @var Internal variable to hold the last query cursor */
    var $_cursor = null;

    /** @var boolean Debug option */
    var $_debug = 0;

    /** @var int A counter for the number of queries performed by the object instance */
    var $_ticker = 0;

    /** @var array A log of queries */
    var $_log = null;

    function database($hostdns, $user, $pass, $table_prefix) {
        // perform a number of fatality checks, then die gracefully
        if (!function_exists('odbc_connect')) {
            //or die( 'FATAL ERROR: obdc support not available.  Please check your configuration.' );
            $mosSystemError = 1;
            //$basePath = dirname( __FILE__ );
            //include '../config.php';
            echo "error al conectarse";
            //include '../offline.php';
            exit();
        }
        //if (!($this->_resource = odbc_connect($hostdns, $user, $pass))) {
        if(!($this->_resource = odbc_connect($hostdns,$user,$pass))){
            //or die( 'FATAL ERROR: Connection to database server failed.' );
            $mosSystemError = 2;
            $basePath = dirname(__FILE__);
            //include '../config.php';
            echo "error al conectarse 3";
            //include '../offline.php';
            exit();
        }
        $this->_table_prefix = $table_prefix;
        $this->_ticker = 0;
        $this->_log = array();
    }

    // @param int	
    function debug($level) {
        $this->_debug = intval($level);
    }

    // @return int The error number for the most recent query	
    function getErrorNum() {
        return $this->_errorNum;
    }

    // @return string The error message for the most recent query
    function getErrorMsg() {
        return str_replace(array("\n", "'"), array('\n', "\'"), $this->_errorMsg);
    }

    // Get a database escaped string
    // @return string	
    function getEscaped($text) {
        return mysql_escape_string($text);
    }

    //Get a quoted database escaped string
    //@return string	
    function Quote($text) {
        return '\'' . mysql_escape_string($text) . '\'';
    }

    function setQuery($sql, $prefix = '#__') {
        $this->_sql = $this->replacePrefix($sql, $prefix);
    }

    // @param string The SQL query
    // @param string The common table prefix	
    function replacePrefix($sql, $prefix = '#__') {
        $sql = trim($sql);

        $escaped = false;
        $quoteChar = '';

        $n = strlen($sql);

        $startPos = 0;
        $literal = '';
        while ($startPos < $n) {
            $ip = strpos($sql, $prefix, $startPos);
            if ($ip === false) {
                break;
            }

            $j = strpos($sql, "'", $startPos);
            $k = strpos($sql, '"', $startPos);
            if (($k !== FALSE) && (($k < $j) || ($j === FALSE))) {
                $quoteChar = '"';
                $j = $k;
            } else {
                $quoteChar = "'";
            }

            if ($j === false) {
                $j = $n;
            }

            $literal .= str_replace($prefix, $this->_table_prefix, substr($sql, $startPos, $j - $startPos));
            $startPos = $j;

            $j = $startPos + 1;

            if ($j >= $n) {
                break;
            }

            // quote comes first, find end of quote
            while (TRUE) {
                $k = strpos($sql, $quoteChar, $j);
                $escaped = false;
                if ($k === false) {
                    break;
                }
                $l = $k - 1;
                while ($l >= 0 && $sql{$l} == '\\') {
                    $l--;
                    $escaped = !$escaped;
                }
                if ($escaped) {
                    $j = $k + 1;
                    continue;
                }
                break;
            }
            if ($k === FALSE) {
                // error in the query - no end quote; ignore it			
                break;
            }
            $literal .= substr($sql, $startPos, $k - $startPos + 1);
            $startPos = $k + 1;
        }
        if ($startPos < $n) {
            $literal .= substr($sql, $startPos, $n - $startPos);
        }
        return $literal;
    }

    // @return string The current value of the internal SQL vairable	
    function getQuery() {
        return "<pre>" . htmlspecialchars($this->_sql) . "</pre>";
    }

    // Execute the query
    // @return mixed A database resource if successful, FALSE if not.	
    function query() {
        global $mosConfig_debug;
        if ($this->_debug) {
            $this->_ticker++;
            $this->_log[] = $this->_sql;
        }
        $this->_errorNum = 0;
        $this->_errorMsg = '';
        $this->_cursor = odbc_exec($this->_resource, $this->_sql);
        if (!$this->_cursor) {
            $this->_errorNum = odbc_error($this->_resource);
            switch ($this->_errorNum) {
                case "S0022": $msg = "Nombre de campo no valido, revisa la consulta";
            }
            $this->_errorMsg = odbc_errormsg($this->_resource) . " SQL = " . $this->_sql;
            if ($this->_debug) {
                trigger_error(odbc_errormsg($this->_resource), E_USER_NOTICE);
                echo "<pre>" . $this->_sql . "</pre>\n";
                if (function_exists('debug_backtrace')) {
                    foreach (debug_backtrace() as $back) {
                        if (@$back['file']) {
                            echo '<br />' . $back['file'] . ':' . $back['line'];
                        }
                    }
                }
            }
            return false;
        }
        return $this->_cursor;
    }

    // This method loads the first field of the first row returned by the query.
    // @return The value returned in the query or null if the query failed.	
    function loadResult() {
        if (!($cur = $this->query())) {
            return null;
        }
        $ret = null;
        $ret = odbc_result($cur, 1);
        odbc_free_result($cur);
        return $ret;
    }

    // devuelve una matriz asociativa con los campos de la consulta
    function loadRowList($numinarray = 0) {
        if (!($cur = $this->query())) {
            return null;
        }
        $array = array();
        while ($row = odbc_fetch_array($cur)) {
            $i = 0;
            foreach ($row as $key => $v) {
                $array[$numinarray][$i++] = $v;
            }
            $numinarray++;
        }
        odbc_free_result($cur);
        return $array;
    }

    // Load an array of single field results into an array
    function loadResultArray($numinarray = 0) {
        if (!($cur = $this->query())) {
            return null;
        }
        $array = array();
        while ($row = odbc_fetch_array($cur)) {
            $array[] = $row;
        }
        odbc_free_result($cur);
        return $array;
    }

    function loadObjectList(&$key = '') {
        if (!($cur = $this->query())) {
            return null;
        }
        $array = array();
        while ($row = odbc_fetch_object($cur)) {
            if ($key) {
                $array[$row->$key] = mysql_escape_string($row);
            } else {
                $array[] = $row;
            }
        }
        odbc_free_result($cur);
        return $array;
    }

    function loadObject(&$object) {
        if ($object != null) {
            if (!($cur = $this->query())) {
                return false;
            }
        } else {
            if ($cur = $this->query()) {
                if ($object = odbc_fetch_object($cur)) {
                    odbc_free_result($cur);
                    return true;
                } else {
                    $object = null;
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    function loadRow() {
        if (!($cur = $this->query())) {
            return null;
        }
        $ret = null;
        if (odbc_fetch_row($cur)) {
            $n = odbc_num_fields($cur);
            for ($i = 0; $i < $n; $i++) {
                $ret[$i] = odbc_result($cur, $i + 1);
            }
        }
        odbc_free_result($cur);
        return $ret;
    }
    
}

?>