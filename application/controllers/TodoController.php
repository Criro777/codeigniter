<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TodoController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('todoModel');
        session_start();
    }

    public function index()
    {
       if(isset($_SESSION['username'])){
           $data['items'] =  $this->todoModel->getItems();

           foreach ($data['items'] as &$item){
               $item['tags']  =  $this->todoModel->getTags($item['id']);
           }

           $this->load->view('main', $data);
       } else {
            header("Location:/login");
        }
    }

    public function addItem()
    {
        $data['task']    = $this->input->post('item');
        $data['user_id'] = $_SESSION['userId'];

        $result = $this->todoModel->setItem($data);

        if($result){
            echo $result;
        }else
            echo false;
    }

    public function editItem()
    {
        $data['task']  = $this->input->post('value');
        $data['id']    = $this->input->post('pk');
        $result        = $this->todoModel->updateItem($data);

        echo $result;
    }

    public function loadFile()
    {
        $upload_dir  = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $allow_types = ['image/png', 'image/jpeg'];

        if (in_array($_FILES["picture"]["type"], $allow_types)) {
            if ($_FILES["picture"]["error"] == UPLOAD_ERR_OK) {

                $filename = microtime(true);
                switch ($_FILES['picture']['type']) {
                    case 'image/png':
                        $filename.='.png';
                        break;
                    case 'image/jpeg':
                        $filename.= '.jpg';
                }

                $upload_file = $upload_dir.$filename;
                $file_path   = '/uploads/'.$filename;
                $tmp_name    = $_FILES["picture"]["tmp_name"];

                move_uploaded_file($tmp_name, $upload_file);

                $data['img_name'] = $file_path;
                $data['task_id']  = $this->input->post('id');

                $img = $this->todoModel->setImage($data);
                if($img){
                    echo $file_path;
                }
            }
        } else
            echo false;
    }

    public function deleteFile()
    {
        $data['task_id']  = $this->input->post('id');
        $result = $this->todoModel->deleteImage($data);
    }

    public function addTag()
    {
        $data['tag_name']  = $this->input->post('tag');
        $data['task_id']   = $this->input->post('id');

        $result = $this->todoModel->setTag($data);

       if($result) {
            $response['tag_name'] = $data['tag_name'];
            $response['tag_id']   = $result;
            echo json_encode($response);
        } else
            echo false;
    }

    public function searchItem()
    {
        $item = $this->input->post('search');
        $data['items'] =  $this->todoModel->searchItem($item);
        //$data['tags']  =  $this->todoModel->getTags();
        $this->load->view('results', $data);
    }

    public function filterItem()
    {
        $id = $item = $this->input->get('id');

        $data['items'] =  $this->todoModel->filterItem($id);
        //$data['tag']   =  $this->todoModel->getTagById($id);

        $this->load->view('tags', $data);
    }


}