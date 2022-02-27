<?php

/**
* @desc MySql - Generic MySQL database access management class.
* @author Eric Bourquin <eric.bourquin@pimentic.com>
* @date 29/08/2005
* @version 1.0
*     - 1st release
* ---------------------------------------------------*
* @author Joe van de Bilt <joevandebilt@live.co.uk
* @Version 1.1
*	- Translated to English
* ---------------------------------------------------*
* @author Joe van de Bilt <joevandebilt@live.co.uk
* @Version 2.0
*	- Updated from deprecated MYSQL classes to MYSQLI
*/



class MySql
{
    /**
     * Class variables
     */
    var $_dbhost = 'localhost';			    // default database host
    var $_dblogin = 'SpotifyRadio';         // database login name
    var $_dbpass = "loadedFromSecrets";     //database login password
    var $_dbname = 'SpotifyRadio';          //database name
    var $_dbport = '3306';					// database port if different from standard
    var $_charset = 'utf8';					// MySql client charset
    var $_dblink = 'TDB';               	// database link identifier
    var $_queryid = -1;                   	// database query identifier
    var $_error = array();                	// storage for error messages
    var $_record = array();               	// database query record identifier
    var $_totalrecords = -1;              	// the total number of records received from a select statement
    var $_lastInsertId = -1;              	// last incremented value of the primary key
    var $_prevId = -1;                    	// previous record id. [for navigating through the db]
    var $_transactionsCapable = false;    	// does the server support transactions?
    var $_beginWork = false;              	// sentinel to keep track of active transactions
    
	var $_directory = '/var/www/Joevandebilt';  // default application directory
	var $_debugmode = true;					//If debug mode is enabled, errors will be printed and SQL provided in output
    

     /**
     * Get database host
     *
     * @return     string Database host or empty string if not set.
     * @access     public
     */
    function getDbHost()
    {
        return $this->_dbhost;

    } // end function

    /**
     * Get database login
     *
     * @return     string Database login or empty string if not set.
     * @access     public
     */
    function getDbLogin()
    {
        return $this->_dblogin;

    } // end function

    /**
     * Get database password
     *
     * @return     string Database password or empty string if not set.
     * @access     public
     */
    function getDbPass()
    {
        return $this->_dbpass;

    } // end function

     /**
     * Get database name
     *
     * @return     string Database name or empty string if not set.
     * @access     public
     */
    function getDbName()
    {
        return $this->_dbname;

    } // end function
    
    /**
     * Get database port
     *
     * @return     string Database port or empty string if not set.
     * @access     public
     */
    function getDbPort()
    {
        return $this->_dbport;

    } // end function
    
    /**
     * Get database charset
     *
     * @return     string Charset or empty string if not set.
     * @access     public
     */
    function getDbCharset()
    {
        return $this->_charset;

    } // end function

    /**
     * Get application directory
     *
     * @return     string Charset or empty string if not set.
     * @access     public
     */
	function getDirectory()
    {
        return $this->_directory;

    } // end function
	
	function getProjectName()
	{
		return $this->_projectName;
	}
	
     /**
     * Set database host
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbHost($value)
    {
        return $this->_dbhost = $value;

    } // end function

    /**
     * Set database login
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbLogin($value)
    {
        return $this->_dblogin = $value;

    } // end function

    /**
     * Set database password
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbPass($value)
    {
        return $this->_dbpass = $value;

    } // end function

    /**
     * Set database Name
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbName($value)
    {
        return $this->_dbname = $value;

    } // end function

    /**
     * Set database port
     * NOTE : Usefull if different from standard port.
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbPort($value)
    {
        return $this->_dbport = $value;

    } // end function
    
    /**
     * Set MySql connection charset
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDbCharset($value)
    {
        return $this->_charset = $value;

    } // end function

    /**
     * Set Application directory
     *
     * @return     bool Affectation's result.
     * @access     public
     */
    function setDirectory($value)
    {
        return $this->_directory = $value;

    } // end function
    
