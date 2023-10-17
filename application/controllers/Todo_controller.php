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
        $data = [
            $title = $this->input->post('title'),
            $description = $this->input->post('description'),
            $status = $this->input->post('status')
        ];
        $inserted = $this->Todo_model->addData($data);
        if ($inserted) {
            echo json_encode(['success' => true, 'message' => 'Task added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add task']);
        }
    }
}
?>