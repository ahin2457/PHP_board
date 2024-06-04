<?php

class Ahindb extends mysqli
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public  $dbConn = null;

    public function __construct()
    {

        $this->servername = "localhost";
        $this->username = "root"; // MySQL 사용자 이름
        $this->password = ""; // MySQL 비밀번호
        $this->dbname = "board";
    }

    public function conn()
    {
        $this->dbConn = $this->connect($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->connect_errno) {

            return false;
        }
        $this->query("set names utf8;");
        return true;
    }
}



$ahindb = new Ahindb();
if ($ahindb->conn() === false) {
    die('Connect Error: ' . $ahindb->connect_error);
}



// echo "<pre>";
// print_r($rsc);
