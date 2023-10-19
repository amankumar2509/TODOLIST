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
           
            return $this->db->insert('todo',$data);

        }
        public function deleteData($id){
            $this->db->where('id',$id);
            $this->db->delete('todo');
            return $this->db->affected_rows()>0;
        }

        public function updateTask($id, $data) {
            // Update the task with the provided data where the ID matches
            $this->db->where('id', $id);
            $this->db->update('tasks', $data);
            
            // Check if the update was successful
            return $this->db->affected_rows() > 0;
        }

        
    }
?>