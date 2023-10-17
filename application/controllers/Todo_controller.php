<?php
class Todo_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Todo_model');
        //$this->load->database();


    }

    public function ajax_getData()
    {
        $data = $this->Todo_model->getData();
        //$this->load->view('todo',$data);
        //  error_log(print_r($data, true));
        echo json_encode(['data' => $data]);
    }
    public function todo()
    {
        $this->load->view('todo');
    }
    public function addTask()
    {
        $data = array(
            'title' => $this->input->post('task'),
            'description' => $this->input->post('discription'),
            'status' => $this->input->post('status')
        );
      $insert=$this->Todo_model->addData($data);
        if ($insert) {
           // echo json_encode(['success' => true, 'message' => 'Task added successfully']);
        echo 1;       
        } else {
           // echo json_encode(['success' => false, 'message' => 'Failed to add task']);
        echo 0;
        }
    }
}
?>