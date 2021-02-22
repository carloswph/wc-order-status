<?php

namespace WPH\WC;

class OrderStatus {

	protected $statusName;

	protected $statusSlug;

	public $backgroundColor, $fontColor;

	public function __construct(string $statusName, array $colors = null) {

		$this->statusName = $statusName;
		$this->statusSlug = $this->slugify($statusName);
		
		add_action('init', array($this, 'register'));
		add_filter('wc_order_statuses', array($this, 'list'));

		if($colors) {

			$this->backgroundColor = $colors[0];
			if(isset($colors[1])) {
				$this->fontColor = $colors[1];
			} else {
				$this->fontColor = 'inherit';
			}
			
			add_action('admin_footer', array($this, 'css'));
		}
	}

	public function register() {

		register_post_status(
			'wc-' . $this->statusSlug,
			array(
				'label'                     => $this->statusName,
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( $this->statusName . ' <span class="count">(%s)</span>', $this->statusName . ' <span class="count">(%s)</span>' ),
			)
		);
	}

	public function list($order_statuses) {

		$new_order_statuses = array();

	    foreach ( $order_statuses as $key => $status ) {
        	$new_order_statuses[ $key ] = $status;
        	$new_order_statuses['wc-' . $this->statusSlug] = $this->statusName;
        }

        return $new_order_statuses;
	}

	public function css() {
		
		?>
    	<style>
        
			.order-status.status-<?php echo $this->statusSlug; ?> {
            	background: <?php echo $this->backgroundColor; ?>;
            	color: <?php echo $this->fontColor; ?>;
        	}
    	</style>
    	<?php
	}

	public function slugify(string $text) {

	    // replace non letter or digits by -
	    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	    // trim
	    $text = trim($text, '-');
	    // transliterate
	    if (function_exists('iconv'))
	    {
	        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	    }
	    // lowercase
	    $text = strtolower($text);
	    // remove unwanted characters
	    $text = preg_replace('~[^-\w]+~', '', $text);
	    if (empty($text))
	    {
	        return 'n-a';
	    }
	    return $text;
	}
}