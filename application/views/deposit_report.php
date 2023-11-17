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
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
  
  .container{
      max-width: 900px !important;
      margin: 0 auto !important;
      border: 1px solid #ccc; 
      padding: 10px ;
      
  }
  header{
      display: flex !important;
      align-items: center;
      justify-content: center;
      border-bottom: 1px solid #ccc !important;
     
  }
  header .branch{
      font-size: 20px !important;
      font-weight: 500 !important;  
  }
  header .logo{
      margin-top: 20px !important;
      margin-left: 10px !important ;
  }
  header .logo img{
      width: 100px !important;
      height:100px !important;
      
      
  }
  .title{
      display: flex !important;
      border-bottom: 2px solid #2b2929 !important;
      justify-content: center;
  }
  .title h1{
      font-size: 35px!important;
      font-weight: 600 !important;
  }
  .title h2{
    font-size: 24px !important;
    font-weight: 300 !important;
    margin-top: 15px !important;
  }
  .content{
      display: flex !important;
      flex-direction: column !important;
  }
  .form-rows{
      display: flex !important;
      margin-left: 10px !important;
     
      
  }
  .form-rows h2 span{
      margin-top:30px !important;
  }
  .user{
      display: flex !important;
  }
  .user span{
      margin-top: 25px !important;
      margin-left: 10px !important;
      font-size: 12px !important;
  }
  
</style>
   <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Deposit Report</h1>
        <p class="mb-4">Get Depsot Rebort in More Ways</p>

<!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
            <form id="ReportForm">
            <div class="row">

            <div class="col">
                <label for="">Account Number</label>
                <select name="account_no" id="account_no" class="form-control">

                </select>
            </div>
             <div class="col">
                <label for="">Branch</label>
                <select name="branch_id" id="branch_id" class="form-control">
                    
                </select>
            </div>
            <div class="col">
                <label for="">Username</label>
                <select name="user_id" id="user_id" class="form-control">
                  
                </select>
            </div>
            <div class="col">
                <label for="">From</label>
                <input type="date" name="from" id="from" class="form-control">
            </div>
            <div class="col">
                <label for="">To</label>
                <input type="date" name="to" id="to" class="form-control">
            </div>
           
          
        </div>
        <button href="#" class="btn btn-success btn-icon-split mt-2" type="submit">
          <span class="icon text-white-50">
          <i class="fas fa-money-bill"></i>
          </span>
          <span class="text">Get Account Information </span>
      </button>
        </form>
    </div>
    <div class="card-body">
       
        <div class="table-responsive">
        <div class="row">
                    <div class="col-12">
                    <button  class="btn btn-primary btn-icon-split mt-2"  id="deposit_reposrt_print">
                    <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Print</span>
                    </button>
                    </div>
                </div>
      <div id="print_era">
            <table class="table branchTable" id="dataTable" width="100%" cellspacing="0">
            
                <thead>
                <tr>
                    <th>#</th>
                    <th >Account No.</th>
                    <th>Amount</th>
                    <th>Account Holder</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th class="print">Print</th>
                   
                </tr>
                </thead>
                <tbody>
                    
                </tbody>
              
          
            </table>
        </div>
        </div>
     
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="reportModal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deposit Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="depositPrint">
       <div class="container">
        <header>
            <h2 class="branch">SALAAM SOMALI BANK-<span id="branch">BAKAARO BARANCH</span></h2>
            <div class="logo">
                <img src="../../assets/img/logo.png" alt="">
            </div>
          
        </header>
        <div class="title">
            <h1 class="cr">CR</h1>
            <h2>Cash Deposit Note -No<span id="invoice">212990</span></h2>   
        </div>
        <div class="content">
          
             <div class="form-rows">
                <label >date</label>
                <span id="dates">: </span>
             </div>
             <div class="form-rows">
                <label >A/c No</label>
                <span id="ac_no">: </span>
                </div>
                <div class="form-rows">
                <label >A/c Type</label>
                <span id="type">: </span>
                </div>
                <div class="form-rows">
                <label >Name</label>
                <span id="names">: </span>
                </div>
                <div class="form-rows">
                <label >Amount</label>
                <span id="amounts">:</span>
                </div>
                <div class="form-rows">
                <label>Currency</label>
                <span>:Dollers </span>
                </div>
                <div class="form-rows">
                 <label>Deposit By</label>
                <span id="deposited_by">: </span>
                </div>
        
            <div class="user">
                <h2>Entered By:</h2>
                <span id="users">xuska</span>
            </div>
            <h2>Cashier Sign </h2>

        </div>
    </div>

</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="deposit_report_print"><i class="fas fa-print"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/deposit_report.js"></script>