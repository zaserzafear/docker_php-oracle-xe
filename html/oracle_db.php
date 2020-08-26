<?php

class oracle_db {

    private $connect = NULL;

    private function db_open() {
        $host = "oracle_db";
        $database = "XE";
        $encoding = "utf8";
        $username = "LEARN";
        $password = "LEARN";
        $dsn = "oci:dbname=" . $host . "/" . $database . ";charset=" . $encoding . ";";
        $this->connect = new PDO($dsn, $username, $password);
        $this->connect->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    private function db_close() {
        $this->connect = null;
    }

    private function db_execute($params, $statement) {
        try {
//            $this->db_open();
            $stmt = $this->connect->prepare($statement);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $ex) {
            echo "<pre>", $ex, "</pre>";
            echo "<pre>", var_dump($params), "</pre>";
            echo "<pre>", var_dump($statement), "</pre>";
//            die();
        } catch (Exception $ex) {
            echo "<pre>", $ex, "</pre>";
//            die();
        } finally {
//            $this->db_close();
        }
    }

    function __construct() {
        $this->db_open();
    }

    function __destruct() {
        $this->db_close();
    }

    private function sequence_nextval($sequence) {
        $statement = "SELECT " . $sequence . ".NEXTVAL FROM dual";
        $params = array();
        $query = $this->db_execute($params, $statement);
        $record = $query->fetch(PDO::FETCH_ASSOC);
        $nextval = $record["NEXTVAL"];
        return $nextval;
    }

    private function fetch_stream_records($query) {
        $data = array();
        try {
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $record = array();
                foreach ($result as $key => $value) {
                    if (gettype($value) == "resource") {
                        $value = stream_get_contents($value);
                    }
                    $record[$key] = $value;
                }
                $data[] = $record;
            }
        } catch (Exception $ex) {
            echo "fetch_stream_records Exception <br />";
            echo "<pre>", var_dump($ex), "</pre>";
            echo "<pre>", var_dump($query), "</pre>";
            die();
        } finally {
            return $data;
        }
    }

    public function date_modify($type, $datetime, $modify) {
        require_once 'date_time.php';
        $date_time = new date_time();
        $data = $date_time->date_time_modify($type, $datetime, $modify);

        return $data;
    }
}
?>
