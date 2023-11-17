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
<style>
  #showImage{
  margin-top:15px;
  border-radius: 50%;
  margin-left: 50px;
  width: 202px;
  height: 202px;
  border: 2px solid #ccc;
}
</style>
   <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>
<!-- <p class="mb-4">This is Branh Information</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <button class="btn btn-success btn-md btn-circle float-right" id="addnew"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered usersTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    
                </tbody>
          
            </table> 
        </div>
    </div>
</div>


<div class="modal fade" id="usersModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="usersForm" enctype="multipart/form-data">
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
            <label for="">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
            <label for="">Password</label>
            <input type="password" name="password" id="password" class="form-control " placeholder="Enter Password"required>
            <label for="">Image</label>
             <input type="file" class="form-control" id="image" name="username">

             <label for="">User Type</label>
            <select name="type" id="type" class="form-control">
              <option value="" required>Please Select User Type</option>
              <option value="Admin">Admin</option>
              <option value="Student">Student</option>
            </select>
            <label for="">User Ststus</label>
            <select name="status" id="status" class="form-control">
              <option value="" required>Please Select User Status</option>
              <option value="Active">Active</option>
              <option value="Disable">Disable</option>
            </select>
          
        </div>
      </div>
      <div class="row">
        <div class="col-2"></div>
      <div class="col-6 ">
        
        <img src="" alt="" id="showImage">
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

                        
<script src="../js/users.js"></script>