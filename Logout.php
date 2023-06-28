<?php 
include "DBconnect.php";
$db = new StonksDB();
$credentials = json_decode(file_get_contents("php://input"));

$row = $db->GetUserInfo($credentials->userId);

if($credentials->accessToken == $row["apikey"] && $row["apikey"] != 0)
{
    $db->Logout($credentials->userId);
}

?>