<?php
session_start();
 if(!isset($_SESSION['id'])){
  header("location:../../index.php");
 }
?>
<style>
    
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
  
    .container{
        max-width: 1000px !important;
        margin: 0 auto !important;
        border: 1px solid #ccc; 
        padding: 10px ;
        
    }
    header{
        display: flex !important;
        margin: 20px auto !important;
        justify-content: space-around;
       
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
    .form-rows span{
        margin-left: 10px !important;
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
        <header>
            <h2 class="branch">SALAAM SOMALI BANK-<span id="branch">BAKAARO BARANCH</span></h2>
            <div class="logo">
                <img src="../../assets/img/logo.png" alt="">
            </div>
          
        </header>
        <div class="title">
            <h1 class="cr">CR</h1>
            <h2>Cash Deposit Note -No<span id="invoice"> 212990</span></h2>   
        </div>
        <div class="content">
          
             <div class="form-rows">
                <label >date</label>:
                <span id="dates">2023-2-22</span>
             </div>
             <div class="form-rows">
                <label >A/c No</label>
                <span id="ac_no">: 22</span>
                </div>
                <div class="form-rows">
                <label >A/c Type</label>
                <span id="type">: Deposit</span>
                </div>
                <div class="form-rows">
                <label >Name</label>
                <span id="names">: Hussein</span>
                </div>
                <div class="form-rows">
                <label >Amount</label>
                <span id="amounts">: # 37,500.00 #</span>
                </div>
                <div class="form-rows">
                <label>Currency</label>
                <span>: Dollars</span>
                </div>
                <div class="form-rows">
                 <label>Deposit By</label>
                <span id="deposited_by">: Hussein Isse Ali</span>
                </div>
        
            <div class="user">
                <h2>Entered By:</h2>
                <span id="users">xuska</span>
            </div>
            <h2>Cashier Sign </h2>

        </div>
    </div>

</body>
<script src="../js/deposit.js"></script>
</html>