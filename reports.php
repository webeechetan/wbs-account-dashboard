<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

include 'includes/functions.php';
include 'includes/DB.php';
session_start();
checkAuth();

$db = new DB();
$msg = false;
$now = Carbon::now();


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
    $result = checkProjectDetails($project_id, $field_name, $description);
    if ($result) {
        $msg = "<div class='bg-primary'>Successfully Done</div>";
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


/////////Delete query for report
if (isset($_POST['delete_report'])) {

    $id = $_POST['delete_repo'];

    $sql =  "DELETE FROM project_details  WHERE id = '$id'";
    $result = $db->delete($sql);
    
    if ($result) {
        $msg = "<div class='bg-primary report_delete_msg'>Deleted Successfull </div>";
    } else {
        header("location: reports.php");
    }
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
    <?php
    $projectid = $account['project_id'];


    ?>

    <!-- Header -->
    <header class="bg-primary">
        <div class="container">
            <div class="row py-3 align-items-center">
                <div class="col-6">
                    <img src="https://www.webeesocial.com/wp-content/uploads/2020/12/logo-tm-white-compressed.png" alt="" width="125">
                </div>
                <div class="col-6 text-end flex-wrap">
                    <!-- <a target="_blank" href="account.php"  class="ac-logout btn btn-primary me-0 me-md-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg"></i> Add Report</a> -->
                    <a target="_blank" href="reportadd.php?id=<?php echo $project_id ?>" class="ac-logout btn btn-primary me-0 me-md-2 mb-2 mb-md-0"><i class="bi bi-plus-lg"></i> Add Report</a>
                    <a href="logout.php" class="ac-logout btn btn-primary" id="user_logout"><i class="bi bi-lock"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <?php
    $sql = "SELECT * FROM projects WHERE id = '$projectid' ";

    $wb_project = $db->select($sql);
    if ($wb_project) {
        $wb_project = $wb_project->fetch_assoc();
    } ?>
    <!-- Body -->

    <section class="account-wrap">
        <div class="container">
            <div class="row mb-3 align-items-center">
                <div class="col-6">
                    
                    <h4><?php echo $project['project_name']?> Reports</h4>
                    
                    
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home </a></li>

                            <?php if (isset($projectid)) {
                                $sql = "SELECT * FROM projects WHERE id = '$projectid' ";

                                $wb_project = $db->select($sql);
                                if ($wb_project) {
                                    $wb_project = $wb_project->fetch_assoc();
                            ?>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a><?php echo isset($wb_project) ? $wb_project['project_name'] : 'Account'; ?></a>
                                    </li>
                            <?php  }
                            } ?>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <?php if ($msg) : ?>
                    <div class="text-center mb-3"><?php echo $msg; ?></div>
                <?php endif; ?>
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM project_details WHERE project_id = '$projectid' ORDER BY created_at DESC";
                        $wb_project = $db->select($sql);
                        while ($row = mysqli_fetch_array($wb_project)) {
                            $report_id = $row['id'];
                        ?>
                            <tr>
                                <td><?php echo  Carbon::parse($row['created_at'])->format('d-M-Y') ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a target="_blank" class="btn btn-warning btn-sm me-3" href="account.php?id=<?php echo $report_id ?>">View</a>

                                        <form method="POST" action="reportupdate.php">
                                            <a target="_blank" class="btn btn-info btn-sm me-3" href="reportupdate.php?id=<?php echo $report_id ?>">Edit</a>
                                        </form>

                                        <form method="POST">
                                            <input type="hidden" name="delete_repo" value="<?php echo $report_id ?>">
                                            <button type="submit" class="btn btn-danger btn-sm delete_report" name="delete_report" value="">Delete </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
    </section>

    <!-- Js-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="js/index.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });


        setTimeout(() => {
            $(".report_delete_msg").fadeOut('slow');
        }, 5000);
    </script>
</body>

</html>