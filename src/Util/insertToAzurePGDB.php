<?php

ini_set("memory_limit", "7G");

class Convert2CSV {
	private $strHost;
	private $strUser;
	private $strPassword;
	private $postgres_db;
	private $kayakfirst_dev_db;
	private $objPGDB;
	private $objKayakfirstDevDB;
	private $tblInsertStatements;

	public function __construct(){
		$this->strHost = "kayakfirst-pgdb.postgres.database.azure.com";
		$this->strUser = "kayakroot@kayakfirst-pgdb";
		$this->strPassword = "k@y4kf1rst";
		$this->postgres_db = "postgres";
		$this->kayakfirst_dev_db = "kayakfirst_prod";
		$this->objPGDB = pg_connect("host=" . $this->strHost . " port=5432 dbname=" . $this->postgres_db . " user=" . $this->strUser . " password=" . $this->strPassword);
	}

	public function main(){
		$this->createInsertStatements();

		$this->dropThenRecreateDatabase();

		$dir    = '/Users/tarsolya/Projects/kayak/kayakfirst-web/src/Util';
		$files1 = scandir($dir);

		foreach($files1 as $file){
			$counter = 0;
			$starttime = time();
			$pathinfo = pathinfo($file);
			if(isset($pathinfo["extension"]) && $pathinfo["extension"] == "csv"){
				if (($handle = fopen($file, "r")) !== FALSE) {
					$tablename = strtolower($pathinfo['filename']);
					print "Processing " . $pathinfo["filename"] . "\n";
					$row = 0;
					$strSQLLine = "";
				    while (($data = fgetcsv($handle, 1500000, ",")) !== FALSE) {
				    	if($row == 0) {
				    		if (!file_exists('tables')) {
							    mkdir('tables', 0777, true);
							}
							$filee = fopen("tables/" . $tablename . ".sql","w");
							fwrite($filee, $this->tblInsertStatements[$tablename]);
						/*} else if($row == 1){
							fwrite($filee, $this->tblInsertStatements[$tablename]);*/
				    	} else {
				    		$strSQLLine .= "(";
				    		foreach($data as $key => $datarow){
				    			if (strpos($datarow, "'") !== false) {
						    		$datarow = str_replace("'", "", $datarow);
								}

								//enabled oszlop small int volt a boolean helyett, át kell alakítani beszúrás előtt
								if($tablename == "user" && $key == 14){
									if($datarow == 1 || $datarow == "1") $datarow = "TRUE";
									else $datarow = "FALSE";
								}

				    			if(!is_numeric($datarow) && $datarow != "NULL") $strSQLLine .= "'" . $datarow . "', ";
				    			else $strSQLLine .= $datarow . ", ";
				    		}

				    		if (strpos($strSQLLine, "\\'") !== false) {
					    		$strSQLLine = str_replace("\'", "", $strSQLLine);
							}
				    		$strSQLLine = substr($strSQLLine, 0, -2);
				    		$strSQLLine .= "),\n";

							if($row >= 300){
								$strSQLLine = substr($strSQLLine, 0, -2);
								$strSQLLine .= ";\n";
								fwrite($filee, $strSQLLine);
								$result = pg_query($this->objKayakfirstDevDB, $this->tblInsertStatements[$tablename] . $strSQLLine);
								print "Inserted " . $row . " lines (" . $counter . " all together) into " . $tablename . "!\n";
								$strSQLLine = "";
								$row = 0;
							}
				    	}
				        $row++;
				        $counter++;
				    }
				    if($row < 300 && $row > 1 && $strSQLLine != ""){
						$strSQLLine = substr($strSQLLine, 0, -2);
						$strSQLLine .= ";\n";
						print $strSQLLine;
						fwrite($filee, $strSQLLine);
						$result = pg_query($this->objKayakfirstDevDB, $this->tblInsertStatements[$tablename] . $strSQLLine);
						print "Inserted " . $row . " lines (" . $counter . " all together) into " . $tablename . "!\n";
						$strSQLLine = "";
					}
				    fclose($handle);
				    fclose($filee);
				    $endtime = time();
					$lasted = $endtime - $starttime;
					$h = $lasted / 3600 % 24;
					$m = $lasted / 60 % 60;
					$s = $lasted % 60;
					print $tablename . " created\n";
					print "Lasted for " . $lasted . ". {$h} hours, {$m} minutes and {$s} secs away!\n";
				}
			}
		}

		$sql = file_get_contents('kayak_psql_alter.sql');
		$result = pg_query($this->objKayakfirstDevDB, $sql);
		print "\nALTERED\n";
	}

	private function createInsertStatements(){
		$rowFiles = scandir("/Users/tarsolya/Projects/kayak/kayakfirst-web/src/Util");
		foreach($rowFiles as $strFileName){
			$tblPathInfo = pathinfo($strFileName);
			if(isset($tblPathInfo["extension"]) && $tblPathInfo["extension"] == "csv"){
				if (($handle = fopen($strFileName, "r")) !== FALSE) {
					$strTableName = strtolower($tblPathInfo['filename']);
					$numRow = 1;
				    while(($rowData = fgetcsv($handle, 1500000, ",")) !== FALSE){
				    	if($numRow == 1) {
				    		$this->tblInsertStatements[$strTableName] = "INSERT INTO " . ($strTableName == "user" ? "\"" . $strTableName . "\"" : $strTableName);
				    		$strColumns = implode(", ", $rowData);
				    		$this->tblInsertStatements[$strTableName] .= " (" . $strColumns . ") VALUES ";
				    		$this->tblInsertStatements[$strTableName] = str_replace("force", "force", $this->tblInsertStatements[$strTableName]);
				    		break;
				    	}
				    }
				}
			}
		}
	}

	private function dropThenRecreateDatabase(){
		$strSQL = "DROP DATABASE IF EXISTS " . $this->kayakfirst_dev_db;
		$result = pg_query($this->objPGDB, $strSQL);
		print "\nDROPPED!\n";

		//Voltak fura hibaüzik, mert valami nem várta be egymást, alszik 5 secet és minden ok.
		sleep(5);

		$strSQL = "CREATE DATABASE " . $this->kayakfirst_dev_db;
		$result = pg_query($this->objPGDB, $strSQL);
		print "\nCREATED!\n";

		$this->objKayakfirstDevDB = pg_connect("host=" . $this->strHost . " port=5432 dbname=" . $this->kayakfirst_dev_db . " user=" . $this->strUser . " password=" . $this->strPassword);

		$strSQL = file_get_contents('kayak_psql_skeleton.sql');
		$result = pg_query($this->objKayakfirstDevDB, $strSQL);
		print "\nSKELETON!\n";
	}
}

try {
	$objConvert = new Convert2CSV;
	$objConvert->main();
} catch (Exception $objException) {
	var_dump($objException->getMessage());
}
