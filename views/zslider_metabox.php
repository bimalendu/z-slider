<?php 
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta( $post->ID, 'zslider_link_text', true );
    $link_url = get_post_meta( $post->ID, 'zslider_link_url', true );
?>
<table class="form-table zslider-metabox"> 
<input type="hidden" name="zslider_nonce" value="<?php echo wp_create_nonce( "zslider_nonce" ); ?>">
    <tr>
        <th>
            <label for="zslider_link_text"><?php esc_html_e( 'Link Text', 'zslider' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="zslider_link_text" 
                id="zslider_link_text" 
                class="regular-text link-text"
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="zslider_link_url"><?php esc_html_e( 'Link URL', 'zslider' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="zslider_link_url" 
                id="zslider_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
                required
            >
        </td>
    </tr>               
</table>