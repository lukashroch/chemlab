<?php

namespace ChemLab\Helpers;

/**
 * This part contains the Backup_Database class wich performs
 * a partial or complete backup of any given MySQL database
 * @author Daniel López Azaña <http://www.daniloaz.com>
 * @version 1.0
 */

use Illuminate\Support\Facades\Config;

class BackupDB
{
    private $DB;

    public function __construct()
    {
        $this->DB = new \MySQLi(
            Config::get('database.connections.mysql.host'),
            Config::get('database.connections.mysql.username'),
            Config::get('database.connections.mysql.password'),
            Config::get('database.connections.mysql.database'));

        if ($this->DB->connect_errno != 0) {
            echo "Cannot connect to database (ERRNO: $this->DB->connect_errno): ";
            echo $this->DB->connect_error;
            exit;
        }

        //$this->name = $db['name'];
        $this->DB->query("SET CHARACTER SET utf8");
        $this->DB->query("SET NAMES 'utf8'");
    }

    public function __destruct()
    {
        $this->DB->close();
    }

    public function backupTables($tables = '*')
    {
        try {
            if ($tables == '*') {
                $tables = array();
                $result = $this->DB->query('SHOW TABLES');
                while ($row = $result->fetch_row()) {
                    $tables[] = $row[0];
                }
                $result->free_result();
            } else
                $tables = is_array($tables) ? $tables : explode(',', $tables);

            $dump = "";
            //$dump = "CREATE DATABASE IF NOT EXISTS ".$this->conn->name.";\n\n";
            //$dump .= "USE ".$this->conn->name.";\n\n";

            foreach ($tables as $table) {
                $result = $this->DB->query('SELECT * FROM ' . $table);
                $numFields = $result->field_count;

                $dump .= "DROP TABLE IF EXISTS `" . $table . "`;\n";
                $struct = $this->DB->query('SHOW CREATE TABLE ' . $table)->fetch_row();
                $dump .= $struct[1] . ";\n\n";

                $query = 1;
                $rowCount = 0;
                $data = "";

                if ($result->num_rows)
                    $data = "INSERT INTO `" . $table . "` VALUES\n";

                while ($row = $result->fetch_row()) {
                    $rowCount++;
                    if (strlen($data) > $query * 20000) {
                        $query++;
                        $data = substr_replace($data, ");", -3, 2);
                        $data .= "INSERT INTO `" . $table . "` VALUES\n";
                    }

                    $data .= "(";
                    for ($i = 0; $i < $numFields; $i++) {

                        if (is_null($row[$i])) {
                            $data .= "NULL";
                        } else {
                            $row[$i] = addslashes($row[$i]);
                            $row[$i] = preg_replace("/\n/", "\\n", $row[$i]);
                            $data .= "'" . $row[$i] . "'";
                        }

                        if ($i < ($numFields - 1))
                            $data .= ", ";
                    }
                    $data .= ($rowCount == $result->num_rows) ? ");\n" : "),\n";
                }

                $dump .= $data . "\n\n";
                $result->free_result();
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return $dump;
    }
}

?>