<?php

 if(!isset($_SESSION['id'])){
  header("location:../../index.php");
 }
?>
 <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion " id="accordionSidebar">
    <?php
    if($_SESSION['type']=="Admin"){
        ?>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['username'];?><sup></sup></div>
        </a>
        
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        
        <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span class="fs-2">Admin Dashboard</span></a>
            </li>
        
            <!-- Divider -->
            <hr class="sidebar-divider">
        
         
        
        
        
     
            <!-- Heading -->
            <div class="sidebar-heading">
                Pages
            </div>
        
        
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="./branch.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Branch</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="./account.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Accounts</span></a>
            </li> -->
            <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Customer Information</span>
                        </a>
                        <div id="collapsePages" class="collapse" aria-labelledby="headingUtilities"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Transaction Reports:</h6>
                                <a class="collapse-item" href="./account.php">Accounts</a>
                                <a class="collapse-item" href="./searchcustomer.php">Customer Search</a>
                                <a class="collapse-item" href="./cheque.php">Create Cheque</a>
                              
                            </div>
                        </div>
                    </li>
            <li class="nav-item">
                <a class="nav-link" href="./employee.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Employee</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./deposit.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Deposit</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./withdrow.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Withdrow</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./account_to_account.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transfere</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="./cheque.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Cheque Number</span></a>
            </li>
         -->
        
            <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Reports</span>
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingUtilities"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Transaction Reports:</h6>
                                <a class="collapse-item" href="./deposit_report.php">Deposit Report</a>
                                <a class="collapse-item" href="./withdrow_report.php">Withdrow Report</a>
                                <a class="collapse-item" href="./transfer_reposrt.php">Transfer Report</a>
                              
                            </div>
                        </div>
                    </li>
                    
            
        
            <li class="nav-item">
                <a class="nav-link" href="./users.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../views/logout.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Logout</span></a>
            </li>
        
        
        
        
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>';
    <?php
    }
    else{
        ?>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['username'];?><sup></sup></div>
        </a>
        
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        
        <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span class="fs-2"> Student Dashboard</span></a>
            </li>
        
            <!-- Divider -->
            <hr class="sidebar-divider">
        
            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
        
        
        
        
        
            <!-- Divider -->
            <hr class="sidebar-divider">
        
            <!-- Heading -->
            <div class="sidebar-heading">
                Pages
            </div>
        
        
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="./branch.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Branch</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./account.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Accounts</span></a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link" href="./deposit.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Deposit</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./withdrow.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Withdrow</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./account_to_account.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transfere</span></a>
            </li>
        
    
                    
            
        
            <li class="nav-item">
                <a class="nav-link" href="../views/logout.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Logout</span></a>
            </li>
        
        
        
        
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
        <?php
        
    }
    ?>


</ul>
<!-- End of Sidebar -->
 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../views/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>