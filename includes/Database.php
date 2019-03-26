<?php
class Database
{
    public static function connect()
    {
        static $db = null;

        if ($db === null) {
            $host = Config::DB_HOST;
            $username = Config::DB_USERNAME;
            $password = Config::DB_PASSWORD;
            $database = Config::DB_NAME;

            try {
                $db = new PDO("mysql:host=$host", $username, $password);
                $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
                $result = $db->query($sql);

                //If database does not exists, create it
                if ($result->fetchColumn() == 0) {
                    $sql = "CREATE DATABASE " . $database;
                    $sql2 = "USE " . $database;

                    $db->exec($sql);
                    $db->exec($sql2);

                    //After creating database, create tables
                    $admin_table = "CREATE TABLE `admin` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `username` varchar(255) NOT NULL,
                                    `password` varchar(255) NOT NULL,
                                    PRIMARY KEY (`id`)
                                    )";

                    $add_admin = "INSERT INTO admin(username, password) VALUES('admin', 'admin')";

                    $visitors_table = "CREATE TABLE `visitors` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `unique_id` varchar(255) NOT NULL,
                                    `user_agent` varchar(255) DEFAULT NULL,
                                    `operating_system` varchar(255) DEFAULT NULL,
                                    `remote_addr` varchar(255) DEFAULT NULL,
                                    `remote_host` varchar(255) DEFAULT NULL,
                                    `time_spent` int(11) DEFAULT '0',
                                    `clicks` int(11) DEFAULT '0',
                                    `visit_count` int(11) NOT NULL DEFAULT '1',
                                    `first_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    PRIMARY KEY (`id`)
                                    )";

                    $db->exec($admin_table);
                    $db->exec($visitors_table);
                    $db->exec($add_admin);
                } else {
                    $db->exec('USE ' . $database);
                }
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return $db;
    }
}
