<?php
session_start();
include("../config/conn.php");


function Login($conn){
    $data=array();
    extract($_POST);
    $query="CALL login('$username','$password')";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        if(isset($row['msg'])){
            if($row['msg']=='deny'){
                $data=array("status"=>false,"data"=>"Invalid Username or Password");
            }else{
                $data=array("status"=>false,"data"=>"This User is locked Contect Admin");
            }
        }else{
            foreach ($row as $key => $value) {
               $_SESSION[$key]=$value;
               
            }
            $data=array("status"=>true,"data"=>"Login SuccessFully");
        }
        
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