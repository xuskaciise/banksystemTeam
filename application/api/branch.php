<?php

include("../config/conn.php");

function AddBranch($conn){
    $data=array();
    extract($_POST);
    $query="CALL branch_sp('$name','$address','$maneger','$limit_amount','$user_id')";
    $result=$conn->query($query);
    if($result){
       $row=$result->fetch_assoc();
       if(isset($row['messege'])){
        if($row['messege']=="deny"){
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
function ReadData($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT `id`, `name`, `address`, `manager`, `limit_amount` FROM `branch` WHERE 1";
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
    $query="DELETE FROM branch WHERE id='$id'";
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
        $query="SELECT * FROM branch WHERE id='$id'";
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
     

        $query="UPDATE `branch` SET `name`='$name',`address`='$address',`manager`='$maneger',`limit_amount`='$limit_amount' WHERE id='$id'";
        $result=$conn->query($query);
        if($result){
           
            $data=array("status"=>true,"data"=>"Successfully Updated");
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