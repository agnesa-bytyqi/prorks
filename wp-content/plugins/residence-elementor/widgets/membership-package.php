<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Wpresidence_Membership_Package extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'WpResidence_Membership_Package';
	}

        public function get_categories() {
		return [ 'wpresidence' ];
	}
        
        
	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'WpResidence Membership Package', 'residence-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
	return [ '' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
         public function elementor_transform($input){
            $output=array();
            if( is_array($input) ){
                foreach ($input as $key=>$tax){
                    $output[$tax['value']]=$tax['label'];
                }
            }
            return $output;
        }



        protected function _register_controls() {
          
               
                $membership_packages                =   wpestate_generate_membershiop_packages_shortcodes();
                $membership_packages_elementor      =   $this->elementor_transform($membership_packages);
                
                $featured_listings  =   array('no'=>'no','yes'=>'yes');
                $items_type         =   array('properties'=>'properties','articles'=>'articles');
                $alignment_type     =   array('vertical'=>'vertical','horizontal'=>'horizontal');
                        
                        
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'residence-elementor' ),
			]
		);

		$this->add_control(
			'package_id',
			[
                            'label' => __( 'Type Package name', 'residence-elementor' ),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'options' => $membership_packages_elementor,
			]
		);
                
                $this->add_control(
			'package_content',
			[
                            'label' => __( 'Content of the package box', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);
                
                $this->add_control(
			'pack_featured_sh',
			[
                            'label' => __( 'Make package featured?', 'residence-elementor' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'no',
                            'options' => $featured_listings
			]
		);
                
             
                
                
                

		$this->end_controls_section();

		
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
        
        public function wpresidence_send_to_shortcode($input){
            $output='';
            $numItems = count($input);
            $i = 0;

            foreach ($input as $key=>$value){
                $output.=$value;
                if(++$i !== $numItems) {
                  $output.=', ';
                }
            }
            return $output;
        }
        
	protected function render() {
		$settings = $this->get_settings_for_display();
   
                $attributes['package_id']         =   $this -> wpresidence_send_to_shortcode( $settings['package_id'] );      
                $attributes['package_content']    =   $settings['package_content'];
                $attributes['pack_featured_sh']   =   $settings['pack_featured_sh'];
               
                
                
              echo  wpestate_membership_packages_function($attributes);
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="title">
			{{{ settings.title }}}
		</div>
		<?php
	}
}
