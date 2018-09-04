<?php

ini_set('memory_limit','7000M');

class DatabaseMigration {
	private $strHost;
	private $strUserName;
	private $strPassword;
	private $strDatabaseName;
	private $objConnection;
	private $tblTransformedTraining;
	private $numInsertCount;

	public function __construct($argv){
		if(count($argv) < 5) throw new Exception('Argumentumkent adja meg a hostot porttal, felhasznalonevet, jelszot es az adatbazis nevet ilyen sorrendben. Peldaul: php src/db_migration.php 127.0.0.1:3300 root root kayakfirst');

		$this->strHost = $argv[1];
		$this->strUserName = $argv[2];
		$this->strPassword = $argv[3];
		$this->strDatabaseName = $argv[4];
		$this->tblTransformedTraining = [];

		$this->objConnection = new mysqli($this->strHost, $this->strUserName, $this->strPassword, $this->strDatabaseName);
	}

	public function main(){
		if ($this->objConnection->connect_error) throw new Exception("Kapcsolodas sikertelen: " . $this->objConnection->connect_error);

        //$this->clearNewTables();

		$strSQL = "
			SELECT
				session_id
			FROM
				training
			GROUP BY
				session_id
			ORDER BY
				session_id DESC
		";

		$result = $this->objConnection->query($strSQL);

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$tblSessionID[] = $row;
			}
		}

		foreach($tblSessionID as $data){
			$strSQL = "
				SELECT
					*
				FROM
					training
				WHERE
					session_id = {$data["session_id"]}
			";

			$result = $this->objConnection->query($strSQL);

			$tblTraining = [];

			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$tblTraining[] = $row;
				}
			}

			foreach($tblTraining as $key => $rowData){
				$tblTraining[$key]["data"] = unserialize($rowData["data"]);
			}

			foreach($tblTraining as $key => $rowTraining){
				foreach($rowTraining as $strColumnName => $columnValue){
					if($strColumnName == "data"){
						foreach($columnValue as $rowData){
							if(!isset($rowData["currentDistance"]) || $rowData["currentDistance"] == NULL) continue;

							if($rowData["dataType"] == "t_200"){
								$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["timestamp"] = $rowData["timestamp"];
								$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["hash"] = $tblTraining[$key]["hash"];
							}/* else if($rowData["dataType"] == "t_500" || $rowData["dataType"] == "t_1000"){
								continue;
							}*/

							$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])][$rowData["dataType"]] = $rowData["dataValue"];
							//if(isset($this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["session_id"])) continue;

							$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["session_id"] = $tblTraining[$key]["session_id"];
							$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["user_id"] = $tblTraining[$key]["user_id"];
							$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["training_type"] = $tblTraining[$key]["training_type"];
							$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["training_env_type"] = $tblTraining[$key]["training_env_type"];
						}
					}
				}
			}

			/*foreach($this->tblTransformedTraining as $numSessionID => $tblTraining){
				foreach($tblTraining as $numCurrentDistance => $rowTraining){
					if(count($rowTraining) < 11) {
						unset($this->tblTransformedTraining[$numSessionID][$numCurrentDistance]);
                    }
				}
			}*/

			foreach($this->tblTransformedTraining as $numSessionID => $tblTraining){
				ksort($this->tblTransformedTraining[$numSessionID]);
			}

			$this->insertNormalTrainingData();

		}
	}

	private function insertNormalTrainingData(){
		foreach($this->tblTransformedTraining as $strSessionID => $tblTraining){
			foreach($tblTraining as $strCurrentDistance => $rowTraining){

				$strSQL = "
					INSERT INTO newtraining
						(
							session_id
							, timestamp
							, _force
							, speed
							, distance
							, strokes
							, t_200
							, user_id
						)
					VALUES
						(
							{$strSessionID}
							, " . (isset($rowTraining["timestamp"]) ? $rowTraining["timestamp"] : 0) . "
							, " . (isset($rowTraining["pull_force"]) ? $rowTraining["pull_force"] : 0) . "
							, " . (isset($rowTraining["speed"]) ? $rowTraining["speed"] : 0) . "
							, " . ($strCurrentDistance ? $strCurrentDistance : 0) . "
							, " . (isset($rowTraining["strokes"]) ? $rowTraining["strokes"] : 0) . "
							, " . (isset($rowTraining["t_200"]) ? $rowTraining["t_200"] : 0) . "
							, " . (isset($rowTraining["user_id"]) ? $rowTraining["user_id"] : 0) . "
						);
				";

				$strSQL = "
						INSERT INTO training (id, timestamp, force, speed, distance, strokes, t200, user_id)
						VALUES ({$strSessionID}, " . (isset($rowTraining["timestamp"]) ? $rowTraining["timestamp"] : 0) . ", " . (isset($rowTraining["pull_force"]) ? $rowTraining["pull_force"] : 0) . ", " . (isset($rowTraining["speed"]) ? $rowTraining["speed"] : 0) . ", " . ($strCurrentDistance ? $strCurrentDistance : 0) . ", " . (isset($rowTraining["strokes"]) ? $rowTraining["strokes"] : 0) . ", " . (isset($rowTraining["t_200"]) ? $rowTraining["t_200"] : 0) . ", " . (isset($rowTraining["user_id"]) ? $rowTraining["user_id"] : 0) . ");
				";

				file_put_contents("newtraininginsert.sql", $strSQL . "\n", FILE_APPEND | LOCK_EX);

				$this->numInsertCount++;

				/*if(!$this->objConnection->query($strSQL)) {
                    throw new Exception("Az insert muvelet a new training tablaba nem sikerult!\n" . $this->objConnection->error . "\n" . $strSQL);
				} else print $this->numInsertCount . " - Inserted into newtraining\n";*/
			}
		}

		//$this->insertSumTrainingData();
	}

	private function insertSumTrainingData(){
		foreach($this->tblTransformedTraining as $strSessionID => $tblTraining){
			$tblArrayKeys = array_keys($tblTraining);
			$strDuration = $tblTraining[$tblArrayKeys[count($tblTraining) - 1]]["timestamp"] - $tblTraining[$tblArrayKeys[0]]["timestamp"];

			$strSQL = "
				SELECT
					id
					, type
				FROM
					plan
				WHERE
					session_id = {$strSessionID}
			";

			$result = $this->objConnection->query($strSQL);

			$rowPlan = [];

			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$rowPlan = $row;
				}
			}

			$strSQL = "
				INSERT INTO sumtraining
					(
						session_id
						, user_id
						, art_of_paddle
						" . ($tblTraining[$tblArrayKeys[0]]["training_env_type"] ? ", training_environment_type" : "") . "
						, training_count
						" . (isset($rowPlan["id"]) ? ", plan_training_id" : "") . "
						" . (isset($rowPlan["type"]) ? ", plan_training_type" : "") . "
						, start_time
						, duration
						, distance
					)
				VALUES
					(
						{$strSessionID}
						, " . (isset($tblTraining[$tblArrayKeys[0]]["user_id"])? $tblTraining[$tblArrayKeys[0]]["user_id"] : 0) . "
						, 'racing_kayaking'
						" . (isset($tblTraining[$tblArrayKeys[0]]["training_env_type"]) ? ", '" . $tblTraining[$tblArrayKeys[0]]["training_env_type"] . "'" : "") . "
						, " . count($tblTraining) . "
						" . (isset($rowPlan["id"]) ? ", '" . $rowPlan["id"] . "'" : "") . "
						" . (isset($rowPlan["type"]) ? ", '" . $rowPlan["type"] . "'" : "") . "
						, " . (isset($tblTraining[$tblArrayKeys[0]]["timestamp"]) ? $tblTraining[$tblArrayKeys[0]]["timestamp"] : 0) . "
						, " . ($strDuration ? $strDuration : 0) . "
						, " . (isset($tblTraining[$tblArrayKeys[count($tblTraining) - 1]]["currant_distance"]) ? $tblTraining[$tblArrayKeys[count($tblTraining) - 1]]["currant_distance"] : 0) . "
					)
			";

            $this->numInsertCount++;

			if(!$this->objConnection->query($strSQL)) throw new Exception("Az insert muvelet a sum training tablaba nem sikerult!\n" . $this->objConnection->error);
			else print $this->numInsertCount . " - Inserted into sumtraining\n";
		}

		$this->insertAvgTrainingData();
	}

	private function insertAvgTrainingData(){
		foreach($this->tblTransformedTraining as $strSessionID => $tblTraining){
			$tblArrayKeys = array_keys($tblTraining);

			$strSQL = "
				SELECT
					data_type
					, data_value
				FROM
					trainingAvg
				WHERE
					session_id = {$strSessionID}
			";

			$result = $this->objConnection->query($strSQL);

			$tblTmpAverage = [];
			$tblAverage = [];

			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    	$tblTmpAverage[] = $row;
			    }
			}

			foreach($tblTmpAverage as $rowAvg){
				$tblAverage[$rowAvg["data_type"]] = $rowAvg["data_value"];
			}

			if(empty($tblAverage)){
				continue;
			}

			$strSQL = "
				INSERT INTO newtrainingavg
					(
						session_id
						, user_id
						, _force
						, speed
						, strokes
						, t_200
					)
				VALUES
					(
						{$strSessionID}
						, " . (isset($tblTraining[$tblArrayKeys[0]]["user_id"]) ? $tblTraining[$tblArrayKeys[0]]["user_id"] : 0) . "
						, " . (isset($tblAverage["pull_force_av"]) ? $tblAverage["pull_force_av"] : 0) . "
						, " . (isset($tblAverage["speed_av"]) ? $tblAverage["speed_av"] : 0) . "
						, " . (isset($tblAverage["strokes_av"]) ? $tblAverage["strokes_av"] : 0) . "
						, " . (isset($tblAverage["t_200_av"]) ? $tblAverage["t_200_av"] : 0) . "
					)
			";

            $this->numInsertCount++;

			if(!$this->objConnection->query($strSQL)) throw new Exception("Az insert muvelet a avg training tablaba nem sikerult!\n" . $this->objConnection->error);
			else print $this->numInsertCount . " - Inserted into newtrainingavg\n";
		}
	}

	private function clearNewTables(){
        $strSQL = "
			DELETE FROM sumtraining;
		";

        if(!$this->objConnection->query($strSQL))
        	throw new Exception("A delete muvelet a sum training tablaban nem sikerult!\n" . $this->objConnection->error);
        else {
            $strSQL = "
				TRUNCATE TABLE sumtraining;
			";

            if(!$this->objConnection->query($strSQL))
                throw new Exception("A delete muvelet a sum training tablaban nem sikerult!\n" . $this->objConnection->error);
            else
                print "DELETED FROM SUMTRAINING\n";
		}

        $strSQL = "
			DELETE FROM newtrainingavg;
		";

        if(!$this->objConnection->query($strSQL))
        	throw new Exception("A delete muvelet a new training avg tablaban nem sikerult!\n" . $this->objConnection->error);
        else {
            $strSQL = "
				TRUNCATE TABLE newtrainingavg;
			";

            if(!$this->objConnection->query($strSQL))
                throw new Exception("A delete muvelet a new training avg tablaban nem sikerult!\n" . $this->objConnection->error);
            else
                print "DELETED FROM NEWTRAININGAVG\n";
        }

        $strSQL = "
			DELETE FROM newtraining;
		";

        if(!$this->objConnection->query($strSQL))
        	throw new Exception("A delete muvelet a new training tablaban nem sikerult!\n" . $this->objConnection->error);
        else {
            $strSQL = "
				TRUNCATE TABLE newtraining;
			";

            if(!$this->objConnection->query($strSQL))
                throw new Exception("A delete muvelet a new training tablaban nem sikerult!\n" . $this->objConnection->error);
            else
                print "DELETED FROM NEWTRAINING\n";
        }
	}
}

try{
	$objMigration = new DatabaseMigration($argv);
	$objMigration->main();
	var_dump("Mindharom tablaba sikeresen beszurasra kerultek az adatok!");
} catch(Exception $objException){
	var_dump($objException->getMessage());
}

?>
