<?php

	/**
	 * Plugin Name: Splash Page
	 * Plugin URI: #
	 * Description: Uses a splash page for the site
	 * Author: Joel Parker
	 * Version: 1.0
	 */

	class SplashPage  {
		// For cache busting
		const VERSION = '1.0';

		private static $instance = null;

		public $redirect;

		private $options = array(
			'General Settings' => array(
				'splash_page_enable' => array(
					'label' => 'Enable Splash Page',
					'type' => 'checkbox',
				),
			),
			'Customization' => array(
				'splash_page_to_mail' => array(
					'label' => 'Send Leads To',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_subject' => array(
					'label' => 'Subject Line',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_redirect' => array(
					'label' => 'Redirect To',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_cta' => array(
					'label' => 'Call to Action',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_submit_button' => array(
					'label' => 'Submit Button Text',
					'type'	=> 'input',
					'default' => 'I AGREE!',
				),
				'splash_page_text' => array(
					'label' => 'Text',
					'type' => 'textarea',
					'default' => '',
				),
				'splash_page_contribute_url' => array(
					'label' => 'Contribute URL',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_site_url' => array(
					'label' => 'Index URL',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_form_redirect' => array(
					'label' => 'Form Redirect',
					'type'	=> 'input',
					'default' => '',
				),
			),
			'Inline Styling and JS' => array(
				'splash_page_h_tags' => array(
					'label' => 'H Tag Hex Code',
					'type'	=> 'input',
					'default' => '#',
				),
				'splash_page_background_image' => array(
					'label' => 'Background Image',
					'type'	=> 'input',
					'default' => '',
				),
				'splash_page_background_color' => array(
					'label' => 'Background Color (Overrides Image)',
					'type'	=> 'input',
					'default' => '#',
				),
				'splash_page_link_color' => array(
					'label' => 'Link Color',
					'type'	=> 'input',
					'default' => '#',
				),
				'splash_page_custom_css' => array(
					'label' => 'Custom CSS',
					'type' => 'textarea',
					'default' => '',
				),
				'splash_page_custom_js' => array(
						'label' => 'Custom JavaScript',
						'type' => 'textarea',
						'default' => '',
				),
			),
		);

		private function __construct() {
			add_action('admin_menu', array($this, 'addOptions'));

			if($this->debug)
				$this->debugCookie();

			if (get_option('splash_page_enable'))
				add_filter('template_include', array($this, 'templateSwitch'), 100);
		}

		public static function getInstance() {
			if (self::$instance === null)
				self::$instance = new SplashPage();

			return self::$instance;
		}

		public function addOptions() {
			add_options_page('Create Splash Page', 'Splash Page', 'manage_options', 'splash-page', array($this, 'pageOptions'));
		}

		public function pageOptions() {
			if (!current_user_can('manage_options'))
				wp_die(__('Sorry! You dont have the correct user access rights to use this plugin!'));

			if (isset($_POST['submit'])) {
	 			foreach($this->options as $heading => $item)
	 				foreach($item as $k => $v)
						if (isset($_POST[$k]) && $v['type'] !== 'checkbox')
							update_option($k, stripslashes($_POST[$k]));
						else
							update_option($k, isset($_POST[$k]) ? 1 : 0 );
			}

			require __DIR__ . '/view/admin-view.php';
		}

		public function templateSwitch($template) {
			global $post;

			$this->homePage = get_option('page_on_front');

			$this->redirect = home_url();

			if (is_page($this->homePage)) {
				$new_template = __DIR__ . '/view/home.php';
				$this->redirect = home_url();

				return $new_template; 
			}

			return $template;
		}
	}

	SplashPage::getInstance();