// ReadData();
// ReadEmployee();


$("#getAccountForm").on("submit", function(event){
    event.preventDefault();
    
    let account_no = $("#account_no").val();
    if(account_no==""){
      
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please Enter Account Number',
          })
        $("#account_no").focus();
        $("#account_no").css('border','1px solid #ff4d40');
        return false;
    }else{
        FeachData(account_no)
        $("#account_no").removeAttr('style');
        $("#account_no").val("");

    }
        
})

$("#withdrowForm").on("submit", function(e){
    e.preventDefault();

    let sendingData=new FormData($("#withdrowForm")[0]);
    sendingData.append("action","WithdrowAmount");
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/withdrow.php",
        data:sendingData,
        processData:false,
        contentType:false,
        success:function(data){
            let status=data.status;
            let response=data.data;
            if(status){
                desplaymessage("success",response);
                PrintTransaction();

            }else{
                desplaymessage("error",response);
            }

        },error:function(data){

        }


    })

})






function ReadData(){
  $(".branchTable tbody").html("");
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
                response.forEach(function(res){
                    html+="<tr>";
                    for(let r in res){
                       
                        html+=`<td>${res[r]}</td>`;
                      
                    }
                    html+=`<td>
                    <a class='btn btn-success  update_info' update_id=${res['id']}><i class='fas fa-edit' style='color:#fff;'></i></a>
                    <a class='btn  btn-danger delete_info' delete_id=${res['id']}><i class='fas fa-trash' style='color:#fff;'></i></a>
                    </td>`;
                    html+="</tr>";
                })
                $(".branchTable tbody").append(html);
                $("#dataTable").dataTable();
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function FeachData(account_no){
    let sendingData = {
        "account_id":account_no,
        "action":"ReadAccountInfo",
     
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/withdrow.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
             
             $("#accountNo").val(response['account_no']);   
             $("#name").val(response['name']);   
             $("#blance").val('$'+response['blance']);   
             $("#branch_id").val(response['branch_id']);   
             $("#image").attr('src',`../uploads/account/image/${response['image']}`)
             $("#signuture").attr('src',`../uploads/account/sign/${response['signature_img']}`) 
             $("#withdrow_info").modal("show");

            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                   text:response
                  })
                  $("#account_no").focus();

            }

        },error:function(data){
            console.log(data.responseText);
        }
    })
}

function PrintTransaction(){
    let sendingData = {
        
        "action":"PrintTransaction",
     
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/withdrow.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                console.log(response)
                
                $("#branch").html(": "+response['branch']);   
                $("#invoice").html(": "+response['id']);    
                $("#dates").html(": "+response['date']);    
                $("#ac_no").html(": "+response['account_id']);     
                $("#type").html(": "+response['type']);     
                $("#names").html(": "+response['name']);   
                $("#amounts").html(": "+response['amout']);   
                $("#deposited_by").html(": "+response['withdrow_persson']);   
                $("#users").html(": "+response['username']);   
                $("#reportModal").modal("show");
           
               

            }else{
               console.log(response)
            }

        },error:function(data){
            console.log(data.responseText);
        }
    })
}
$("#deposit_report_print").on("click", function(){
    print_deposit();
})
function  print_deposit(){
    let print_eria = document.querySelector("#depositPrint");
    let  w=window.open();
    w.document.write(`<style media="print">
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
    </style>`)
    w.document.write($('.depositPrint').html());
    w.print();
    w.close();
   
}

function desplaymessage(alert,messege){
    let success=document.querySelector(".alert-success");
    let error=document.querySelector(".alert-danger");
    if(alert=="success"){
        success.classList="alert alert-success";
        success.innerHTML=messege;
        error.classList="alert alert-danger d-none";
        setTimeout(() => {
            $("#withdrowForm")[0].reset();
            $("#withdrow_info").modal("hide");
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}