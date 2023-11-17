ChequeNumber();
ReadData();
ReadAccount();
let btnAction="Insert";
$("#addnew").on("click", function(){
    $("#chequeModal").modal("show");
})

$("#chequeForm").on("submit", function(event){
    event.preventDefault();
    let update_id=$("#update_id").val();
    let chequeNo = $("#chequeNo").val();
    let accountNo = $("#accountNo").val();
    let sendingData={};
    if(btnAction=="Insert"){
        sendingData={
            "action":"AddChequeNo",
            "chequeNo":chequeNo,
            "accountNo":accountNo,
           
           
           
        }
    }else{
        sendingData={
            "id":update_id,
            "action":"UpdateChequeNo",
            "chequeNo":chequeNo,
            "accountNo":accountNo,
        }
    }
 
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/cheque.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data;
            if(status){
                desplaymessage("success",response);
               
                btnAction="Insert";
                ReadData();
            }else{
              desplaymessage("error",response);
            }

        },error:function(data){
            desplaymessage("error",data.responseText);
        }
    })
})




function ReadData(){
  $(".chequeTable tbody").html("");
    let sendingData = {
        "action":"ReadChequeNo",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/cheque.php",
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
                   
                    </td>`;
                    html+="</tr>";
                })
                $(".chequeTable tbody").append(html);
                $("#dataTable").dataTable();
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function FeachData(id){
    let sendingData = {
        "id":id,
        "action":"FetchData",
     
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/cheque.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
               
             $("#update_id").val(response['id']);  
             $("#chequeNo").val(response['chequeNo']);   
             $("#accountNo").val(response['account_no']);  
             console.log(response['account_no']);  
             $("#chequeModal").modal("show");

            }else{
               alert(response);

            }

        },error:function(data){
            console.log(data.responseText);
        }
    })
}
function DeleteData(id){

        let sendingData = {
            "id":id,
            "action":"DeleteData",
         
        }
        $.ajax({
            method:"POST",
            dataType:"JSON",
            url:"../api/cheque.php",
            data:sendingData,
            success:function(data){
                let status = data.status;
                let response = data.data; 
                
                if(status){
                    // swal("Good job!", response, "success");
                    Swal.fire(
                        'Good job!',
                         response,
                        'success'
                      )
                  ReadData();

                }else{
                   alert(response);

                }

            },error:function(data){
                console.log(data.responseText);
            }
        })
}


function desplaymessage(alert,messege){
    let success=document.querySelector(".alert-success");
    let error=document.querySelector(".alert-danger");
    if(alert=="success"){
        success.classList="alert alert-success";
        success.innerHTML=messege;
        error.classList="alert alert-danger d-none";
        setTimeout(() => {
            $("#chequeForm")[0].reset();
            $("#chequeModal").modal("hide");
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}


$(".chequeTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
    }

})
$(".chequeTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
    FeachData(id);

})

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
               html+="<option>Please Select AccountNo</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['account_no']}">${res['account_no']}</option>`;
               
                })
                $("#accountNo").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}
function ChequeNumber(){
   
    let sendingData = {
        "action":"GenereteChequeNo",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/cheque.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
           
            if(status){
             $("#chequeNo").val(response);
            
            }else{
                console.log(response);
              desplaymessage("error", response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}