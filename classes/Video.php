<?php

class Video {

    private $_db,
            $_data;

    public function __construct($video = null) {
        $this->_db = DB::getInstance();
        $this->find($video);
    }

    public function find($video = null) {
        if ($video) {
            $field = 'id';
            $data = $this->_db->get('videos', array($field, '=', $video));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function search($field, $query) {
        if ($query) {
            $data = $this->_db->get('videos', array($field, 'LIKE', "%$query%"));
            if ($data->count()) {
                $this->_data = $data->results();
                return true;
            }
        }
        $this->_data = array();
        return false;
    }

    public function listAll() {
        $data = $this->_db->get('videos', array('id', '>=', '1'));
        if ($data->count()) {
            $this->_data = $data->results();
            return true;
        }
        return false;
    }

    public function related($query) {
        if ($query) {
            $field = 'category';
            $data = $this->_db->get('videos', array($field, '=', $query));
            if ($data->count()) {
                $this->_data = $data->results();
                return true;
            }
        }
        return false;
    }

    public function create($fields = array()) {
        $id = $this->_db->insert('videos', $fields);
        if (!$id) {
            throw new Exception('There was a problem upload an image');
        }
        return $id;
    }

    public function update($fields = array(), $id = null) {

        if (!$this->_db->update('videos', $id, $fields)) {
            throw new Exception("There was a problem updating image");
        }
    }

    public function data() {
        return $this->_data;
    }

}

?>
