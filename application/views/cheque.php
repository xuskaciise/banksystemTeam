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
<h1 class="h3 mb-2 text-gray-800">cheque Number</h1>
<p class="mb-4">Create And Modafy Cheque Number</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <button class="btn btn-success btn-md btn-circle float-right" id="addnew"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered chequeTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Cheque No.</th>
                    <th>Account No.</th>
                    <th>Creation Date</th>

                    <th>Created User</th>
                    
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    
                </tbody>
          
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="chequeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cheque Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="chequeForm">
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
            <label for="">cheque  No</label>
            <input type="text" name="chequeNo" id="chequeNo" class="form-control" placeholder="Enter Brach Name" required readonly>
            <label for="">Account No.</label>
            <select name="accountNo" id="accountNo" class="form-control">

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
<!-- /.container-fluid -->

<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/cheque.js"></script>