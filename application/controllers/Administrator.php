<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array());
    }


    public function index()
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            $view['title'] = 'Home';
            $view['pageName'] = 'home';
            $view['active_dashboard'] = 'active';

            $view['getListData'] = $this->Model_user->getListData();

            $this->load->view('index', $view);
        }
    }

    function user($param = '', $id = '')
    {
        if (empty($param)) {
            $view['title'] = 'User';
            $view['pageName'] = 'user';
            $view['active_user'] = 'active';
            $view['listUser'] = $this->Model_user->getData();
            $view['listUserRole'] = $this->Model_user_role->getData();
            $this->load->view('index', $view);
        } else if ($param == 'getAllData') {
            $dt = $this->Model_user->getAllData();
            $start = $this->input->post('start');
            $data = array();
            foreach ($dt['data'] as $row) {
                $userid     = ($row->userid);
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = '<div class="text-left">' . $row->full_name . '</div>';
                $th3    = '<div class="text-center">' . $row->nick_name . '</div>';
                $th4    = '<div class="text-center">' . $row->initial . '</div>';
                $th5    = '<div class="text-center">' . $row->NIP . '</div>';
                $th6    = '<div class="text-center">' . $row->email . '</div>';
                $th7    = '<div class="text-center">' . $row->address . '</div>';
                $th8    = '<div class="text-center">' . $row->phone_number . '</div>';
                // $th9    = '<div class="text-center">' . $row->picture . '</div>';
                $th9   = '<div class="text-center" style="width:100px;">' . (get_btn_group1('update_user(' . $userid . ')', 'delete_user(' . $userid . ')')) . '</div>';
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8, $th9));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'insert') {
            $this->form_validation->set_rules("full_name", "Full Name", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("nick_name", "Nick Name", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("initial", "Initial", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("NIP", "NIP", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("email", "Email", "trim|required", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed!'));
            $this->form_validation->set_rules("address", "Address", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("phone_number", "Phone Number", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));

            $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">* ', '</h6>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data is not right, please check again.');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $data = array(
                    'full_name'          => htmlspecialchars($this->input->post('full_name')),
                    'nick_name'          => htmlspecialchars($this->input->post('nick_name')),
                    'initial'            => htmlspecialchars($this->input->post('initial')),
                    'NIP'                => htmlspecialchars($this->input->post('NIP')),
                    'email'              => htmlspecialchars($this->input->post('email')),
                    'address'            => htmlspecialchars($this->input->post('address')),
                    'phone_number'       => htmlspecialchars($this->input->post('phone_number')),
                );
                $result['messages'] = '';
                $result = array('status' => 'success', 'msg' => 'Data Inserted!');
                $this->Model_user->addData($data);
                // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Add data Tracer Study Program Study', $this->session->userdata('id')));
            }

            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'getById') {
            $data = $this->Model_user->getById($id);
            echo json_encode(array('data' => $data));
            die;
        } else if ($param == 'update') {
            $this->form_validation->set_rules("full_name", "Full Name", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("nick_name", "Nick Name", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("initial", "Initial", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("NIP", "NIP", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("email", "Email", "trim|required", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed!'));
            $this->form_validation->set_rules("address", "Address", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));
            $this->form_validation->set_rules("phone_number", "Phone Number", "trim|required|alpha_numeric_spaces", array('required' => '{field} cannot be null !', 'alpha_numeric_spaces' => 'Character not allowed !'));

            $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $aidi = $this->input->post('userid');
                $data = array(
                    'full_name'          => htmlspecialchars($this->input->post('full_name')),
                    'nick_name'          => htmlspecialchars($this->input->post('nick_name')),
                    'initial'            => htmlspecialchars($this->input->post('initial')),
                    'NIP'                => htmlspecialchars($this->input->post('NIP')),
                    'email'              => htmlspecialchars($this->input->post('email')),
                    'address'            => htmlspecialchars($this->input->post('address')),
                    'phone_number'       => htmlspecialchars($this->input->post('phone_number')),
                );
                $result['messages']    = '';
                $result        = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                $this->Model_user->update($aidi, $data);
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'delete') {
            $this->Model_user->delete($id);
            $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
            echo json_encode(array('result' => $result));
            die;
        }
    }

    function userLogin($param = '', $id = '')
    {
        if (empty($param)) {
            $view['listUser'] = $this->Model_user->getData();
            $this->load->view('index', $view);
        } else if ($param == 'getAllData') {
            $dt = $this->Model_user_login->getAllData();
            $start = $this->input->post('start');
            $data = array();
            foreach ($dt['data'] as $row) {
                $user_login_id     = $row->user_login_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = '<div class="text-left">' . $row->full_name . '</div>';
                $th3    = '<div class="text-center">' . $row->nick_name . '</div>';
                $th4    = '<div class="text-center">' . $row->initial . '</div>';
                $th5    = '<div class="text-center">' . $row->NIP . '</div>';
                $th6    = '<div class="text-center">' . $row->email . '</div>';
                $th7    = '<div class="text-center">' . $row->address . '</div>';
                $th8    = '<div class="text-center">' . $row->phone_number . '</div>';
                $th9    = '<div class="text-center">' . $row->username . '</div>';
                $th10    = '<div class="text-center">' . $row->role . '</div>';
                $th11    = '<div class="text-center">' . $row->block_status . '</div>';
                $th12   = '<div class="text-center" style="width:100px;">' . (get_btn_group1('update_user_login(' . $user_login_id . ')', 'delete_user_login(' . $user_login_id . ')')) . '</div>';
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8, $th9, $th10, $th11, $th12));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'insert') {
            $this->form_validation->set_rules("userid", "Pilih Pengguna", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("username", "Username", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("password", "Password", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("user_role_id", "Pilih Role", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("block_status", "Status Blokir", "trim|required", array('required' => '{field} cannot be null !'));

            $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">* ', '</h6>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data is not right, please check again.');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $password = md5(htmlspecialchars($this->input->post('password')));
                $data = array(
                    'userid'           => htmlspecialchars($this->input->post('userid')),
                    'username'         => htmlspecialchars($this->input->post('username')),
                    'password'         => $password,
                    'user_role_id'     => htmlspecialchars($this->input->post('user_role_id')),
                    'block_status'     => htmlspecialchars($this->input->post('block_status')),
                );
                $result['messages'] = '';
                $result = array('status' => 'success', 'msg' => 'Data Inserted!');
                $this->Model_user_login->addData($data);
                // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Add data Tracer Study Program Study', $this->session->userdata('id')));
            }

            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'getById') {
            $data = $this->Model_user_login->getById($id);
            echo json_encode(array('data' => $data));
            die;
        } else if ($param == 'update') {
            $this->form_validation->set_rules("userid", "Pilih Pengguna", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("username", "Username", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("password", "Password", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("user_role_id", "Pilih Role", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("block_status", "Status Blokir", "trim|required", array('required' => '{field} cannot be null !'));

            $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $aidi = $this->input->post('user_login_id');
                $password = md5(htmlspecialchars($this->input->post('password')));

                $data = array(
                    'userid'           => htmlspecialchars($this->input->post('userid')),
                    'username'         => htmlspecialchars($this->input->post('username')),
                    'password'         => $password,
                    'user_role_id'     => htmlspecialchars($this->input->post('user_role_id')),
                    'block_status'     => htmlspecialchars($this->input->post('block_status')),
                );
                $result['messages']    = '';
                $this->Model_user_login->update($aidi, $data);
                $result        = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'delete') {
            $this->Model_user_login->delete($id);
            $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
            echo json_encode($result);
            die;
        }
    }

    function userRole($param = '', $id = '')
    {
        if (empty($param)) {
        } else if ($param == 'getAllData') {
            $dt = $this->Model_user_role->getAllData();
            $start = $this->input->post('start');
            $data = array();
            foreach ($dt['data'] as $row) {
                $user_role_id     = $row->user_role_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = '<div class="text-left">' . $row->role . '</div>';
                $th3    = '<div class="text-center">' . $row->description . '</div>';
                if ($row->role == 'sys_manager') {
                    $th4   = '<div class="text-center" style="width:100px;"> </div>';
                } else {
                    $th4   = '<div class="text-center" style="width:100px;">' . get_btn_group1('update_user_role(' . $user_role_id . ')', 'delete_user_role(' . $user_role_id . ')') . '</div>';
                }
                $data[] = gathered_data(array($th1, $th2, $th3, $th4));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'insert') {
            $this->form_validation->set_rules("role", "Role", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("description", "Description", "trim|required", array('required' => '{field} cannot be null !'));

            $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">* ', '</h6>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data is not right, please check again.');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $data = array(
                    'role'                => htmlspecialchars($this->input->post('role')),
                    'description'                => htmlspecialchars($this->input->post('description')),

                );
                $result['messages'] = '';
                $result = array('status' => 'success', 'msg' => 'Data Inserted!');
                $this->Model_user_role->addData($data);
                // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Add data Tracer Study Program Study', $this->session->userdata('id')));
            }

            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'getById') {
            $data = $this->Model_user_role->getById($id);
            echo json_encode(array('data' => $data));
            die;
        } else if ($param == 'update') {
            $this->form_validation->set_rules("role", "Full Name", "trim|required", array('required' => '{field} cannot be null !'));
            $this->form_validation->set_rules("description", "Nick Name", "trim|required", array('required' => '{field} cannot be null !'));

            $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $aidi = $this->input->post('user_role_id');
                $data = array(
                    'role'          => htmlspecialchars($this->input->post('role')),
                    'description'   => htmlspecialchars($this->input->post('description'))
                );
                $result['messages']    = '';
                $this->Model_user_role->update($aidi, $data);
                $result        = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'delete') {
            $this->Model_user_role->delete($id);
            $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
            echo json_encode($result);
            die;
        }
    }

    function employee($param = '', $id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Home';
                $view['pageName'] = 'employee';
                $view['active_employee'] = 'active';

                // $view['getListData'] = $this->Model_employee->getListData();

                $this->load->view('index', $view);
            } else if ($param == 'getAllData') {
                $dt                 = $this->Model_employee->getAllData();
                $start              = $this->input->post('start');
                $data               = array();
                foreach ($dt['data'] as $row) {
                    $id             = encrypt($row->id);
                    $th1            = '<center>' . ++$start . '</center>';
                    $th2            = $row->e_name;
                    $th3            = $row->e_phone;
                    $th4            = $row->e_address;
                    $th5            = $row->e_email;
                    $th6            = '<center>' . get_btn_group1('updateEmployee("' . $id . '")', 'deleteEmployee("' . $id . '")') . '<button class="btn btn-primary btn-sm"> Set to User Login</button>' . '</center>';
                    $data[]         = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'insert') {
                $this->form_validation->set_rules("e_name", "Name", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_phone", "Phone Number", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_address", "Address", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_email", "Email", "trim|required|xss_clean|valid_email", array('valid_email' => 'email is not valid !', 'required' => '{field} tidak boleh kosong !'));

                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['e_name']     = htmlspecialchars($this->input->post('e_name'));
                    $data['e_phone']     = htmlspecialchars($this->input->post('e_phone'));
                    $data['e_address']     = htmlspecialchars($this->input->post('e_address'));
                    $data['e_email']     = htmlspecialchars($this->input->post('e_email'));
                    $result['messages']     = '';
                    $result                 = array('status' => 'success', 'msg' => 'Data berhasil ditambahkan');
                    $this->Model_employee->addData($data);
                    // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Menambahkan data jenis Kerja Sama dengan nama ' . $data['jenis_nama'], $this->session->userdata('id')));
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $decrypt_id = decrypt($id);
                $data = $this->Model_employee->getById($decrypt_id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("e_name", "Name", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_phone", "Phone Number", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_address", "Address", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("e_email", "Email", "trim|required|xss_clean|valid_email", array('valid_email' => 'email is not valid !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $aidi = $this->input->post('id');
                    $data['e_name']     = htmlspecialchars($this->input->post('e_name'));
                    $data['e_phone']     = htmlspecialchars($this->input->post('e_phone'));
                    $data['e_address']     = htmlspecialchars($this->input->post('e_address'));
                    $data['e_email']     = htmlspecialchars($this->input->post('e_email'));
                    $result['messages'] = '';
                    $result = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Model_employee->update($aidi, $data);
                    // $this->B_user_log_model->addLog(userLog('Ubah Data', $this->session->userdata('first_name') . ' Melakukan perubahan pada data Jenis Kerja Sama yang memiliki id = ' . $jenis_id, $this->session->userdata('id')));
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_employee->delete($decrypt_id);
                echo json_encode(array("status" => 'success', 'msg' => 'Data Berhasil dihapus !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            } else if ($param == 'export') {
                $data = array(
                    'title'                     => 'Report Jenis Kerja Sama',
                    'active_kerjasama'          => 'active open',
                    'active_jenis_kerja_sama'         => 'active open',
                    'page_breadcrumb'           => generate_breadcrumb(array('Jenis Kerja Sama', 'Report Jenis Kerja Sama')),
                    'report_jenis_kerjasama'    => $this->B_jenis_mou_model->getAllDataJenisMou(),
                    // Bagian navbar
                    'get_picture'               => $this->session->userdata('picture'),
                    'get_name'                  => $this->session->userdata('first_name'),
                    'array_notif'               => $this->B_notif_model->get_all_notif(),
                    'count_notif'               => $this->B_notif_model->count_new_notif()
                );
                $this->load->view('elements/header', $data);
                $this->load->view('page_export_data/V_Export_jenis_kerjasama');
                $this->load->view('elements/footer');
            }
        }
    }

    function criteria($param = '', $id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Home';
                $view['pageName'] = 'criteria';
                $view['active_criteria'] = 'active';

                // $view['getListData'] = $this->Model_employee->getListData();

                $this->load->view('index', $view);
            } else if ($param == 'getAllData') {
                $dt                 = $this->Model_criteria->getAllData();
                $start              = $this->input->post('start');
                $data               = array();
                foreach ($dt['data'] as $row) {
                    $id             = encrypt($row->id);
                    $th1            = '<center>' . ++$start . '</center>';
                    $th2            = $row->criteria_code;
                    $th3            = $row->criteria_detail;
                    $th4            = '<center>' . get_btn_group1('updateCriteria("' . $id . '")', 'deleteCriteria("' . $id . '")') . '</center>';
                    $data[]         = gathered_data(array($th1, $th2, $th3, $th4));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'insert') {
                $this->form_validation->set_rules("criteria_code", "Criteria Code", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("criteria_detail", "Criteria Detail", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));

                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['criteria_code']     = htmlspecialchars($this->input->post('criteria_code'));
                    $data['criteria_detail']     = htmlspecialchars($this->input->post('criteria_detail'));
                    $result['messages']     = '';
                    $result                 = array('status' => 'success', 'msg' => 'Data berhasil ditambahkan');
                    $this->Model_criteria->addData($data);
                    // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Menambahkan data jenis Kerja Sama dengan nama ' . $data['jenis_nama'], $this->session->userdata('id')));
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $decrypt_id = decrypt($id);
                $data = $this->Model_criteria->getById($decrypt_id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("criteria_code", "Criteria Code", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_rules("criteria_detail", "Criteria Detail", "trim|required|xss_clean|alpha_numeric_spaces", array('alpha_numeric_spaces' => 'Karakter simbol tidak diizinkan !', 'required' => '{field} tidak boleh kosong !'));
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $aidi = $this->input->post('id');
                    $data['criteria_code']     = htmlspecialchars($this->input->post('criteria_code'));
                    $data['criteria_detail']     = htmlspecialchars($this->input->post('criteria_detail'));
                    $result['messages'] = '';
                    $result = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Model_criteria->update($aidi, $data);
                    // $this->B_user_log_model->addLog(userLog('Ubah Data', $this->session->userdata('first_name') . ' Melakukan perubahan pada data Jenis Kerja Sama yang memiliki id = ' . $jenis_id, $this->session->userdata('id')));
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_criteria->delete($decrypt_id);
                echo json_encode(array("status" => 'success', 'msg' => 'Data Berhasil dihapus !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            } else if ($param == 'export') {
                $data = array(
                    'title'                     => 'Report Jenis Kerja Sama',
                    'active_kerjasama'          => 'active open',
                    'active_jenis_kerja_sama'         => 'active open',
                    'page_breadcrumb'           => generate_breadcrumb(array('Jenis Kerja Sama', 'Report Jenis Kerja Sama')),
                    'report_jenis_kerjasama'    => $this->B_jenis_mou_model->getAllDataJenisMou(),
                    // Bagian navbar
                    'get_picture'               => $this->session->userdata('picture'),
                    'get_name'                  => $this->session->userdata('first_name'),
                    'array_notif'               => $this->B_notif_model->get_all_notif(),
                    'count_notif'               => $this->B_notif_model->count_new_notif()
                );
                $this->load->view('elements/header', $data);
                $this->load->view('page_export_data/V_Export_jenis_kerjasama');
                $this->load->view('elements/footer');
            }
        }
    }

    function weight($param = '', $id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Weight';
                $view['pageName'] = 'weight';
                $view['active_weight'] = 'active';
                $view['getCriteria'] = $this->Model_criteria->getData();

                // $view['getListData'] = $this->Model_employee->getListData();

                $this->load->view('index', $view);
            } else if ($param == 'getAllData') {
                $dt                 = $this->Model_weight->getAllData();
                $start              = $this->input->post('start');
                $data               = array();
                foreach ($dt['data'] as $row) {
                    $id             = encrypt($row->weight_id);
                    $th1            = '<center>' . ++$start . '</center>';
                    $th2            = $row->criteria_code;
                    $th3            = $row->weight_value;
                    $th4            = '<center>' . get_btn_group1('updateWeight("' . $id . '")', 'deleteWeight("' . $id . '")') . '</center>';
                    $data[]         = gathered_data(array($th1, $th2, $th3, $th4));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'insert') {
                $this->form_validation->set_rules("criteria_id", "Criteria", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                $this->form_validation->set_rules("weight_value", "Weight Value", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));

                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getWeightVal = htmlspecialchars($this->input->post('weight_value'));
                    $numberToDecimals = ($getWeightVal / 100);
                    $data['criteria_id']     = $this->input->post('criteria_id');
                    $data['weight_value']     = $numberToDecimals;
                    $result['messages']     = '';
                    $result                 = array('status' => 'success', 'msg' => 'Success !');
                    $this->Model_weight->addData($data);
                    // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Menambahkan data jenis Kerja Sama dengan nama ' . $data['jenis_nama'], $this->session->userdata('id')));
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $decrypt_id = decrypt($id);
                $data = $this->Model_weight->getById($decrypt_id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("criteria_id", "Criteria", "trim|required|xss_clean", array('required' => '{field} Cannot Empty !'));
                $this->form_validation->set_rules("weight_value", "Weight Value", "trim|required|xss_clean", array('required' => '{field} Cannot Empty !'));
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $aidi = $this->input->post('weight_id');
                    $getWeightVal = htmlspecialchars($this->input->post('weight_value'));
                    $numberToDecimals = ($getWeightVal / 100);
                    $data['criteria_id']     = htmlspecialchars($this->input->post('criteria_id'));
                    $data['weight_value']     = htmlspecialchars($this->input->post('weight_value'));
                    $result['messages'] = '';
                    $result = array('status' => 'success', 'msg' => 'Update success !');
                    $this->Model_weight->update($aidi, $data);
                    // $this->B_user_log_model->addLog(userLog('Ubah Data', $this->session->userdata('first_name') . ' Melakukan perubahan pada data Jenis Kerja Sama yang memiliki id = ' . $jenis_id, $this->session->userdata('id')));
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_weight->delete($decrypt_id);
                echo json_encode(array("status" => 'success', 'msg' => 'Delete Success !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            } else if ($param == 'export') {
            }
        }
    }

    function matrixCalculation($param = '', $id = '', $criteria_id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        $criteria = $this->Model_criteria->getData();

        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Matrix Calculation';
                $view['pageName'] = 'matrixCalculation';
                $view['active_matrixCalculation'] = 'active';
                $view['getMaxMin'] = $this->Model_matrix_calculation->getMaxMin();
                $view['getCriteria'] = $this->Model_criteria->getData();
                $view['getCriteriaJoin'] = $this->Model_matrix_calculation->getJoinData();
                $view['getEmployee'] = $this->Model_employee->getData();

                $this->load->view('index', $view);
            } else if ($param == 'insert') {
                $this->form_validation->set_rules("employee_id", "Employee", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                foreach ($criteria as $b) {
                    $this->form_validation->set_rules("value[" . $b->criteria_code . "]", "Value " . $b->criteria_code, "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                }
                $this->form_validation->set_error_delimiters('<h6 id="text-error" style="color:red;" class="help-block help-block-error">*', '</h6>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'All data are required!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    foreach ($criteria as $bar) {
                        $data['employee_id']     = htmlspecialchars($this->input->post('employee_id'));
                        $data['criteria_id']     = htmlspecialchars($this->input->post('criteria_id[' . $bar->criteria_code . ']'));
                        $data['value']     = htmlspecialchars($this->input->post('value[' . $bar->criteria_code . ']'));
                        $result['messages']     = '';
                        $this->Model_matrix_calculation->addData($data);
                        $result                 = array('status' => 'success', 'msg' => 'Success !');
                    }
                    // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Menambahkan data jenis Kerja Sama dengan nama ' . $data['jenis_nama'], $this->session->userdata('id')));
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->Model_matrix_calculation->getById($id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );

                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getByEmpIdCritId') {
                $data = $this->Model_matrix_calculation->getByEmployeeIdCriteriaId($id, $criteria_id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );

                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("employee_id", "Employee", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                $this->form_validation->set_rules("value", "Value ", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $employee_id = $this->input->post('employee_id');
                    $criteria_id     = htmlspecialchars($this->input->post('criteria_id'));
                    $data['value']     = htmlspecialchars($this->input->post('value'));
                    $result['messages']     = '';
                    $this->Model_matrix_calculation->update($employee_id, $criteria_id, $data);
                    $result                 = array('status' => 'success', 'msg' => 'Success !');
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_matrix_calculation->delete($id);
                echo json_encode(array("status" => 'success', 'msg' => 'Delete Success !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            }
        }
    }


    function normalization($param = '', $id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        $criteria = $this->Model_criteria->getData();

        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Normalization';
                $view['pageName'] = 'normalization';
                $view['active_normalization'] = 'active';
                $view['getMaxMin'] = $this->Model_matrix_calculation->getMaxMin();
                $view['getCriteria'] = $this->Model_criteria->getData();
                $view['getCriteriaJoin'] = $this->Model_matrix_calculation->getJoinData();
                $view['getEmployee'] = $this->Model_employee->getData();
                $this->load->view('index', $view);
            } else if ($param == 'insertNormalization') {

                $showData = $this->db->query('select distinct a.employee_id, b.e_name from calc_criteria_employee a inner join employee b on b.id = a.employee_id');
                foreach ($showData->result() as $baris) {
                    $getValue = $this->db->query('select criteria_id,value from calc_criteria_employee where employee_id = "' . $baris->employee_id . '"');
                    foreach ($criteria as $c) {
                        $query_value = $this->db->query('select value from calc_criteria_employee where criteria_id = "' . $c->id . '" and employee_id="' . $baris->employee_id . '" group by criteria_id')->row();
                        $queryMax = $this->db->query('select max(value) as max_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row();
                        $queryMin = $this->db->query('select min(value) as min_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row();
                        $maxVal_value = ($queryMax->max_val - $query_value->value);
                        $maxVal_minVal = ($queryMax->max_val - $queryMin->min_val);

                        $divMaxVal_divMaxMinVal = '';
                        if ($maxVal_minVal == 0) {
                            $divMaxVal_divMaxMinVal = 'NaN';
                        } else {
                            $divMaxVal_divMaxMinVal = ($maxVal_value / $maxVal_minVal);
                        }
                        $data['employee_id'] = $baris->employee_id;
                        $data['criteria_id'] = $c->id;
                        $data['value'] = $divMaxVal_divMaxMinVal;
                        $querquery = $this->db->query('select employee_id from calc_normalization where employee_id = "' . $baris->employee_id . '" and criteria_id ="' . $c->id . '"')->num_rows();
                        if ($querquery != 0) {
                            $this->Model_normalization->updateNormalization($baris->employee_id, $c->id, $data);
                        } else {
                            $this->Model_normalization->addNormalization($data);
                        }
                    }
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('csrf' => $new_csrf));
                die;
            } else if ($param == 'insertWeightNormalization') {

                $showData = $this->db->query('select distinct a.employee_id, b.e_name from calc_criteria_employee a inner join employee b on b.id = a.employee_id');
                foreach ($showData->result() as $baris) {
                    $getValue = $this->db->query('select criteria_id,value from calc_criteria_employee where employee_id = "' . $baris->employee_id . '"');
                    foreach ($criteria as $c) {
                        $query_value = $this->db->query('select value from calc_criteria_employee where criteria_id = "' . $c->id . '" and employee_id="' . $baris->employee_id . '" group by criteria_id')->row();
                        $weight = $this->db->query('select weight_value from weight where criteria_id = "' . $c->id . '" group by criteria_id')->row();
                        $queryMax = $this->db->query('select max(value) as max_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row();
                        $queryMin = $this->db->query('select min(value) as min_val from calc_criteria_employee where criteria_id = "' . $c->id . '" group by criteria_id')->row();
                        $maxVal_value = ($queryMax->max_val - $query_value->value);
                        $maxVal_minVal = ($queryMax->max_val - $queryMin->min_val);

                        $divMaxVal_divMaxMinVal = '';
                        if ($maxVal_minVal == 0) {
                            $divMaxVal_divMaxMinVal = 'NaN';
                        } else {
                            $divMaxVal_divMaxMinVal = ($maxVal_value / $maxVal_minVal);
                        }
                        $data['employee_id'] = $baris->employee_id;
                        $data['criteria_id'] = $c->id;
                        $data['value'] = ($weight->weight_value * $divMaxVal_divMaxMinVal);
                        $querquery = $this->db->query('select employee_id from calc_normalization where employee_id = "' . $baris->employee_id . '" and criteria_id ="' . $c->id . '"')->num_rows();
                        if ($querquery != 0) {
                            $result['messages']     = '';
                            $this->Model_normalization->updateWeightNormalization($baris->employee_id, $c->id, $data);
                            $result                 = array('status' => 'warning', 'msg' => 'Success, Some data updated !');
                        } else {
                            $result['messages']     = '';
                            $this->Model_normalization->addWeightNormalization($data);
                            $result                 = array('status' => 'success', 'msg' => ' Processed !');
                        }
                    }
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'insertSum') {

                $showData = $this->db->query('SELECT a.employee_id, b.e_name, SUM(a.VALUE) AS sum_val FROM calc_weight_normalization a 
                inner join employee b on b.id = a.employee_id 
                GROUP BY employee_id');
                foreach ($showData->result() as $baris) {

                    $data['employee_id'] = $baris->employee_id;
                    $data['value'] = $baris->sum_val;
                    $querquery = $this->db->query('select employee_id from calc_total_weight_normalization where employee_id = "' . $baris->employee_id . '"')->num_rows();
                    if ($querquery != 0) {
                        $this->Model_normalization->updateSum($baris->employee_id,  $data);
                    } else {
                        $this->Model_normalization->addSum($data);
                    }
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('csrf' => $new_csrf));
                die;
            } else if ($param == 'insertMax') {

                $showData = $this->db->query('SELECT  a.employee_id,  b.e_name, max(a.VALUE) AS max_val FROM calc_weight_normalization a 
                inner join employee b on b.id = a.employee_id 
                GROUP BY employee_id');
                foreach ($showData->result() as $baris) {

                    $data['employee_id'] = $baris->employee_id;
                    $data['value'] = $baris->max_val;
                    $querquery = $this->db->query('select employee_id from calc_max_weight_normalization where employee_id = "' . $baris->employee_id . '"')->num_rows();
                    if ($querquery != 0) {
                        $this->Model_normalization->updateMax($baris->employee_id,  $data);
                    } else {
                        $this->Model_normalization->addMax($data);
                    }
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->Model_matrix_calculation->getById($id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("employee_id", "Employee", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                foreach ($criteria as $b) {
                    $this->form_validation->set_rules("value[" . $b->criteria_code . "]", "Value " . $b->criteria_code, "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                }
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    foreach ($criteria as $bar) {
                        $employee_id = $this->input->post('employee_id');
                        $criteria_id     = htmlspecialchars($this->input->post('criteria_id[' . $bar->criteria_code . ']'));
                        $data['value']     = htmlspecialchars($this->input->post('value[' . $bar->criteria_code . ']'));
                        $result['messages']     = '';
                        $this->Model_matrix_calculation->update($employee_id, $criteria_id, $data);
                        $result                 = array('status' => 'success', 'msg' => 'Success !');
                    }
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_matrix_calculation->delete($id);
                echo json_encode(array("status" => 'success', 'msg' => 'Delete Success !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            }
        }
    }

    function result($param = '', $id = '')
    {
        $userOnById = $this->Model_user_login->getOnlineUserById($this->session->userdata('id'));
        $temp = $this->Model_user_login->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else {
            #code..
            if (empty($param)) {
                $view['title'] = 'Weight';
                $view['pageName'] = 'result';
                $view['active_weight'] = 'active';
                $view['getCriteria'] = $this->Model_criteria->getData();

                // $view['getListData'] = $this->Model_employee->getListData();

                $this->load->view('index', $view);
            } else if ($param == 'getAllData') {
                $dt                 = $this->Model_weight->getAllData();
                $start              = $this->input->post('start');
                $data               = array();
                foreach ($dt['data'] as $row) {
                    $id             = encrypt($row->weight_id);
                    $th1            = '<center>' . ++$start . '</center>';
                    $th2            = $row->criteria_code;
                    $th3            = $row->weight_value;
                    $th4            = '<center>' . get_btn_group1('updateWeight("' . $id . '")', 'deleteWeight("' . $id . '")') . '</center>';
                    $data[]         = gathered_data(array($th1, $th2, $th3, $th4));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'insert') {
                $this->form_validation->set_rules("criteria_id", "Criteria", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));
                $this->form_validation->set_rules("weight_value", "Weight Value", "trim|required|xss_clean|alpha_numeric_spaces", array('required' => '{field} Cannot empty !', 'alpha_numeric_spaces' => '{field} must in number format/cannot decimal value. Ex 10'));

                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getWeightVal = htmlspecialchars($this->input->post('weight_value'));
                    $numberToDecimals = ($getWeightVal / 100);
                    $data['criteria_id']     = $this->input->post('criteria_id');
                    $data['weight_value']     = $numberToDecimals;
                    $result['messages']     = '';
                    $result                 = array('status' => 'success', 'msg' => 'Success !');
                    $this->Model_weight->addData($data);
                    // $this->B_user_log_model->addLog(userLog('Add Data', $this->session->userdata('first_name') . ' Menambahkan data jenis Kerja Sama dengan nama ' . $data['jenis_nama'], $this->session->userdata('id')));
                }
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'getById') {
                $decrypt_id = decrypt($id);
                $data = $this->Model_weight->getById($decrypt_id);
                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('data' => $data, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("criteria_id", "Criteria", "trim|required|xss_clean", array('required' => '{field} Cannot Empty !'));
                $this->form_validation->set_rules("weight_value", "Weight Value", "trim|required|xss_clean", array('required' => '{field} Cannot Empty !'));
                $this->form_validation->set_error_delimiters('<h6 id="text-error" class="help-block help-block-error">*', '</h6>');

                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data is not correct !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $aidi = $this->input->post('weight_id');
                    $getWeightVal = htmlspecialchars($this->input->post('weight_value'));
                    $numberToDecimals = ($getWeightVal / 100);
                    $data['criteria_id']     = htmlspecialchars($this->input->post('criteria_id'));
                    $data['weight_value']     = htmlspecialchars($this->input->post('weight_value'));
                    $result['messages'] = '';
                    $result = array('status' => 'success', 'msg' => 'Update success !');
                    $this->Model_weight->update($aidi, $data);
                    // $this->B_user_log_model->addLog(userLog('Ubah Data', $this->session->userdata('first_name') . ' Melakukan perubahan pada data Jenis Kerja Sama yang memiliki id = ' . $jenis_id, $this->session->userdata('id')));
                }

                $new_csrf = array(
                    'token_hash' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $new_csrf));
                die;
            } else if ($param == 'delete') {
                $decrypt_id = decrypt($id);
                $this->Model_weight->delete($decrypt_id);
                echo json_encode(array("status" => 'success', 'msg' => 'Delete Success !'));
                // $cek_id = $this->B_mou_model->get_by_jenis_id($decrypt_id);
                // if (!$cek_id) {

                // $this->B_user_log_model->addLog(userLog('Hapus Data', $this->session->userdata('first_name') . ' Melakukan hapus data Jenis Kerja Sama yang memiliki id = ' . $decrypt_id, $this->session->userdata('id')));

                // } else {
                //     echo json_encode(array("status" => 'error', 'msg' => "Can not delete this item, It's being used !"));
                // }
            } else if ($param == 'export') {
            }
        }
    }
}

/* End of file Administrator.php */
