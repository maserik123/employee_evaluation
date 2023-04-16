<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_weight extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('weight');
        return $this->db->get()->result();
    }

    function getCriteria()
    {
        $this->db->select('*');
        $this->db->from('criteria');
        return $this->db->get()->result();
    }

    function getAllData()
    {
        $this->datatables->select('a.weight_id, b.criteria_code, a.weight_value');
        $this->datatables->from('weight a');
        $this->datatables->join('criteria b', 'b.id = a.criteria_id', 'left');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('weight', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('weight');
        $this->db->where('weight_id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from weight where weight_id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('weight ap', array('ap.weight_id' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('weight_id', $id);
        $this->db->update('weight', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('weight_id', $id);
        $this->db->delete('weight');
    }
}

/* End of file Model_user.php */
