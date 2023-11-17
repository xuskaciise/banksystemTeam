<?php
session_start();
include("../config/conn.php");

function AddChequeNo($conn){
    $data=array();
    extract($_POST);
    $query="CALL create_chequeNo_sp('$chequeNo','$accountNo','$_SESSION[id]')";
    $result=$conn->query($query);
    if($result){
       $row=$result->fetch_assoc();
       if(isset($row['msg'])){
        if($row['msg']=="deny"){
            $data=array("status"=>false,"data"=>"Allready Exsists");
        }else{
            $data=array("status"=>true,"data"=>"successFull Registered");
        }
       }
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}
function ReadChequeNo($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT * FROM `chequeno` WHERE 1";
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

function DeleteData($conn){
    $data=array();
  
    extract($_POST);
    $query="DELETE FROM chequeno  WHERE id='$id'";
    $result=$conn->query($query);
    if($result){
        $data=array("status"=>true,"data"=>"Deleted Successfully");
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}


        
function FetchData($conn){
    $data=array();

    extract($_POST);
    $query="SELECT * FROM chequeno  WHERE id='$id'";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

}

function UpdateData($conn){
    $data=array();
    extract($_POST);
    

    $query="UPDATE `chequeno` SET account_no='$accountNo' WHERE id='$id'";
    $result=$conn->query($query);
    if($result){
        
        $data=array("status"=>true,"data"=>"Successfully Updated");
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

} 

function GenereteChequeNo($conn){
    $new_chequeNo='';
    $data=array();
    $query="SELECT * FROM `chequeno` ORDER BY id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $num_rows=$result->num_rows;
        if($num_rows>0){
            $row=$result->fetch_assoc();
            $new_chequeNo= ++$row['chequeNo'];
           
        }else{
            $new_chequeNo="CH000001";
        }
        $data=array("status"=>true,"data"=>$new_chequeNo);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
      echo json_encode($data);
      return $new_chequeNo;

    
}








if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}



?>