<?php
class ControllerCommonContentAbsolute extends Controller {
    public function index() {
        $this->load->model('design/layout');
        $this->load->language('common/header');

        $data['config_email'] 			= $this->config->get('config_email');
        $data['config_telephone'] 		= $this->config->get('config_telephone');
        $data['config_skype'] 			= $this->config->get('config_skype');
        $data['config_address'] 		= $this->config->get('config_address');
        $data['text_a_callme']          = $this->language->get('text_a_callme');

        $data['text_register']  = $this->language->get('text_a_register');
        $data['text_login']     = $this->language->get('text_a_login');
        $data['register'] 		= $this->url->link('account/register', '', 'SSL');
        $data['account'] 		= $this->url->link('account/account', '', 'SSL');

        if (isset($this->request->get['route'])) {
            $route = (string)$this->request->get['route'];
        } else {
            $route = 'common/home';
        }

        $layout_id = 0;

        if ($route == 'product/category' && isset($this->request->get['path'])) {
            $this->load->model('catalog/category');

            $path = explode('_', (string)$this->request->get['path']);

            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }

        if ($route == 'product/product' && isset($this->request->get['product_id'])) {
            $this->load->model('catalog/product');

            $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
        }

        if ($route == 'information/information' && isset($this->request->get['information_id'])) {
            $this->load->model('catalog/information');

            $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
        }

        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        $this->load->model('extension/module');

        $data['modules'] = array();

        $modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_absolu');

        foreach ($modules as $module) {
            $part = explode('.', $module['code']);

            if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
                $data['modules'][] = $this->load->controller('module/' . $part[0]);
            }

            if (isset($part[1])) {
                $setting_info = $this->model_extension_module->getModule($part[1]);

                if ($setting_info && $setting_info['status']) {
                    $data['modules'][] = $this->load->controller('module/' . $part[0], $setting_info);
                }
            }
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/content_absolute.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/common/content_absolute.tpl', $data);
        } else {
            return $this->load->view('default/template/common/content_absolute.tpl', $data);
        }
    }
}
?>