<!DOCTYPE html>
<?php
session_start();
include_once "config.php";

$username = $mysqli->real_escape_string($_GET["username"]);
$password = $mysqli->real_escape_string($_GET["password"]);

if($username === "HARIS" && $password === "MOTOS")
{
    // ADMINISTRATOR IS PRESENT  
    
    ?>
    <!-- JAVASCRIPT -->
    <script>
    window.location.replace("administrator/index.php");
    </script>
    <?php
    // STOP FURTHER PHP EXECUTION
    die;
  
}

// NO ADMIN MODE , USER present
if( !($result = $mysqli->query("SELECT * FROM user WHERE username='$username' AND password='$password' ")) == False)       
{
    foreach($result->fetch_assoc() as $index=>$item)
        {
            $_SESSION["active_user"][$index] = $item ;
        } 
}
else
     printf("Errormessage: %s\n", $mysqli->error);

?>


<script type="text/javascript">
window.location = "http://localhost/e-shop/my_account.php";
</script>      


