<?php

include "ResultModel/LoginResult.php";
include "DBconnect.php";

$db = new StonksDB();
$login = json_decode(file_get_contents("php://input"));

$row = $db->GetLogin($login->email);

$loginResult = new LoginResult();

if ($row && password_verify($login->password,$row["password"]))
{
    if(($row["active"] == 0 || $login->overwride == true) && $row["banned"] == false)
    {
        $loginResult->result = 'succes';
        $loginResult->userId = $row["id"];
        $loginResult->accessToken = $db->setAccessToken($row["id"]);
    }
    else
    {
        $loginResult->result = 'active';
    }       
}
echo json_encode( get_object_vars($loginResult));
?>