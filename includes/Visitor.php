<?php

class Visitor extends Database
{
    public $id, $unique_id, $user_agent, $operating_system, $remote_addr, $remote_host, $first_access, $last_access, $time_spent, $visit_count, $clicks;

    public static function find($unique_id)
    {
        global $db;

        $sql = "SELECT * FROM visitors WHERE unique_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$unique_id]);

        if ($stmt->rowCount() == 0) {
            return false;
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $the_object = self::instantation($result);

        return $the_object;
    }

    public static function findAll()
    {
        global $db;

        $objects_array = array();
        $sql = "SELECT * FROM visitors";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        $result_set = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result_set as $result) {
            $object = static::instantation($result);
            $objects_array[] = $object;
        }

        return $objects_array;
    }

    public static function instantation($result)
    {
        $class = get_called_class();
        $the_object = new $class;

        foreach ($result as $attribute => $value) {
            if (property_exists($the_object, $attribute)) {
                $the_object->$attribute = $value;
            }
        }

        return $the_object;
    }

    public function update()
    {
        global $db;

        $sql = "UPDATE visitors SET visit_count=?, last_access=now() WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$this->visit_count, $this->id]);

        return $stmt;
    }

    public function save()
    {
        global $db;

        $sql = "INSERT INTO visitors(unique_id, user_agent, operating_system, remote_addr, remote_host, visit_count) VALUES(?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$this->unique_id, $this->user_agent, $this->operating_system, $this->remote_addr, $this->remote_host, $this->visit_count]);

        return $stmt;
    }

    public function updateUserActivity()
    {
        global $db;

        $sql = "UPDATE visitors SET time_spent=?, clicks=?";
        $stmt = $db->prepare($sql);

        return $stmt->execute([$this->time_spent, $this->clicks]);
    }
}
