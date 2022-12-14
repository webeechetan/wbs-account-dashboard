<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    include 'includes/DB.php';
    include 'includes/functions.php';

    checkAuth();
    $msg = false;
    $db = new DB();
    if((isset($_POST['project_name']))&&(!empty($_POST['project_name']))){
        $project_name = $db->santize($_POST['project_name']);
        $sql = "INSERT INTO `projects` (project_name) VALUES ('$project_name')";
        if($db->insert($sql)){
            $msg = "Project Added successfully ";
        }else{
            $mg = "Something went wrong ";
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
                        <a href="#"  class="ac-logout btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg"></i> Add Project</a>
                        <a href="logout.php"  class="ac-logout btn btn-primary" id= "user_logout"><i class="bi bi-lock"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Modal button for add the new project -->

        <!-- Body -->
        <section class="content-wrap">
            <div class="container px-lg-5">
            <div class="row ac-list">

            <?php 
            $sql = "SELECT * FROM projects WHERE status != 'deleted' ";

            $projects = $db->select($sql);

            if($projects) {
                while($project = mysqli_fetch_assoc($projects)){
                ?>
                    <div class="col-sm-4 col-md-3 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center pt-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4"><i class="bi bi-person-vcard"></i></div>
                                <h2 class="fs-4 fw-bold"><?php echo $project['project_name'];?></h2>
                                <a href="reports.php?id=<?php echo $project['id']?>" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                        
                    </div>
                    <?php } }?>
                    <?php if($msg): ?>
                            <div class="col-12">
                                <div class="project-msg"><h5 class="mb-0"><?php echo $msg; ?></h5></div>
                            </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Modal for add new project -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" >
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="project_name" name="project_name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- Js-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script>
        setTimeout(()=>{
            $(".project-msg").fadeOut('slow');
        },10000);
        </script>

    </body>

</html>