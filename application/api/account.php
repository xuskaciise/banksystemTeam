<?php
session_start();
include("../config/conn.php");

function addAccount($conn){
    $data=array();
    $error_array =array();
    $new_id=generete_id($conn);
    $save_image_name='';
    $save_document_name='';
    $save_sign_name='';
    extract($_POST);
     
    if(isset($_FILES['image'])){
        
        $file_name=$_FILES['image']['name'];
        $file_tmp=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_size=$_FILES['image']['size'];
        $allowed_images=['image/jpg','image/jpeg','image/png'];
        $max_size=1*1024*1024;
    
        $save_image_name=$new_id.".png";
       
    
        if(in_array($file_type,$allowed_images)){
            if($file_size>$max_size){
                $error_array[]="Image file Size must be less then".$max_size;
    
            }
    
        }else{
            $error_array[]="Image File Is Not Allowed".$file_type;
        }   
    }
     if(isset($_FILES['document_img'])){
        
        $file_document_name=$_FILES['document_img']['name'];
        $file_document_tmp=$_FILES['document_img']['tmp_name'];
        $file_document_type=$_FILES['document_img']['type'];
        $file_document_size=$_FILES['document_img']['size'];
        $allowed_document_images=['image/jpg','image/jpeg','image/png'];
        $max_document_size=1*1024*1024;
    
        $save_document_name=$new_id.".png";
       
    
        if(in_array($file_document_type,$allowed_document_images)){
            if($file_document_size>$max_document_size){
                $error_array[]=" Document file Size must be less then".$max_document_size."  ";
    
            }
    
        }else{
            $error_array[]="Document  File Is Not Allowed".$file_document_type;
        }   
    }
        if(isset($_FILES['sign'])){
        
            $file_sign_name=$_FILES['sign']['name'];
            $file_sign_tmp=$_FILES['sign']['tmp_name'];
            $file_sign_type=$_FILES['sign']['type'];
            $file_sign_size=$_FILES['sign']['size'];
            $allowed_sign_images=['image/jpg','image/jpeg','image/png'];
            $max_sign_size=1*1024*1024;
        
            $save_sign_name=$new_id.".png";
           
        
            if(in_array($file_sign_type,$allowed_sign_images)){
                if($file_sign_size>$max_sign_size){
                    $error_array[]=" Signature file Size must be less then".$max_sign_size."  ";
        
                }
        
            }else{
                $error_array[]="Signature  File Is Not Allowed" .$file_sign_type;
            }    
    
    

    }
    
 
    if(count($error_array)<=0){
        $query="CALL create_account_sp('$account_no','$name','$type','$sex','$phone','$email','$address','$document_no',
        '$save_document_name','$issue_date','$expire_date','$save_image_name','$save_sign_name','$branch','$next_of_kind_name',
        '$next_of_kind_number','$relationship','$user_id')";

        $result=$conn->query($query);

        if($result){
            while($row=$result->fetch_assoc()){
                if(isset($row['msg'])){
                 if($row['msg']=="deny"){
                     $data=array("status"=>false,"data"=>$phone." Is Allready Exsists");
                 }else{
                    move_uploaded_file($file_tmp,"../uploads/account/image/".$save_image_name);
                    move_uploaded_file($file_document_tmp,"../uploads/account/document/".$save_document_name);
                    move_uploaded_file($file_sign_tmp,"../uploads/account/sign/".$save_sign_name);
                     $data=array("status"=>true,"data"=>"successFull Registered");
                 }
                }
            }
        }
    else{
        $data=array("status"=>false,"data"=>$conn->error);
    }

     
}else{
    $data=array("status"=>false,"data"=>$error_array);
}
  echo json_encode($data);
}
function ReadData($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT `account_id`, `account_no`, `name`, `type`, `sex`, `phone`, `email`, `image`,  `user_id` FROM `account` WHERE 1";
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

function ReadAllAccounts($conn){
    $data=array();
    extract($_POST);
    $query="SELECT  a.`account_id`, a.`account_no`, a.`name`, a.`type`, a.`sex`,a. `phone`,a. `email`, a.`address`, a.`document_no`,a. `document_img`,a. `issue_date`, a.`expire_date`,a. `image`,a. `signature_img`, a.`branch_id`, a.`next_of_kind_name`, a.`next_of_kind_number`, a.`relationship`,
     a.`user_id`, a.`date`,b.name branch_name FROM `account`  a LEFT JOIN branch b ON a.branch_id=b.id WHERE  account_id='$id'";
    $result=$conn->query($query);
    if($result){
       $row=$result->fetch_assoc();

        $data=array("status"=>true,"data"=>$row);
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data); 
}

function DeleteData($conn){
    $data=array();
  
    extract($_POST);
    $query="DELETE FROM account WHERE account_id='$id'";
    $result=$conn->query($query);
    if($result){
        $data=array("status"=>true,"data"=>"Delted Successfully");
    }else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
    echo json_encode($data);
}

        
    function FetchData($conn){
        $data=array();
  
        extract($_POST);
        $query="SELECT * FROM employee WHERE id='$id'";
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
        $query="UPDATE `employee` SET `name`='$name',`address`='$address',`maneger`='$maneger',`contect`='$phone',`limit_amount`='$limit_amount' WHERE id='$id'";
        $result=$conn->query($query);
        if($result){
           
            $data=array("status"=>true,"data"=>"Successfully Updated");
        }else{
            $data=array("status"=>false,"data"=>$conn->error);
        }
        echo json_encode($data);
    
    } 

    function generete_id($conn){
        $new_id='';
        $data=array();
        $query="SELECT * FROM account ORDER BY account_id DESC LIMIT 1";
        $result=$conn->query($query);
        if($result){
            $num_rows=$result->num_rows;
            if($num_rows>0){
                $row=$result->fetch_assoc();
                
                $new_id= ++$row['account_no'];
               
            }else{
                $new_id="SAL0001";
            }
            $data=array("status"=>true,"data"=>$new_id);
        }else{
            $data=array("status"=>false,"data"=>$conn->error);
        }
          return $new_id;
        
       
        
    }
    function genereteAccount_no($conn){
        $new_id='';
        $data=array();
        $query="SELECT * FROM account ORDER BY account.account_id DESC LIMIT 1";
        $result=$conn->query($query);
        if($result){
            $num_rows=$result->num_rows;
            if($num_rows>0){
                $row=$result->fetch_assoc();
               $new_id= ++$row['account_no'];

               
            }else{
                $new_id="SAL0001";
            }
            $data=array("status"=>true,"data"=>$new_id);
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