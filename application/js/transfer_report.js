ReadAccount();
ReadBranch();
ReadUsers();


$("#ReportForm").on("submit", function(e){
    e.preventDefault();

    let sendingData=new FormData($("#ReportForm")[0]);
    sendingData.append("action","TransferReport");
    $(".branchTable tbody").html("");
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/account_to_account.php",
        data:sendingData,
        processData:false,
        contentType:false,
        success:function(data){
            let status=data.status;
            let response=data.data;
            let html="";
            if(status){
                response.forEach(function(res){
                    html+="<tr>";
                    for(let r in res){
                       
                        html+=`<td>${res[r]}</td>`;
                      
                    }
                    html+=`<td>
                    <a class='btn btn-success  print_info' print_id=${res['id']}><i class='fas fa-edit' style='color:#fff;'></i></a>
                   
                    </td>`;
                    html+="</tr>";
                })
                $(".branchTable tbody").append(html);
                // $("#dataTable").dataTable();

            }else{
               
            }

        },error:function(data){

        }


    })

})


function ReadBranch(){
   
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/branch.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            let html="";
            if(status){
               html+="<option value=''required>Please Select Branch </option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['name']}</option>`;
               
                })
                $("#branch_id").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function ReadAccount(){
   
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/account.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            let html="";
            if(status){
               html+="<option value=''required>Please Select Account No </option>";
                response.forEach(function(res){
                    html+=`<option value="${res['account_id']}">${res['account_id']}</option>`;
               
                })
                $("#account_no").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function ReadUsers(){
   
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/users.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            let html="";
            if(status){
               html+="<option value=''required>Please Select Username </option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['username']}</option>`;
               
                })
                $("#user_id").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function  PrintAllDeposit(){
    
    let  w=window.open();
    w.document.write(`<style media="print">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
  
    table{
        border-collapse: collapse !important;
        max-width: 900px !important;
        margin: 25px auto !important;
        font-size: 0.9rem !important;
        font-family: 'poppins' sans-serif !important;
        min-width: 400px !important;
        box-shadow:  0 0 25px rgba(0, 0, 0, 0.15) !important;
        
    }
    table thead tr{
        background-color: #009879 !important;
        color: #fff !important;
        text-align: left !important;
        padding: 10px !important;
    }
    table thead th{
        padding: 8px !important;
        
    }
    tbody th,td{
        padding: 12px 15px !important;
    }
    table tbody tr{
        border-bottom: 1px solid #dddddd !important;
    }
     input{
        display: block !important;
     }
     li{
        display:block !important;
     }
     select{
        display: block !important;
     }
     thead {display: table-row-group;}
     ths.print{
        display: block !important;
     }
    </style>`)
    w.document.write($('#print_era').html());
    w.print();
    w.close();
   
}

function PrintOneTransacion(id){
    let sendingData = {
        "id":id,
        "action":"PrintOneTransaction"
     
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/account_to_account.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
             
                $("#invoice").html(""+response['debit_id']);
                $("#branch").html(""+response['branch_name']);
                $("#cr_invoice").html(""+response['debit_id']);
                $("#date").html(": "+response['date']);
                $("#cr_date").html(": "+response['date']);
                $("#debit_ac_no").html(": "+response['debit_ac']);
                $("#_debit_acc_name").html(response['debit_name']);
                $("#dr_amount").html(""+response['amout']);
                $("#debit_account").html(""+response['debit_name']);
                $("#write_amount").html(": "+response['write_amount']);
                $("#dr_user").html(": "+response['username']);
                $("#cr_user").html(": "+response['username']);
                $("#_credit_ac_no").html(": "+response['credit_account']);
                $("#credit_name").html(": "+response['credit_name']);
                $("#credit_account").html(""+response['credit_name']);
                $("#cr_amount").html(""+response['amout']);
       
                 $("#reportModal").modal("show");

            }else{
                console.log(response)

            }

        },error:function(data){
            console.log(data.responseText);
        }
    })
}

function  print_transfer(){
    let print_eria = document.querySelector("#depositPrint");
    let  w=window.open();
    w.document.write(`<style media="print">
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
  
    </style>`)
    w.document.write($('.depositPrint').html());
    w.print();
    w.close();
   
}


$("#deposit_reposrt_print").on("click",function(){
    PrintAllDeposit();
})

$("#transfer_report_print").on("click", function(){
    print_transfer();
})

$(".branchTable tbody").on("click","a.print_info", function(){
    let id=$(this).attr("print_id");
    PrintOneTransacion(id);

})