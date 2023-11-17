<?php

include("../config/conn.php");

function account_to_account_register($conn){
    $data=array();
    extract($_POST);
    $query=" CALL account_to_account_register('$amount','$debit','$credit','$write_amount','$person',
    '$description','$branch_id','$user_id')";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        if(isset($row['msg'])){
             if($row['msg']=='invalid'){
                $data=array("status"=>false,"data"=>$debit." Is invalid  Account Number ");
            }else if($row['msg']=='deny'){
                $data=array("status"=>false,"data"=>"Insaficence Blance");
            }else if($row['msg']=='same'){
                $data=array("status"=>false,"data"=>"Account Number Must be Different ");
            }else if($row['msg']=="amount"){
                $data=array("status"=>false,"data"=>"Amount Must be greater than Zero");
            }
            else{
                $data=array("status"=>true,"data"=>"Money Is Transfered Successfully");
            }
        }
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}
function ReadAccountInfo($conn){
    $data=array();
    extract($_POST);
    $query="CALL WithdrowAccountInfo('$account_id')";
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

function PrintTransaction($conn){
    $data=array();
    $query="SELECT a.id debit_id ,a.amout ,ac.account_no debit_ac,ac.name debit_name,date(a.date)date, a.write_amount,
    a.id credit_id,a.credit_account,acc.account_no credit_ac,acc.name credit_name,a.description,b.name branch_name
    FROM account_to_account a LEFT JOIN account ac ON a.debit_amount=ac.account_no LEFT JOIN account acc ON a.credit_account=acc.account_no LEFT JOIN branch b ON a.branch_id=b.id  ORDER BY a.id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

}
function PrintOneTransaction($conn){
    $data=array();
    $query="SELECT a.id debit_id ,a.amout ,ac.account_no debit_ac,ac.name debit_name,a.date, a.write_amount,
    a.id credit_id,a.credit_account,acc.account_no credit_ac,acc.name credit_name,a.description,b.name branch_name,u.username
    FROM account_to_account a LEFT JOIN account ac ON a.debit_amount=ac.account_no LEFT JOIN account acc ON a.credit_account=acc.account_no LEFT JOIN branch b ON a.branch_id=b.id LEFT JOIN users u on a.user_id=u.id
      ORDER BY a.id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

}
function TransferReport($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="CALL transfer_report_p('$account_no','$branch_id','$user_id','$from','$to')";
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
function getToAccount($conn){
    
    $data=array();
    extract($_POST);
    $query="SELECT a.account_no,a.name  FROM account a WHERE a.account_no='$account_no'";
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