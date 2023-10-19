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
           
        );
        $insert = $this->Todo_model->addData($data);
        if ($insert) {
            // echo json_encode(['success' => true, 'message' => 'Task added successfully']);
            echo 1;
        } else {
            // echo json_encode(['success' => false, 'message' => 'Failed to add task']);
            echo 0;
        }

    }
    public function deleteTask()
    {
        $id = $this->input->post('id');
        $success = $this->Todo_model->deleteData($id);
        $response = array('success' => $success);
        echo json_encode($response);
    }

    public function updateTaskStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->load->model('Todo_model');

        // Check if the task exists with the provided ID
        $task = $this->Todo_model->getTaskById($id);

        if ($task) {
            echo 1;
        } else {
            echo 0;
        }

        // echo json_encode($response);
    }

    // Inside your Todo_Controller.php or appropriate controller file

public function updateStatus()
{
        $task_id = $this->input->post('id');
        $current_status = $this->db->get_where('todo', ['id' => $task_id])->row()->status;
        $new_status = $current_status == 1 ? 0 : 1;

        $res=$this->db->where('id', $task_id)->update('todo', ['status' => $new_status]);
        if($res){
        echo json_encode(['success' => true, 'new_status' => $new_status]);
        }
        else{
            echo json_encode(['success' => false]);
        }
}


}
?>