stockNumber();
ReadData();
ReadManager();
ReadManagerUser()
let btnAction="Insert";
$("#addnew").on("click", function(){
    $("#stockModal").modal("show");
})

$("#stockForm").on("submit", function(event){
    event.preventDefault();
    let update_id=$("#update_id").val();
    let stockNo = $("#stockNo").val();
    let manger_id = $("#manger_id").val();
    let manager_user = $("#manager_user").val();
    let blance = $("#blance").val();
    let sendingData={};
    if(btnAction=="Insert"){
        sendingData={
            "action":"AddStockNo",
            "stockNo":stockNo,
            "manger_id":manger_id,
            "manager_user":manager_user,
            "blance":blance,
           
           
           
        }
    }else{
        sendingData={
            "id":update_id,
            "action":"UpdatestockNo",
            "stockNo":stockNo,
            "manger_id":manger_id,
            "manager_user":manager_user,
            "blance":blance,
        }
    }
    console.log(stockNo);
 
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/stock.php",
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
  $(".stockTable tbody").html("");
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/stock.php",
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
                $(".stockTable tbody").append(html);
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
        url:"../api/stock.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
               
             $("#update_id").val(response['id']);  
             $("#stockNo").val(response['stockNo']);   
             $("#accountNo").val(response['account_no']);  
             console.log(response['account_no']);  
             $("#stockModal").modal("show");

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
            url:"../api/stock.php",
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
            $("#stockForm")[0].reset();
            $("#stockModal").modal("hide");
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}


$(".stockTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
    }

})
$(".stockTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
    FeachData(id);

})

function ReadManager(){
   
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/employee.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            let html="";
            if(status){
               html+="<option>Please Select Manger</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['First']+" "+res['Last']}</option>`;
               
                })
                $("#manger_id").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}
function ReadManagerUser(){
   
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
               html+="<option>Please Select Manger</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['username']}</option>`;
               
                })
                $("#manager_user").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}
function stockNumber(){
   
    let sendingData = {
        "action":"GenereteStockNo",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/stock.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
           
            if(status){
             $("#stockNo").val(response);
            
            }else{
                console.log(response);
              desplaymessage("error", response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}