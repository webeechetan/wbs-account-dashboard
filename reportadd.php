<?php
error_reporting(E_ALL);

if(!isset($_GET['id'])){

    header("Location: index.php");
}

require 'vendor/autoload.php';

use Carbon\Carbon;

include 'includes/functions.php';
include 'includes/DB.php';

session_start();
checkAuth();

$db = new DB();
$msg = false;
$now = Carbon::now();

$current_id = 0;
if (isset($_GET['current_id'])) {
    $current_id = $_GET['current_id'];
}
    if (isset($_POST['description']) && isset($_POST['field_name'])) {
         $description = $db->santize($_POST['description']);
         $field_name = $db->santize($_POST['field_name']);

         $files = [];
         if (isset($_FILES['files'])) {

            $files = $_FILES['files'];
            $files_array = [];
            foreach ($files['name'] as $key => $value) {
                $image = $files['name'][$key];
                $tmp_dir = $files['tmp_name'][$key];
                move_uploaded_file($tmp_dir, 'uploads/' . $image);
                $description .= '<br /><a href="uploads/' . $image . '" /> ' . $image . ' </a>';
                $files_array[] = $image;
            }
            $files = implode(',', $files_array);
    }

    $project_id = $_GET['id'];


    if ($current_id) {
        $sql = "UPDATE project_details SET $field_name = '$description' WHERE id='$current_id'";
    } else {
        $sql = "INSERT INTO project_details (project_id, $field_name, created_at) VALUES ('$project_id', '$description', '$now')";
    }
    $result = $db->query($sql);
    if ($result > 0) {
        header('location:reportadd.php?id=' . $project_id . '&current_id=' . $result);
    }
}


if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $account = $db->select("SELECT * FROM project_details WHERE project_id = '$project_id' ORDER BY created_at DESC LIMIT 1");

    if ($account) {
        $account = $account->fetch_assoc();
    }
} else {
    header("location: index.php");
}


