<?php 

if( ! class_exists( 'ZSlider_Settings' )){
    class ZSlider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'zslider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        public function admin_init(){
            
            register_setting( 'zslider_group', 'zslider_options', array( $this, 'zslider_validate' ) );

            add_settings_section(
                'zslider_main_section',
                esc_html__( 'How does it work?', 'zslider' ),
                null,
                'zslider_page1'
            );

            add_settings_section(
                'zslider_second_section',
                esc_html__( 'Other Plugin Options', 'zslider' ),
                null,
                'zslider_page2'
            );

            add_settings_field(
                'zslider_shortcode',
                esc_html__( 'Shortcode', 'zslider' ),
                array( $this, 'zslider_shortcode_callback' ),
                'zslider_page1',
                'zslider_main_section'
            );

            add_settings_field(
                'zslider_title',
                esc_html__( 'Slider Title', 'zslider' ),
                array( $this, 'zslider_title_callback' ),
                'zslider_page2',
                'zslider_second_section',
                array(
                    'label_for' => 'zslider_title'
                )
            );

            add_settings_field(
                'zslider_bullets',
                esc_html__( 'Display Bullets', 'zslider' ),
                array( $this, 'zslider_bullets_callback' ),
                'zslider_page2',
                'zslider_second_section',
                array(
                    'label_for' => 'zslider_bullets'
                )
            );

            add_settings_field(
                'zslider_style',
                esc_html__( 'Slider Style', 'zslider' ),
                array( $this, 'zslider_style_callback' ),
                'zslider_page2',
                'zslider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'zslider_style'
                )
                
            );
        }

        public function zslider_shortcode_callback(){
            ?>
            <span><?php esc_html_e( 'Use the shortcode [zslider] to display the slider in any page/post/widget', 'zslider' ); ?></span>
            <?php
        }

        public function zslider_title_callback( $args ){
            ?>
                <input 
                type="text" 
                name="zslider_options[zslider_title]" 
                id="zslider_title"
                value="<?php echo isset( self::$options['zslider_title'] ) ? esc_attr( self::$options['zslider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function zslider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="zslider_options[zslider_bullets]"
                    id="zslider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['zslider_bullets'] ) ){
                            checked( "1", self::$options['zslider_bullets'], true );
                        }    
                    ?>
                />
                <label for="zslider_bullets"><?php esc_html_e( 'Whether to display bullets or not', 'zslider' ); ?></label>
                
            <?php
        }

        public function zslider_style_callback( $args ){
            ?>
            <select 
                id="zslider_style" 
                name="zslider_options[zslider_style]">
                <?php 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['zslider_style'] ) ? selected( $item, self::$options['zslider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }

        public function zslider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'zslider_title':
                        if( empty( $value )){
                            add_settings_error( 'zslider_options', 'zslider_message', esc_html__( 'The title field can not be left empty', 'zslider' ), 'error' );
                            $value = esc_html__( 'Please, type some text', 'zslider' );
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }

    }
}

