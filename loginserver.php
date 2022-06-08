<?php 
session_start();
include("connect.php");
$error= array();
$pos = '' ;
if(isset($_POST['login']))
{
    //something was posted
    $user_name = $_POST['username'];
    $_SESSION['username']=$user_name;
    $password = $_POST['password'];
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        //read from database
        $query = "select * from users where username = '$user_name' limit 1";
        $result = mysqli_query($conn, $query);
        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['password'] === $password)
                {
                    $_SESSION['user_id'] = $user_data['user_id'];
                if($user_data['Isactive']==1){
                    if($user_data['type']==1){
                        header("Location: AdminLandingPage.php");
                    }
                    else{
                        header("Location: index.php");
                    }
                }
                else if($user_data['Isactive']==0){
                        // array_push($error, "You're Deactivated"); 
                        //echo "Sorry you are still deactivated\r\n";
                        echo "Sorry you have been deactivated";
                        
                        header('REFRESH:2;URL=signup.php');
                      
                    }
                   
                    //
                    die;
                } else
                {
                    array_push($error, "Wrong Username or Password!");
                }
            } else
            {
                array_push($error, "Wrong Username or Password!");
            }
        }
    } else
    {
        array_push($error, "Wrong Username or Password!");
    }
}

if(isset($_GET['logout'])) {
    unset($_SESSION['username']);
    session_destroy();
    
    header("location:starter.html");
  }



?>