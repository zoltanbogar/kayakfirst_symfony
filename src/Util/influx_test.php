<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 06. 19.
 * Time: 12:49
 */

require __DIR__.'/../../vendor/autoload.php';

class InfluxTest {
    private $objDb;
    private $objMockDB;

    public function __construct(){
        $this->objDb = new InfluxDB\Client("localhost", "8086");
        $this->objMockDB = $this->objDb->selectDB('mock');
    }

    public function select(){
        $result = $this->objMockDB->query('select * from ergo');

        $points = $result->getPoints();

        var_dump($points);
    }

    public function main(){
        $rowUsers = [173, 10, 34, 45];
        $numUserID = $rowUsers[mt_rand(0, count($rowUsers) - 1)];
        $numToolID = substr(md5(rand()), 0, 16);
        $rowType = ['indoor', 'outdoor'];
        $strType = $rowType[mt_rand(0, count($rowType) - 1)];
        $numStrokesOffset = NULL;
        $numPeriod = 0;
        $numRandPercent = rand(900, 1100) / 1000;
        $numStrokes = 100.00001;
        $numLastDistance = 0.5;
        $numSpeed = 16 / 3.6;
        $numStateOfCsuszka = 50;
        $t200 = 45;
        $t200_actual = $t200 * $numRandPercent;
        $numForce = 100;
        $numAngularSpeed = 33.3;
        $timestamp = round(microtime(true) * 1000);
        $numCounter = 1;

        $points = [];
        for($i = 0; $i < 600; $i++){
            $numRandPercent = rand(900, 1100) / 1000;
            if($numPeriod >= 3){
                $numPeriod = 0;
                $numStrokesOffset = NULL;
            } else if($numPeriod == 1){
                $numStrokesOffset = rand(1,99);
            } else {
                $numStrokesOffset = NULL;
            }

            if($numStrokes > 160) $numStrokes = $this->convert2FloatWithPrecision5($numStrokes * 0.9);
            if($numStrokes < 70) $numStrokes = $this->convert2FloatWithPrecision5($numStrokes * 1.1);
            if($numLastDistance > 0.8) $numLastDistance = $this->convert2FloatWithPrecision5($numLastDistance * 0.9);
            if($numLastDistance < 0.1) $numLastDistance = $this->convert2FloatWithPrecision5($numLastDistance * 1.1);
            if($numSpeed > 30 / 3.6) $numSpeed = $this->convert2FloatWithPrecision5($numSpeed * 0.9);
            if($numSpeed < 2 / 3.6) $numSpeed = $this->convert2FloatWithPrecision5($numSpeed * 1.1);
            if($numForce < 65) $numForce = $this->convert2FloatWithPrecision5($numForce * 1.1);
            if($numForce > 125) $numForce = $this->convert2FloatWithPrecision5($numForce * 0.9);
            if($numAngularSpeed > 37) $numAngularSpeed = $this->convert2FloatWithPrecision5($numAngularSpeed * 0.9);
            if($numAngularSpeed < 28) $numAngularSpeed = $this->convert2FloatWithPrecision5($numAngularSpeed * 1.1);

            $points[] = new InfluxDB\Point(
                'ergo', // name of the measurement
                $numCounter, // the measurement value
                [
                    'user' => $numUserID
                    , 'tool_id' => $numToolID
                ],
                [
                    'type' => $strType
                    , 'strokes_offset' => strval($numStrokesOffset)
                    , 'avg_strokes' => $this->convert2FloatWithPrecision5($numStrokes) //középérték 100 strokes per minute
                    , 'actual_strokes' => $this->convert2FloatWithPrecision5($numStrokes * $numRandPercent) //középérték 100 strokes per minute
                    , 'last_100_distance' => $this->convert2FloatWithPrecision5($numLastDistance) //Elméleti max 0.8 m
                    , 'avg_speed' => $this->convert2FloatWithPrecision5($numSpeed) //középérték 16 km/h
                    , 'actual_speed' => $this->convert2FloatWithPrecision5($numSpeed * $numRandPercent) //középérték 16 km/h
                    , 'avg_speed_training' => $this->convert2FloatWithPrecision5($numSpeed * $numRandPercent) //középérték 16 km/h
                    , 'state_of_csuszka' => $numStateOfCsuszka //%
                    , 'avg_t200_last_3sec' => $this->convert2FloatWithPrecision5($t200) //középérték 45 sec
                    , 'actual_t200' => $this->convert2FloatWithPrecision5($t200_actual) //középérték 45 sec
                    , 'avg_t500_last_3sec' => $this->convert2FloatWithPrecision5($t200 * 5 / 2) //számolni
                    , 'actual_t500' => $this->convert2FloatWithPrecision5($t200_actual * 5 / 2) //számolni
                    , 'avg_t1000_last_3sec' => $this->convert2FloatWithPrecision5($t200_actual * 5) //számolni
                    , 'actual_t1000' => $this->convert2FloatWithPrecision5($t200 * 5) //számolni
                    , 'actual_force' => $this->convert2FloatWithPrecision5($numForce) //középérték 100 N
                    , 'avg_force' => $this->convert2FloatWithPrecision5($numForce * $numRandPercent) //középérték 100 N
                    , 'angular_speed' => $this->convert2FloatWithPrecision5($numAngularSpeed) //középérték 33.333 1/s
                ],
                $timestamp
            );

            $numPeriod++;
            $numCounter++;
            $numStrokes *= $numRandPercent;
            $numLastDistance *= $numRandPercent;
            $numSpeed *= $numRandPercent;
            $t200 *= $numRandPercent;
            $t200_actual *= $numRandPercent;
            $numForce *= $numRandPercent;
            $numAngularSpeed *= $numRandPercent;
            $timestamp += 100;
        }

        $result = $this->objMockDB->writePoints($points, InfluxDB\Database::PRECISION_MILLISECONDS);
    }

    private function convert2FloatWithPrecision5($number){
        $number = sprintf('%0.5f', $number);

        return floatval($number);
    }
}

$objInflux = new InfluxTest();
$objInflux->main();
$objInflux->select();