<?php
class User {
    private $con, $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;

        try {
            $query = $con->prepare("SELECT * FROM users WHERE username=:username");
            $query->bindValue(":username", $username);
            $query->execute();

            if ($query->rowCount() > 0) {
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            } else {
                // Handle user not found scenario
                // For now, let's set sqlData to an empty array
                $this->sqlData = [];
            }
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in User::__construct(): " . $e->getMessage());
            // For now, let's set sqlData to an empty array
            $this->sqlData = [];
        }
    }

    public function getFirstName() {
        return $this->sqlData["firstName"] ?? null;
    }

    public function getLastName() {
        return $this->sqlData["lastName"] ?? null;
    }

    public function getEmail() {
        return $this->sqlData["email"] ?? null;
    }

    public function getIsSubscribed() {
        return $this->sqlData["isSubscribed"] ?? null;
    }

    public function getUsername() {
        return $this->sqlData["username"] ?? null;
    }

    public function setIsSubscribed($value) {
        try {
            $query = $this->con->prepare("UPDATE users SET isSubscribed=:isSubscribed
                                        WHERE username=:username");
            $query->bindValue(":isSubscribed", $value);
            $query->bindValue(":username", $this->getUsername());
            
            if($query->execute()) {
                $this->sqlData["isSubscribed"] = $value;
                return true;
            }
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in User::setIsSubscribed(): " . $e->getMessage());
        }
        
        return false;
    }
}
?>
