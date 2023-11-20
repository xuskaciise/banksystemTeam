ReadTransaction();
function ReadTransaction(){
    $(".StockTransaction tbody").html("");
      let sendingData = {
          "action":"ReadTransaction",
          
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
                      <a class='btn btn-info  back_info' ><i class="fas fa-arrow-left">Back</i></a>
                      </td>`;
                      html+="</tr>";
                  })
                  $(".StockTransaction tbody").append(html);
                  $("#dataTable").dataTable();
                 
              }else{
                  console.log(response);
              }
          },error:function(data){
              console.log(data.responseText);
          }
      })
  
  }
  $(".StockTransaction tbody").on("click","a.back_info", function(){
    window.location="../views/stock.php"
    
 })