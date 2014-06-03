<?php
	error_reporting(0);
	//ini_set("display_errors", 1);
	define("RESERVE_WORDS", " UUID() CURDATE() NOW() AES_ENCRYPT");
	function multineedle_stripos($haystack, $needles, $offset=0) {
		foreach($needles as $needle) {
			$found[$needle] = stripos($haystack, $needle, $offset);
		}
		return $found;
	}
	
	class MySqlConnection{
		private $reserveWords = array("UUID()", "CURDATE()", "NOW()", "AES_ENCRYPT");
		private $strCon = array();
		private $objCon;
		function __construct($constring){
			$cs = explode(';', $constring);
			for($i = 0; $i < count($cs); $i++){
				if($cs[$i] != '' && strpos($cs[$i], '=') > -1){
					$csval = explode('=', $cs[$i]);
					if($csval[0] != '')
					$this->strCon[$csval[0]] = $csval[1];
				}
			}
		}
		function __destruct(){
			//try{
			//	$this->objCon->close();
			//}
			//catch(Exception $e){}
		}
		function __set($name, $value){
			$this->strCon[$name] = $value;
		}
		function __get($name){
			if(array_key_exists($name, $this->strCon)){
				return $this->strCon[$name];
			}
			$trace = debug_backtrace();
			trigger_error("Undefined property: " . $name, E_USER_NOTICE);
			return null;
		}
		function __isset($name){
			if(isset($this->strCon[$name]))
				return isset($this->strCon[$name]);
			trigger_error("Undefined property: " . $name, E_USER_ERROR);
		}
		function __unset($name){
			unset($this->strCon[$name]);
		}
		function open(){
			$this->objCon = new mysqli($this->strCon["server"], $this->strCon["userid"], $this->strCon["password"], $this->strCon["database"]);
			if(mysqli_connect_errno())
				die("Unable to connect to database server.\n" . mysqli_connect_error());
		}
		function close(){
			$this->objCon->close();
		}		
		function query(){
			$args = func_get_args();
			$data = array();
			switch($args[0]){
				case "text":
				case "query":
					$rs = mysqli_query($this->objCon, $args[1]);
					if(is_object($rs)){
						if(mysqli_num_rows($rs) >= 1){
							if(mysqli_num_rows($rs) <= 1000){
								while($record = $rs->fetch_array(MYSQLI_ASSOC))
									$data[] = $record;
							}
							else{
								$data["response"] = "ERROR";
								$data["error"] = "No many data";
							}
						}
						else{
							$data["response"] = "ERROR";
							$data["error"] = "No data found";
						}
						if(is_resource($rs)){
							mysqli_free_result($rs);
							mysqli_next_result($this->objCon);
						}
					}
					else{
						$data["response"] = "ERROR";
						$data["error"] = "Unable to execute query: \"" . $args[1] . "\"";
					}
				break;
				case "table":
					switch(count($args)){
						case 6:
						$recordCount = 0;
						$firstCol = "";
						$rs = mysqli_query($this->objCon, "SHOW COLUMNS FROM " . $args[1]);
						if(is_object($rs)){
							if(mysqli_num_rows($rs) >= 1){
								$record = $rs->fetch_array(MYSQLI_ASSOC);
								$firstCol = $record["Field"];
							}
							else{
								$data["response"] = "ERROR";
								$data["error"] = "No column found";
							}
							if(is_resource($rs)){
								mysqli_free_result($rs);
								mysqli_next_result($this->objCon);
							}
						}
						else{
							$data["response"] = "ERROR";
							$data["error"] = "Unable to get columns for table \"" + $args[1] + "\"";
						}
						if($firstCol != ""){
							$rs = mysqli_query($this->objCon, "SELECT COUNT(" . $firstCol . ") as TotalCols FROM " . $args[1]);
							if(is_object($rs)){
								if(mysqli_num_rows($rs) >= 1){
									$record = $rs->fetch_array(MYSQLI_ASSOC);
									$recordCount = $record["TotalCols"];
								}
								else{
									$data["response"] = "ERROR";
									$data["error"] = "No record found";
								}
								if(is_resource($rs)){
									mysqli_free_result($rs);
									mysqli_next_result($this->objCon);
								}
							}
							else{
								$data["response"] = "ERROR";
								$data["error"] = "Unable to find record count from table \"" + $args[1] + "\"";
							}
						}
						if($recordCount > 0){
							$limitStart = 0;
							$limitEnd = 0;
							if($args[5] > 0){
								$noOfpage = ceil($recordCount/$args[5]);
								if($args[4] <= 0 || $args[4] > $noOfpage)
									$args[4] = 1;
								$limitStart = ($args[4] - 1) * $args[5];
								$limitEnd = $args[5];
							}
							$sql = "SELECT * FROM " . $args[1];
							if($args[2] != '')
								$sql .=  " WHERE " . $args[2];
							if($args[3] != '')
								$sql .=  " ORDER BY " . $args[3];
							if($limitStart > -1 && $limitEnd > 0)
								$sql .= " LIMIT " . $limitStart . ", " . $limitEnd;
							$rs = mysqli_query($this->objCon, $sql);
							if(is_object($rs)){
								if(mysqli_num_rows($rs) >= 1){
									if(mysqli_num_rows($rs) <= 1000){
										while($record = $rs->fetch_array(MYSQLI_ASSOC))
											$data[] = $record;
									}
									else{
										$data["response"] = "ERROR";
										$data["error"] = "Too many data, can not show more than 1000 records.";
									}
								}
								else{
									$data["response"] = "ERROR";
									$data["error"] = "No data found";
								}
								if(is_resource($rs)){
									mysqli_free_result($rs);
									mysqli_next_result($this->objCon);
								}
							}
							else {
								$data["response"] = "ERROR";
								$data["error"] = "Unable to execute query on table \"" . $args[1] . "\"";
								$data["sql"] = $sql;
							}
						}
						break;
						case 5:
							$data["response"] = "ERROR";
							$data["error"] = "Record per page not defined.";
						break;
						case 4:
							$data["response"] = "ERROR";
							$data["error"] = "Page number not defined.";
						break;
						case 3:
							$data["response"] = "ERROR";
							$data["error"] = "Sorting fields [ORDER BY] not defined. Pass blank '' if not reqiured.";
						break;
						case 2:
							$data["response"] = "ERROR";
							$data["error"] = "Filter [WHERE] parameters not defined. Pass blank '' if not reqiured.";
						break;
						case 1:
							$data["response"] = "ERROR";
							$data["error"] = "Table name not defined.";
						break;
						default:
							$data["response"] = "ERROR";
							$data["error"] = "No parameter defined.";
						break;
					}
				break;
				case "stored procedure":
					$rs = mysqli_query($this->objCon, "Call " . $args[1]);
					$noORA = mysqli_affected_rows($this->objCon);
					//echo $noORA;
					if($noORA > 0){
						if(is_object($rs))
						{
							if(mysqli_num_rows($rs) >= 1){
								if(mysqli_num_rows($rs) <= 1000){
									while($record = $rs->fetch_array(MYSQLI_ASSOC))
										$data[] = $record;
								}
								else{
									$data["response"] = "ERROR";
									$data["error"] = "Too many data, can not show more than 1000 records.";
								}
							}
							else{
								$data["response"] = "ERROR";
								$data["error"] = "No data found";
							}
							if($rs){
								mysqli_free_result($rs);
								mysqli_next_result($this->objCon);
							}
						}
						else {
							if(mysqli_error($this->objCon) == 0){
								$data["response"] = "SUCCESS";
								$data["count"] = mysqli_affected_rows($this->objCon);
								$data["sql"] = $args[1];
							}
							else
							{
								$data["response"] = "ERROR";
								$data["error"] = mysqli_errno($this->objCon) . ": " . mysqli_error($this->objCon);
								$data["sql"] = $args[1];
							}
						}
					}
					else {
						$data["response"] = "ERROR";
						$data["error"] = mysqli_errno($this->objCon) . ": " . mysqli_error($this->objCon);
						mysqli_next_result($this->objCon);
					}
				break;
				default:
					$data["response"] = "ERROR";
					$data["error"] = "Call type \"" . $args[0] . "\" not available.";
				break;
			}
			return $data;	
		}
		function insert($table, $arrFieldsValues){
			$data = array();
			$fields = array_keys($arrFieldsValues);
			$values = array_values($arrFieldsValues);
			$escValues = array();
			foreach($values as $val){
				$iF = FALSE;
				if(!is_numeric($val)){
					$result = multineedle_stripos(trim($val), $this->reserveWords);
					for($i = 0; $i < count($this->reserveWords); $i++){
						if(trim($result[$this->reserveWords[$i]]) != "")
							$iF = TRUE;
					}
				}
				//if(!is_numeric($val) && stripos(RESERVE_WORDS, trim($val)) === false){
				//	$val = "'" . mysqli_escape_string($this->objCon, $val) . "'";
				//}
				if(!is_numeric($val) && !$iF){
					$val = "'" . mysqli_escape_string($this->objCon, $val) . "'";
				}				
				$escValues[] = $val;
			}
			$sql = "INSERT INTO " . $table . "(";
			$sql .= join(', ', $fields);
			$sql .= ") VALUES (";
			$sql .= join (', ', $escValues) . ")";
			if(!mysqli_query($this->objCon, $sql)){
				$data["response"] = "ERROR";
				$data["error"] = mysqli_error($this->objCon);
				$data["sql"] = $sql;
			}
			else {
				$data["response"] = "SUCCESS";
				$data["count"] = mysqli_affected_rows($this->objCon);
				$data["sql"] = $sql;
			}
			return $data;
		}
		function update($table, $arrFieldsValues, $arrConditions){
			$arrUpdates = array();
			$data = array();
			$result = array();
			foreach($arrFieldsValues as $fields => $values){
				$iF = FALSE;
				if(!is_numeric($values)){
					$result = multineedle_stripos(trim($values), $this->reserveWords);
					for($i = 0; $i < count($this->reserveWords); $i++){
						if(trim($result[$this->reserveWords[$i]]) != "")
							$iF = TRUE;
					}
				}
				//if(!is_numeric($values) && stripos(RESERVE_WORDS, trim($values)) === false){
				//	$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				//}
				if(!is_numeric($values) && !$iF){
					$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				}
				$arrUpdates[] = $fields . " = " . $values;
			}
			$arrWhere = array();
			foreach($arrConditions as $fields => $values){
				$iF = FALSE;
				if(!is_numeric($values)){
					$result = multineedle_stripos(trim($values), $this->reserveWords);
					for($i = 0; $i < count($this->reserveWords); $i++){
						if(trim($result[$this->reserveWords[$i]]) != "")
							$iF = TRUE;
					}
				}
				//if(!is_numeric($values) && stripos(RESERVE_WORDS, trim($values)) === false){
				//	$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				//}
				if(!is_numeric($values) && !$iF){
					$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				}
				$arrWhere[] = $fields . " = " . $values;
			}			
			$sql = "UPDATE " . $table;
			$sql .= " SET " . join(', ', $arrUpdates);
			$sql .= " WHERE " . join(' AND ', $arrWhere);
			if(!mysqli_query($this->objCon, $sql)){
				$data["response"] = "ERROR";
				$data["error"] = mysqli_error($this->objCon);
				$data["sql"] = $sql;
			}
			else {
				$data["response"] = "SUCCESS";
				$data["count"] = mysqli_affected_rows($this->objCon);
				$data["sql"] = $sql;
			}
			return $data;
		}
		function delete($table, $arrConditions){
			$arrWhere = array();
			foreach($arrConditions as $fields => $values){
				$iF = FALSE;
				if(!is_numeric($values)){
					$result = multineedle_stripos(trim($values), $this->reserveWords);
					for($i = 0; $i < count($this->reserveWords); $i++){
						if(trim($result[$this->reserveWords[$i]]) != "")
							$iF = TRUE;
					}
				}
				//if(!is_numeric($values) && stripos(RESERVE_WORDS, trim($values)) === false){
				//	$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				//}
				if(!is_numeric($values) && !$iF){
					$values = "'" . mysqli_escape_string($this->objCon, $values) . "'";
				}
				$arrWhere[] = $fields . " = " . $values;
			}
			$sql = "DELETE FROM " . $table;
			$sql .= " WHERE " . join(' AND ', $arrWhere);
			if(!mysqli_query($this->objCon, $sql)){
				$data["response"] = "ERROR";
				$data["error"] = mysqli_error($this->objCon);
				$data["sql"] = $sql;
			}
			else {
				$data["response"] = "SUCCESS";
				$data["count"] = mysqli_affected_rows($this->objCon);
				$data["sql"] = $sql;
			}
			return $data;
		}
		
		/* Funtions to encrypt and decrypt values */
		function encode_base64($sData){
			$sBase64 = base64_encode($sData);
			return strtr($sBase64, '+/', '-_');
		}
		function decode_base64($sData){
		    $sBase64 = strtr($sData, '-_', '+/');
		    return base64_decode($sBase64);
		}
		function _encrypt($sData, $sKey='cor_encryption_key'){
		    $sResult = '';
		    for($i=0;$i<strlen($sData);$i++)
		    {
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) + ord($sKeyChar));
				$sResult .= $sChar;
		    }
		    return $this->encode_base64($sResult);
		}
	
		function _decrypt($sData, $sKey='cor_encryption_key'){
		    $sResult = '';
		    $sData   = $this->decode_base64($sData);
		    for($i=0;$i<strlen($sData);$i++){
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) - ord($sKeyChar));
				$sResult .= $sChar;
		    }
		    return $sResult;
		}
		/* Funtions to encrypt and decrypt values */
	}
?>