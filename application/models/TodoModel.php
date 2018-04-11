<?php


class TodoModel extends CI_Model
{
    public  function  __construct ()
    {
        $this->load->database();
    }

    public function getItems()
    {
        $this->db->select('tasks.id, tasks.task, images.img_name');
        $this->db->from('tasks');
        $this->db->join('images', 'images.task_id = tasks.id', 'left');
        $this->db->where('user_id', $_SESSION['userId']);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTags($id)
    {
        $this->db->select('tag_id , tag_name, tasks.id');
        $this->db->from('tasks_tags');
        $this->db->join('tasks', 'tasks_tags.task_id = tasks.id');
        $this->db->join('tags',  'tasks_tags.tag_id  = tags.id');
        $this->db->where('tasks.id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function setItem($data)
    {
        $this->db->insert('tasks', $data);

        return $this->db->insert_id();
    }

    public function setTag($data)
    {
        $this->db->select('*');

        $this->db->from('tags');
        $this->db->where('tag_name', $data['tag_name']);

        $query  = $this->db->get();
        $result = $query->result_array();

        if(empty($result)){
            $this->db->insert('tags', ['tag_name' => $data['tag_name']]);

            $tag_id = $this->db->insert_id();

            $this->db->insert('tasks_tags', [
                'task_id' => $data['task_id'],
                'tag_id' => $tag_id
            ]);

            return  $tag_id;
        } else {
            $this->db->select('*');

            $this->db->from('tasks_tags');
            $this->db->where('task_id', $data['task_id']);
            $this->db->where('tag_id', $result[0]['id']);
            $query  = $this->db->get();
            $res = $query->result_array();

            if(empty ($res)){
                $this->db->insert('tasks_tags', [
                    'task_id' => $data['task_id'],
                    'tag_id'  => $result[0]['id']
                ]);
            }

            return $result[0]['id'];
        }
    }

    public function setImage($data)
    {
        $this->db->select('*');
        $this->db->from('images');
        $this->db->where('task_id',$data['task_id']);
        $query = $this->db->get();

        $result = $query->result_array();

        if(! empty($result)){
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['img_name']);
            return $this->db->update('images' , $data,  ['task_id'  =>  $data[ 'task_id' ]]);
        } else {
            $this->db->insert('images', $data);

            return  $this->db->insert_id();
        }
    }

    public function deleteImage($data)
    {
        return $this->db->delete('images', ['task_id' => $data['task_id']]);

    }

    public function updateItem($data)
    {
        return $this->db->update('tasks' , $data,  ['id'  =>  $data[ 'id' ]]);
    }

    public function searchItem($item)
    {
        $this->db->select('tasks.id, tasks.task, images.img_name');
        $this->db->from('tasks');
        $this->db->join('images', 'images.task_id = tasks.id', 'left');
        $this->db->like('tasks.task', $item);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function filterItem($id)
    {
        $this->db->select('tag_id , tag_name, task, tasks.id, images.img_name');
        $this->db->from('tasks_tags');
        $this->db->join('tasks', 'tasks_tags.task_id = tasks.id');
        $this->db->join('tags',  'tasks_tags.tag_id  = tags.id');
        $this->db->join('images', 'images.task_id = tasks.id', 'left');
        $this->db->where('tags.id', $id);
        $query = $this->db->get();


        return $query->result_array();
    }


}