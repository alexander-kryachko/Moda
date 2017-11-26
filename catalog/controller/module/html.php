<?php
class ControllerModuleHTML extends Controller {
	public function index($setting) {

		$this->load->language('module/html');
		//$data['heading_title_after'] = $this->language->get('heading_title_after');

		$data['module_id'] = substr($setting['name'], strrpos($setting['name'],"|")+1);;


		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');

			if ( empty($setting['module_description'][$this->config->get('config_language_id')]['description_for_html']) ) {
				$data['description_for_html'] = '';
			}

			if ( !empty($setting['module_description'][$this->config->get('config_language_id')]['html_tpl']) ) {
				$data['html_tpl'] = $setting['module_description'][$this->config->get('config_language_id')]['html_tpl'];

				$description_for_html['text'] = $data['description_for_html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description_for_html'], ENT_QUOTES, 'UTF-8');

				$data['html_tpl'] = $this->load->view('default/template/information/html/' . $data['html_tpl'] . '.tpl', $description_for_html);
			} else {
				$data['description_for_html'] = '';
				$data['html_tpl'] = '';
			}



			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/html.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/html.tpl', $data);
			} else {
				return $this->load->view('default/template/module/html.tpl', $data);
			}
		}
	}
}