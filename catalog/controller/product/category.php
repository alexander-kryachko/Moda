<?php
class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {

			$data['customer_group_id'] = $category_info['customer_group_id'];

			if ( ($this->config->get('config_customer_group_id') == $category_info['customer_group_id']) || $category_info['customer_group_id'] == '1' ) {

				$this->document->setTitle($category_info['meta_title']);
				$this->document->setDescription($category_info['meta_description']);
				$this->document->setKeywords($category_info['meta_keyword']);
				$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path']), 'canonical');

				$data['heading_title'] = $category_info['name'];
				$data['view'] = $category_info['view'];

				$data['text_refine'] = $this->language->get('text_refine');
				$data['text_empty'] = $this->language->get('text_empty');
				$data['text_quantity'] = $this->language->get('text_quantity');
				$data['text_manufacturer'] = $this->language->get('text_manufacturer');
				$data['text_model'] = $this->language->get('text_model');
				$data['text_price'] = $this->language->get('text_price');
				$data['text_tax'] = $this->language->get('text_tax');
				$data['text_points'] = $this->language->get('text_points');
				$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$data['text_sort'] = $this->language->get('text_sort');
				$data['text_limit'] = $this->language->get('text_limit');
				$data['text_vid'] = $this->language->get('text_vid');

				$data['button_cart'] = $this->language->get('button_cart');
				$data['read_more'] = $this->language->get('read_more');
				$data['button_wishlist'] = $this->language->get('button_wishlist');
				$data['button_compare'] = $this->language->get('button_compare');
				$data['button_continue'] = $this->language->get('button_continue');
				$data['button_list'] = $this->language->get('button_list');
				$data['button_grid'] = $this->language->get('button_grid');

				// Set the last category breadcrumb
				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
				);

				if ($category_info['image']) {
					$data['thumbbg'] = $this->model_tool_image->onesize($category_info['image'], 1200);
					$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				} else {
					$data['thumbbg'] = '';
					$data['thumb'] = '';
				}

				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				$data['short_description'] = html_entity_decode($category_info['description_short'], ENT_QUOTES, 'UTF-8');
				$data['compare'] = $this->url->link('product/compare');

				// Опции
				$data['config_catagory_product'] = $this->config->get('config_catagory_product');
				$data['config_catagory_product_position'] = $this->config->get('config_catagory_product_position');
				$data['config_catagory_product_child'] = $this->config->get('config_catagory_product_child');

				$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$fmSettings = $this->config->get('mega_filter_settings');

				if( ! empty( $fmSettings['not_remember_filter_for_subcategories'] ) && false !== ( $mfpPos = strpos( $url, '&mfp=' ) ) ) {
					$mfUrlBeforeChange = $url;
					$mfSt = mb_strpos( $url, '&', $mfpPos+1, 'utf-8');
					$url = $mfSt === false ? '' : mb_substr($url, $mfSt, mb_strlen( $url, 'utf-8' ), 'utf-8');
				}

				$data['categories'] = array();

				$results = $this->model_catalog_category->getCategories($category_id);

				foreach ($results as $result) {

					$filter_data = array(
						'filter_category_id'  => $result['category_id'],
						'filter_sub_category' => true
					);

					$data['categories'][] = array(
						'name'  => $result['name'],
						'thumb' => $this->model_tool_image->onesize($result['image'], 350),
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
					);
				}

				if( isset( $mfUrlBeforeChange ) ) {
					$url = $mfUrlBeforeChange;
					unset( $mfUrlBeforeChange );
				}

				$data['products'] = array();

				$filter_data = array(
					'filter_category_id' => $category_id,
					'filter_filter'      => $filter,
					'sort'               => $sort,
					'order'              => $order,
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				);

				$fmSettings = $this->config->get('mega_filter_settings');

				if( ! empty( $fmSettings['show_products_from_subcategories'] ) ) {
					if( ! empty( $fmSettings['level_products_from_subcategories'] ) ) {
						$fmLevel = (int) $fmSettings['level_products_from_subcategories'];
						$fmPath = explode( '_', empty( $this->request->get['path'] ) ? '' : $this->request->get['path'] );

						if( $fmPath && count( $fmPath ) >= $fmLevel ) {
							$filter_data['filter_sub_category'] = '1';
						}
					} else {
						$filter_data['filter_sub_category'] = '1';
					}
				}

