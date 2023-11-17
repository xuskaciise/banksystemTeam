
$("#loginForm").on("submit", function(e){
    e.preventDefault();
    let formData=new FormData($("#loginForm")[0]);
    formData.append("action","login");
   
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"application/api/login.php",
        data:formData,
        processData:false,
        contentType:false,
        success:function(data){
            let status=data.status;
            let response=data.data;
            if(status){
                desplaymessage("success",response); 
                setTimeout(function(){
                    window.location="application/views/index.php";

                },1000)
         
                
            
            

            }else{
                desplaymessage("error",response);
            }
        },error:function(data){
            desplaymessage("error",data.responseText);
        }
    })

})

function desplaymessage(alert,messege){
    let success=document.querySelector(".alert-success");
    let error=document.querySelector(".alert-danger");
    if(alert=="success"){
        success.classList="alert alert-success";
        success.innerHTML=messege;
        error.classList="alert alert-danger d-none";
        setTimeout(() => {
            success.classList="alert alert-success d-none"; 
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
        $("#password").val("");
    }
}