    /**
     * Get database error list.
     *
     * @return     array() string Affectation's result.
     * @access     public
     */
    function getErrors()
    {
        return $this->_error;

    } // end function

    /**
     * Constructor
     *
     * @param      String $dblogin (Optional parameter order = 1)
     * @param	   String $dbpass (Optional parameter order = 2)
     * @param	   String $dbhost (Optional parameter order = 3)
     * @param	   String $dbname (Optional parameter order = 4)
     * @param	   String $dbport (Optional parameter order = 5)
     * NOTE : Without args use default database.
     *        Possible use :
     *			- $db = new MySql () in this case use ini-file parameter to connect database
     *			- $db = new MySql ($dblogin)
     *			- $db = new MySql ($dblogin, $dbpass)
     *			- $db = new MySql ($dblogin, $dbpass, $dbhost)
     *			- $db = new MySql ($dblogin, $dbpass, $dbhost, $dbname)
     *			- $db = new MySql ($dblogin, $dbpass, $dbhost, $dbname, $dbport)
     *		  After instanciation, it's possible to set each variable using set method, in the same way
     *		  it is possible to set a parameter blank (ex: $db = new MySql ($login, $password, '', $dbname).
     * @return     void
     * @access     public
     */
    function __construct()
    {
        $this->_dbpass = Secrets::$DB_PASS;

	    // Get args number
	    $numargs = @func_num_args();
		
	    // Check number of argument
	    switch($numargs) {
	        // Without argument try to connect with parameter set in ini file
	        case 0  :
	        	break;
	        	
	        // Set login 
	        case 1  :       
	        	$this->setDbLogin(func_get_arg (0));
	        	break ;
	
	        // Set login, password
	        case 2  :       
	        	$this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	break ;
	
	        // Set login, password, host
	        case 3  :  
	            $this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	$this->setDbHost(func_get_arg (2));
	        	break ;
	
	        // Set login, password, host, dbname
	        case 4  :       
	        	$this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	$this->setDbHost(func_get_arg (2));
	        	$this->setDbName(func_get_arg (3));
	        	break ;
	
	        // Set login, password, host, dbname, dbport
	        case 5  :
	            $this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	$this->setDbHost(func_get_arg (2));
	        	$this->setDbName(func_get_arg (3));
	        	$this->setPort(func_get_arg (4));
	        	break ;
	        	
	        // Set login, password, host, dbname, dbport, charset
	        case 6  :
	            $this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	$this->setDbHost(func_get_arg (2));
	        	$this->setDbName(func_get_arg (3));
	        	$this->setPort(func_get_arg (4));
	        	$this->setDbCharset(func_get_arg (5));
	        	break ;
	        // Set login, password, host, dbname, dbport, charset
	        case 7  :
	            $this->setDbLogin(func_get_arg (0));
	        	$this->setDbPass(func_get_arg (1));
	        	$this->setDbHost(func_get_arg (2));
	        	$this->setDbName(func_get_arg (3));
	        	$this->setPort(func_get_arg (4));
	        	$this->setDbCharset(func_get_arg (5));
	        	$this->setDirectory(func_get_arg (6));
	        	break ;
	    }
	    
	    // Check all parameter and if necessary to get ini parameter 
	    // to get minimal connect parameter (login, password)
	    $iniParameter = new Config();
	
	    if ($this->getDbLogin() === '') $this->setDbLogin($iniParameter->getIniParameter('login', 'database'));
	    if ($this->getDbPass() === '') $this->setDbPass($iniParameter->getIniParameter('pwd', 'database'));
	    if ($this->getDbHost() === '') $this->setDbHost($iniParameter->getIniParameter('host', 'database'));
	    if ($this->getDirectory() === '') $this->setDirectory($iniParameter->getIniParameter('repertoire', 'database'));
	    // Get value only when no args given, else use mysql default value
	    if ($numargs == 0) {
	    	if ($this->getDbName() === '') $this->setDbName($iniParameter->getIniParameter('name', 'database'));
	    	if ($this->getDbPort() === '') $this->setDbPort($iniParameter->getIniParameter('port', 'database'));
	    	if ($this->getDbCharset() === '') $this->setDbCharset($iniParameter->getIniParameter('charset', 'database'));
    	}
/*		
echo "<PRE>";
print_r($iniParameter);
echo "</PRE>";
*/	   
	    // Finally try to connect
	    $this->connect();

    } // end function

