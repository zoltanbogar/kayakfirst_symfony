<?php

class DatabaseMigration {
	private $strHost;
	private $strUserName;
	private $strPassword;
	private $strDatabaseName;
	private $objConnection;
	private $tblTransformedTraining;

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

		$strSQL = "
			SELECT
				*
			FROM
				training
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
						} else if($rowData["dataType"] == "t_500" || $rowData["dataType"] == "t_1000"){
							continue;
						}

						$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])][$rowData["dataType"]] = $rowData["dataValue"];
						if(isset($this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["session_id"])) continue;

						$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["session_id"] = $tblTraining[$key]["session_id"];
						$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["user_id"] = $tblTraining[$key]["user_id"];
						$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["training_type"] = $tblTraining[$key]["training_type"];
						$this->tblTransformedTraining[$rowTraining["session_id"]][strval($rowData["currentDistance"])]["training_env_type"] = $tblTraining[$key]["training_env_type"];
					}
				}
			}
		}

		$this->insertNormalTrainingData();
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
						)
					VALUES
						(
							{$strSessionID}
							, {$rowTraining["timestamp"]}
							, {$rowTraining["pull_force"]}
							, {$rowTraining["speed"]}
							, {$strCurrentDistance}
							, {$rowTraining["strokes"]}
							, {$rowTraining["t_200"]}
						)
				";

				if(!$this->objConnection->query($strSQL)) throw new Exception("Az insert muvelet a new training tablaba nem sikerult!\n" . $this->objConnection->error);
			}
		}

		$this->insertSumTrainingData();
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
						, {$tblTraining[$tblArrayKeys[0]]["user_id"]}
						, 'racing_kayaking'
						" . ($tblTraining[$tblArrayKeys[0]]["training_env_type"] ? ", '" . $tblTraining[$tblArrayKeys[0]]["training_env_type"] . "'" : "") . "
						, " . count($tblTraining) . "
						" . (isset($rowPlan["id"]) ? ", '" . $rowPlan["id"] . "'" : "") . "
						" . (isset($rowPlan["type"]) ? ", '" . $rowPlan["type"] . "'" : "") . "
						, {$tblTraining[$tblArrayKeys[0]]["timestamp"]}
						, {$strDuration}
						, {$tblTraining[$tblArrayKeys[count($tblTraining) - 1]]["currant_distance"]}
					)
			";

			if(!$this->objConnection->query($strSQL)) throw new Exception("Az insert muvelet a sum training tablaba nem sikerult!\n" . $this->objConnection->error);
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
						, {$tblTraining[$tblArrayKeys[0]]["user_id"]}
						, {$tblAverage["pull_force_av"]}
						, {$tblAverage["speed_av"]}
						, {$tblAverage["strokes_av"]}
						, {$tblAverage["t_200_av"]}
					)
			";

			if(!$this->objConnection->query($strSQL)) throw new Exception("Az insert muvelet a new avg training tablaba nem sikerult!\n" . $this->objConnection->error);
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