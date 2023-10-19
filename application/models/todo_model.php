<?php 
    Class Todo_Model extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
            

        }

        public function countAllData(){
            return $this->db->count_all('todo');
        }

        public function getPaginatedData($limit, $offset){
            $this->db->limit($limit, $offset);
            $query = $this->db->get('todo');
            return $query->result();
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

        public function updateInfo($data)
        {
            $id = $data['id'];
            $dataa = array(
                'title' => $data['title'],
                'description' => $data['description']
            );
            $this->db->where('id', $id);
            $status = $this->db->update('todo', $dataa);
            if ($status) {
                return true;
            } else {
                return false;
            }
        }
    }
?>