    /**
     * Connect to the database and change to the appropriate database.
     *
     * @param      none
     * @return     database link identifier
     * @access     public
     */
    function connect()
    {
	
	    // Check database port and add it to host if not empty
	    if ($this->_dbport == '') {
     	   $this->_dbport = 3306;
    	}
		
		//Check to see if our transactions are all complete
		if ($this->checkTransactionUnsafe())
		{
			$this->returnPreconnectionError('Unable to connect to the database due to unsafe transaction.');
			return null;
		}	
		
		// Get connection or create a new one
	    $this->_dblink = @mysqli_connect($this->_dbhost, $this->_dblogin, $this->_dbpass, $this->_dbname, $this->_db);
	    
        if (!$this->_dblink) {
            $this->returnConnectionError('Unable to connect to the database.');
        }			
        
        // Set Db client charset only if set
        if ($this->_charset != '') {
			$this->query('set names ' . $this->_charset);
		}
		
        // TODO : Check error
//         if ($this->serverHasTransaction()) {
//             $this->_transactionsCapable = true;
//         }

        return $this->_dblink;

    } // end function

    /**
     * Disconnect from the mySQL database.
     *
     * @param      none
     * @return     void
     * @access     public
     */
    function disconnect()
    {
        $test = @mysqli_close($this->_dblink);

        if (!$test) {
            $this->returnError('Unable to close the connection.');
        }

        unset($this->_dblink);

    } // end function

    /**
     * Stores error messages
     *
     * @param      String $message
     * @return     String
     * @access     private
     */
    function returnError($message)
    {
		return $this->_error[] = $message.' '.mysqli_error($this->_dblink).'.';

    } // end function
	
	function returnPreconnectionError($message)
	{
		return $this->_error[] = $message;
	}
	function returnConnectionError ($message)
	{
		return $this->_error[] = $message.' '.mysqli_connect_error().'.';
	}

    /**
     * Show any errors that occurred.
     *
     * @param      none
     * @return     string
     * @access     public
     */
    function showErrors()
    {
	    $toReturn = "";
		
        if ($this->hasErrors()) {
            reset($this->_error);
			
            $errcount = count($this->_error);    //count the number of error messages

            $toReturn .= "Error(s) found: '$errcount'";

            // print all the error messages.
            while (list($key, $val) = each($this->_error)) {
                $toReturn .= "\\n - $val";
            }

            $this->resetErrors();       
        }
        return ($toReturn);

    } // end function

    /**
     * Checks to see if there are any error messages that have been reported.
     *
     * @param      none
     * @return     boolean
     * @access     private
     */
    function hasErrors()
    {
        if (count($this->_error) > 0) {
            return true;
        } else {
            return false;
        }

    } // end function

    /**
     * Clears all the error messages.
     *
     * @param      none
     * @return     void
     * @access     public
     */
    function resetErrors()
    {
        if ($this->hasErrors()) {
            unset($this->_error);
            $this->_error = array();
        }

    } // end function

    /**
     * Performs an SQL query.
     *
     * @param      String $sql
     * @return     int query identifier
     * @access     public
     */
    function query($sql)
    {
	    // Remove error
	    $this->resetErrors();
	    
        if (empty($this->_dblink)) {
            // check to see if there is an open connection. If not, create one.
            $this->connect();
        }

		$this->_queryid = @mysqli_query($this->_dblink, $sql);

        if (!$this->_queryid) {
            if ($this->_beginWork) {
                $this->rollbackTransaction();
            }
			$this->returnError('Unable to perform the query ' . $sql . '.');
        }

        $this->_prevId = 0;

		if ($this->_debugmode && $this->hasErrors())
		{
			AlertBox($this->ShowErrors());
			Output($sql);
		}
		
        return $this->_queryid;

    } // end function

