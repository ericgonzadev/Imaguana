<?php

class Image {

    private $_db,
            $_data;

    public function __construct($image = null) {
        $this->_db = DB::getInstance();
        $this->find($image);
    }

    public function find($image = null) {
        if ($image) {
            $field = 'id';
            $data = $this->_db->get('images', array($field, '=', $image));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function search($field, $query) {
        if ($query) {
            $data = $this->_db->get('images', array($field, 'LIKE', "%$query%"));
            if ($data->count()) {
                $this->_data = $data->results();
                return true;
            }
        }
        $this->_data = array();
        return false;
    }

    public function listAll() {
        $data = $this->_db->get('images', array('id', '>=', '1'));
        if ($data->count()) {
            $this->_data = $data->results();
            return true;
        }
        return false;
    }

    public function related($query) {
        if ($query) {
            $field = 'category';
            $data = $this->_db->get('images', array($field, '=', $query));
            if ($data->count()) {
                $this->_data = $data->results();
                return true;
            }
        }
        return false;
    }

    public function create($fields = array()) {
        $id = $this->_db->insert('images', $fields);
        if (!$id) {
            throw new Exception('There was a problem upload an image');
        }
        return $id;
    }

    public function update($fields = array(), $id = null) {

        if (!$this->_db->update('images', $id, $fields)) {
            throw new Exception("There was a problem updating image");
        }
    }

    public function data() {
        return $this->_data;
    }

}

?>
