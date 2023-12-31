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
#image,#signuture{
  margin-top:15px;
  border-radius: 3%;
  margin-left: 20px;
  width: 202px;
  height: 202px;
}
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
    body{
        font-family: 'Poppins', sans-serif;
    }
    .container1{
        max-width: 900px !important;
        margin: 0 auto !important;
        border: 1px solid #ccc; 
        padding: 10px ;
        
    }
    .container2{
        max-width: 900px !important;
        margin: 10px auto !important;
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
        justify-content: space-around;
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
    p{
        font-size: 15px;
        color: #424040;
        margin-top: 5px !important;
    }
    table{
        width: 100%;
    }
    table ,th ,td{
        border: 1px solid #535151;
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
   <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Account To Account</h1>
<p class="mb-4">Money Transfeer</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <!-- <button class="btn btn-success btn-md btn-circle float-right" id="addnew"><i class="fas fa-plus"></i></button> -->
    </div>
    <div class="card-body">
      <div class="row">
    
        <div class="col-12">
        <form id="getAccountForm">
        <label for="">Account Number</label>
        <input type="text" name="" id="account_no" class="form-control" placeholder="Enter Account Number">
        <button href="#" class="btn btn-primary btn-icon-split mt-2">
          <span class="icon text-white-50">
          <i class="fas fa-money-bill"></i>
          </span>
          <span class="text">Get Account Information</span>
      </button>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accountToAccount_info">
  <div class="modal-dialog   modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="accountToAccountForm">
      <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success d-none">
                this is success alert
            </div>
            <div class="alert alert-danger d-none">
                this is danger alert
            </div>
        </div>
        </div>
        <div class="row">
          <div class="col-4">
            <label for="">Account No</label>
           <input type="text" class="form-control" id="accountNo" readonly name="account_no">
           <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['id'];?>">
          </div>
          <div class="col-4">
            <label for="">Account Holder Name</label>
          <input type="text" class="form-control" id="name" readonly>
          </div>
          <div class="col-4">
            <label for="">Account Blance</label>
          <input type="text" class="form-control" id="blance" readonly >
          <input type="hidden" name="branch_id" id="branch_id">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-6">
            <span>Image</span>
            <img  id="image">
          </div>
          <div class="col-6">
            <label for="">Signutare</label>
            <img  id="signuture">
          </div>
        </div>
        <hr>
        <div class="row">
       
          <div class="col-12">
            <label for="">Amount </label>
           <input type="number" class="form-control" id="amount" placeholder="Enter Amount You Went To accountToAccount" required name="amount">
          </div>
         </div>
         <div class="row">
          <div class="col-6">
            <label for="">Account Transfering To</label>
           <input type="text" class="form-control" id="TransferingTo" placeholder="Enter account Number" required name="debit">
          </div>
          
          <div class="col-6">
            <label for="">Account Transfering From </label>
           <input type="text" class="form-control" id="credit" placeholder="Enter account Number" required name="credit" readonly>
          </div>
          </div>
            <hr style="border:2px solid blue">
          
          
          <div class="row" id="transferInfo">
          
          </div>




         <div class="row">
          <div class="col-6">
            <label for="">Write Money </label>
           <input type="text" class="form-control"  placeholder="Enter Write Money" required name="write_amount" >
          </div>
          <div class="col-6">
            <label for="">Transfered Person </label>
           <input type="text" class="form-control" id="person" placeholder="Enter accountToAccount Person" required name="person">
          </div>
          </div>
         
          <div class="row">
          <div class="col-12">
            <label for="">accountToAccount Description</label>
           <textarea name="description" id="description" cols="30" rows="10" placeholder="Transfer Description" class="form-control"></textarea>
          </div>
          </div>
            
          </div>
       
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">accountToAccount</button>
      </div>
    </div>
</form>
  </div>
</div>
<!-- Modal -->









<div class="modal fade printmodls" id="reportModal" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deposit Report</h5>
        <button type="button" class="btn btn-primary" id="deposit_report_print"><i class="fas fa-print"></i></button>
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
                    <label >date</label>:
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
                    <h2>Entered By:</h2>
                    <span id="user">xuska</span>
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
                    <span id="date"></span>
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
                    <span id="user1"></span>
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

                        
<script src="../js/account_to_account.js"></script>