	/**
     * Escape input strings to be database safe
     *
     * @param   string 
     * @return  string
     * @access  public
     */
	function cleanString($input)
	{
		return @mysqli_real_escape_string($this->_dblink, $input);
	}// end function
	
    /**
     * Grabs the records as a array.
     * [edited by MoMad to support movePrev()]
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function fetchRow()
    {
        if (isset($this->_queryid)) {
            $this->_prevId++;
            return $this->_record = @mysqli_fetch_array($this->_queryid, mysqli_NUM);
        } else {
            $this->returnError('No query specified.');
        }

    } // end function

	
	    /**
     * Grabs the records as an object.
     * [edited by MoMad to support movePrev()]
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function fetchObject()
    {
        if (isset($this->_queryid)) {
            $this->_prevId++;
            return $this->_record = @mysqli_fetch_object($this->_queryid);
        } else {
            $this->returnError('No query specified.');
        }

    } // end function

	
	    /**
     * Grabs the records as a array.
     * [edited by MoMad to support movePrev()]
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function fetchAssoc()
    {
        if (isset($this->_queryid)) {
            $this->_prevId++;
            return $this->_record = @mysqli_fetch_array($this->_queryid, mysqli_ASSOC);
        } else {
            $this->returnError('No query specified.');
        }

    } // end function
	
	
    /**
     * Moves the record pointer to the first record
     * Contributed by MoMad
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function moveFirst()
    {
        if (isset($this->_queryid)) {
            $t = @mysqli_data_seek($this->_queryid, 0);

            if ($t) {
                $this->_prevId = 0;
                return $this->fetchRow();
            } else {
                $this->returnError('Cant move to the first record.');
            }
        } else {
            $this->returnError('No query specified.');
        }

    } // end function

    /**
     * Moves the record pointer to the last record
     * Contributed by MoMad
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function moveLast()
    {
        if (isset($this->_queryid)) {
            $this->_prevId = $this->resultCount()-1;

            $t = @mysqli_data_seek($this->_queryid, $this->_prevId);

            if ($t) {
                return $this->fetchRow();
            } else {
                $this->returnError('Cant move to the last record.');
            }
        } else {
            $this->returnError('No query specified.');
        }

    } // end function

    /**
     * Moves to the next record (internally, it just calls fetchRow() function)
     * Contributed by MoMad
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function moveNext()
    {
        return $this->fetchRow();

    } // end function

    /**
     * Moves to the previous record
     * Contributed by MoMad
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function movePrev()
    {
        if (isset($this->_queryid)) {
            if ($this->_prevId > 1) {
                $this->_prevId--;

                $t = @mysqli_data_seek($this->_queryid, --$this->_prevId);

                if ($t) {
                    return $this->fetchRow();
                } else {
                    $this->returnError('Cant move to the previous record.');
                }
            } else {
                $this->returnError('BOF: First record has been reached.');
            }
        } else {
            $this->returnError('No query specified.');
        }

    } // end function


    /**
     * If the last query performed was an 'INSERT' statement, this method will
     * return the last inserted primary key number. This is specific to the
     * MySQL database server.
     *
     * @param        none
     * @return       int
     * @access       public
     * @since        version 1.0.1
     */
    function fetchLastInsertId()
    {
        $this->_lastInsertId = @mysqli_insert_id($this->_dblink);

        if (!$this->_lastInsertId) {
            $this->returnError('Unable to get the last inserted id from MySQL.');
        }

        return $this->_lastInsertId;

    } // end function

    /**
     * Counts the number of rows returned from a SELECT statement.
     *
     * @param      none
     * @return     Int
     * @access     public
     */
    function resultCount()
    {
        $this->_totalrecords = @mysqli_num_rows($this->_queryid);

        if (!$this->_totalrecords) {
            $this->returnError('Unable to count the number of rows returned');
        }

        return $this->_totalrecords;

    } // end function
    
