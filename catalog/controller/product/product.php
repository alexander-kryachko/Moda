<?php
class ControllerProductProduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('product/product');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('catalog/category');

		$data['isXhr'] = $this->request->isXhr();

		if (isset($this->request->get['path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
				);
			}
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->get['manufacturer_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_brand'),
				'href' => $this->url->link('product/manufacturer')
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

			if ($manufacturer_info) {
				$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
				);
			}
		}

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('product/search', $url)
			);
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		$data['issetwshlist'] = false;
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		if ( !empty($this->session->data['wishlist']) && in_array($this->request->get['product_id'], $this->session->data['wishlist'])) {
			$data['issetwshlist'] = true;
			$data['button_wishlist'] = $this->language->get('button_wishlist_in');
		}

		/*code start*/
		if ((strtotime(date('Y-m-d')) >= strtotime($product_info['promo_date_start'])) && (strtotime(date('Y-m-d')) <= strtotime($product_info['promo_date_end'])) || (($product_info['promo_date_start'] == '0000-00-00') && ($product_info['promo_date_end'] == '0000-00-00'))) {
			$promo_on = TRUE;
		} else {
			$promo_on = FALSE;
		}
		/*code end*/

		if ($product_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
			);

			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
			//$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			//$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			//$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			//$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			// Blueimp Stylesheet
			$this->document->addStyle('catalog/view/theme/default/stylesheet/blueimp/blueimp-gallery.css');
			$this->document->addStyle('catalog/view/theme/default/stylesheet/blueimp/blueimp-gallery-indicator.css');
			//$this->document->addStyle('catalog/view/theme/default/stylesheet/blueimp/blueimp-gallery-video.css');

			// Blueimp Script
			//$this->document->addScript('catalog/view/javascript/blueimp/blueimp-helper.js');
			$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery.js');
			$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery-fullscreen.js');
			$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery-indicator.js');
			//$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery-video.js');
			//$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery-vimeo.js');
			//$this->document->addScript('catalog/view/javascript/blueimp/blueimp-gallery-youtube.js');
			$this->document->addScript('catalog/view/javascript/blueimp/jquery.blueimp-gallery.js');
			$this->document->addScript('catalog/view/javascript/jquery.elevatezoom.js');

			$data['heading_title'] = $product_info['name'];

			// My Lang
			$data['text_article_q'] 	= $this->language->get('text_article_q');
			$data['text_features_q'] 	= $this->language->get('text_features_q');
			$data['text_features_table'] 	= $this->language->get('text_features_table');
			$data['text_payment_q']		= $this->language->get('text_payment_q');
			$data['text_consultation_q']= $this->language->get('text_consultation_q');
			$data['text_add_review_q']	= $this->language->get('text_add_review_q');

			$data['text_select'] = $this->language->get('text_select');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_stock'] = $this->language->get('text_stock');
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['button_send'] = $this->language->get('button_send');

			$data['entry_qty'] = $this->language->get('entry_qty');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');

			$this->load->model('catalog/review');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$this->request->get['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['sku'] = $product_info['sku'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			$data['consultation'] = $this->config->get('config_telephone');

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = 'image/'.$product_info['image'];
				//$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));;
			} else {
				$data['popup'] = '';
			}

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'original' => 'image/'.$result['image'],
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$data['price'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$data['special'] = false;
			}

			if ((float)$product_info['discount']) {
				$data['discount'] = $this->currency->format($this->tax->calculate($product_info['discount'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$data['discount'] = false;
			}

			if ($product_info['percent']) {
				$data['percent'] = $product_info['percent'];
			} else {
				$data['percent'] = "";
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
			} else {
				$data['tax'] = false;
			}


			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}

			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				// Skip Option if disabled
				if (isset($option['product_page']) && $option['product_page'] == 0) continue;

				$product_option_value_data = array();
				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
                            'product_option_image'          => $this->model_tool_image->resize($option_value['product_option_image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                            'product_option_image_popup'    => $this->model_tool_image->resize($option_value['product_option_image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                            'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'product_page' 		   => isset($option['product_page']) ? ((int)$option['product_page']) : 1,
					'type'                 => $option['type'],
					'style'                => $option['style'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

            if ($product_info['table_size']) {
                $data['table_size'] = htmlspecialchars_decode($product_info['table_size']);
            } else {
                $data['table_size'] = "";
            }

			/*code start*/
			$promo_top_right = $this->model_catalog_product->getPromo($product_info['product_id'], $product_info['promo_top_right']);

			if (!empty($promo_top_right['promo_text']) && $promo_on) {
				if (!empty($promo_top_right['promo_link'])) {
					$promo_tags = '<span>Notes: </span><span style="color:red"><a href="' . $promo_top_right['promo_link'] . '" Title="Click Me">' . $promo_top_right['promo_text'] . '</a></span>';
					if (!empty($promo_top_right['pimage'])) {
						$promo_tags = $promo_tags . '<br /><tr><td colspan="2"><a href="' . $promo_top_right['promo_link'] . '" Title="Click Me"><img src="image/' . $promo_top_right['pimage'] . '" /></a></td></tr>';
					}
				} else {
					$promo_tags = '<span>Notes: </span><span style="color: red; font-weight:bold;">' . $promo_top_right['promo_text'] . '</span>';
					if (!empty($promo_top_right['pimage'])) {
						$promo_tags = $promo_tags . '<br /><tr><td colspan="2"><img src="image/' . $promo_top_right['pimage'] . '" /></td></tr>';
					}
				}
			} else {
				$promo_tags = '';
			}

			if (!empty($promo_top_right['promo_text']) && $promo_on) {
				$promo_tag_product_top_right = '<div class="promotags" style="width:100px;height:100px;top:0px;right:0px;background: url(\'' . 'image/' . $promo_top_right['image'] . '\') no-repeat;background-position:top right"></div>';
			} else {
				$promo_tag_product_top_right = '';
			}

			$promo_top_left = $this->model_catalog_product->getPromo($product_info['product_id'], $product_info['promo_top_left']);
			if (!empty($promo_top_left['promo_text']) && $promo_on) {
				$promo_tag_product_top_left = '<div class="promotags" style="width:100px;height:100px;top:0px;left:0px;background: url(\'' . 'image/' . $promo_top_left['image'] . '\') no-repeat;background-position:top left"></div>';
			} else {
				$promo_tag_product_top_left = '';
			}

			$promo_bottom_left = $this->model_catalog_product->getPromo($product_info['product_id'], $product_info['promo_bottom_left']);
			if (!empty($promo_bottom_left['promo_text']) && $promo_on) {
				$promo_tag_product_bottom_left = '<div class="promotags" style="width:100px;height:100px;bottom:0px;left:0px;background: url(\'' . 'image/' . $promo_bottom_left['image'] . '\') no-repeat;background-position:bottom left"></div>';
			} else {
				$promo_tag_product_bottom_left = '';
			}

			$promo_bottom_right = $this->model_catalog_product->getPromo($product_info['product_id'], $product_info['promo_bottom_right']);
			if (!empty($promo_bottom_right['promo_text']) && $promo_on) {
				$promo_tag_product_bottom_right = '<div class="promotags" style="width:100px;height:100px;bottom:0px;right:0px;background: url(\'' . 'image/' . $promo_bottom_right['image'] . '\') no-repeat;background-position:bottom right"></div>';
			} else {
				$promo_tag_product_bottom_right = '';
			}
			/*code end*/

			$special_end = 0;
			if($product_info['special_end'] && $product_info['special_end'] >= date('Y-m-d H:i:s') && $product_info['special_start'] <= date('Y-m-d H:i:s')) {
				$time = new DateTime($product_info['special_end']);
				$special_end = $time->getTimestamp() - time();
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

			/*code start*/
			$data['special_end'] = $special_end;
			$data['promo_tags'] = $promo_tags;
			$data['promo_tag_product_top_right'] = $promo_tag_product_top_right;
			$data['promo_tag_product_top_left'] = $promo_tag_product_top_left;
			$data['promo_tag_product_bottom_left'] = $promo_tag_product_bottom_left;
			$data['promo_tag_product_bottom_right'] = $promo_tag_product_bottom_right;
			/*code end*/

			$data['products'] = array();

			$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
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
					$rating = (int)$result['rating'];
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

				if ($result['percent']) {
					$percent = $result['percent'];
				} else {
					$percent = "";
				}

				$special_end = 0;
				if($result['special_end'] && $result['special_end'] >= date('Y-m-d H:i:s') && $result['special_start'] <= date('Y-m-d H:i:s')) {
					$time = new DateTime($result['special_end']);
					$special_end = $time->getTimestamp() - time();
				}

				$add_images = array();

				$results_image = $this->model_catalog_product->getProductImages($result['product_id']);

				foreach ($results_image as $result_image) {
					$add_images[] = array(
						'image' => $this->model_tool_image->cropsize($result_image['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height')),
						'thumb' => $this->model_tool_image->cropsize($result_image['image'], 50, 50)
					);
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'add_images'  => $add_images,
					'name'        => $result['name'],
					'quantity'    => $result['quantity'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'percent'     => $percent,
					'special_end' => $special_end,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					'promotag'	  => $promotag,
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

			$this->model_catalog_product->updateViewed($this->request->get['product_id']);

			if ($this->config->get('config_google_captcha_status')) {
				$this->document->addScript('https://www.google.com/recaptcha/api.js');

				$data['site_key'] = $this->config->get('config_google_captcha_public');
			} else {
				$data['site_key'] = '';
			}

			/* layout patch - choose template by path */
			$this->load->model('design/layout');
			if (isset ($this->request->get ['route'])) {
				$route = ( string )$this->request->get ['route'];
			} else {
				$route = 'common/home';
			}
			$layout_template = $this->model_design_layout->getLayoutTemplate($route);
			$isLayoutRoute = true;
			if (!$layout_template) {
				$layout_template = 'product';
				$isLayoutRoute = false;
			}
			// get general layout template
			if (!$isLayoutRoute) {
				$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
				if ($layout_id) {
					$tmp_layout_template = $this->model_design_layout->getGeneralLayoutTemplate($layout_id);
					if ($tmp_layout_template)
						$layout_template = $tmp_layout_template;
				}
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			// Группа пользователя
			$customer_group_now = $this->config->get('config_customer_group_id'); //$this->customer->getGroupId()

			// Группа пользоватедля для доступа к категории
			$category_info = $this->model_catalog_product->getCategories($product_id);
			if (!empty($category_info)) {
				$category_id_product = $category_info[0]['category_id'];
				$category_info = $this->model_catalog_product->getCategory($category_id_product);
				$customer_group_access = $category_info['customer_group_id'];

				if ($customer_group_now == $customer_group_access || $customer_group_access == '1') {
					$data['group_access'] = true;
				} else {
					$data['group_access'] = false;
				}
			} else {
				$data['group_access'] = true;
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $layout_template . '.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/' . $layout_template . '.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/' . $layout_template . '.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function review() {
		$this->load->language('product/product');

		$this->load->model('catalog/product');
		$this->load->model('catalog/review');

		$product_info_r = $this->model_catalog_product->getProduct($this->request->get['product_id']);

		$data['tab_review_text'] = sprintf($this->language->get('tab_review'), $product_info_r['reviews']);
		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reviews'] = array();

		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviews'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/review.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/review.tpl', $data));
		}
	}

	public function write() {
		$this->load->language('product/product');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			if ($this->config->get('config_google_captcha_status') && empty($json['error'])) {
				if (isset($this->request->post['g-recaptcha-response'])) {
					$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

					$recaptcha = json_decode($recaptcha, true);

					if (!$recaptcha['success']) {
						$json['error'] = $this->language->get('error_captcha');
					}
				} else {
					$json['error'] = $this->language->get('error_captcha');
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getRecurringDescription() {
		$this->language->load('product/product');
		$this->load->model('catalog/product');

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}

		if (isset($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		$product_info = $this->model_catalog_product->getProduct($product_id);
		$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

		$json = array();

		if ($product_info && $recurring_info) {
			if (!$json) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}

				$json['success'] = $text;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
