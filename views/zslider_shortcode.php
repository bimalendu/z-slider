<h3><?php echo ( ! empty ( $content ) ) ? esc_html( $content ) : esc_html( ZSlider_Settings::$options['zslider_title'] ); ?></h3>
<div class="mv-slider flexslider <?php echo ( isset( ZSlider_Settings::$options['zslider_style'] ) ) ? esc_attr( ZSlider_Settings::$options['zslider_style'] ) : 'style-1'; ?>">
    <ul class="slides">
    <?php 
    
    $args = array(
        'post_type' => 'zslider',
        'post_status'   => 'publish',
        'post__in'  => $id,
        'orderby' => $orderby
    );

    $my_query = new WP_Query( $args );

    if( $my_query->have_posts() ):
        while( $my_query->have_posts() ) : $my_query->the_post();

        $button_text = get_post_meta( get_the_ID(), 'zslider_link_text', true );
        $button_url = get_post_meta( get_the_ID(), 'zslider_link_url', true );

    ?>
        <li>
        <?php 
        if( has_post_thumbnail() ){
            the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
        }else{
            echo zslider_get_placeholder_image();
        }
         
        ?>
            <div class="zs-container">
                <div class="slider-details-container">
                    <div class="wrapper">
                        <div class="slider-title">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="slider-description">
                            <div class="subtitle"><?php the_content(); ?></div>
                            <a class="link" href="<?php echo esc_attr( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
                        </div>
                    </div>
                </div>              
            </div>
        </li>
        <?php
        endwhile; 
        wp_reset_postdata();
    endif; 
    ?>
    </ul>
</div>