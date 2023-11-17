ReadBranch();
ReadData();
AccountNumber()


let btnAction="Insert";
let FileImage=document.querySelector("#image");
let ShowImage=document.querySelector("#showImage");

let FileDocument=document.querySelector("#document_img");
let ShowDocument=document.querySelector("#showDocument");



let SignFile=document.querySelector("#sign");
let ShowSign=document.querySelector("#showSign");




const imageReader=new FileReader();
const documentReader=new FileReader();
const signReader=new FileReader();
FileImage.addEventListener("change",(e)=>{
    const selectedFile=e.target.files[0];
    imageReader.readAsDataURL(selectedFile);
})
imageReader.onload = e=>{
    ShowImage.src=e.target.result;
}




FileDocument.addEventListener("change",(e)=>{
    const selectedFile=e.target.files[0];
    documentReader.readAsDataURL(selectedFile);
})
documentReader.onload = e=>{
    ShowDocument.src=e.target.result;
}

SignFile.addEventListener("change",(e)=>{
    const selectedFile=e.target.files[0];
    signReader.readAsDataURL(selectedFile);
})
signReader.onload = e=>{
    ShowSign.src=e.target.result;
}

$("#addnew").on("click", function(){
    $("#accountModal").modal("show");
})

$("#accountForm").on("submit", function(event){
    event.preventDefault();
     formdata=new FormData($("#accountForm")[0]);
     formdata.append("image",$("input[type=file")[1].files[0]);
     formdata.append("document_img",$("input[type=file")[0].files[0]);
     formdata.append("sign",$("input[type=file")[0].files[2]);
    //  formdata.append("document",$("input[type=file")[0].files[0]);
    if(btnAction=="Insert"){
      formdata.append("action","addAccount");
    }else{
        formdata.append("action","UpdateData");
    }
 
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/account.php",
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
              console.log(response)
            }

        },error:function(data){
            desplaymessage("error",data.responseText);
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
                 html+="<option>Please Select Branch</option>";
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

function AccountNumber(){
   
    let sendingData = {
        "action":"genereteAccount_no",
        
    }
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/account.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
           
            if(status){
             $("#account_no").val(response);
            
            }else{
              desplaymessage("error", response);
            }
        },error:function(data){
            console.log(data.responseText);
        }
    })

}

function ReadData(){
  $(".accountTable tbody").html("");
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
                response.forEach(function(res){
                    html+="<tr>";
                    for(let r in res){
                    
                        if(r=="image"){
                         html+=`<td><img src='../uploads/account/image/${res[r]}' style='width:50px;height:50px;border-radius:50%;object-fit:cover;margin-left:30px' ></td>`
                        
                        }else{
                            html+=`<td>${res[r]}</td>`;
                        }

                    
                      
                    }
                    html+=`<td>
                  
                    </td>`;
                    html+="</tr>";
                })
                $(".accountTable tbody").append(html);
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
        url:"../api/employee.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                btnAction="Update";
                $("#first").val(response['First']);
                $("#last").val(response['Last']);
                $("#phone").val(response['contect']);
                $("#Email").val(response['email']);
                $("#address").val(response['address']);
                $("#title").val(response['title']);
                $("#document").val(response['docoment']);
                $("#issue_date").val(response['issu_date']);
                $("#expier_date").val(response['expire_date']);
                $("#branch_id").val(response['branch_id']);
                $("#showImage").attr('src',`../uploads/images/${response['image']}`)
                $("#showCv").attr('src',`../uploads/cv/${response['cv']}`)
             $("#employeeModal").modal("show");

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
            url:"../api/account.php",
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
            $("#accountForm")[0].reset();
            $("#accountModal").modal("hide");
        //     $("#showSign").attr('src')="";
        //     $("#showDocument").attr("src")="";
        //    $("#showImage").src="";

       
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}


function ViewEmployee(id){
  
      let sendingData = {
        "id": id,
          "action":"ReadAllAccounts",
          
      }
      $.ajax({
          method:"POST",
          dataType:"JSON",
          url:"../api/account.php",
          data:sendingData,
          success:function(data){
              let status = data.status;
              let response = data.data; 
               
              if(status){
              
                $("#account_num").html(response['account_no']);
                $("#names").html(response['name']);
                $("#types").html(response['type']);
                $("#sexs").html(response['sex']);
                $("#phones").html(response['phone']);
                $("#emails").html(response['email']);
                $("#addresss").html(response['address']);
                $("#document_nos").html(response['document_no']);
               
                $("#issue_date").html(response['issue_date']);
                $("#expire_date").html(response['expire_date']);
                $("#branch_ids").html(response['branch_name']);
                $("#next_of_kind_names").html(response['next_of_kind_name']);
                $("#next_of_kind_numbers").html(response['next_of_kind_number']);
                $("#relationships").html(response['relationship']);
                // $("#user_id").html(response['user_id']);

                $("#document_imgs").attr('src',`../uploads/account/document/${response['document_img']}`)
                $("#showImage1").attr('src',`../uploads/account/image/${response['image']}`)
                $("#showSigns").attr('src',`../uploads/account/sign/${response['signature_img']}`)
                // $("#date").html(response['date']);
                console.log(response)
               
                $("#ViewModal").modal("show");
                 
              }else{
                  console.log(response);
              }
          },error:function(data){
              console.log(data.responseText);
          }
      })
  
  }


$("#print_employee").on("click",function(){
    print_employee();
})

function  print_employee(){
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


$(".accountTable tbody").on("click","a.delete_info", function(){
    let id=$(this).attr("delete_id");
    if(confirm("Are you sure you want to delete")){
        DeleteData(id);
        
    }

})
$(".accountTable tbody").on("click","a.update_info", function(){
    let id=$(this).attr("update_id");
    FeachData(id);

})
$(".accountTable tbody").on("click","a.see_info", function(){
    let id=$(this).attr("see_id");
    ViewEmployee(id);
    

})