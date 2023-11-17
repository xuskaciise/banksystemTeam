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
        <div class="row">
            <div class="col-12">
            <button  class="btn btn-primary btn-icon-split mt-2"  id="deposit_reposrt_print">
            <span class="icon text-white-50">
            <i class="fas fa-print"></i>
            </span>
            <span class="text">Print Withdrow Report</span>
            </button>
            </div>
        </div>
        </form>
    </div>
    <div class="card-body">
      
        <div class="table-responsive">
     
        <div id="print_era">
            <table class="table branchTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Debit Account</th>
                    <th>Dibit Account Name</th>
                    <th>Credit Account</th>
                    <th>Credit Account Name</th>
                    <th>Branch</th>
                    <th>Date</th>
                    <th>Username</th>
                  
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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
    body{
        font-family: 'Poppins', sans-serif;
    }
    .container1{
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid #ccc; 
        padding: 10px ;
        
    }
    .container2{
        max-width: 900px;
        margin: 10px auto;
        border: 1px solid #ccc; 
        padding: 10px ;
    }
    header{
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #ccc;
       
    }
    header .branch{
        font-size: 20px;
        font-weight: 500;  
    }
    header .logo{
        margin-top: 20px;
        margin-left: 10px ;
    }
    header .logo img{
        width: 100px;
        height:100px;
        
        
    }
    .title{
        display: flex;
        justify-content: space-around;
    }
    .title h1{
        font-size: 35px!important;
        font-weight: 600;
    }
    .title h2{
      font-size: 24px;
      font-weight: 300;
      margin-top: 15px;
    }
    .content{
        display: flex;
        flex-direction: column;
    }
    .form-rows{
        display: flex;
        margin-left: 10px;
       
        
    }
    .form-rows h2 span{
        margin-top:30px;
    }
    .user{
        display: flex;
    }
    .user span{
        margin-top: 25px;
        margin-left: 10px;
        font-size: 12px;
    }
    p{
        font-size: 15px;
        color: #424040;
        margin-top: 5px;
    }
    table{
        width: 100%;
    }
    table ,th ,td{
        border-bottom: 1px solid  #ccc;
        border-collapse: collapse;
        
    }
    #write_amount{
        margin-left: 30px;
    }
    .printmodls{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>
<div class="modal fade printmodls" id="reportModal" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deposit Report</h5>
        <button type="button" class="btn btn-primary" id="transfer_report_print"><i class="fas fa-print"></i></button>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="depositPrint">
      <div class="container1">
            <header>
                <h2 class="branch">SALAAM SOMALI BANK-<span id="branch">BAKAARO BARANCH</span></h2>
                <div class="logo">
                    <img src="../../assets/img/logos.png" alt="">
                </div>
              
            </header>
            <div class="title">
                <h1 class="cr">Dr</h1>
                <h2>Dibit  Note -<span id="invoice"> 212990</span></h2>   
            </div>
            <div class="content">
              
                 <div class="form-rows">
                    <label >date</label>
                    <span id="date">2023-2-22</span>
                 </div>
                 <div class="form-rows">
                    <label >Account No</label>
                    <span id="debit_ac_no">: 22</span>
                    </div>
                    <div class="form-rows">
                    <label >Customer Name</label>
                    <span id="_debit_acc_name">: Hussein</span>
                    </div>
                 <p>Please Note That We Debited Your Account As Detailed Below </p>
                 <table>
                    <tr>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Narration</th>
                    </tr>
                    <tr>
                        <td id="dr_amount">10,309</td>
                        <td>Currence</td>
                        <td id="debit_account">SIU OPRATIONS ACCOUNT</td>
                    </tr>
                 </table>
                 <p id="write_amount">ten thaousand and three Hundred</p>
            
                <div class="user">
                    <h2>Entered By</h2>
                    <span id="dr_user">xuska</span>
                </div>
                <h2 class="cashier">Cashier Sign________________________ </h2>
    
            </div>
        </div>
        <div class="container2">
            <header>
                <h2 class="branch">SALAAM SOMALI BANK-<span id="branch">BAKAARO BARANCH</span></h2>
                <div class="logo">
                <img src="../../assets/img/logos.png" alt="">
                </div>
              
            </header>
            <div class="title">
                <h1 class="cr">Cr</h1>
                <h2>Credit  Note -<span id="cr_invoice"> 212990</span></h2>   
            </div>
            <div class="content">
              
                 <div class="form-rows">
                    <label >date</label>
                    <span id="cr_date"></span>
                 </div>
                 <div class="form-rows">
                    <label >Account No</label>
                    <span id="_credit_ac_no"></span>
                    </div>
                    <div class="form-rows">
                    <label > Customer Name</label>
                    <span id="credit_name"></span>
                    </div>
                 <p>Please Note That We Debited Your Account As Detailed Below </p>
                 <table>
                    <tr>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Narration</th>
                    </tr>
                    <tr>
                        <td id="cr_amount"></td>
                        <td>Currence</td>
                        <td id="credit_account"></td>
                    </tr>
                 </table>
                 <p id="write_amount">ten thaousand and three Hundred</p>
            
                <div class="user">
                    <h2>Entered By</h2>
                    <span id="cr_user"></span>
                </div>
                <h2 class="cashier">Cashier Sign________________________ </h2>
    
            </div>
        </div>

</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/transfer_report.js"></script>