<?php

error_reporting(E_ALL & ~E_NOTICE);

$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];

function hasCurrentDistance($trainingEntries) {
  $exists = true;
  foreach($trainingEntries["data"] as $k => $v) {
    if(!array_key_exists("currentDistance", $v)) {
      $exists = false;
    }
  }
  return $exists;
}

function reduceTrainingEntries($carry, $item) {
  if(strval($item["currentDistance"]) != "") {
    //print("Key: " . strval($item["currentDistance"]) . "\n");
    //print_r($carry);
    $carry[strval($item["currentDistance"])]["timestamp"] = $item["timestamp"];
    switch ($item["dataType"]) {
      case 't_200':
        $carry[strval($item["currentDistance"])][$item["dataType"]] = $item["dataValue"];
        break;
      case 'pull_force':
        $carry[strval($item["currentDistance"])]["_force"] = $item["dataValue"];
        break;
      case 't_500':
      case 't_1000':
      case 'currant_distance':
        break;
      default:
        $carry[strval($item["currentDistance"])][$item["dataType"]] = $item["dataValue"];
        break;
    }
    $carry[strval($item["currentDistance"])]["distance"] = $item["currentDistance"];
    
    if(!$carry[strval($item["currentDistance"])]["_force"]) {
      $carry[strval($item["currentDistance"])]["_force"] = 0;
    };
    if(!$carry[strval($item["currentDistance"])]["speed"]) {
      $carry[strval($item["currentDistance"])]["speed"] = 0;
    };
    if(!$carry[strval($item["currentDistance"])]["strokes"]) {
      $carry[strval($item["currentDistance"])]["strokes"] = 0;
    };
    if(!$carry[strval($item["currentDistance"])]["t_200"]) {
      $carry[strval($item["currentDistance"])]["t_200"] = 0;
    };
  }
  return $carry;
}

function explodeData($trainingEntries) {
  $exploded = array_reduce($trainingEntries["data"], "reduceTrainingEntries", []);
  $retval = [];
  foreach($exploded as $k => $v) {
    $v["user_id"] = $trainingEntries["user_id"];
    if(!$v["user_id"]) {
      $v["user_id"] = 0;
    }
    $v["session_id"] = $trainingEntries["session_id"];
    if(!$v["session_id"]) {
      $v["session_id"] = 0;
    }
    $retval[] = $v;
  }
  return $retval;
}

if(count($argv) < 6) {
  throw new Exception('Usage: php export_training.php <host> <user> <pass> <db> <csv file>');
}
$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error) {
  throw new Exception("Can\'t connect to {$host}");
}

$fp = fopen($argv[5], 'w');

$sessionIdSql = "select session_id from training group by session_id order by session_id";
$res = $conn->query($sessionIdSql);
while($row = $res->fetch_assoc()) {
  if($row["session_id"] != 0) {
    $sessionIds[] = $row["session_id"];
  }
}

$header = false;
foreach($sessionIds as $sessionId) {
  $trainingRows = [];
  $sessions = [];
  $sql = "select * from training where session_id = " . $sessionId . "\n";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    $row["data"] = unserialize($row["data"]);
    $merged = false;
    foreach($sessions as $k => $v) {
      if($v["session_id"] == $row["session_id"]) {
        array_merge($v["data"], $row["data"]);
        $merged = true;
      }
    }
    if(!$merged) {
      $sessions[] = $row;
    }
  }

  foreach($sessions as $k => $v) {
    if(hasCurrentDistance($v)) {
      print("Session with currDist: " . $k . ": " . $v["id"] . " / " . $v["user_id"] . " / " . $v["session_id"] . " / " . $v["training_type"] . "\n");
      $trainingRows = array_merge($trainingRows, explodeData($v));
    }
  }
  if(!$header) {
    fputcsv($fp, ["user_id", "session_id", "timestamp", "distance", "_force", "speed", "strokes", "t_200"]);
    $header = true;
  }

  foreach($trainingRows as $row) {
    fputcsv($fp, [$row["user_id"], $row["session_id"], $row["timestamp"], $row["distance"], $row["_force"], $row["speed"], $row["strokes"], $row["t_200"]]);
  }
}

fclose($fp);
?>
