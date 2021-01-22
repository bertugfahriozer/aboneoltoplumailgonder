<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model', 'common');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function aboneol()
	{
		if ($this->input->method() == 'post') {
			$this->load->library('form_validation');
			$config = [
				['field' => 'email',
					'label' => 'email',
					'rules' => 'trim|required|valid_email'],
			];
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {
				print_r(validation_errors('<p>', '</p>'));
			} else {
				$this->load->helper('common');
				if ($this->common->create('aboneler', ['mailaddress' => $this->input->post('email', true), 'isActive' => 1, 'token' => userActCode()]))
					echo 'başarılı';
				else
					echo 'vt işlenemedi.';
			}
		}
	}

	public function abonecikar($token)
	{
		if (!empty($token) && $this->common->isHave('aboneler', ['token' => $token, 'isActive' => 1]) == 1 && $this->common->edit('aboneler', ['isActive' => 0], ['token' => $token])) {
			echo 'abonelikten çıkarıldı.';
		} else
			echo 'abonelikten çıkarılmadın.';
	}

	public function tekraraboneol($token)
	{
		if (!empty($token) && $this->common->isHave('aboneler', ['token' => $token, 'isActive' => 0]) == 1 && $this->common->edit('aboneler', ['isActive' => 1], ['token' => $token])) {
			echo 'tekrar abone olundu.';
		} else
			echo 'abone olunamadı.';
	}

	public function mailList()
	{
		$data = ['mails' => $this->common->lists(['isActive' => 1], 'aboneler')];
		$this->load->view('mail_list', $data);
	}

	public function mailsend()
	{
		if ($this->input->method() == 'post') {
			$this->load->library('Mailsender');
			$this->mailsender->sendmail($this->input->post('mails',true));
		}
	}
}
