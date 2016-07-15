<?php

include_once 'db.php';

Class Image {

    function __construct() {
        
    }

    public static function withID($id) {
        $instance = new self();
        $instance->loadByID($id);
        return $instance;
    }

    public static function withRow(array $row) {
        $instance = new self();
        $instance->fill($row);
        return $instance;
    }

    protected function loadByID($id) {
        // do query
        $query = mysql_query("SELECT * "
                . "FROM Search "
                . "WHERE id = $id "
                ) or die("Error");
        if ($row = mysql_fetch_array($query)) {
            $this->fill($row);
        }
    }

    protected function fill(array $row) {
        // fill all properties from array
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->title = $row['title'];
        $this->image = $row['image'];
        $this->description = $row['description'];
        $this->category = $row['category'];
    }

    public static function Insert(array $row) {
        // do query
        $query = mysql_query("INSERT INTO Search "
                . "('name','title','image','description','category')"
                . "VALUES ('{$row['name']}','{$row['title']}','{$row['image']}','{$row['description']}','{$row['category']}')"
                ) or die("Error");
    }

    function Update() {
        // do query
        $query = mysql_query("UPDATE Search "
                . "SET name=$this->name,"
                . "SET title=$this->title,"
                . "SET image=$this->image,"
                . "SET description=$this->description,"
                . "SET category=$this->category,"
                . "WHERE id = $this->id "
                ) or die("Error");
    }

    function Delete() {
        $query = mysql_query("DELETE "
                . "FROM Search "
                . "WHERE id = $this->id "
                ) or die("Error");
    }

}

?>
