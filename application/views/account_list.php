<?php
session_start();
 if(!isset($_SESSION['id'])){
  header("location:../../index.php");
 }
?>
<style>

#showImage,#showDocument,#showSign{
  margin-top:15px;
  border-radius: 3%;
  margin-left: 20px;
  width: 202px;
  height: 202px;
}
#document_imgs,#showImage1,#showSigns{
  margin-top:15px;
  border-radius: 3%;
  margin-left: 20px;
  width: 202px;
  height: 202px;
}




</style>
<?php
include("header.php");
include("navbar.php");
include("topbar.php");

?>
   <!-- Begin Page Content -->
        <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Branches</h1>
<p class="mb-4">This is Branh Information</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
      
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered accountTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Account No</th>
                    <th>Name</th>
                    <th>Account Type</th>
                    <th>Sex</th>
                    <th>Phone</th>   
                    <th>Email</th>   
                    <th>Image</th>  
                    <th>Username</th>   
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
<div class="modal" id="accountModal">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Account Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="accountForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
             <div class="alert alert-success d-none">
                this is success alert
             </div>
             <div class="alert alert-danger d-none">
                this is danger alert
             </div>
            </div>
        </div>
      <div class="row">
        <div class="col-md-4">
        <label for="">Account Number</label>
            <input type="text" name="account_no" id="account_no" class="form-control mt-2" placeholder="Enter First Name" readonly="true">
        </div>
        <div class="col-md-4">
        <label for="">Full Name</label>
            <input type="text" name="name" id="name" class="form-control mt-2" placeholder="Enter Last Name">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['id'];?>">
        </div>
        <div class="col-md-4">
        <label for="">Account Type</label>
          <select class="form-control" name="type">
            <option value="" required>Select Account Type</option>
            <option value="Current">Current</option>
            <option value="Saving">Saving</option>

          </select>
        </div>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
            <label for="" class="form-lable">Sex</label>
            <select class="form-control" name="sex" class="form-control">
            <option value="" required>Select Sex </option>
            <option value="Male">Male</option>
            <option value="Femele">Femele</option>

          </select>
            </div>
            </div>
            <div class="col-md-4">
            <label for="">phone</label>
            <input type="number" name="phone" id="phone" class="form-control mt-2" placeholder="Enter Brach Image">
            </div>
            <div class="col-md-4">
            <label for="">Email</label>
            <input type="email" name="email" id="Email" class="form-control mt-2" placeholder="Enter  Email">
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="">Address</label>
            <input type="text" name="address" id="address" class="form-control mt-2" placeholder="Enter  address ">
            </div>
          
            <div class="col-md-4">
            <label for="">Document Number</label>
            <input type="text" name="document_no" id="document_no" class="form-control mt-2" placeholder="Enter Employee document ">
            </div>
            <div class="col-md-4">
            <label for="">Document Image</label>
            <input type="file" name="document_img" id="document_img" class="form-control mt-2" >
            </div>
        </div>
        <div class="row">
           
            <div class="col-md-4">
            <label for="">Issue Date</label>
            <input type="date" name="issue_date" id="expiissue_dateer_date" class="form-control mt-2">
            </div>
            <div class="col-md-4">
            <label for="">Expire Date</label>
          <input type="date" name="expire_date" id="expire date" class="form-control">
          </div>
            
            <div class="col-md-4">
            <label for=""> Image</label>
            <input type="file" name="image" id="image" class="form-control mt-2" >
            </div>
          
        </div>
        <div class="row">
            
            <div class="col-md-6">
            <label for="">Signature </label>
            <input type="file" name="sign" id="sign" class="form-control mt-2">
            </div>
            <div class="col-md-6">
            <label for=""> Branch </label>
            <select name="branch" id="branch_id" class="form-control mt-2" >

            </select>
            </div>
            
        </div>
        
        <div class="row">
           
           <div class="col-md-4">
           <label for="">Next of Kind Name</label>
           <input type="text" name="next_of_kind_name" id="next_of_kind_name" class="form-control mt-2" placeholder="Enter Next of kind Name">
           </div>
           <div class="col-md-4">
           <label for="">Next of Kind Phone</label>
         <input type="text" name="next_of_kind_number" id="next_of_kind_number" class="form-control" placeholder="Enter Next of Kind Number">
         </div>
           
           <div class="col-md-4">
           <label for=""> RelationShip</label>
           <input type="text" name="relationship" id="relationship" class="form-control mt-2" placeholder="Enter Relationship">
           </div>
         
       </div>
            
        </div>
        <div class="row">
            <div class="col mb-2">
             <img  alt="" id="showImage">
            </div>
            <div class="col mb-2 ">
             <img  id="showDocument">
            </div>
            <div class="col mb-2 ">
             <img  id="showSign">
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

<div class="modal" id="ViewModal">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
    
        <h5 class="modal-title" >Employee Content</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="print_eria">
      <div id="titles">
      <h5 class=" text-center m-2">Employee Content</h5>
      <img src="../../assets/img/siu.png" alt="" style="width:80%;height:100px">
      </div>
      <div class="maincontainer">
      <div id="container">
        
        <div class="row">
         <div class="col-6">
         <span>Account Number</span>
          <h6 class=" p-2  bg-light " id="account_num"></h6>
         </div>
         <div class="col-6">
         <span>Name</span>
          <h6 class="d-flex  p-2  bg-light "  id="names"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Account Type</span>
          <h6 class="d-flex p-2  bg-light" id="types"></h6>
         </div>
         <div class="col-6">
         <span>Sex</span>
          <h6 class="d-flex  p-2  bg-light" id="sexs"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Phone</span>
          <h6 class="d-flex  p-2  bg-light" id="phones"></h6>
         </div>
         <div class="col-6">
         <span>Email</span>
          <h6 class="d-flex p-2  bg-light" id="emails"></h6>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
         <span>Address</span>
          <h6 class="d-flex p-2  bg-light" id="addresss"></h6>
         </div>
         <div class="col-6">
         <span>Document Number</span>
          <h6 class="d-flex p-2  bg-light" id="document_nos"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Issue Date</span>
          <h6 class="d-flex p-2  bg-light" id="issue_date"></h6>
         </div>
         <div class="col-6">
         <span>Expire Date</span>
          <h6 class="d-flex p-2  bg-light " id="expire_date"></h6>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
         <span>Branch</span>
          <h6 class="d-flex p-2  bg-light" id="branch_ids"></h6>
         </div>
         <div class="col-6">
         <span>Next of Kind Name</span>
          <h6 class="d-flex p-2  bg-light" id="next_of_kind_names"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>next of Kind Number</span>
          <h6 class="d-flex p-2  bg-light" id="next_of_kind_numbers"></h6>
         </div>
         <div class="col-6">
         <span>next of Kind Relationship</span>
          <h6 class="d-flex p-2  bg-light" id="relationships"></h6>
         </div>
        </div>

      
        </div>
        <div class="row" id="images">
         <div class="col-4 mb-2">
          
         <img src="" alt="" id="document_imgs">

         </div>
         <div class="col-4 mb-2">
          <img src="" alt="" id="showImage1">
         </div>
         <div class="col-4 mb-2">
          <img src="" alt="" id="showSigns">
         </div>
        </div>
        </div>
        </div>
        </div>
      <div class="modal-footer">
       
   <button class="btn btn-success d-block" id="print_employee"><i class="fas fa-print"></i></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
   
    </div>
</form>
  </div>
</div>
<?php
                        include("footer.php");
                        include("script.php");

                        ?>

                        
<script src="../js/account.js"></script>