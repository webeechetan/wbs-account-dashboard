<?php
include 'includes/DB.php';
$db = new DB();
$msg = false;
if(isset($_POST['description']) && isset($_POST['field_name'])){
    $description = $db->santize($_POST['description']);
    $field_name = $db->santize($_POST['field_name']);
    $project_id = '1';
    $check_old_entries = $db->select("SELECT * FROM project_details WHERE project_id = '$project_id'");
    if($check_old_entries){
        $sql = "UPDATE project_details SET $field_name = '$description' WHERE project_id = '$project_id'";
        if($db->update($sql)){
            $msg =  "Updated";
        }else{
            $msg = "Failed";
        }
    }else{
        $sql = "INSERT INTO project_details (project_id, $field_name) VALUES ('$project_id', '$description')";
        if($db->insert($sql)){
            $msg = "Inserted";
        }else{
            $msg = "Failed";
        }
    }
}

$account = $db->select("SELECT * FROM project_details WHERE project_id = '1'");
if($account){
    $account = $account->fetch_assoc();
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
                    <a href="#" class="ac-logout"><i class="bi bi-lock"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Body -->
    <section class="account-wrap">
        <div class="container-fluid px-lg-5">
            <!-- Page Features-->
            <div class="row">
                <?php if($msg): ?>
                    <div class="text-center mb-3"><?php echo $msg;?></div>
                <?php endif;?>
                <div class="col-sm-4 col-md-3 mb-4">
                    <div class="card bg-card border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between bg-card sow mb-1">
                                <div class="sow-name">
                                    <h4><span class="bi bi-file-earmark-text pe-2"></span>Sow</h4>
                                </div>
                               <div class="edit-button">
                                 <a class=" btn sow-edit open_modal" data-title='Sow' data-field='sow'><i class="bi bi-pencil-square"></i></a>  
                               </div>                         
                            </div>
                            <div class="sow-content" id="sow">
                                <?php if($account){ echo $account['sow']; } ?>
                            </div>
                            <div class="edit-button mt-2">
                                <a class=" btn sow-edit" data-bs-toggle="modal" data-bs-target="#viewmodal"><i class="bi bi-eye"></i></a>  
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
                                         <a class=" btn sow-edit open_modal" data-title='Spoc Details' data-field='spoc_details'><i class="bi bi-pencil-square"></i></a>  
                                       </div>                         
                                    </div>
                                    <div class="sow-content" id="spoc_details">
                                        <?php if($account){ echo $account['spoc_details']; } ?>
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
                                         <a class=" btn sow-edit open_modal" data-title='Wbs Teams' data-field='wbs_teams'><i class="bi bi-pencil-square"></i></a>  
                                       </div>                         
                                    </div>
                                    <div class="sow-content" id="wbs_teams">
                                        <?php if($account){ echo $account['wbs_teams']; } ?>
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
                                 <a class=" btn sow-edit open_modal" data-title='Work Detail' data-field='work_details'><i class="bi bi-pencil-square"></i></a>  
                               </div>                         
                            </div>
                            <div class="sow-content" id="work_details">
                                <?php if($account){ echo $account['work_details']; } ?>
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
                                         <a class=" btn sow-edit open_modal" data-title='Customer Relatiionship' data-field='customer_relationships'><i class="bi bi-pencil-square"></i></a>  
                                       </div>                         
                                    </div>
                                    <div class="sow-content" id="customer_relationships">
                                        <?php if($account){ echo $account['customer_relationships']; } ?>
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
                                         <a class=" btn sow-edit open_modal" data-title='Deadlines' data-field='deadlines'><i class="bi bi-pencil-square"></i></a>  
                                       </div>                         
                                    </div>
                                    <div class="sow-content" id="deadlines">
                                        <?php if($account){ echo $account['deadlines']; } ?>
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
                                 <a class=" btn sow-edit open_modal" data-title='Last Meeting' data-field='last_meetings'><i class="bi bi-pencil-square"></i></a>  
                               </div>                         
                            </div>
                            <div class="sow-content"  id="last_meetings">
                                <?php if($account){ echo $account['last_meetings']; } ?>
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
                                 <a class=" btn sow-edit open_modal" data-title='Account Status Remarks' data-field='account_status'><i class="bi bi-pencil-square"></i></a>  
                               </div>                         
                            </div>
                            <div class="sow-content" id="account_status">
                                <?php if($account){ echo $account['account_status']; } ?>
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
                                 <a class=" btn sow-edit open_modal" data-title='Billing Details' data-field='billing_details'><i class="bi bi-pencil-square"></i></a>  
                               </div>                         
                            </div>
                            <div class="sow-content" id="billing_details">
                                <?php if($account){ echo $account['billing_details']; } ?>
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
                        <form method="POST">
                            <div class="modal-body">
                                <textarea class="form-control" name="description" id="description"></textarea>
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
                        <h4 class="modal-title" id="">View</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           
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
    <!-- <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="js/upload.js"></script>
    <script src="js/index.js"></script>

</body>

</html>