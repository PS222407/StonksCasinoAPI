<?php
    class StonksDB 
    {
        const DSN = "mysql:host=localhost;dbname=stonkscasinoweb";
        const USER = "root";
        const PASSWD = "";

        function setAccessToken($id)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);
            $timestamp = random_int(1,99999999999999999);
            $statement = $pdo->prepare("UPDATE `users` SET `apikey` = :timestamp , `active` = 1 WHERE `id` = :id; ");
            $statement->bindParam(":timestamp",$timestamp,PDO::PARAM_INT);
            $statement->bindParam(":id",$id,PDO::PARAM_INT);
            $statement->execute();

            return $timestamp;
        }
        
        function UpdateUserTokens($userId, $tokens)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("UPDATE `users` SET `token` = ? WHERE id = ?"); 

            $statement->execute([$tokens, $userId]);
        }

        function GetUserAccesstoken($userId)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("SELECT `apikey` FROM `users` WHERE `id` = ?");

            $statement->execute([$userId]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        function GetUserInfo($userId)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");

            $statement->execute([$userId]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        function GetLogin($email)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("SELECT `password`, `id`, `active`, `banned` FROM users WHERE email=:email");
            $statement->bindParam(":email",$email,PDO::PARAM_STR);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        function Logout($userId)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("UPDATE `users` SET `active` = 0, `apikey` = 0 WHERE `id` = ?"); 

            $statement->execute([$userId]);
        }

        function AddTransaction($userId, $tokens, $sender, $tokensBefore, $tokensAfter)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("INSERT INTO `transactions` (`userid`, `tokens`, `sender`, `tokensBefore`, `tokensAfter`, `timestamp`) VALUES (:userid, :tokens, :sender, :tokensBefore, :tokensAfter, CURRENT_TIMESTAMP)");

            $statement->bindParam(":userid", $userId, PDO::PARAM_INT);
            $statement->bindParam(":tokens", $tokens, PDO::PARAM_INT);
            $statement->bindParam(":sender", $sender, PDO::PARAM_STR);
            $statement->bindParam(":tokensBefore", $tokensBefore, PDO::PARAM_INT);
            $statement->bindParam(":tokensAfter", $tokensAfter, PDO::PARAM_INT);
            
            $statement->execute();
        }

        function GetSelectedCardskin($userId)
        {
            $pdo = new PDO(self::DSN, self::USER, self::PASSWD);

            $statement = $pdo->prepare("SELECT `wpf_card_map` FROM `card_skins` INNER JOIN `users` ON `card_skins`.`id` = `users`.`selected_cardskin` WHERE `users`.`id` = :id");

            $statement->bindParam(":id",$userId,PDO::PARAM_INT);

            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        }
    }
?>
