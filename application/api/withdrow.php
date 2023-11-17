<?php

include("../config/conn.php");

function WithdrowAmount($conn){
    $data=array();
    extract($_POST);
    $query=" CALL withdrow_register('$amount','$account_no','$write_amount','$withdrow_person',
    '$description','$check_no','$branch_id','$user_id')";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        if(isset($row['msg'])){
            if($row['msg']=='deny'){
                $data=array("status"=>false,"data"=>"Blance is Efficintly");
            }else if($row['msg']=="amount"){
                $data=array("status"=>false,"data"=>"Amount Must be greater than Zero");
            }
            else{
                $data=array("status"=>true,"data"=>"Amount Withdrow Successfully");
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
    $query="SELECT w.`id`, w. `amout`,  w.`account_id`, w. `write_amount`,  w.`withdrow_persson`,  w.`description`,  w.`check_no`,  b.name as branch, w. `user_id`,a.name,u.username,  date( w.`date`) date,a.type 
    FROM withdrow w LEFT JOIN branch b on w.branch_id=b.id LEFT JOIN users u on w.user_id=u.id LEFT JOIN account a ON w.account_id=a.account_id 
     ORDER BY w.id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

}


function WithdrowReport($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="CALL withdrow_report_p('$account_no','$branch_id','$user_id','$from','$to')";
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
function PrintOneTransactin($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT w.`id`, w. `amout`,  w.`account_id`, w. `write_amount`,  w.`withdrow_persson`,  w.`description`,  w.`check_no`,  b.name as branch, w. `user_id`,a.name,u.username,  date( w.`date`) date,a.type 
    FROM withdrow w LEFT JOIN branch b on w.branch_id=b.id LEFT JOIN users u on w.user_id=u.id LEFT JOIN account a ON w.account_id=a.account_id 
    WHERE w.id='$id'";
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