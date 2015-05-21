<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("initialize.php");

class DbCoreFunctions extends MySqlDatabase
{

    public $last_inserted_id = '';
    public $num_of_rows = 0;

    /*
        method for selecting data from tables
        sample code:
        $dbcore = new DbCoreFunctions();
        $dbcore->select('tblname','columnsname,columnsname',NULL,' ID= 1');

     */
    public function select($table, $columns = '*', $join = null, $where = null, $order = null, $limit = null)
    {
        $str_query = 'SELECT ' . $columns . ' FROM ' . $table;

        if ($join != null) {
            $str_query .= ' INNER JOIN ' . $join;
        }

        if ($where != null) {
            $str_query .= ' WHERE ' . $where;
        }

        if ($order != null) {
            $str_query .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $str_query .= ' LIMIT ' . $limit;
        }

        if ($this->tableExists($table)) {

            $data = $this->query($str_query);
            $this->num_of_rows = $this->num_rows($data);

            return (isset($data) && !empty($data)) ? $data : false;

        } else {
            return false;
        }
    }

    /*
        code for the inserting data to database
        sample code:
        $dbcore = new DbCoreFunctions();
        $dbcore->insert('tblname',array('field name'=>'value sa field name') );

     */
    public function insert($table, $params = array())
    {
        if ($this->tableExists($table)) {


            $str_insert = "INSERT INTO " . $table . "  (" . implode(', ', array_keys($params)) . ") VALUES ('" . implode("', '", $params) . "') ";

            $insert = $this->query($str_insert);
            if ($insert) {
                //get the last inserted id and set it to out varialble name last_inserted_id
                $this->last_inserted_id = $this->insert_id($this->connection);
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    /*
        mao ni method nga para sa delete nga method
        like this code

        $dbcore = new DbCoreFunctions();
        $dbcore->delete('tblname','id=1')
     */

    public function delete($table, $where = null)
    {
        if ($this->tableExists($table)) {
            $str_delete = 'DELETE FROM ' . $table;

            if ($where != null) {
                $str_delete .= ' WHERE ' . $where;
            }

            $del = $this->query($str_delete);

            if ($del) {
                return true;
            } else {
                return false;
            }


        }

    }

    /*
     mao ni dapat porma sa update nga array 'field name' => 'ang new value'

           $a = array('Username'=>'Nasdfsdfde 5');
           $dbcore = new DbCoreFunctions();
           $dbcore->update('login',$a," Password=1 ");
    */
    public function update($table, $param = array(), $where)
    {
        if ($this->tableExists($table)) {
            //hold all coloums to update

            $arg = array();
            foreach ($param as $field => $value) {
                //separate each column out with its coresponding value

                $arg[] = $field . " = '" . $this->escape_value($value) . "' ";

            }

            //create the query string
            $update_query = "UPDATE " . $table . " SET " . implode(',', $arg) . " WHERE " . $where;

            $update_data = $this->query($update_query);
            if ($update_data) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    // method to check if naa ba ang table sa database
    private function tableExists($table)
    {
        $tablesIndb = $this->query("SHOW TABLES FROM {$this->dbname}  LIKE '" . $table . "' ");

        if ($tablesIndb) {

            if ($this->num_rows($tablesIndb) == 1) {
                return true;
            } else {
                return true;
            }
        }


    }
}

$dbcore = new DbCoreFunctions();

