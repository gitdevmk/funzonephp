<?php
class BillingDetails {

    public static function insertDetails($con, $agreement, $token, $username) {
        try {
            $query = $con->prepare("INSERT INTO billingDetails (agreementId, nextBillingDate, token, username)
                                    VALUES(:agreementId, :nextBillingDate, :token, :username)");
            $agreementDetails = $agreement->getAgreementDetails();

            $query->bindValue(":agreementId", $agreement->getId());
            $query->bindValue(":nextBillingDate", $agreementDetails->getNextBillingDate());
            $query->bindValue(":token", $token);
            $query->bindValue(":username", $username);

            return $query->execute();
        } catch (PDOException $e) {
            // Handle the error gracefully
            error_log("Error inserting billing details: " . $e->getMessage());
            return false;
        }
    }

}
?>
