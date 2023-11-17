<?php
session_start();
 if(!isset($_SESSION['id'])){
  header("location:../../index.php");
 }
?>
<style>
#showImage{
  margin-top:15px;
  border-radius: 3%;
  margin-left: 20px;
  width: 202px;
  height: 202px;
}
#showCv{
  margin-top:15px;
  border-radius:3%;
  margin-left: 40px;
  width: 202px;
  height: 202px;
}
#showImage1{
  margin-top:15px;
  border-radius: 3%;
  margin-left: 20px;
  width: 100%;
  height: 202px; 
}
#showCv1{
  margin-top:15px;
  border-radius:3%;
  margin-left: 40px;
  width: 80%;
  height: 202px;
}
/* img{
 margin-left: 60px;

} */



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
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <button class="btn btn-success btn-md btn-circle float-right" id="addnew"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered employeeTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Image</th>   
                    <th>CV</th>   
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
<div class="modal" id="employeeModal">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Employee Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="employeeForm" enctype="multipart/form-data">
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
        <label for="">First Name</label>
            <input type="text" name="first" id="first" class="form-control mt-2" placeholder="Enter First Name" required>
        </div>
        <div class="col-md-4">
        <label for="">Last Name</label>
            <input type="text" name="last" id="last" class="form-control mt-2" placeholder="Enter Last Name" required>
        </div>
        <div class="col-md-4">
        <label for="">Phone</label>
            <input type="number" name="phone" id="phone" class="form-control mt-2" placeholder="Enter Phone Number" required>
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['id'];?>">
        </div>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
            <label for="" class="form-lable">Email</label>
            <input type="email" name="email" id="Email" class="form-control mt-2" placeholder="Enter Brach Email" required>
            </div>
            </div>
            <div class="col-md-4">
            <label for="">Image</label>
            <input type="file" name="image" id="image" class="form-control mt-2" placeholder="Enter Brach Image" required>
            </div>
            <div class="col-md-4">
            <label for="">Cv</label>
            <input type="file" name="cv" id="cv" class="form-control mt-2" placeholder="Enter Brach Employee Cv" required>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="">Address</label>
            <input type="text" name="address" id="address" class="form-control mt-2" placeholder="Enter Employee address "required>
            </div>
            <div class="col-md-4">
            <label for="">Title</label>
            <input type="text" name="title" id="title" class="form-control mt-2" placeholder="Enter Emplooyeetitle "required>
            </div>
            <div class="col-md-4">
            <label for="">Passport/Document</label>
            <input type="text" name="document" id="document" class="form-control mt-2" placeholder="Enter Employee document "required>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
            <label for="">Issue Date</label>
            <input type="date" name="issue_date" id="issue_date" class="form-control mt-2" required>
            </div>
            <div class="col-md-6">
            <label for="">Expire Date</label>
            <input type="date" name="expier_date" id="expier_date" class="form-control mt-2"required>
            </div>
          
            
        </div>
        
            
            
        </div>
        <div class="row">
            <div class="col mb-2">
             <img  alt="" id="showImage">
            </div>
            <div class="col mb-2 ">
             <img  id="showCv">
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
        <h5 class=" p-3 m-2">Employee Information</h5>
      <img src="../../assets/img/siu.png" alt="" style="width:80%;height:100px">
     
      
      </div>
      <div class="maincontainer">
    
        
        <div class="row">
         <div class="col-6">
         <span >First Name</span>
          <h6 class=" p-2  bg-light " id="name1">/h6>
         </div>
         <div class="col-6">
         <span>Last Name</span>
          <h6 class="d-flex  p-2  bg-light "  id="name2"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Phone</span>
          <h6 class="d-flex p-2  bg-light" id="phoneno"></h6>
         </div>
         <div class="col-6">
         <span>Email</span>
          <h6 class="d-flex  p-2  bg-light" id="email2"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Address</span>
          <h6 class="d-flex  p-2  bg-light" id="address2"></h6>
         </div>
         <div class="col-6">
         <span>Title</span>
          <h6 class="d-flex p-2  bg-light" id="title2"></h6>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
         <span>Document</span>
          <h6 class="d-flex p-2  bg-light" id="document1"></h6>
         </div>
         <div class="col-6">
         <span>Issue Date</span>
          <h6 class="d-flex p-2  bg-light" id="issue_date1"></h6>
         </div>
        </div>

        <div class="row">
         <div class="col-6">
         <span>Expire Date</span>
          <h6 class="d-flex p-2  bg-light" id="expire_date1"></h6>
         </div>
         <div class="col-6">
         <span>Branch</span>
          <h6 class="d-flex p-2  bg-light " id="branch1"></h6>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
         <span>Username</span>
          <h6 class="d-flex p-2  bg-light" id="user_id"></h6>
         </div>
         <div class="col-6">
         <span>Date</span>
          <h6 class="d-flex p-2  bg-light" id="date"></h6>
         </div>
        </div>

     
        </div>
      <div class="empl_images">
      <div class="row" id="images">
         <div class="col-6 mb-2">
       
         <img src="" alt="" id="showImage1" width="100%">
         </div>
         <div class="col-6 mb-2">
        
          <img src="" alt="" id="showCv1">
         </div>
        </div>
        <!-- <div class="row">
       
        </div> -->
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

                        
<script src="../js/employee.js"></script>