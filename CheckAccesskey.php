<?php 
include "ResultModel/Result.php";
include "DBconnect.php";
$db = new StonksDB();
$result = new Result();

$credentials = json_decode(file_get_contents("php://input"));
$row = $db->GetUserInfo($credentials->userId);

if($credentials->accessToken == $row["apikey"] && $row["apikey"] != 0)
{
    $result->result = true;
}

echo json_encode( get_object_vars($result));
?>