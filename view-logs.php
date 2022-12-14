<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

include 'includes/functions.php';
include 'includes/DB.php';

$db = new DB();
$msg = false;
$now = Carbon::now();
if (isset($_POST['project_id'])) {
    $date = $_POST['date'];
    $project_id = $_POST['project_id'];
    $date = Carbon::parse($date);
    $date = $date->format('Y-m-d');
    $sql = "SELECT * FROM project_details WHERE project_id = '$project_id' AND created_at LIKE '$date%' LIMIT 1";
    $account = $db->select($sql);
    if ($account) {
        $account = $account->fetch_assoc();
    }
} else {
    header("location: index.php");
}


?>
<!doctype html>
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
</head>

<body>
    <!-- Header -->
    <header class="bg-primary">
        <div class="container">
            <div class="row py-3 align-items-center">
                <div class="col-6">
                    <img src="https://www.webeesocial.com/wp-content/uploads/2020/12/logo-tm-white-compressed.png" alt="" width="125">
                </div>
                <div class="col-6 text-end">
                    <a href="logout.php" class="ac-logout"><i class="bi bi-lock"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <?php
    $projectid = $account['project_id'];
    ?>
    <!-- Body -->
    <section class="account-wrap">
        <div class="container-fluid px-lg-5">
            <div class="row mb-3">
                <div class="col-md-12 text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">



                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <?php if (isset($projectid)) {

                                $sql = "SELECT * FROM projects WHERE id = '$projectid' ";
                                $wb_project = $db->select($sql);
                                if ($wb_project) {
                                    $wb_project = $wb_project->fetch_assoc();
                            ?>
                                    <li class="breadcrumb-item"><a href="account.php?id=<?php echo $projectid; ?>">
                                            <?php echo isset($wb_project) ? $wb_project['project_name'] : 'Account'; ?>
                                        </a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo isset($wb_project) ? $wb_project['project_name'] : 'Account'; ?>
                                    </li>
                            <?php  }
                            } ?>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Features-->
            <div class="row">
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-1">
                                <div class="sow-name">
                                    <h4><span class="bi bi-file-earmark-text pe-2"></span>Sow</h4>
                                </div>
                                <div class="edit-button">
                                    <a class=" btn sow-edit open_view_modal" data-title='Sow'><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="sow-content" id="sow">
                                <?php
                                if ($account) {
                                    echo $account['sow'];
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between bg-card sow mb-1">
                                        <div class="sow-name">
                                            <h4><span class="bi bi-ticket-detailed pe-2"></span>Spoc Details</h4>
                                        </div>
                                        <div class="edit-button">
                                            <a class=" btn sow-edit open_view_modal" data-title='Spoc Details'><i class="bi bi-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="sow-content" id="spoc_details">
                                        <?php if ($account) {
                                            echo $account['spoc_details'];
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between bg-card sow">
                                        <div class="sow-name">
                                            <h4><span class="bi bi-people pe-2"></span>Wbs Teams</h4>
                                        </div>
                                        <div class="edit-button">
                                            <a class=" btn sow-edit open_view_modal" data-title='Wbs Teams'><i class="bi bi-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="sow-content" id="wbs_teams">
                                        <?php if ($account) {
                                            echo $account['wbs_teams'];
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-1">
                                <div class="sow-name">
                                    <h4><span class="bi bi-people pe-2"></span>Work Detail</h4>
                                </div>
                                <div class="edit-button">
                                    <a class=" btn sow-edit open_view_modal" data-title='Work Detail'><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="sow-content" id="work_details">
                                <?php if ($account) {
                                    echo $account['work_details'];
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between bg-card sow mb-1">
                                        <div class="sow-name">
                                            <h4><span class="bi bi-people pe-2"></span>Customer Relatiionship</h4>
                                        </div>
                                        <div class="edit-button">
                                            <a class=" btn sow-edit open_view_modal" data-title='Customer Relatiionship'><i class="bi bi-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="sow-content" id="customer_relationships">
                                        <?php if ($account) {
                                            echo $account['customer_relationships'];
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card bg-card border-0 h-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between bg-card sow mb-1">
                                        <div class="sow-name">
                                            <h4><span class="bi bi-people pe-2"></span>Deadlines</h4>
                                        </div>
                                        <div class="edit-button">
                                            <a class=" btn sow-edit open_view_modal" data-title='Deadlines'><i class="bi bi-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="sow-content" id="deadlines">
                                        <?php if ($account) {
                                            echo $account['deadlines'];
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-md-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-3">
                                <div class="sow-name">
                                    <h4><span class="bi bi-people pe-2"></span>Last Meeting</h4>
                                </div>
                                <div class="edit-button">
                                    <a class=" btn sow-edit open_view_modal" data-title='Last Meeting'><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="sow-content" id="last_meetings">
                                <?php if ($account) {
                                    echo $account['last_meetings'];
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-3">
                                <div class="sow-name">
                                    <h4><span class="bi bi-people pe-2"></span>Account Status Remarks</h4>
                                </div>
                                <div class="edit-button">
                                    <a class=" btn sow-edit open_view_modal" data-title='Account Status Remarks'><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="sow-content" id="account_status">
                                <?php if ($account) {
                                    echo $account['account_status'];
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-3">
                                <div class="sow-name">
                                    <h4><span class="bi bi-people pe-2"></span>Billing Details</h4>
                                </div>
                                <div class="edit-button">
                                    <a class=" btn sow-edit open_view_modal" data-title='Billing Details'><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="sow-content" id="billing_details">
                                <?php if ($account) {
                                    echo $account['billing_details'];
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <!-- Js-->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
            <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
            <!-- <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script> -->
            <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
            <script src="js/upload.js"></script>
            <script src="js/index.js"></script>

</body>

</html>