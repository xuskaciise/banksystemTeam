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
<h1 class="h3 mb-2 text-gray-800">stock Number</h1>
<p class="mb-4">Create And Modafy stock Number</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <button class="btn btn-success btn-md btn-circle float-right" id="addnew"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered StockTransaction" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>stock No.</th>
                    <th>Taller No.</th>
                    <th>Amount</th>
                    <th>Write Amount</th>
                    <th>Type</th>
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



<div class="modal fade" id="Stack_deposit">
  <div class="modal-dialog   modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send To Taller</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="stock_depositForm">
      <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info d-none">
                this is success alert
            </div>
            <div class="alert alert-warning d-none">
                this is danger alert
            </div>
        </div>
        </div>
        <div class="row">
          
          <div class="col-12">
            <label for="">Account Holder Name</label>
          <input type="hidden" name="stock_no" id="stock_no">
           <select name="taller_no" id="taller_no" class="form-control">

           </select>
           
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['id'];?>">
          </div>
        </div>
      
        <div id="demo">
        <div class="row">
       
          <div class="col-12">
            <label for="">Amount </label>
           <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter Amount You Went To deposit" required name="amount">
          </div>
         </div>
         <div class="row">
          <div class="col-12">
            <label for="">Write Money </label>
           <input type="text" class="form-control" name="write_amount" id="write_amount" placeholder="Enter Write Money" required name="write_amount" readonly >
          </div>
          </div>
          </div>
          </div>
       
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Deposit</button>
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

                        
<script src="../js/stock_trsnsaction.js"></script>