if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $project = $db->select("SELECT * FROM projects WHERE id = '$project_id' ");
    $project = $project->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webeesocial Account Dashorad</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- Header -->
    <header class="bg-primary">
        <div class="container">
            <div class="row py-3 align-items-center">
                <div class="col-6">
                    <img src="https://www.webeesocial.com/wp-content/uploads/2020/12/logo-tm-white-compressed.png" alt="" width="125">
                </div>
                <div class="col-6 text-end flex-wrap">
                    <a href="reportadd.php?id=<?php echo $project_id?>" class="ac-logout btn btn-primary me-0 me-md-2 mb-2 mb-md-0"><i class="bi bi-plus-lg"></i> Add Report</a>
                    <a href="logout.php" class="ac-logout btn btn-primary" id="user_logout"><i class="bi bi-lock"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <?php
    $projectid = $account['project_id'];

    $sql = "SELECT * FROM projects WHERE id = '$projectid' ";

    $wb_project = $db->select($sql);
    if ($wb_project) {
        $wb_project = $wb_project->fetch_assoc();
    } ?>

    <section class="account-wrap">
        <div class="container">
            <div class="row mb-3 align-items-center">
                <div class="col-6">
                    <h4> New Report </h4>
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="index.php">Home </a></li>

                            <?php if (isset($projectid)) {
                                $sql = "SELECT * FROM projects WHERE id = '$projectid' ";

                                $wb_project = $db->select($sql);
                                if ($wb_project) {
                                    $wb_project = $wb_project->fetch_assoc();
                            ?>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="reports.php?id=<?php echo $wb_project['id'] ?>"><?php echo isset($wb_project) ? $wb_project['project_name'] : 'Account'; ?></a>
                                    </li>
                            <?php  }
                            } ?>
                            <li class="breadcrumb-item">New</a></li>

                        </ol>
                    </nav>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12">
                   <div class="report-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <small class="text-muted  total-report ">Total Logs : <b><?php echo totalLogs($_GET['id']); ?></b></small>
                                <small class="text-muted report-date">Last Log Date : <b><?php echo lastLogDate($_GET['id']); ?></b></small>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="log_date" class="form-control ms-auto" onchange="viewByRecentDate(this.value)" id="log_date">
                                        <option value="">Select Log</option>
                                        <?php
                                            $project_id = $_GET['id'];
                                            $logs = $db->select("SELECT * FROM project_details WHERE project_id='$project_id' ORDER BY created_at DESC LIMIT 30");
                                        if ($logs) {
                                            while ($row = mysqli_fetch_assoc($logs)) {
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row["created_at"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                   </div>
                </div>
            </div> -->

            <?php

            if (isset($current_id)) {

                $sql = "SELECT * FROM project_details WHERE id = '$current_id' ";

                $project_details = $db->select($sql);

                if ($project_details) {
                    $project_details = $project_details->fetch_assoc();
                }
            }else{
                $project_details =  false ;
            }

            ?>


            <div class="row">
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="card-wrap">
                                <div class="d-flex justify-content-between bg-card sow mb-1">
                                    <div class="sow-name">
                                        <h4><span class="bi bi-file-earmark-text pe-2"></span>Sow</h4>
                                    </div>
                                    <div class="edit-button">
                                        <a class="open_view_modal" data-title='Sow'><i class="bi bi-eye"></i></a>
                                        <a class="open_modal" data-title='Sow' data-field='sow'><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </div>
                                <div class="sow-content card-content h-big" id="sow">

                                    <?php  if($project_details)
                                    { 
                                        echo $project_details['sow'];
                                     } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="card-wrap">
                                        <div class="d-flex justify-content-between bg-card sow mb-1">
                                            <div class="sow-name">
                                                <h4><span class="bi bi-ticket-detailed pe-2"></span>Spoc Details</h4>
                                            </div>
                                            <div class="edit-button">
                                                <a class="open_view_modal" data-title='Spoc Details'><i class="bi bi-eye"></i></a>
                                                <a class="open_modal" data-title='Spoc Details' data-field='spoc_details'><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        </div>
                                        <div class="sow-content card-content" id="spoc_details">
                                            <?php if($project_details){
                                             echo  $project_details['spoc_details'];

                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="card-wrap">
                                        <div class="d-flex justify-content-between bg-card sow">
                                            <div class="sow-name">
                                                <h4><span class="bi bi-people pe-2"></span>Wbs Teams</h4>
                                            </div>
                                            <div class="edit-button">
                                                <a class="open_view_modal" data-title='Wbs Teams'><i class="bi bi-eye"></i></a>
                                                <a class="open_modal" data-title='Wbs Teams' data-field='wbs_teams'><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        </div>
                                        <div class="sow-content card-content" id="wbs_teams">
                                            <?php 
                                            if($project_details){
                                                echo  $project_details['wbs_teams']; 
                                            }?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="card-wrap">
                                <div class="d-flex justify-content-between bg-card sow mb-1">
                                    <div class="sow-name">
                                        <h4><span class="bi bi-people pe-2"></span>Work Detail</h4>
                                    </div>
                                    <div class="edit-button">
                                        <a class="open_view_modal" data-title='Work Detail'><i class="bi bi-eye"></i></a>
                                        <a class="open_modal" data-title='Work Detail' data-field='work_details'><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </div>
                                <div class="sow-content card-content h-big" id="work_details">
                                    <?php echo  $project_details['work_details']; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="card-wrap">
                                        <div class="d-flex justify-content-between bg-card sow mb-1">
                                            <div class="sow-name">
                                                <h4><span class="bi bi-people pe-2"></span>Customer Relationship</h4>
                                            </div>
                                            <div class="edit-button">
                                                <a class="open_view_modal" data-title='Customer Relatiionship'><i class="bi bi-eye"></i></a>
                                                <a class="open_modal" data-title='Customer Relatiionship' data-field='customer_relationships'><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        </div>
                                        <div class="sow-content card-content" id="customer_relationships">
                                            <?php echo  $project_details['customer_relationships']; ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="card-wrap">
                                        <div class="d-flex justify-content-between bg-card sow mb-1">
                                            <div class="sow-name">
                                                <h4><span class="bi bi-people pe-2"></span>Deadlines</h4>
                                            </div>
                                            <div class="edit-button">
                                                <a class="open_view_modal" data-title='Deadlines'><i class="bi bi-eye"></i></a>
                                                <a class="open_modal" data-title='Deadlines' data-field='deadlines'><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        </div>
                                        <div class="sow-content card-content" id="deadlines">
                                            <?php echo  $project_details['deadlines']; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-md-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="card-wrap">
                                <div class="d-flex justify-content-between bg-card sow mb-3">
                                    <div class="sow-name">
                                        <h4><span class="bi bi-people pe-2"></span>Last Meeting</h4>
                                    </div>
                                    <div class="edit-button">
                                        <a class="open_view_modal" data-title='Last Meeting'><i class="bi bi-eye"></i></a>
                                        <a class="open_modal" data-title='Last Meeting' data-field='last_meetings'><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </div>
                                <div class="sow-content card-content h-big" id="last_meetings">

                                    <?php echo  $project_details['last_meetings']; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="card-wrap">
                                <div class="d-flex justify-content-between bg-card sow mb-3">
                                    <div class="sow-name">
                                        <h4><span class="bi bi-people pe-2"></span>Account Status Remarks</h4>
                                    </div>
                                    <div class="edit-button">
                                        <a class="open_view_modal" data-title='Account Status Remarks'><i class="bi bi-eye"></i></a>
                                        <a class="open_modal" data-title='Account Status Remarks' data-field='account_status'><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </div>
                                <div class="sow-content card-content h-big" id="account_status">
                                    <?php echo  $project_details['account_status']; ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="card-wrap">
                                <div class="d-flex justify-content-between bg-card sow mb-3">
                                    <div class="sow-name">
                                        <h4><span class="bi bi-people pe-2"></span>Billing Details</h4>
                                    </div>
                                    <div class="edit-button">
                                        <a class="open_view_modal" data-title='Billing Details'><i class="bi bi-eye"></i></a>
                                        <a class="open_modal" data-title='Billing Details' data-field='billing_details'><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </div>
                                <div class="sow-content card-content h-big" id="billing_details">
                                    <?php echo  $project_details['billing_details']; ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <!---- Modal Popup ---->

            <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <textarea class="form-control" name="description" id="description"></textarea>
                                <input type="file" multiple name="files[]">

                            </div>
                            <input type="hidden" name="field_name" id="field_name">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-light">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!----- View Modal-->
            <div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="view_modal_title"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body view_modal_content">

                        </div>
                    </div>
                </div>
            </div>

        </div>
        </scection>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="js/index.js"></script>

        <script>
            setTimeout(() => {
                $(".add_report_msg").fadeOut('slow');
            }, 5000);
        </script>

</body>

</html>