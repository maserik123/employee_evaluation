<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_normalization extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('calc_normalization');
        return $this->db->get()->result();
    }


    function getAllData()
    {
        $this->datatables->select('id, criteria_code, criteria_detail, crt_date');
        $this->datatables->from('calc_normalization');
        return $this->datatables->generate();
    }

    function addNormalization($data)
    {
        $this->db->insert('calc_normalization', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function addData($data)
    {
        $this->db->insert('calc_normalization', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('calc_normalization');
        $this->db->where('employee_id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from calc_normalization where employee_id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('calc_normalization ap', array('ap.id' => $id))->result();
    }

    function updateNormalization($employee_id, $criteria_id, $data)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('criteria_id', $criteria_id);
        $this->db->update('calc_normalization', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('employee_id', $id);
        $this->db->delete('calc_normalization');
    }
}

/* End of file Model_user.php */
