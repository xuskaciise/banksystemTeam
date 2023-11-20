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
<h1 class="h3 mb-2 text-gray-800">Taller Number</h1>
<p class="mb-4">Create New Taller </p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
       
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
            <label for="">taller  No</label>
            <input type="text" name="tallerNo" id="tallerNo" class="form-control" placeholder="Enter taller No." required readonly>
            <label for="">Taller.</label>
            <select name="taller_id" id="taller_id" class="form-control">

            </select>
            <label for="">Taller User.</label>
            <select name="taller_user" id="taller_user" class="form-control">

            </select>
            <button class="btn btn-success btn-lg mt-2">Save Taller</button>
        </div>
      </div>
      
        
    </div>
</div>


<!-- /.container-fluid -->

<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/taller.js"></script>