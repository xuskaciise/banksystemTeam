<?php

include("../config/conn.php");


function ReadData($conn){
    $data=array();
    extract($_POST);
    // $phone=mysql_real_escape_string($_POST['phone']);

    $query="CALL searchAccount('$phone')";
    $result=$conn->query($query);
    if($result){
        while($row=$result->fetch_assoc()){
            if(isset($row['msg'])){
                if($row['msg']=="deny"){
                    $data=array("status"=>false,"data"=>$phone." Not Exsists");                    
                }
               }else{
                $data=array("status"=>true,"data"=>$row);
               }
             
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