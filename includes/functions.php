<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

date_default_timezone_set('Asia/Kolkata');

$now = Carbon::now();

function checkProjectDetails(int $project_id, string $field, string $description){
  $now = Carbon::now();
  $db = new DB();
  $sql = "SELECT * FROM project_details WHERE project_id = '$project_id' ORDER BY created_at DESC LIMIT 1";
  $latest_project_details = $db->select($sql);
  if ($latest_project_details) {
    $latest_project_details = mysqli_fetch_assoc($latest_project_details);
    $created_at = $latest_project_details['created_at'];
    $created_at = Carbon::parse($created_at);
    if ($created_at->isToday()) {
      return updateProjectDetails($latest_project_details['id'], $field, $description);
    } else {
      return copyAndUpdateProjectDetailsRow($project_id, $field, $description);
    }
  } else {
    return createNewProjectDetails($project_id, $field, $description);
  }
}

function createNewProjectDetails(int $project_id, string $field, string $value){
  $db = new DB();
  $now = Carbon::now();
  $sql = "INSERT INTO project_details (project_id, $field, created_at) VALUES ('$project_id', '$value', '$now')";


  $result = $db->insert($sql);

  if ($result) {
    return true;
  }
  return false;
}

function updateProjectDetails(int $id, string $field, string $value){
  $db = new DB();
  $now = Carbon::now();
  $sql = "UPDATE project_details SET $field = '$value', updated_at = '$now' WHERE id = '$id'";
  $result = $db->update($sql);
  if ($result) {
    return true;
  }
  return false;
}

function copyAndUpdateProjectDetailsRow(int $project_id, string $field, string $value){
  $db = new DB();
  $now = Carbon::now();
  $project_details = $db->select("SELECT * FROM project_details WHERE project_id = '$project_id' ORDER BY created_at DESC LIMIT 1");
  if ($project_details) {
    $project_details = mysqli_fetch_assoc($project_details);
    $project_details['project_id'] = $project_id;
    $project_details['created_at'] = Carbon::now();
    $project_details['updated_at'] = Carbon::now();
    unset($project_details['id']);
    $keys = array_keys($project_details);
    $values = array_values($project_details);
    $keys = implode(', ', $keys);
    $values = implode("', '", $values);
    $sql = "INSERT INTO project_details ($keys) VALUES ('$values')";
    $last_insert_id = $db->insert($sql);
    if ($last_insert_id) {
      $sql = "UPDATE project_details SET $field = '$value', updated_at = '$now' WHERE id = '$last_insert_id'";
      $result = $db->update($sql);
      if ($result) {
        return true;
      }
    }
    return false;
  }
  return false;
}

function totalLogs(int $project_id){
  $db = new DB();
  $sql = "SELECT * FROM project_details WHERE project_id = '$project_id' ";
  $result = $db->select($sql);
  if ($result) {
    return mysqli_num_rows($result) - 1;
  }
  return 'No Logs';
}

function lastLogDate(int $project_id){
  $db = new DB();
  $sql = "SELECT * FROM project_details WHERE project_id = '$project_id' ORDER BY created_at ASC LIMIT 1";
  $result = $db->select($sql);
  if ($result) {
    $result = mysqli_fetch_assoc($result);
    $created_at = $result['created_at'];
    $created_at = Carbon::parse($created_at);
    return $created_at->format('d-m-Y');
  }
  return 'No Logs';
}

function checkAuth(){
  if(!isset($_SESSION['email'])){
    header('location:login.php');
  }
}