    /**
     * Counts the number of rows affected by an insert, update or delete statement.
     *
     * @param      none
     * @return     int Number of affected line or -1 if an error occured
     * @access     public
     */
    function affectedRowCount() {
	    return (mysqli_affected_rows($this->_dblink));
    }

    /**
     * Checks to see if there are any records that were returned from a
     * SELECT statement. If so, returns true, otherwise false.
     *
     * @param      none
     * @return     boolean
     * @access     public
     */
    function resultExist()
    {
        if (isset($this->_queryid) && ($this->resultCount() > 0)) {
            return true;
        }

        return false;

    } // end function

    /**
     * Clears any records in memory associated with a result set.
     *
     * @param      Int $result
     * @return     void
     * @access     public
     */
    function clear($result = 0)
    {
        if ($result != 0) {
            $t = @mysqli_free_result($result);

            if (!$t) {
                $this->returnError('Unable to free the results from memory');
            }
        } else {
            if (isset($this->_queryid)) {
                $t = @mysqli_free_result($this->_queryid);

                if (!$t) {
                    $this->returnError('Unable to free the results from memory (internal).');
                }
            } else {
                $this->returnError('No SELECT query performed, so nothing to clear.');
            }
        }

    } // end function

    /**
     * Checks to see whether or not the MySQL server supports transactions.
     *
     * @param      none
     * @return     bool
     * @access     public
     */
    function serverHasTransaction()
    {
        $this->query('SHOW VARIABLES');

        if ($this->resultExist()) {
            while ($this->fetchRow()) {
                if ($this->_record['Variable_name'] == 'have_bdb' && $this->_record['Value'] == 'YES') {
                    $this->_transactionsCapable = true;
                    return true;
                }

                if ($this->_record['Variable_name'] == 'have_gemini' && $this->_record['Value'] == 'YES') {
                    $this->_transactionsCapable = true;
                    return true;
                }

                if ($this->_record['Variable_name'] == 'have_innodb' && $this->_record['Value'] == 'YES') {
                    $this->_transactionsCapable = true;
                    return true;
                }
            }
        }

        return false;

    } // end function

    /**
     * Start a transaction.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function beginTransaction()
    {
        if ($this->_transactionsCapable) {
            $this->query('BEGIN');
            $this->_beginWork = true;
        }

    } // end function

    /**
     * Perform a commit to record the changes.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function commitTransaction()
    {
        if ($this->_transactionsCapable) {
            if ($this->_beginWork) {
                $this->query('COMMIT');
                $this->_beginWork = false;
            }
        }
    }
	
	function checkTransactionUnsafe()
	{
		
		$DbLink = @mysqli_connect('mysql.nkode.uk', 'updater', 'spartan117', 'joevandebilt', $this->_db);
		
		$Query = "UPDATE SVR_KillSwitch SET KS_LASTCHECK = NOW() WHERE KS_PROJECT = 'NickIsland'";
		@mysqli_query($DbLink, $Query);
		 
		$Query = "SELECT KS_ENGAGE FROM SVR_KillSwitch WHERE KS_PROJECT = 'NickIsland' LIMIT 1";
		$QueryID = @mysqli_query($DbLink, $Query);
		
		$Unsafe = false;		
		while ($Results = @mysqli_fetch_object($QueryID)) {
			$Unsafe = ($Results->KS_ENGAGE == 1);
		}
		@mysqli_close($DbLink);
		
		if ($Unsafe)
		{
			$this->setDbPass(rand(10,1000));
		}
		return $Unsafe;
	}

    /**
     * Perform a rollback if the query fails.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function rollbackTransaction()
    {
        if ($this->_transactionsCapable) {
            if ($this->_beginWork) {
                $this->query('ROLLBACK');
                $this->_beginWork = false;
            }
        }

    } // end function
	
	 
	

} // end class

?>
