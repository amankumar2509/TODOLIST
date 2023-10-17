<?php 
    Class Todo_Model extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        public function getData(){
            $query=$this->db->get('todo');
            $result=$query->result();
            return $result;
        }
        public function addData($data){
            $this->db->insert('todo',$data);
            return $this->db->insert_id();

        }
    }
?>