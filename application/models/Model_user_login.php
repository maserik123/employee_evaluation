<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user_login extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->get();
        return $this->db->result();
    }

    function getAllData()
    {
        $this->datatables->select('
        a.user_login_id,
        b.full_name,
        b.nick_name,
        b.initial,
        b.NIP,
        b.email,
        b.address,
        b.phone_number,
        a.username,
        a.user_role_id,
        c.role,
        a.block_status,
        a.create_date');
        $this->datatables->from('user_login a');
        $this->datatables->join('user b', 'b.userid = a.userid', 'left');
        $this->datatables->join('user_role c', 'c.user_role_id = a.user_role_id', 'left');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('user_login', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('user_login');
        $this->db->where('user_login_id', $id);
        return $this->db->get()->row();
    }

    function update($id, $data)
    {
        $this->db->where('user_login_id', $id);
        $this->db->update('user_login', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('user_login_id', $id);
        $this->db->delete('user_login');
    }

    function cek_user_pwd($username, $password)
    {
        $this->db->select('a.user_login_id,
        b.full_name,
        b.nick_name,
        b.initial,
        b.NIP,
        b.email,
        b.address,
        b.phone_number,
        a.username,
        a.block_status,
        a.access_status,
        b.picture,
        c.role,
        c.user_role_id,
        a.online_status
        ');
        $this->db->from('user_login a');
        $this->db->join('user b', 'b.userid = a.userid', 'left');
        $this->db->join('user_role c', 'c.user_role_id = a.user_role_id', 'left');
        $this->db->where('username like binary', $username);
        $this->db->where('password like binary', $password);
        return $this->db->get();
    }

    function change_on_off($id, $data)
    {
        $this->db->where('user_login_id', $id);
        $this->db->update('user_login', $data);
        return $this->db->affected_rows();
    }

    function getOnlineUserById($id)
    {
        $this->db->select('online_status');
        $this->db->from('user_login');
        $this->db->where('user_login_id', $id);
        return $this->db->get()->result();
    }

    public function getuserById($id)
    {
        return $this->db->get_where('user_login ap', array('ap.user_login_id' => $id))->result();
    }
}

/* End of file Model_user.php */
