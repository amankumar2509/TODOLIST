<?php
class Todo_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Todo_model');
        //$this->load->database();
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));


    }

    // public function ajax_getData()
    // {
    //     $data = $this->Todo_model->getData();
    //     //$this->load->view('todo',$data);
    //     //  error_log(print_r($data, true));
    //     echo json_encode(['data' => $data]);
    // }

    public function ajax_getData()
    {
        $config = ['
             base_url' => base_url('Todo_controller/ajax_getData/'),
            'total_rows' => $this->Todo_model->countAllData(),
            'per_page' => 10,
            'uri_segment' => 2
        ];
        $this->pagination->initialize($config);

        $page = intval($this->uri->segment(2, 0));
        $offset = $page > 0 ? ($page - 1) * $config['per_page'] : 0;
        $data = $this->Todo_model->getPaginatedData($config['per_page'], $offset);
        $response = [
            'data' => $data,
            'pagination' => $this->pagination->create_links()
        ];

        echo json_encode($response);
    }
    public function todo()
    {
        $this->load->view('todo');
    }
    public function addTask()
    {
        $this->form_validation->set_rules('task', 'Task', 'required');
        $this->form_validation->set_rules('discription', 'Discription', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo 0;
        } else {
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

        $res = $this->db->where('id', $task_id)->update('todo', ['status' => $new_status]);
        if ($res) {
            echo json_encode(['success' => true, 'new_status' => $new_status]);
        } else {
            echo json_encode(['success' => false]);
        }
    }


}
?>