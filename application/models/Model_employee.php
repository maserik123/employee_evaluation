<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_employee extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('employee');
        return $this->db->get()->result();
    }

    function getAllData()
    {
        $this->datatables->select('id, e_name, e_phone, e_address, e_email, crt_date');
        $this->datatables->from('employee');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('employee', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('employee');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from employee where id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('employee ap', array('ap.id' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('employee', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('employee');
    }
}

/* End of file Model_user.php */
