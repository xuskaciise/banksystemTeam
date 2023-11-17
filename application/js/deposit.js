$(document).ready(function() {
    $('#num').focus();
    $('#demo').num2words();
 });
// ReadData();
// ReadAccount();
// ReadBranch();




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

$("#depositForm").on("submit", function(e){
    e.preventDefault();

    let sendingData=new FormData($("#depositForm")[0]);
    sendingData.append("action","DepositAmount");
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/deposit.php",
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

$("#ReportForm").on("submit", function(e){
    e.preventDefault();

    let sendingData=new FormData($("#ReportForm")[0]);
    sendingData.append("action","DepositReport");
    $(".branchTable tbody").html("");
    $.ajax({
        method:"POST",
        dataType:"JSON",
        url:"../api/deposit.php",
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
                  
                    html+="</tr>";
                })
                $(".branchTable tbody").append(html);
                $("#dataTable").dataTable();

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
        url:"../api/deposit.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
             
             $("#accountNo").val(response['account_no']);   
             $("#name").val(response['name']);    
             $("#branch_id").val(response['branch_id']);   
             $("#image").attr('src',`../uploads/account/image/${response['image']}`)
             $("#signuture").attr('src',`../uploads/account/sign/${response['signature_img']}`) 
             $("#deposit_info").modal("show");

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
        url:"../api/deposit.php",
        data:sendingData,
        success:function(data){
            let status = data.status;
            let response = data.data; 
            
            if(status){
                console.log(response)
                
                $("#branch").html(": "+response['name']);   
                $("#invoice").html(": "+response['id']);    
                $("#dates").html(": "+response['date']);    
                $("#ac_no").html(": "+response['accout_id']);     
                $("#type").html(": "+response['type']);     
                $("#names").html(": "+response['username']);   
                $("#amounts").html(": "+response['amount']);   
                $("#deposited_by").html(": "+response['transacted_person']);   
                $("#reportModal").modal("show");
           
               

            }else{
               console.log(response)
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
            $("#depositForm")[0].reset();
            $("#deposit_info").modal("hide");
            success.classList="alert alert-success d-none";
            
        }, 3000);
    }else{
        error.classList="alert alert-danger"
        error.innerHTML=messege;
    }
}


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