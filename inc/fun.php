<?php

class db{
 public function getAllRows($table)
{   
    global $con;
    // its sample it just  select all data from table var
    $sql = "SELECT * FROM $table";
}

public function find($table ,$id){
    global $con;
    $id = mysqli_escape_string($con,$id);
    //find any row from table by id
    $sql = "SELECT * FROM $table WHERE  id = $id";

    $query = mysqli_query($con,$sql);
    
    if($query){

        return mysqli_fetch_array($query);
    }
    else
    {
        return false;
    }
}

public function insert($table,$array){

    global $con;
    //check if $array is array
    if(is_array($array)){
        // get all arry keys
        $keys = array_keys($array);

        //get all arry values
        $values = array_values($array);

        //make arry keys in string from and , beten keys
       $tables = implode(',',$keys);

       // sname for values
       $dbvalues = implode("','",$values);

       // make sql query
        $sql = "INSERT INTO $table($tables)
        VALUES ('$dbvalues')";
        //ex the query
        $query = mysqli_query($con , $sql);
    }
    else
    {
        return false;
    }
}

function emptyy($name , $email , $password){

    if(empty($name)||empty($email)||empty($password)){

        return true;
    }
    else{
        return false;
    }
}

 public function update($table, $array)
{
 
    
}


public function new_images($file , $table , $name, $array=null){

    require_once "../connect.php";
        $image_name =  $file['image']['name'];
        $image_size = $file['image']['size'];
        $tmp_name = $file['image']['tmp_name'];
        $error = $file['image']['error'];
        if ($error === 0) {
            if ($image_size > 3000000) {
                $em = "sorry your file is to large";
                header("location:../../index.php?error=$em");
            }else{
                $image_ex = pathinfo($image_name , PATHINFO_EXTENSION);
                $image_ex_lc = strtolower($image_ex);
                $allowd_exs = array('png' , 'jpg' , 'jpeg');
                if (in_array($image_ex_lc , $allowd_exs)) {
                    $new_image_name = uniqid("IMG-" , true).'.'.$image_ex_lc;
                    $image_path = "../../uplaods/" . $new_image_name;
                    move_uploaded_file($tmp_name , $image_path );
    
                    if($array == null){
                        $insert = "INSERT INTO $table (img) VALUES ( '$new_image_name')";
                    }
                    else{
                        $tables = array_values($array);
                        $comm = implode("','" , $tables);
                        $keys = array_keys($array);
                        $comm_k = implode("," , $keys);
                        $insert = "INSERT INTO $table (img , $comm_k) VALUES ( '$new_image_name' , '$comm')";
                    }
    
                    mysqli_query($conn,$insert);
                    $em = "succes";
                    return header("location:../../$name.php?add=$em");
                }else{
                    $em = "you cant upload this file in this type";
                    return  header("location:../../index.php?error=$em");
                }
            }
        }else {
            $em = "unknown error occured!";
            header("location:../../index.php?error=$em");
        }
    
    }
    
}