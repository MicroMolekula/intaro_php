<?php

function add_values_bd(PDO $pdo, $values, $date)
{
    try {
        $sql = "INSERT INTO request (surname, name, middle_name, phone, email, comment, date) 
                VALUES 
                (:surname, :name, :middle_name, :phone, :email, :comment, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":surname", $values['sname']);
        $stmt->bindValue(":name", $values['fname']);
        $stmt->bindValue(":middle_name", $values['mname']);
        $stmt->bindValue(":phone", $values['phone']);
        $stmt->bindValue(":email", $values['email']);
        $stmt->bindValue(":comment", $values['comment']);
        $stmt->bindValue(":date", $date);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function check_email(PDO $pdo, $values, DateTime $date)
{
    try {
        $sql = "SELECT r.email, r.date FROM request r";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
            if ($row['email'] === $values['email']){
                if (($date->getTimestamp() - strtotime($row['date']))< 3600){
                    return date("'H:i:s d:m:Y'", strtotime($row['date']) + 3600);
                }
            }
        }
        return 'ok';
    } catch (PDOException) {
        return false;
    }
}