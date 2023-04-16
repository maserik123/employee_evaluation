<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('user');
        return $this->db->get()->result();
    }


    function getListData()
    {
        $listUser = $this->db->from('user')->get()->result();
        $userid = array();
        $full_name = array();
        foreach ($listUser as $row) {
            $userid[] = $row->userid;
            $full_name[] = $row->full_name;
        }
        $data = $userid;
        $data = $full_name;
        return $data;
    }

    function getUserBaseRole($role)
    {
        $query = $this->db->query('
        select *
        from user a
        inner join user_login b on b.userid = a.userid
        inner join user_role c on c.user_role_id = b.user_role_id
        where c.role = "' . $role . '"');
        return $query->result();
    }

    function getAllData()
    {
        $this->datatables->select('userid,full_name,nick_name,initial,NIP,email,address,phone_number,create_date');
        $this->datatables->from('user');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('user', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('user');
        $this->db->where('userid', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from user where userid =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('user ap', array('ap.userid' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('userid', $id);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('userid', $id);
        $this->db->delete('user');
    }
}

/* End of file Model_user.php */
