<?php

include("../config/conn.php");


function ReadData($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="CALL searchAccount('$phone')";
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



  





if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}

?>