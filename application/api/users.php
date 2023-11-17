<?php
session_start();

include("../config/conn.php");

function Addusers($conn){
    $data=array();
    $error_array =array();
    $new_id=generete_id($conn);
    $save_name='';
    extract($_POST);
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
            $error_array[]="Image File Is Not Allowed";
        }   
    
    if(count($error_array)<=0){
        $query="CALL users('$new_id','$username','$password','$save_name','$type','$status','$_SESSION[username]')";

        $result=$conn->query($query);

        if($result){
            $row=$result->fetch_assoc();
            if(isset($row['msg'])){
                if($row['msg']=='exsist'){
                    $data=array("status"=>false,"data"=>"Username Already Exists");
            }else{
                move_uploaded_file($file_tmp,"../uploads/users/".$save_name);
                $data=array("status"=>true,"data"=>"saved Successfully");
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
function UpdateUser($conn){
    $data=array();
    $error_array =array();
    $save_name='';
    extract($_POST);
    if(!empty($_FILES['image']['name'])){
        $file_name=$_FILES['image']['name'];
        $file_tmp=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_size=$_FILES['image']['size'];
        $allowed_images=['image/jpg','image/jpeg','image/png'];
        $max_size=3*1024*1024;
    
        $save_name=$update_id.".png";
       
    
        if(in_array($file_type,$allowed_images)){
            if($file_size>$max_size){
                $error_array[]="file Size must be less then".$max_size;
    
            }
    
        }else{
            $error_array[]="Image File Is Not Allowed";
        }   
    
    if(count($error_array)<=0){
        $query="UPDATE `users` SET `username`='$username',`password`='$password',`type`='$type',`status`='$status' WHERE id='$update_id'";

        $result=$conn->query($query);

        if($result){
          move_uploaded_file($file_tmp,"../uploads/users/".$save_name);
         $data=array("status"=>true,"data"=>"Updated Successfully");
        }
    else{
        $data=array("status"=>false,"data"=>$conn->error);
    }
     
}else{
    $data=array("status"=>false,"data"=>$error_array);
}
    }else{
        $query="UPDATE `users` SET `username`='$username',`password`='$password',`type`='$type',`status`='$status' WHERE id='$update_id'";

       $result=$conn->query($query);

       if($result){
        $data=array("status"=>true,"data"=>"Updated Successfully");
       }
   else{
       $data=array("status"=>false,"data"=>$conn->error);
   } 
    }
       
  echo json_encode($data);
}

function ReadData($conn){
    $data=array();
    $data_array=array();
    extract($_POST);
    $query="SELECT `id`, `username`, `image`,`type`,`status`, `user_id`, `date` FROM `users` WHERE 1";
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

function ReadAlluserss($conn){
    $data=array();
    extract($_POST);
    $query="SELECT `id`, `First`, `Last`, `contect`, `email`, `image`, `cv`, `address`, `title`, `docoment`, `issu_date`, `expire_date`,
     `branch_id`, `user_id`, date(date) as date FROM `users` WHERE id='$id'";
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
    $query="DELETE FROM users WHERE id='$id'";
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
        $query="SELECT `id`, `username`,`password`, `image`,`type`,status ,`user_id`, `date` FROM `users` WHERE  id='$id'";
        $result=$conn->query($query);
        if($result){
            $row=$result->fetch_assoc();
            $data=array("status"=>true,"data"=>$row);
        }else{
            $data=array("status"=>false,"data"=>$conn->error);
        }
        echo json_encode($data);
    
    }

 

    function generete_id($conn){
        $new_id='';
        $data=array();
        $query="SELECT * FROM users ORDER BY users.id DESC LIMIT 1";
        $result=$conn->query($query);
        if($result){
            $num_rows=$result->num_rows;
            if($num_rows>0){
                $row=$result->fetch_assoc();
                $new_id= ++$row['id'];
               
            }else{
                $new_id="USER001";
            }
            $data=array("status"=>true,"data"=>$new_id);
        }else{
            $data=array("status"=>false,"data"=>$conn->error);
        }
   
        // 
       return $new_id;
        
    }
    





if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}else{
    echo json_encode(array("status"=>false,"data"=>"Action Is Required"));
}

?>