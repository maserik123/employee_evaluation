<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user_role extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        return $this->db->get()->result();
    }

    function getDataExceptSysManager()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $this->db->where('role != "sys_manager"');
        return $this->db->get()->result();
    }

    function getAllData()
    {
        $this->datatables->select('user_role_id,role,description,create_date');
        $this->datatables->from('user_role');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('user_role', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('user_role');
        $this->db->where('user_role_id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from user_role where user_role_id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('user_role ap', array('ap.user_role_id' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('user_role_id', $id);
        $this->db->update('user_role', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('user_role_id', $id);
        $this->db->delete('user_role');
    }
}

/* End of file Model_user.php */
