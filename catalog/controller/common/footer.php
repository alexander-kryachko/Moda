<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['address'] = $this->config->get('config_address');
		$data['skype'] = $this->config->get('config_skype');
		$data['email'] = $this->config->get('config_email');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['telephone_2'] = $this->config->get('config_telephone_2');
		$data['telephone_3'] = $this->config->get('config_telephone_3');

		$data['text_social'] = $this->language->get('text_social');
		$data['developers'] = $this->language->get('developers');
		$data['text_about_us'] = $this->language->get('text_about_us');
		$data['text_projects'] = $this->language->get('text_projects');
		$data['text_products'] = $this->language->get('text_products');
		$data['text_services'] = $this->language->get('text_services');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$data['text_valid_error'] = $this->language->get('text_valid_error');
		$data['text_valid_valid'] = $this->language->get('text_valid_valid');
		$data['text_valid_false'] = $this->language->get('text_valid_false');
		$data['text_valid_submit'] = $this->language->get('text_valid_submit');
		$data['text_loading'] = $this->language->get('text_loading');


        if(isset($this->request->post['email_news'])){
            $data['news_email'] = $this->request->post['email_news'];
        }else{
            $data['news_email'] = NULL;
        }
        $data['news_firstname']  = "user_for_news";
        $data['news_lastname']   = "user_for_news";
        $data['news_telephone']  = "phone_for_news";
        $data['news_newsletter']   = (int)1;
        $data['password']  = $this->generate_password();
        $data['fax'] = "fax_for_phone";


        $this->load->model('account/customer');
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($data['news_email'])){
            if($this->model_account_customer->getTotalCustomersByEmail($data['news_email']) == 0 ){
            $customer_id = $this->model_account_customer->addCustomerForNews($data);
                echo "sucsess";
            }else{
               echo "error";
            }
        }






        $this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['about_us'] = $this->url->link('information/information', 'information_id=4', 'SSL');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['language'] = $this->load->controller('common/language');
		$data['languagese'] = $this->language->getGroupData();

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		$data['content_footer'] = $this->load->controller('common/content_footer');




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/modals.tpl')) {
			$data['modals'] = $this->load->view($this->config->get('config_template') . '/template/common/modals.tpl', $data);
		} else {
			$data['modals'] = $this->load->view('default/template/common/modals.tpl', $data);
		}

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
    public function generate_password()
    {
        $number = (int)8;
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0','.',',',
            '(',')','[',']','!','?',
            '&','^','%','@','*','$',
            '<','>','/','|','+','-',
            '{','}','`','~');

        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

}