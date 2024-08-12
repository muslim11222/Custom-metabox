<?PHP



/** 
 * Plugin name: custom metabox
 * Description: this is my custom metabox
 * Author: Muslim khan
*/


class cm_custom_metabox{
     
     public function __construct() {
          add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
          add_action('save_post', array($this, 'save_post'));// input e ja likhbo seta save korar jonno ai hook
          add_action('cmb2_admin_init', array($this, 'cmb2_admin_init'));
          

          
     }

     public function add_meta_boxes() {
          add_meta_box(

               'muslim-post-meta-box-1',
               'Meta box one',
               array($this, 'post_meta_box_1'),
               'page'
          );
     }

     public function post_meta_box_1($post) {
          $your_text = get_post_meta($post->ID, '_your_text', true);
          $associate_page_id = get_post_meta($post->ID, '_associate_page_id', true);

          $posts = get_posts( array(
               'post_type' => 'page',
          ));
          
          ?>
              <div class="inside">
                    <p   class="post-attributes-label-wrapper-menu-order-label-wrapper">
                         <label class="post-attributes-label"> Your text finld </label>   
                    </p>
                    <input type="text" name="Your_test" value="<?php echo $your_text; ?>">

                    <p   class="post-attributes-label-wrapper-menu-order-label-wrapper">
                         <label class="post-attributes-label"> Select Your item </label>   
                    </p>

                    <select name="associate_page_id" id="">
                         <?php foreach ($posts as $new_post): ?>
                              <option value="<?php echo $new_post->ID; ?>" <?php echo $associate_page_id == $new_post->ID ? 'selected': ''; ?> ><?php echo $new_post->ID; ?></option>
                              <option value="<?php echo esc_attr($new_post->ID); ?>" <?php echo $associate_page_id == $new_post->ID ? 'selected': ''; ?> ><?php echo $new_post->ID; ?>21</option>
                         <?php endforeach; ?>
                    </select>
              </div>
          <?php
     }

      // save post 
     public function save_post($post_id) {
          if (isset( $_POST ['your_text'] ) ) {
               $your_text = sanitize_text_field( $_POST ['your_text'] );
               update_post_meta( $post_id,'_your_text',  $your_text);  
          }


          if (isset( $_POST ['associate_page_id'] ) ) {
               $associate_page_id = intval( $_POST ['associate_page_id'] );
               update_post_meta( $post_id,'_associate_page_id',  $associate_page_id);  
          }
     }


     // cmb2?

     public function cmb2_admin_init() {
          $cmb = new_cmb2_box( array(
               'id'            => 'test_metabox',
               'title'         => 'Test Metabox',
               'object_types'  => array( 'page', ), 
          ) );

          $cmb->add_field( array(
               'name'       => 'Test Text', 'cmb2' ,
               'desc'       => 'field description',
               'id'         => 'yourprefix_text',
               'type'       => 'text',
          ) );
     }

}


new cm_custom_metabox();
