<?php
class Message {

    private $_db, $_data;

    public function __construct($video = null) {
        $this->_db = DB::getInstance();
    }

    public function listAll() {
        $data = $this->_db->get('messages', array('id', '>=', '1'));
        if ($data->count()) {
            $this->_data = $data->results();
            return true;
        }
        return false;
    }

    public function create($fields = array()) {
        $id = $this->_db->insert('messages', $fields);
        if (!$id) {
            throw new Exception('There was a problem upload an message');
        }
        return $id;
    }

    public function data() {
        return $this->_data;
    }

}

?>