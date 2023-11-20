tallerNumber();
ReadData();
ReadTaller();
ReadTallerUser()
let btnAction="Insert";
$("#addnew").on("click", function(){
    $("#tallerModal").modal("show");
})

$("#tallerForm").on("submit", function(event){
    event.preventDefault();
    let update_id=$("#update_id").val();
    let tallerNo = $("#tallerNo").val();
    let taller_id = $("#taller_id").val();
    let taller_user = $("#taller_user").val();
    let sendingData={};
    if(btnAction=="Insert"){
        sendingData={
            "action":"AddtallerNo",
            "tallerNo":tallerNo,
            "taller_id":taller_id,
            "taller_user":taller_user,
            
           
           
           
        }
    }else{
        sendingData={
            "id":update_id,
            "action":"UpdateData",
            "tallerNo":tallerNo,
            "taller_id":taller_id,
            "taller_user":taller_user,
        }
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/taller.php",
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
  $(".TallerTable tbody").html("");
    let sendingData = {
        "action":"ReadData",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/taller.php",
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
                $(".TallerTable tbody").append(html);
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
        url:"../api/taller.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
               
             $("#update_id").val(response['id']);  
             $("#tallerNo").val(response['taller_no']);   
             $("#taller_id").val(response['taller_name']);  
             $("#taller_user").val(response['taller_user']);   
             $("#TallerModal").modal("show");

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
            url:"../api/taller.php",
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
            $("#tallerForm")[0].reset();
            window.location.reload();
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}

$(".TallerTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
    }

})
$(".TallerTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
 
    FeachData(id);

})
function ReadTaller(){
   
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
               html+="<option>Please Select Taller</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['First']+" "+res['Last']}</option>`;
               
                })
                $("#taller_id").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}
function ReadTallerUser(){
   
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
                $("#taller_user").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}
function tallerNumber(){
   
    let sendingData = {
        "action":"GeneretetallerNo",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/taller.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
           
            if(status){
             $("#tallerNo").val(response);
            
            }else{
                console.log(response);
              desplaymessage("error", response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}