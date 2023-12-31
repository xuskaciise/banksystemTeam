<?php
session_start();
include("../config/conn.php");

function AddStockNo($conn){
    $data=array();
    extract($_POST);
    $query="CALL create_stock_sp('$stockNo','$manger_id','$manager_user','$_SESSION[id]','$blance')";    
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
function ReadData($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT s.id,s.stock_no,e.First,s.manager_user,s.blance,date(s.date) date FROM stock s JOIN employee e 
    ON s.manager_id=e.id WHERE s.manager_user='$_SESSION[id]'";
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
function ReadTransaction($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT `id`, `stock_id` , `taller_id`, `amount`, `write_amount`, `type`, `date`FROM `stock_transaction` WHERE 1";
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

function GenereteStockNo($conn){
    $new_chequeNo='';
    $data=array();
    $query="SELECT * FROM `stock` ORDER BY id DESC LIMIT 1";
    $result=$conn->query($query);
    if($result){
        $num_rows=$result->num_rows;
        if($num_rows>0){
            $row=$result->fetch_assoc();
            $new_chequeNo= ++$row['stock_no'];
           
        }else{
            $new_chequeNo="Stock0001";
        }
        $data=array("status"=>true,"data"=>$new_chequeNo);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
      echo json_encode($data);
      return $new_chequeNo;

    
}



function SendToTaller($conn){
    $data=array();
    extract($_POST);
    $query="CALL send_to_taller_sp('$taller_no','$amount','$write_amount','Send','$user_id','$stock_no')";
    $result=$conn->query($query);
    if($result){
        $row=$result->fetch_assoc();
        if(isset($row['msg'])){
            if($row['msg']=="exsist"){
                $data=array("status"=>false,"data"=>"Exsist");
            }else{
                $data=array("status"=>true,"data"=>"You transferred "."$".$amount." To  ".$taller_no);
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