ReadData();
ReadEmployee();
let btnAction="Insert";
$("#addnew").on("click", function(){
    $("#branchModal").modal("show");
})

$("#branchForm").on("submit", function(event){
    event.preventDefault();
    let update_id=$("#update_id").val();
    let name = $("#name").val();
    let address = $("#address").val();
    let maneger = $("#manager").val();
    let limit_amount = $("#Limit").val();
    let user_id=$("#user_id").val();
    let sendingData={};
    if(btnAction=="Insert"){
        sendingData={
            "action":"AddBranch",
            "name":name,
            "address":address,
            "maneger":maneger,
            "limit_amount":limit_amount,
            "user_id":user_id
           
        }
    }else{
        sendingData={
            "id":update_id,
            "action":"UpdateData",
            "name":name,
            "address":address,
            "maneger":maneger,
            "limit_amount":limit_amount,
            "user_id":user_id
        }
    }
 
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/branch.php",
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

function FeachData(id){
    let sendingData = {
        "id":id,
        "action":"FetchData",
     
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/branch.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
                console.log(response)
             $("#update_id").val(response['id']);  
             $("#name").val(response['name']);   
             $("#address").val(response['address']);   
             $("#Manger").val(response['maneger']);   
             $("#phone").val(response['contect']);   
             $("#Limit").val(response['limit_amount']);   
             $("#branchModal").modal("show");

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
            url:"../api/branch.php",
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
            $("#branchForm")[0].reset();
            $("#branchModal").modal("hide");
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}
function ReadEmployee(){
   
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
               html+="<option value=''required>Please Branch Manager</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['id']}">${res['First']+ " "+ res['Last']}</option>`;
               
                })
                $("#manager").append(html);
                
               
            }else{
                console.log(response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

$(".branchTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
    }

})
$(".branchTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
    FeachData(id);

})