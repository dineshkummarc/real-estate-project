<?php
    include dirname(__FILE__) . '/connection.php';

    function OpenDBConnection() {
        $db = NULL;
        try {
            $db = new PDO($GLOBALS['pdoConnectionString'], $GLOBALS['pdoUser'], $GLOBALS['pdoPass'], array(PDO::ATTR_PERSISTENT => true));
        }catch (PDOException $e) {
            echo 'Connection failed: There was an error accessing the database.';
			//var_dump(print_r(debug_backtrace(),true));
            die;
        }
        return $db;
    }
    
    function CloseDBConnection(&$pdoObject) {
        $pdoObject = NULL;
    }

    function DBSelect($sql, $paramsArray = array()) {
        $rows = NULL;
        $db = OpenDBConnection();
        if($stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY))) {
            $stmt->execute($paramsArray);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($stmt->rowCount()<=0) $rows = NULL;
        }
        $stmt = NULL;
        CloseDBConnection($db);
        return $rows;
    }

    function DBSelectOne($sql, $paramsArray = array()) {
        $rows = NULL;
        $db = OpenDBConnection();
        if($stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY))) {
            $stmt->execute($paramsArray);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            if($rows===FALSE) $rows = NULL;
        }
        $stmt = NULL;
        CloseDBConnection($db);
        return $rows;
    }

    function DBQuery($sql, $paramsArray = array()) {
        $rows = NULL;
        $db = OpenDBConnection();
		if($stmt = $db->prepare($sql)) {
            if($rows = $stmt->execute($paramsArray)) {
				$rows = $stmt->rowCount();
            }
        }
        $stmt = NULL;
        CloseDBConnection($db);
        return $rows;
    }

    function DBInsert($table, $fieldsArray, $valuesArray) {
        $result = NULL;
        if(trim($table) && is_array($valuesArray) && is_array($fieldsArray)) {
            $flds = implode(",", $fieldsArray);
			if(array_key_exists(0, $valuesArray)){
				if(! is_array($valuesArray[0])) $valuesArray = array($valuesArray);
			}else{
				$valuesArray = array($valuesArray);
			}
            $vals = array();
            foreach($valuesArray as $v) {
                $vals[] = "('" . implode("','", $v) . "')";
            }
            $vals = implode(",", $vals);
            $sql = "INSERT INTO $table($flds) VALUES $vals";
			var_dump($sql);
			$result = DBQuery($sql);
        }
        return $result;
    }

    function DBUpdate($table, $fieldsArray, $valuesArray, $key) {
        $result = NULL;
        if(trim($table) && is_array($valuesArray) && is_array($fieldsArray)) {
			if(array_key_exists(0, $valuesArray)){
				if(! is_array($valuesArray[0])) $valuesArray = array($valuesArray);
			}else{
				$valuesArray = array($valuesArray);
			}
            $vals = array();
            foreach($valuesArray as $v) {
				$result = '';
				$index = 0;
				$is_assoc = (is_assoc($v) || false);
				foreach($fieldsArray as $f){
					if($is_assoc)
						$value = $v[$f];
					else
						$value = $v[$index];
					$result .= "`$f`=". (($value || $value==="0") ? "'$value'," : "DEFAULT,");
					$index++;
				}
				$keyval = $is_assoc ? $v[$key] : end($v);
				$sql = "UPDATE $table SET ".substr($result,0,strlen($result)-1)." WHERE $key = " . $keyval;
				$result = DBQuery($sql);
            }
        }
        return $result;
    }
    
    function Login($user, $pass) {
        $err = '';
        $user = trim($user);
        $pass = trim($pass);
        if(!$user || !$pass) {
            $err = "Both User Name and Password are required.";
        }
        else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $row = DBSelectOne("SELECT *, CONCAT(surname,' ',othernames) AS name FROM users WHERE (phone=? OR regNumber=? OR email=?)", array($user,$user,$user));
            if($row && password_verify($pass, $row['password'])) {
                unset($row['password']);
                $_SESSION['user'] = $row;
                $err = TRUE;
            }
            else
                $err = "Invalid User Name or Password!";
        }
        return $err;
    }
    
    function adminLogin($user, $pass) {
        $err = '';
        $user = trim($user);
        $pass = trim($pass);
        if(!$user || !$pass) {
            $err = "Both User Name and Password are required.";
        }
        else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $row = DBSelectOne("SELECT *, fullname AS name FROM admin WHERE (phone=? OR staffNumber=? OR email=?)", array($user,$user,$user));
            if($row && password_verify($pass, $row['password'])) {
                unset($row['password']);
                $_SESSION['__user'] = $row;
                $err = TRUE;
            }
            else
                $err = "Invalid User Name or Password!";
        }
        return $err;
    }
    
    function CreateAccount($surname, $othername, $email, $phone, $pass, $prog) {
        $err = '';
        $sur = trim($surname);
        $oth = trim($othername);
        $email = trim($email);
        $phn = trim($phone);
        $pass = trim($pass);
        $prog = trim($prog);
        if(!$sur || !$oth || !$email || !$phn || !$pass || !$prog) {
            $err = "Please supply all fields, as they are required.";
        }
        else {
			$db = OpenDBConnection();
			if($prog == 'LVT')
				$e = DBSelectOne("SELECT * FROM session WHERE isCurrentLVT=1");
			else
				$e = DBSelectOne("SELECT * FROM session WHERE isCurrentHD=1");
			$passHash = password_hash($pass, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users (surname, othernames, email, phone, password, date, sessionId, programme) VALUES(?,?,?,?,?,?,?,?)";
			$stmt = $db->prepare($sql);
			$res = $stmt->execute(array($sur,$oth,$email,$phn,$passHash,date("j-M-Y g:i A"),$e['sessionId'],$prog));
			$regnum = '';
			if(!($res === FALSE)) {
				$r = $db->lastInsertId();
				switch(strlen($r)){
					case 1 :
					$regnum = "0000".$r;
					break;
					case 2 :
					$regnum = "000".$r;
					break;
					case 3 :
					$regnum = "00".$r;
					break;
					case 4 :
					$regnum = "0".$r;
					break;
					default:
					$regnum = $r;
				}
				$sql = "UPDATE users SET regNumber=? WHERE email=? AND phone=?";
				DBQuery($sql, array($regnum,$email,$phone));
				$err = TRUE;
			}else{
				$err = "Error occured while creating account, please note that a phone number or an email address can be used to create only one account.";
			}
			$stmt = NULL;
        }
        return $err;
    }
    
    function RedirectTo($location, $msg = NULL) {
        if($msg) {
            $_SESSION['appMsg'] = $msg;
            session_write_close();
        }
        header("Location: $location");
    }

    function GrantAuthenticated() {
		if(!(isset($_SESSION['user']))) {
            $_SESSION['appMsg'] = 'You do not have the right to access the requested page! Please log in with an appropriate privilege';
            RedirectTo($GLOBALS['rootDir']."/index.php",$_SESSION['appMsg']);
        }
    }

    function IsAuthenticated() {
        return isset($_SESSION['user']) && isset($_SESSION['user']['role']);
    }

    function AppMsg($msg) {
        $_SESSION['appMsg'] = $msg;
    }

    /*=============================
    *   GetCrossTabSql  : returns a sql string for creating cross tab query
    *   Params          : Array (
    *                               'table'             = REQUIRED : Name of table on which query will be executed
    *                               'rowHeaders'        = REQUIRED : An array or comma-delimited-list of row headers
    *                               'columnHeader'      = name of column whose unique values will form the column headers
    *                               'columnHeaders'     = OPTIONAL : An array of column headers, if provided will be used instead of columnHeader field
    *                               'valueField'        = REQUIRED : name of column to use as the value for each column headers
    *                               'aggregateFnName'   = OPTIONAL : name of aggregate function to aggregate the valueField. DEFAULT=SUM
    *                               'filter'            = OPTIONAL : WHERE clause for limiting the returned records, without the WHERE keyword
    *                               'getColumnNames'    = OPTIONAL : a reference field, if provided, used to return the generated column headers back to the calling scope
    ) 
    */
	function GetCrossTabSql(array $paramsArray) {
		$sql = ''; $fixedCols = false;

        $table = isset($paramsArray['table']) ? $paramsArray['table'] : NULL;
        $rowHeaders = isset($paramsArray['rowHeaders']) ? $paramsArray['rowHeaders'] : NULL;
        $columnHeader = isset($paramsArray['columnHeader']) ? $paramsArray['columnHeader'] : NULL;
        $columnHeaders = isset($paramsArray['columnHeaders']) ? $paramsArray['columnHeaders'] : NULL;
        $valueField = isset($paramsArray['valueField']) ? $paramsArray['valueField'] : NULL;
        $aggregateFnName = isset($paramsArray['aggregateFnName']) ? $paramsArray['aggregateFnName'] : "SUM";
        $filter = isset($paramsArray['filter']) ? $paramsArray['filter'] : NULL;
        $getColumnNames = isset($paramsArray['getColumnNames']) ? $paramsArray['getColumnNames'] : NULL;
        
		if($table && $rowHeaders && ($columnHeader || $columnHeaders) && $valueField) {
			if(is_array($rowHeaders))
				$rowHeaders = implode(",", $rowHeaders);
			$whereClause = ($filter ? "WHERE $filter" : "");
            if(isset($columnHeaders) && $columnHeaders) {
                $cols = $columnHeaders;
                $fixedCols = true;
            }
            else
                $cols = DBSelect("SELECT DISTINCT $columnHeader FROM $table $whereClause");
            if(is_array($cols)) {
                $cnames = '';
                foreach($cols as $c) {
                    $cVal = $fixedCols ? $c : $c["$columnHeader"];
                    $sql .= "$aggregateFnName(IF($columnHeader = '$cVal',$valueField,NULL)) AS `$cVal`,";
                    $cnames .= "$cVal,";
                }
                $sql = substr($sql,0,strlen($sql)-1);
                if(isset($getColumnNames)) $getColumnNames = substr($cnames,0,strlen($cnames)-1);
                $sql = "SELECT $rowHeaders,$sql FROM $table $whereClause GROUP BY $rowHeaders ORDER BY $rowHeaders";
            }
		}
		return($sql);
	}

	function SendMail($message, $recipient) {
		$res = mail($recipient, "ATBU SUG Election", $message."\r\n\r\nThis message is auto-generated. Don't reply this message.", "From: sugelcom@atbu.edu.ng\r\nReply-To: sugelcom@atbu.edu.ng", "-fsugelcom@atbu.edu.ng" );
        AppLog("result=$res #  $recipient # ATBU SUG Election # $message This message is auto-generated. Don't reply this message. # From: sugelcom@atbu.edu.ng\r\nReply-To: sugelcom@atbu.edu.ng # -fsugelcom@atbu.edu.ng",true);
	}
	
    function GenerateCode() {
        //alphanumeric LOWER
        $alphabetLower = "abcdefghijklmnopqrstuwxyz";
        $password_created = array(); //remember to declare $pass as an array
        $alphabetLength = strlen($alphabetLower) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $pos = rand(0, $alphabetLength); // rand(int $min , int $max)
            $password_created[] = $alphabetLower[$pos];
        }
        $part1 = ''; //implode($password_created); //turn the array into a string
        //alphanumeric UPPER
        $alphabetUpper = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $password_created2 = array(); //remember to declare $pass as an array
        $alphabetLength2 = strlen($alphabetUpper) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $pos = rand(0, $alphabetLength2); // rand(int $min , int $max)
            $password_created2[] = $alphabetUpper[$pos];
        }
        $part2 = implode($password_created2); //turn the array into a string
        //alphanumeric NUMBER
        $alphabetNum = "23456789";    //"0123456789";
        $password_created3 = array(); //remember to declare $pass as an array
        $alphabetNumLength = strlen($alphabetNum) - 1; //put the length -1 in cache
        for ($i = 0; $i < 2; $i++) {
            $pos = rand(0, $alphabetNumLength); // rand(int $min , int $max)
            $password_created3[] = $alphabetNum[$pos];
        }
        $part3 = implode($password_created3); //turn the array into a string
        return $password = $part2 . $part3 . $part1; // . "#";
    }
    
    function AppLog($msg, $show = TRUE) {
        if($show) {
            $path = dirname(dirname(__FILE__))."/app_log.txt";
            $fp = fopen($path, 'a');
            $ln = "%s; %s\r\n";
            fprintf($fp, $ln, date("F j, Y, g:i a"), $msg);
            fclose($fp);
        }
	}
    
	function CreateList($query,$selectedvalue=NULL,$doecho=TRUE)
	{
		$result = '';
		$isarray = false;
		$QueryAnswer = NULL;
		
		if(is_string($query)) {
			$QueryAnswer = DBSelect($query);
			if(!is_array($QueryAnswer)) $QueryAnswer = NULL;
		}
		else
			$isarray = is_array($query);

		if(!$query || (!$isarray && !$QueryAnswer) || ($isarray && count(array_values($query))<=0) ){
			$result = "<option OptionValue= \"-1\">No List Available</option>";
		}
		else
		{
			if($QueryAnswer)
			{
				for($i=0; $i<count($QueryAnswer); $i++)
				{
					$row = array_values($QueryAnswer[$i]);
					list($OptionValue,$OptionName) = $row;
					$result .= CreateSelectOptionTag($OptionValue,$OptionName,$selectedvalue);
				}
			}
			else
			{
				//$array = array_flatten($array);
				foreach($query as $key => $value)
				{
					$result .= CreateSelectOptionTag($key,$value,$selectedvalue);
				}
			}
		}
		if($doecho)
			echo $result;
		return $result;
	}
	
	function CreateSelectOptionTag($key,$value,$selected=NULL)
	{
		return '<option ' . ($selected==$key ? 'selected="selected" ' : '') . "value =\"$key\">$value</option>";
	}
	
	function is_assoc($arr) {
		return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
	}
	
	function is_iassoc($arr){
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	function RefreshUser(){
		$row = DBSelectOne("SELECT *, CONCAT(surname,' ',othernames) AS name FROM users WHERE (id=?)", array($_SESSION['user']['id']));
		if($row) {
			unset($row['password']);
			$_SESSION['user'] = $row;
		}
	}