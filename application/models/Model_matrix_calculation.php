<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_matrix_calculation extends CI_Model
{
    function getData()
    {
        $this->db->select('*');
        $this->db->from('calc_criteria_employee');
        return $this->db->get()->result();
    }

    function getJoinData()
    {
        $this->db->select('a.id, a.employee_id, a.criteria_id, a.value, b.criteria_code, c.e_name,c.e_phone');
        $this->db->from('calc_criteria_employee a');
        $this->db->join('criteria b', 'b.id = a.criteria_id', 'left');
        $this->db->join('employee c', 'c.id = a.employee_id', 'left');
        return $this->db->get()->result();
    }

    function getMaxMin()
    {
        $query = $this->db->query('SELECT MAX(VALUE) AS max_val, MIN(VALUE) AS min_val FROM calc_criteria_employee GROUP BY criteria_id')->result();
        return $query;
    }

    function getAllData()
    {
        $this->datatables->select('id, criteria_code, criteria_detail, crt_date');
        $this->datatables->from('calc_criteria_employee');
        return $this->datatables->generate();
    }

    function addData($data)
    {
        $this->db->insert('calc_criteria_employee', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getById($id)
    {
        $this->db->from('calc_criteria_employee');
        $this->db->where('employee_id', $id);
        return $this->db->get()->row();
    }

    public function getDataById($id)
    {
        $query = $this->db->query('select * from calc_criteria_employee where employee_id =' . $id);
        return $query->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('calc_criteria_employee ap', array('ap.id' => $id))->result();
    }

    function update($employee_id, $criteria_id, $data)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('criteria_id', $criteria_id);
        $this->db->update('calc_criteria_employee', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('employee_id', $id);
        $this->db->delete('calc_criteria_employee');
    }
}

/* End of file Model_user.php */
