<?php
session_start();
include("../config/conn.php");

function AddTallerNo($conn){
    $data=array();
    extract($_POST);
    $query="CALL create_taller_sp('$tallerNo','$taller_id','$taller_user','$_SESSION[id]')";    
    $result=$conn->query($query);
    if($result){
       $row=$result->fetch_assoc();
       if(isset($row['msg'])){
        if($row['msg']=="deny"){
            $data=array("status"=>false,"data"=>"This Taller Allready Exsists");
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
    $query="SELECT * FROM `taller` WHERE 1";
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
    $query="DELETE FROM taller  WHERE id='$id'";
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
    $query="SELECT * FROM taller  WHERE id='$id'";
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
    

    $query="UPDATE `taller` SET taller_name='$taller_id',taller_user='$taller_user'  WHERE id='$id'";
    $result=$conn->query($query);
    if($result){
        
        $data=array("status"=>true,"data"=>"Successfully Updated");
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);

} 
function GenereteTallerNo($conn){
    $new_taller='';
    $data=array();
    $query="SELECT * FROM `taller` ORDER BY id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $num_rows=$result->num_rows;
        if($num_rows>0){
            $row=$result->fetch_assoc();
            $new_taller= ++$row['taller_no'];
           
        }else{
            $new_taller="Taller0001";
        }
        $data=array("status"=>true,"data"=>$new_taller);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
      echo json_encode($data);
      return $new_taller;

    
}







if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}



?>