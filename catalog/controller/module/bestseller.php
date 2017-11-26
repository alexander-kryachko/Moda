<?php
class ControllerModuleBestSeller extends Controller {
	public function index($setting) {
		$this->load->language('module/bestseller');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_model'] = $this->language->get('text_model');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				/*code start*/
				if((strtotime(date('Y-m-d')) >= strtotime($result['promo_date_start'])) && (strtotime(date('Y-m-d')) <= strtotime($result['promo_date_end'])) || (($result['promo_date_start'] == '0000-00-00') && ($result['promo_date_end'] == '0000-00-00'))) {
					$promo_on = TRUE;
				} else {
					$promo_on = FALSE;
				}

				$promo = $this->model_catalog_product->getPromo($result['product_id'],$result['promo_top_right']);
				if ( !empty($promo_on) && !empty($promo) ) {
					$promotag = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo['image'] . '\') no-repeat;"></span>';
				} else {
					$promotag = '';
				}
				/*code end*/

				$special_end = 0;
				if($result['special_end'] && $result['special_end'] >= date('Y-m-d H:i:s') && $result['special_start'] <= date('Y-m-d H:i:s')) {
					$time = new DateTime($result['special_end']);
					$special_end = $time->getTimestamp() - time();
				}

				$add_images = array();

				$results_image = $this->model_catalog_product->getProductImages($result['product_id']);

				foreach ($results_image as $result_image) {
					$add_images[] = array(
						'image' => $this->model_tool_image->cropsize($result_image['image'], $setting['width'], $setting['height']),
						'thumb' => $this->model_tool_image->cropsize($result_image['image'], 50, 50)
					);
				}

				$add_images = array();

				$results_image = $this->model_catalog_product->getProductImages($result['product_id']);

				foreach ($results_image as $result_image) {
					$add_images[] = array(
						'image' => $this->model_tool_image->cropsize($result_image['image'], $setting['width'], $setting['height']),
						'thumb' => $this->model_tool_image->cropsize($result_image['image'], 50, 50)
					);
				}

				if (!empty($result['percent'])) {
					$percent = $result['percent'];
				} else {
					$percent = "";
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'add_images'  => $add_images,
					'name'        => $result['name'],
					'model'       => $result['model'],
					'quantity'    => $result['quantity'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'description_short' => utf8_substr(strip_tags(html_entity_decode($result['description_short'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'percent'     => $percent,
					'special'     => $special,
					'special_end' => $special_end,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					'promotag'	  => $promotag,
				);
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bestseller.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/bestseller.tpl', $data);
			} else {
				return $this->load->view('default/template/module/bestseller.tpl', $data);
			}
		}
	}
}