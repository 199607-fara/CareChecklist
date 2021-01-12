<?php
include "../../includes/DBconn.php";

if (isset($_POST['type'])) :

    $tests = new Tests();

    switch ($_POST['type']) {

        case "addTest":

            echo $tests->addTests(
                $_POST['in_TestName'],
                $_POST['in_Result'],
                $_POST['in_UserId']
            );
            break;
    }
endif;


class Tests
{
    public function addTests($name, $result, $userID)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "INSERT INTO tests (test_name,result,user_id) VALUES (:test_name,:result,:user_id)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':test_name', $name);
        $query->bindparam(':result', $result);
        $query->bindparam(':user_id', $userID);
        $query->execute();
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function viewTest($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT tests.*, patients.* from tests
                                inner join patients on patients.user_id = tests.user_id
                                 where tests.user_id = '$id'");
    }
}
