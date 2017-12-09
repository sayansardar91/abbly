<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author Sayan
 */
class database {

    //put your code here
    public $conn;
    public $short;

    public function __construct() {
		$this->conn = mysqli_connect() or die('Cannot connect to the Data Base');
		if(!mysqli_select_db($this->conn,DB_NAME)){
			mysqli_select_db($this->conn,DB_NAME);
		}
    }

    function dbRowInsert($table_name, $form_data) {
        // retrieve the keys of the array (column titles)
        $fields = array_keys($form_data);

        // build the query
        $sql = "INSERT INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES('" . implode("','", $form_data) . "')";
        //echo $sql;
        //die;
        // run and return the query result resource
        return $this->conn->query($sql);
    }
    function dbRowReplaceInsert($table_name, $form_data) {
        // retrieve the keys of the array (column titles)
        $fields = array_keys($form_data);

        // build the query
        $sql = "REPLACE INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES('" . implode("','", $form_data) . "')";
        //echo $sql;
        //die;
        // run and return the query result resource
        return $this->conn->query($sql);
    }

    // the where clause is left optional incase the user wants to delete every row!
    function dbRowDelete($table_name, $where_clause = '') {
        // check for optional where clause
        $whereSQL = '';
        if (!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add keyword
                $whereSQL = " WHERE " . $where_clause;
            } else {
                $whereSQL = " " . trim($where_clause);
            }
        }
        // build the query
        $sql = "DELETE FROM " . $table_name . $whereSQL;
        //echo $sql;
        // run and return the query result resource
        $this->conn->query($sql);
        return mysqli_affected_rows($this->conn);
    }

    // again where clause is left optional
    function dbRowUpdate($table_name, $form_data, $where_clause = '') {
        // check for optional where clause
        $whereSQL = '';
        if (!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add key word
                $whereSQL = " WHERE " . $where_clause;
            } else {
                $whereSQL = " " . trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE " . $table_name . " SET ";

        // loop and build the column /
        $sets = array();
        foreach ($form_data as $column => $value) {
            $sets[] = "`" . $column . "` = '" . $value . "'";
        }
        $sql .= implode(', ', $sets);

        // append the where statement
        $sql .= $whereSQL;
        // run and return the query result
        return $this->conn->query($sql);
    }
    function __destruct() {
        $this->conn = null;
    }

}
