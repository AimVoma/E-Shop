<?php
session_start();
include_once "config.php";
$redirect = "register.php";

if(!$_GET["username"]
    or !$_GET["password"]
        or !$_GET["name"]
            or !$_GET["sname"]
                or !$_GET["phone"]
                    or !$_GET["adress"]
                        or !$_GET["pcode"])
    {

    echo "
        <script type=\"text/javascript\">
        alert(\"Please Input Correct Numeric Values!\");
        </script>
        ";
        goto wrong_input;
    }
    if(!(is_numeric($_GET["phone"])) or !(is_numeric($_GET["pcode"])))
   {
        echo "
        <script type=\"text/javascript\">
        alert(\"Please Input Correct Numeric Values!\");
        </script>
        ";
        goto wrong_input;
   }
$query = sprintf
("
   SELECT usr_id FROM user
   WHERE username = '%s'
",
   $mysqli->escape_string($_GET["username"])     
);
if (!$result = $mysqli->query($query))
{
     printf("Errormessage: %s\n", $mysqli->error);
}
if(mysqli_num_rows($result) != 0){
$error = "The Username : ". $_GET["username"]. "is reserved, Please Select Another One!";
echo '<script type="text/javascript">alert("'.$error.'");</script>';
goto wrong_input;
}       
   
   
$sql =<<<MYSQL
INSERT INTO user
(username, password, name , sname , phone , adress , postal_code , email ,proficiency) 
    VALUES(
    '{$_GET["username"]}', '{$_GET["password"]}', 
    '{$_GET["name"]}', '{$_GET["sname"]}', '{$_GET["phone"]}', 
    '{$_GET["adress"]}','{$_GET["pcode"]}', '{$_GET["mail"]}','{$_GET["proficiency"]}');
MYSQL;

   
if ($mysqli->query($sql) === TRUE) {
echo "
        <script type=\"text/javascript\">
        window.location = \"http://localhost/e-shop/my_account.php\";
        </script>      
";
}

wrong_input:
  echo "
        <script type=\"text/javascript\">
        window.location = \"http://localhost/e-shop/register.php\";
        </script>      
";