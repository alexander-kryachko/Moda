<?php
class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_model'] = $this->language->get('text_model');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					/*code start*/
					if((strtotime(date('Y-m-d')) >= strtotime($product_info['promo_date_start'])) && (strtotime(date('Y-m-d')) <= strtotime($product_info['promo_date_end'])) || (($product_info['promo_date_start'] == '0000-00-00') && ($product_info['promo_date_end'] == '0000-00-00'))) {
						$promo_on = TRUE;
					} else {
						$promo_on = FALSE;
					}

					$promo = $this->model_catalog_product->getPromo($product_info['product_id'],$product_info['promo_top_right']);
					if ( !empty($promo_on) && !empty($promo) ) {
						$promotag = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo['image'] . '\') no-repeat;"></span>';
					} else {
						$promotag = '';
					}
					/*code end*/

					$special_end = 0;
					if($product_info['special_end'] && $product_info['special_end'] >= date('Y-m-d H:i:s') && $product_info['special_start'] <= date('Y-m-d H:i:s')) {
						$time = new DateTime($product_info['special_end']);
						$special_end = $time->getTimestamp() - time();
					}

					$add_images = array();

					$results_image = $this->model_catalog_product->getProductImages($product_info['product_id']);

					foreach ($results_image as $result_image) {
						$add_images[] = array(
							'image' => $this->model_tool_image->cropsize($result_image['image'], $setting['width'], $setting['height']),
							'thumb' => $this->model_tool_image->cropsize($result_image['image'], 50, 50)
						);
					}

					if ($product_info['percent']) {
						$percent = $product_info['percent'];
					} else {
						$percent = "";
					}

					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'add_images'  => $add_images,
						'name'        => $product_info['name'],
						'model'       => $product_info['model'],
						'quantity'    => $product_info['quantity'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'description_short' => utf8_substr(strip_tags(html_entity_decode($product_info['description_short'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'percent'     => $percent,
						'special'     => $special,
						'special_end' => $special_end,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'promotag'	  => $promotag,
					);
				}
			}
		}

		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}
	}
}