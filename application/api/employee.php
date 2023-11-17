<?php

include("../config/conn.php");

function Addemployee($conn){
    $data=array();
    $error_array =array();
    $new_id=generete_id($conn);
    $save_name='';
    $save_cv_name='';
    extract($_POST);
     
    if(isset($_FILES['image'])){
        
        $file_name=$_FILES['image']['name'];
        $file_tmp=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_size=$_FILES['image']['size'];
        $allowed_images=['image/jpg','image/jpeg','image/png'];
        $max_size=3*1024*1024;
    
        $save_name=$new_id.".png";
       
    
        if(in_array($file_type,$allowed_images)){
            if($file_size>$max_size){
                $error_array[]="file Size must be less then".$max_size;
    
            }
    
        }else{
            $error_array[]="Image File Is Not Allowed".$file_type;
        }   
    }
    if(isset($_FILES['cv'])){
        
        $file_cv_name=$_FILES['cv']['name'];
        $file_cv_tmp=$_FILES['cv']['tmp_name'];
        $file_cv_type=$_FILES['cv']['type'];
        $file_cv_size=$_FILES['cv']['size'];
        $allowed_cv_images=['image/jpg','image/jpeg','image/png'];
        $max_cv_size=3*1024*1024;
    
        $save_cv_name=$new_id.".png";
       
    
        if(in_array($file_cv_type,$allowed_cv_images)){
            if($file_cv_size>$max_cv_size){
                $error_array[]=" cv file Size must be less then".$max_cv_size."  ";
    
            }
    
        }else{
            $error_array[]="Cv  File Is Not Allowed".$file_cv_type;
        }   
    }
    
 
    if(count($error_array)<=0){
        $query="INSERT INTO `employee`(`id`, `First`, `Last`, `contect`, `email`, `image`, `cv`, `address`, `title`,
         `docoment`, `issu_date`, `expire_date`,  `user_id`)VALUES
        ('$new_id','$first','$last','$phone','$email','$save_name','$save_cv_name','$address',
        '$title','$document','$issue_date','$expier_date','$user_id')";

        $result=$conn->query($query);

        if($result){
          move_uploaded_file($file_tmp,"../uploads/employee/images/".$save_name);
          move_uploaded_file($file_cv_tmp,"../uploads/employee/cv/".$save_cv_name);
         $data=array("status"=>true,"data"=>"saved Successfully");
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
    $query="SELECT `id`, `First`, `Last`, `contect`, `email`, `image` FROM `employee` WHERE 1";
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

function ReadAllEmployees($conn){
    $data=array();
    extract($_POST);
    $query="SELECT `id`, `First`, `Last`, `contect`, `email`, `image`, `cv`, `address`, `title`, `docoment`, `issu_date`, `expire_date`,
     `branch_id`, `user_id`, date(date) as date FROM `employee` WHERE id='$id'";
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
    $query="DELETE FROM employee WHERE id='$id'";
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
        $query="
        UPDATE `employee` SET `First`='',`Last`='',`contect`='',`email`=''
        ,`image`='',`cv`='',`address`='',`title`='',
        `docoment`='',`issu_date`='',`expire_date`='',`branch_id`=''
        
        ";
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
        $query="SELECT * FROM employee ORDER BY id DESC LIMIT 1";
        $result=$conn->query($query);
        if($result){
            $num_rows=$result->num_rows;
            if($num_rows>0){
                $row=$result->fetch_assoc();
                $new_id= ++$row['id'];
               
            }else{
                $new_id="Empl001";
            }
            $data=array("status"=>true,"data"=>$new_id);
        }else{
            $data=array("status"=>false,"data"=>$conn->error);
        }
   
        return $new_id;
        
    }
    





if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}

?>