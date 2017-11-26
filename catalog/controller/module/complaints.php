<?php
class ControllerModulecomplaints extends Controller {

	private $error = array();

	public function index() {
		$this->language->load('module/complaints');

		$data['complaints_title'] = $this->language->get('complaints_title');
		$data['entry_complaints'] = $this->language->get('entry_complaints');
		$data['text_description'] = $this->language->get('text_description');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_submit'] = $this->language->get('entry_submit');
		$data['text_success'] = $this->language->get('text_success');
		$data['error_email'] = $this->language->get('error_email');

		$data['entry_author_name'] = $this->language->get('entry_author_name');
		$data['entry_author_mail'] = $this->language->get('entry_author_mail');
		$data['entry_faq'] = $this->language->get('entry_faq');

		$data['text_faq'] = $this->language->get('text_faq');
		$data['text_info'] = $this->language->get('text_info');
		$data['text_success'] = $this->language->get('text_success');

		$this->load->model('fido/complaints');

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
			$this->model_fido_complaints->addFaq($this->request->post);
			$this->session->data['success'] = true;
			$this->response->redirect($this->url->link('information/information', 'information_id=18', 'SSL'));
		}

		$data['error_author_name'] = '';
		if (isset($this->error['author_name']))
			$data['error_author_name'] = $this->error['author_name'];

		$data['error_author_email'] = '';
		if (isset($this->error['author_mail']))
			$data['error_author_email'] = $this->error['author_mail'];

		$data['error_title'] = '';
		if (isset($this->error['title']))
			$data['error_title'] = $this->error['title'];

		$data['success'] = false;
		if (isset($this->session->data['success'])){
			$data['success'] = true;
			unset($this->session->data['success']);
		}

		if (isset($this->request->post['author_name']))
			$data['author_name'] = $this->request->post['author_name'];
		else
			$data['author_name'] = $this->customer->getFirstName();

		if (isset($this->request->post['author_mail']))
			$data['author_mail'] = $this->request->post['author_mail'];
		else
			$data['author_mail'] = $this->customer->getEmail();

		$data['title'] = '';
		if (isset($this->request->post['title']))
			$data['title'] = $this->request->post['title'];

		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}

		if (isset($this->request->get['topic'])) {
			$parts = explode('_', (string)$this->request->get['topic']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['topic_id'] = $parts[0];
		} else {
			$data['topic_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$data['faqs'] = array();

		$faqs = $this->model_fido_complaints->getTopics(0);

		foreach ($faqs as $faq) {
			$children_data = array();

			$children = $this->model_fido_complaints->getTopics($faq['faq_id']);

			foreach ($children as $child) {
				$data = array(
					'filter_faq_id'  => $child['faq_id'],
					'filter_sub_faq' => true
				);

				$children_data[] = array(
					'faq_id'      => $child['faq_id'],
					'title'       => strip_tags(html_entity_decode($child['title'], ENT_QUOTES, 'UTF-8')),
					'href'        => $this->url->link('information/faq', 'topic=' . $faq['faq_id'] . '_' . $child['faq_id'])
				);
			}

			$date = date("d.m.Y", strtotime($faq['date']));

			$data['faqs'][] = array(
				'faq_id'		=> $faq['faq_id'],
				'description'	=> strip_tags(html_entity_decode($faq['description'], ENT_QUOTES, 'UTF-8')),
				'title'			=> strip_tags(html_entity_decode($faq['title'], ENT_QUOTES, 'UTF-8')),
				'author_name'	=> $faq['author_name'],
				'moderator_name'=> $faq['moderator_name'],
				'date'			=> $date,
				'children'		=> $children_data,
				'href'			=> $this->url->link('information/complaints', 'topic=' . $faq['faq_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/complaints.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/complaints.tpl', $data);
		} else {
			return $this->load->view('default/template/module/complaints.tpl', $data);
		}
  	}

	private function validate(){
		if ((strlen(trim(utf8_decode($this->request->post['author_name']))) < 2) || (strlen(trim(utf8_decode($this->request->post['author_name']))) > 20)) {
			$this->error['author_name'] = $this->language->get('error_author_name');
		}
		if ((strlen(utf8_decode($this->request->post['title'])) < 5) || (strlen(utf8_decode($this->request->post['title'])) > 1000)) {
			$this->error['title'] = $this->language->get('error_title');
		}
		if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['author_mail'])) {
			$this->error['author_mail'] = $this->language->get('error_email');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}




}