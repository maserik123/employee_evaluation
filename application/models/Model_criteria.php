<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_criteria extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('criteria');
        return $this->db->get()->result();
    }


    function getAllData()
    {
        $this->datatables->select('a.id, a.criteria_code, a.criteria_detail, a.crt_date');
        $this->datatables->from('criteria a');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('criteria', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('criteria');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from criteria where id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('criteria ap', array('ap.id' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('criteria', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('criteria');
    }
}

/* End of file Model_user.php */
