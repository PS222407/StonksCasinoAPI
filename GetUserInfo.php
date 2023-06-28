<?php

include "ResultModel/UserInfoResult.php";
include "DBconnect.php";

$result = new UserInfoResult();
$db = new StonksDB();

$credentials = json_decode(file_get_contents("php://input"));
$row = $db->GetUserInfo($credentials->userId);

if($credentials->accessToken == $row["apikey"] && $row["apikey"] != 0 && $row["banned"] == false)
{
    $result = new UserInfoResult();
    $result->result = true;
    $result->userName = $row["username"];
    $result->tokens = $row["token"];
    $row = $db->GetSelectedCardskin($credentials->userId);
    $result->selectedSkin = $row["wpf_card_map"];
}

echo json_encode( get_object_vars($result));

?>