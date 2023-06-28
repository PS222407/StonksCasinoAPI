<?php 
include "ResultModel/Result.php";
include "DBconnect.php";
$db = new StonksDB();
$result = new Result();

$input = json_decode(file_get_contents("php://input"));
$row = $db->GetUserInfo($input->credentials->userId);

if($input->credentials->accessToken == $row["apikey"] && $row["apikey"] != 0)
{
    //update tokens
    $tokens = $row["token"] + $input->tokens;
    $db->UpdateUserTokens($input->credentials->userId, $tokens);
    $result->result = true;

    //add transaction
    $db->AddTransaction($input->credentials->userId, $input->tokens, $input->sender, $row["token"], $tokens);
}

echo json_encode( get_object_vars($result));
?>