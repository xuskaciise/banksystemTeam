$(document).ready(function() {
    $('#num').focus();
    $('#demo').num2words();
 });
 let btnAction="Insert";
stockNumber();
ReadData();
ReadManager();
ReadManagerUser()
ReadTaller();


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
$("#stock_depositForm").on("submit", function(event){
    event.preventDefault();
    formdata=new FormData($("#stock_depositForm")[0]);
     formdata.append("action","SendToTaller");
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/stock.php",
        data:formdata,
        contentType:false,
        processData:false,
        success:function(data){
            let status = data.status;
            let response = data.data;
            if(status){
                
                Servicealert("info",response);
            }else{
                Servicealert("warning",response);
           
            }

        },error:function(data){
            Servicealert("warning",data.responseText);
          
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
                    <a class='btn btn-success  update_info' update_id=${res['id']}><i class='fas fa-edit' style='color:#fff;'> Edit</i></a>
                    <a class='btn btn-info  send_info' send_id=${res['stock_no']}><i class="fas fa-paper-plane" style='color:#fff;'> Send</i></a>
                    <a class='btn btn-info  show_info' ><i class="fas fa-eye" style='color:#fff;'> Show</i></a>
                   
                   
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
function ReadTaller(){
   
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
               html+="<option>Please Select Taller</option>";
                response.forEach(function(res){
                    html+=`<option value="${res['taller_no']}">${res['taller_no']}</option>`;
               
                })
                $("#taller_no").append(html);
                
               
            }else{
                console.log(response);
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
function Servicealert(type,messege){
    let success=document.querySelector(".alert-info");
    let danger =document.querySelector(".alert-warning");
    if(type=="info"){
        success.classList="alert alert-info  ";
        success.innerHTML=messege;
        danger.classList="alert alert-warning  d-none";
        setTimeout(function(){
            $("#stock_depositForm")[0].reset()
            $("#Stack_deposit").modal("hide");
            success.classList="alert alert-info  d-none"

        },2000)
    }else{
        danger.classList="alert alert-warning  ";
        danger.innerHTML=messege;

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
$(".stockTable tbody").on("click","a.send_info", function(){
    let id=$(this).attr("send_id");
    $("#stock_no").val(id);
    $("#Stack_deposit").modal("show");
})
$(".stockTable tbody").on("click","a.show_info", function(){
   window.location="../views/stock_transaction_list.php"
   
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
(function($){
    $.fn.extend({ 
       num2words: function(options) {
         
             var defaults = {
                units: [ "", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten" ],
                teens: [ "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen","Sixteen", "Seventeen", "Eighteen", "Nineteen", "Twenty" ],
                tens: [ "", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty","Seventy", "Eighty", "Ninety" ],
                othersIntl: [ "Thousand", "Million", "Billion", "Trillion" ]
             };
                 
             var options = $.extend(defaults, options);
 
             function NumberToWords() {
                 var o = options;
                 
                 var units = o.units;
                 var teens = o.teens;
                 var tens = o.tens;
                 var othersIntl = o.othersIntl;
           
                 var getBelowHundred = function(n) {
                     if (n >= 100) {
                         return "greater than or equal to 100";
                     };
                     if (n <= 10) {
                         return units[n];
                     };
                     if (n <= 20) {
                         return teens[n - 10 - 1];
                     };
                     var unit = Math.floor(n % 10);
                     n /= 10;
                     var ten = Math.floor(n % 10);
                     var tenWord = (ten > 0 ? (tens[ten] + " ") : '');
                     var unitWord = (unit > 0 ? units[unit] : '');
                     return tenWord + unitWord;
                 };
           
                 var getBelowThousand = function(n) {
                     if (n >= 1000) {
                         return "greater than or equal to 1000";
                     };
                     var word = getBelowHundred(Math.floor(n % 100));
                     
                     n = Math.floor(n / 100);
                     var hun = Math.floor(n % 10);
                     word = (hun > 0 ? (units[hun] + " Hundred ") : '') + word;
                     
                     return word;
                 };
           
                 return {
                     numberToWords : function(n) {
                         if (isNaN(n)) {
                             return "Not a number";
                         };
                         
                         var word = '';
                         var val;
                         var word2 = '';
                         var val2;
                         var b = n.split(".");
                         n = b[0];
                         d = b[1];
                         d = String (d);
                         d = d.substr(0,2);
                         
                         val = Math.floor(n % 1000);
                         n = Math.floor(n / 1000);
                         
                         val2 = Math.floor(d % 1000);
                         d = Math.floor(d / 1000);
                         
                         word = getBelowThousand(val);
                         word2 = getBelowThousand(val2);
                         
                         othersArr = othersIntl;
                         divisor = 1000;
                         func = getBelowThousand;
             
                         var i = 0;
                         while (n > 0) {
                             if (i == othersArr.length - 1) {
                                 word = this.numberToWords(n) + " " + othersArr[i] + " " + word;
                                 break;
                             };
                             val = Math.floor(n % divisor);
                             n = Math.floor(n / divisor);
                             if (val != 0) {
                                 word = func(val) + " " + othersArr[i] + " " + word;
                             };
                             i++;
                         };
                         
                         var i = 0;
                         while (d > 0) {
                             if (i == othersArr.length - 1) {
                                 word2 = this.numberToWords(d) + " " + othersArr[i] + " " + word2;
                                 break;
                             };
                             val2 = Math.floor(d % divisor);
                             d = Math.floor(d / divisor);
                             if (val2 != 0) {
                                 word2 = func(val2) + " " + othersArr[i] + " " + word2;
                             };
                             i++;
                         };
                         if (word!='') word = word.toUpperCase() + ' DOLLARS';
                         if (word2!='') word2 = ' AND ' + word2.toUpperCase() + ' CENTS';
                         return word+word2;
 
                     }
                 }
             }
 
             return this.each(function(){
                 
                 var obj = $(this);
                 var input = $("#amount", obj);
                 // var button = $("input[type='button']", obj);
                 var div = $("#write_amount", obj);
                 
                 input.keyup(function(){
                     div.hide();
                     var inputval = input.val();
                     if (isNaN(inputval)){
                         div.html("This is not a number - " + inputval);
                         div.show("slow");
                         return;
                     };
                     var num2words = new NumberToWords();
                     var intl = num2words.numberToWords(inputval);
                     
                     div.val(intl);
                     div.show("slow");
                 });
                 button.trigger('change');
                 input.focus();
              
             });
       }
    });
 })(jQuery);