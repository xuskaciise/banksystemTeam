<?php
session_start();
 if(!isset($_SESSION['id'])){
  header("location:../../index.php");
 }
?>

<?php
include("header.php");
include("navbar.php");
include("topbar.php");

?>
   <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Taller List</h1>
<p class="mb-4">List And Modafy Taller </p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered TallerTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Taller No.</th>
                    <th>Taller Name</th>
                    <th>Taller user</th>
                  
                    <th>Taller Blance</th>
                    <th>Created User</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    
                </tbody>
          
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="TallerModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">stock Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="tallerForm">
      <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success d-none">
                this is success alert
            </div>
            <div class="alert alert-danger d-none">
                this is danger alert
            </div>
        </div>
       
        <div class="col-md-12">
            <input type="hidden" name="update_id" id="update_id">
            <label for="">stock  No</label>
            <input type="text" name="tallerNo" id="tallerNo" class="form-control" placeholder="Enter Stock No." required readonly>
            <label for="">Manager.</label>
            <select name="Taller_id" id="taller_id" class="form-control">

            </select>
            <label for="">Manger User.</label>
            <select name="taller_user" id="taller_user" class="form-control">

            </select>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
</form>
  </div>
</div>

<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/taller.js"></script>