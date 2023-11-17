<?php

include("../config/conn.php");

function DepositAmount($conn){
    $data=array();
    extract($_POST);
    $query="INSERT INTO `deposit`( `accout_id`, `amount`, `write_amount`, `transacted_person`, `branch_id`, `userid`)
      VALUES('$accountNo','$amount','$write_amount','$person','$branch_id','$user_id')";
    $result=$conn->query($query);
    if($result){
        $data=array("status"=>true,"data"=>"Amount Deposied Successfully");
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}
function ReadAccountInfo($conn){
    $data=array();
    extract($_POST);
    $query="CALL getAccountInformation('$account_id')";
    $result=$conn->query($query);
    if($result){
      $row=$result->fetch_assoc();
      if(isset($row['msg'])){
        if($row['msg']=='invalid'){
            $data=array("status"=>false,"data"=>"Invalid Account Number ");
          }else if($row['msg']=='expire'){
            $data=array("status"=>false,"data"=>"This Account is Expired");
          }
      }
     else{
        $data=array("status"=>true,"data"=>$row);
      }
      
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}


function DepositReport($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="CALL deposit_report_p('$account_no','$branch_id','$user_id','$from','$to')";
    $result=$conn->query($query);
    if($result){
        while( $row=$result->fetch_assoc()){
         $data_array[]=$row;
        }
        $data=array("status"=>true,"data"=>$data_array);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}

function PrintTransaction($conn){
    $data=array();
    $query="SELECT d.`id`, d.`accout_id`, d.`amount`, d.`write_amount`, d.`transacted_person`,b.name ,u.username, date(d.`date`) date,a.type 
    FROM deposit d LEFT JOIN branch b on d.branch_id=b.id LEFT JOIN users u on d.userid=u.id LEFT JOIN account a ON d.accout_id=a.account_id 
     ORDER BY d.id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

}
        
  
function PrintOneTransactin($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT d.`id`, d.`accout_id`, d.`amount`, d.`write_amount`, d.`transacted_person`,b.name ,u.username, date(d.`date`) date,a.type ,a.name account_name
    FROM deposit d LEFT JOIN branch b on d.branch_id=b.id LEFT JOIN users u on d.userid=u.id LEFT JOIN account a ON d.accout_id=a.account_id 
    WHERE d.id='$id'";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}
    





if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}

?>