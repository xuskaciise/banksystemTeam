// ReadBranch();
ReadData();


let btnAction="Insert";
let FileImage=document.querySelector("#image");
let ShowImage=document.querySelector("#showImage");

const imagereader=new FileReader();

FileImage.addEventListener("change",(e)=>{
    const selectedFile=e.target.files[0];
    imagereader.readAsDataURL(selectedFile);
})
imagereader.onload = e=>{
    ShowImage.src=e.target.result;
}
$("#addnew").on("click", function(){
    $("#usersModal").modal("show");
})

$("#usersForm").on("submit", function(event){
    event.preventDefault();
     formdata=new FormData($("#usersForm")[0]);
     formdata.append("image",$("input[type=file")[0].files[0]);
    if(btnAction=="Insert"){
      formdata.append("action","Addusers");
    }else{
        formdata.append("action","UpdateUser");
    }
 
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/users.php",
        data:formdata,
        processData:false,
        contentType:false,
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
                 html+="<option required>Please Select Branch</option>";
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

function ReadData(){
  $(".usersTable tbody").html("");
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
                response.forEach(function(res){
                    html+="<tr>";
                    for(let r in res){
                    
                        if(r=="image" ){
                         html+=`<td><img src='../uploads/users/${res[r]}' style='width:50px;height:50px;border-radius:50%;object-fit:cover;margin-left:20px' ></td>`
                       
                        }
                        
                        else{
                            html+=`<td>${res[r]}</td>`;
                        }

                    
                      
                    }
                    html+=`<td>
                    <a class='btn btn-primary    update_info' update_id=${res['id']}><i class='fas fa-edit'style='color:#fff'></i></a>
                    <a class='btn btn-danger    delete_info' delete_id=${res['id']}><i class='fas fa-trash'style='color:#fff'></i></a>

                   
                   
                    </td>`;
                    html+="</tr>";
                })
                $(".usersTable tbody").append(html);
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
        url:"../api/users.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
                $("#update_id").val(response['id']);
                $("#username").val(response['username']);
                $("#password").val(response['password']);
                $("#type").val(response['type']);
                $("#status").val(response['status']);
                $("#showImage").attr('src',`../uploads/users/${response['image']}`)
                $("#usersModal").modal("show");

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
            url:"../api/users.php",
            data:sendingData,
            success:function(data){
                let status = data.status;
                let response = data.data; 
                
                if(status){
                   
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
            $("#usersForm")[0].reset();
            $("#usersModal").modal("hide");
       
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}


function Viewusers(id){
  
      let sendingData = {
        "id": id,
          "action":"ReadAlluserss",
          
      }
      $.ajax({
          method:"POST",
          dataType:"JSON",
          url:"../api/users.php",
          data:sendingData,
          success:function(data){
              let status = data.status;
              let response = data.data; 
               
              if(status){
              
                $("#name1").html(response['First']);
                $("#name2").html(response['Last']);
                $("#phoneno").html(response['contect']);
                $("#email2").html(response['email']);
                $("#address2").html(response['address']);
                $("#title2").html(response['title']);
                $("#document1").html(response['docoment']);
                $("#issue_date1").html(response['issu_date']);
                $("#expire_date1").html(response['expire_date']);
                $("#branch1").html(response['branch_id']);
                $("#user_id").html(response['user_id']);
                $("#date").html(response['date']);
                $("#showImage1").attr('src',`../uploads/users/images/${response['image']}`)
                $("#showCv1").attr('src',`../uploads/users/cv/${response['cv']}`)
                // $("#date").html(response['date']);
               
                $("#ViewModal").modal("show");
                 
              }else{
                  console.log(response);
              }
          },error:function(data){
              console.log(data.responseText);
          }
      })
  
  }


$("#print_users").on("click",function(){
    print_users();
})

function  print_users(){
    let print_eria = document.querySelector("#print_eria");


    let newWindow=window.open("");
    newWindow.document.write(`<html><head><title></title>`);
    newWindow.document.write(`</head><body>`)
    newWindow.document.write(`<style media="print">
    
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;1,200;1,300&display=swap');

    body{
        font-family: 'Poppins', sans-serif  !important;
      
    }
    #titles{
        font-size:26px  !important;
        font-weight:600  !important;
        text-align:center  !important;
        color:grey  !important;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px  !important;
        margin:10px 0  !important;

    }
    #titles img{
        width:100%  !important;
        height:100px  !important;
        margin-top:15px  !important;
    }
    .maincontainer{
    display:flex  !important;
    align-items: center  !important;
    width:100%  !important;
    margin-top:15px  !important;
    height:300px  !important;
    
   
    
    }
    .row{
        display:flex;
        flex-direction:column;
        width:100%!important;
        // border-bottom:1px solid #999 !important;
   
       
       
    }
    .row  span{
        font-size:24px!important;
        padding-bottom:10px !important;
      
       

    }
    .row h6{
        font-size:20px !important;
        font-weight:400 !important;
        color:gray !important;;
        margin-top:10px !important;

    }
  .empl_images{
    display:flex!important;
    align-items:center!important;
     justify-content: space-around !important;
  }
  .empl_images .row{
    margin:10px;
  }
  .empl_images .row .col-12 img{
    width:400px !important;
    height:200px !important;
    border-radius:15px !important;

}
 

   


    
    

    
    </style>`)
    newWindow.document.write(print_eria.innerHTML);
    newWindow.document.write(`</body></html>`);
    newWindow.print();
   
}


$(".usersTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
    }

})
$(".usersTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
    FeachData(id);

})
$(".usersTable tbody").on("click","a.see_info", function(){
    let id=$(this).attr("see_id");
    Viewusers(id);

})