				if( ! empty( $this->request->get['manufacturer_id'] ) ) {
					$filter_data['filter_manufacturer_id'] = (int) $this->request->get['manufacturer_id'];
				}

				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

				$results = $this->model_catalog_product->getProducts($filter_data);

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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

					if ($result['percent']) {
						$percent = $result['percent'];
					} else {
						$percent = "";
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

					$special_end = 0;
					if($result['special_end'] && $result['special_end'] >= date('Y-m-d H:i:s') && $result['special_start'] <= date('Y-m-d H:i:s')) {
						$time = new DateTime($result['special_end']);
						$special_end = $time->getTimestamp() - time();
					}

					$add_images = array();

					$results_image = $this->model_catalog_product->getProductImages($result['product_id']);

					foreach ($results_image as $result_image) {
						$add_images[] = array(
							'image' => $this->model_tool_image->cropsize($result_image['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
							'thumb' => $this->model_tool_image->cropsize($result_image['image'], 50, 50)
						);
					}

					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'add_images'  => $add_images,
						'name'        => $result['name'],
						'model'        => $result['model'],
						'quantity'    => $result['quantity'],
						'short_description' => utf8_substr(strip_tags(html_entity_decode($result['description_short'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'percent'     => $percent,
						'special_end' => $special_end,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
						'promotag'	  => $promotag,
					);
				}

				$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['sorts'] = array();

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
				);

				/*$data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
				);*/

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
				);

				if ($this->config->get('config_review_status')) {
					$data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_desc'),
						'value' => 'rating-DESC',
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
					);

					/*$data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_asc'),
						'value' => 'rating-ASC',
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
					);*/
				}

				/*$data['sorts'][] = array(
					'text'  => $this->language->get('text_model_asc'),
					'value' => 'p.model-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_model_desc'),
					'value' => 'p.model-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
				);*/

				$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				$data['limits'] = array();

				$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

				sort($limits);

				foreach($limits as $value) {
					$data['limits'][] = array(
						'text'  => $value,
						'value' => $value,
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
					);
				}

				$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

				$data['sort'] = $sort;
				$data['order'] = $order;
				$data['limit'] = $limit;

				$data['continue'] = $this->url->link('common/home');

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {

					if( isset( $this->request->get['mfilterAjax'] ) ) {
						$settings	= $this->config->get('mega_filter_settings');
						$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );

						if( isset( $this->request->get['mfilterBTypes'] ) ) {
							$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
						}

						if( ! empty( $settings['calculate_number_of_products'] ) || in_array( 'categories:tree', $baseTypes ) ) {
							if( empty( $settings['calculate_number_of_products'] ) ) {
								$baseTypes = array( 'categories:tree' );
							}

							$this->load->model( 'module/mega_filter' );

							$idx = 0;

							if( isset( $this->request->get['mfilterIdx'] ) )
								$idx = (int) $this->request->get['mfilterIdx'];

							$data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL )->getJsonData($baseTypes, $idx) );
						}

						$data['header'] = $data['column_left'] = $data['column_right'] = $data['content_top'] = $data['content_bottom'] = $data['footer'] = '';
					}

					if( ! empty( $data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
						foreach( $data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
							$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
							$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );

							$data['breadcrumbs'][$mfK]['href'] = str_replace(array(
								$mfFind . $this->request->get['mfp'],
								'&amp;mfp=' . $this->request->get['mfp'],
								$mfFind . urlencode( $this->request->get['mfp'] ),
								'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
							), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
						}
					}

					// $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));

					/* layout patch - choose template by path */
					$this->load->model ( 'design/layout' );
					if (isset ( $this->request->get ['route'] )) {
						$route = ( string ) $this->request->get ['route'];
					} else {
						$route = 'common/home';
					}
					$layout_template = $this->model_design_layout->getLayoutTemplate($route);

					$isLayoutRoute = true;
					if(!$layout_template){
						$layout_template = 'category';
						$isLayoutRoute = false;
					}
					// get general layout template
					if(!$isLayoutRoute){
						$layout_id = $this->model_catalog_category->getCategoryLayoutId($category_id);
						if($layout_id){
							$tmp_layout_template = $this->model_design_layout->getGeneralLayoutTemplate($layout_id);
							if($tmp_layout_template)
								$layout_template = $tmp_layout_template;
						}
					}

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $layout_template . '.tpl')) {
						$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/' . $layout_template . '.tpl', $data));
					} else {
						$this->response->setOutput($this->load->view('default/template/product/' . $layout_template . '.tpl', $data));
					}

				} else {

					if( ! empty( $data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
						foreach( $data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
							$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
							$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );

							$data['breadcrumbs'][$mfK]['href'] = str_replace(array(
								$mfFind . $this->request->get['mfp'],
								'&amp;mfp=' . $this->request->get['mfp'],
								$mfFind . urlencode( $this->request->get['mfp'] ),
								'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
							), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
						}
					}

					$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
				}

			} else {



				$this->document->setTitle($category_info['meta_title']);
				$this->document->setDescription($category_info['meta_description']);
				$this->document->setKeywords($category_info['meta_keyword']);
				$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path']), 'canonical');

				$data['heading_title'] = $category_info['name'];

				$url = '';

				if (isset($this->request->get['path'])) {
					$url .= '&path=' . $this->request->get['path'];
				}

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
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

				// Set the last category breadcrumb
				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
				);

				$data['text_error_access'] = $this->language->get('text_error_access');

				$data['button_continue'] = $this->language->get('button_continue');

				$data['continue'] = $this->url->link('common/home');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

				//$data['column_left'] = $this->load->controller('common/column_left');
				//$data['column_right'] = $this->load->controller('common/column_right');

				$data['column_left'] = '';
				$data['column_right'] = '';
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/no_access.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/no_access.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/no_access.tpl', $data));
				}

			}

		} else {
			$url = ''; if( ! empty( $this->request->get['mfp'] ) ) { $url .= '&mfp=' . $this->request->get['mfp']; }

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
				'href' => $this->url->link('product/category', $url)
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

				if( isset( $this->request->get['mfilterAjax'] ) ) {
					$settings	= $this->config->get('mega_filter_settings');
					$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );

					if( isset( $this->request->get['mfilterBTypes'] ) ) {
						$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
					}

					if( ! empty( $settings['calculate_number_of_products'] ) || in_array( 'categories:tree', $baseTypes ) ) {
						if( empty( $settings['calculate_number_of_products'] ) ) {
							$baseTypes = array( 'categories:tree' );
						}

						$this->load->model( 'module/mega_filter' );

						$idx = 0;

						if( isset( $this->request->get['mfilterIdx'] ) )
							$idx = (int) $this->request->get['mfilterIdx'];

						$data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL )->getJsonData($baseTypes, $idx) );
					}

					$data['header'] = $data['column_left'] = $data['column_right'] = $data['content_top'] = $data['content_bottom'] = $data['footer'] = '';
				}

				if( ! empty( $data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
					foreach( $data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
						$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
						$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );

						$data['breadcrumbs'][$mfK]['href'] = str_replace(array(
							$mfFind . $this->request->get['mfp'],
							'&amp;mfp=' . $this->request->get['mfp'],
							$mfFind . urlencode( $this->request->get['mfp'] ),
							'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
						), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
					}
				}

				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {

				if( isset( $this->request->get['mfilterAjax'] ) ) {
					$settings	= $this->config->get('mega_filter_settings');
					$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );

					if( isset( $this->request->get['mfilterBTypes'] ) ) {
						$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
					}

					if( ! empty( $settings['calculate_number_of_products'] ) || in_array( 'categories:tree', $baseTypes ) ) {
						if( empty( $settings['calculate_number_of_products'] ) ) {
							$baseTypes = array( 'categories:tree' );
						}

						$this->load->model( 'module/mega_filter' );

						$idx = 0;

						if( isset( $this->request->get['mfilterIdx'] ) )
							$idx = (int) $this->request->get['mfilterIdx'];

						$data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL )->getJsonData($baseTypes, $idx) );
					}

					$data['header'] = $data['column_left'] = $data['column_right'] = $data['content_top'] = $data['content_bottom'] = $data['footer'] = '';
				}

				if( ! empty( $data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
					foreach( $data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
						$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
						$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );

						$data['breadcrumbs'][$mfK]['href'] = str_replace(array(
							$mfFind . $this->request->get['mfp'],
							'&amp;mfp=' . $this->request->get['mfp'],
							$mfFind . urlencode( $this->request->get['mfp'] ),
							'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
						), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
					}
				}

				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}