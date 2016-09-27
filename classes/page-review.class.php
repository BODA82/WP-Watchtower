<?php
require_once('watchtower.class.php');

class WP_Watchtower_Page_Review extends WP_Watchtower {
	
	/**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
    	add_action('post_submitbox_misc_actions', array($this, 'page_review_date'));
		add_action('save_post', array($this, 'save_page_review_date'));
     	
	}
	
	public function page_review_date() {
	    global $post;
		wp_nonce_field(plugin_basename(__FILE__), 'page_review_nonce');
		
		$review_date = (get_post_meta($post->ID, '_wpw_page_review_date', true) ? get_post_meta($post->ID, '_wpw_page_review_date', true) : '0000-00-00');
		$date_format = __('M j, Y');
			
		if ($review_date != '0000-00-00') { // review date set
			$stamp = __('Review date: <b>%1$s</b>', 'wpw');
		} elseif (time() > strtotime($review_date) && $review_date != '0000-00-00') { // review date overdue
			$stamp = __('Review date: <span class="overdue"><b>Overdue</b></span>', 'wpw');
		} else { // review date not set
			$stamp = __('Review date: <b>Not set</b>', 'wpw');
		}
		$date = date_i18n($date_format, strtotime($review_date));
		?>
		
        <div class="misc-pub-section curtime misc-pub-curtime">
			<span id="wpw-page-review-date" class="dashicons-before dashicons-welcome-view-site">
				<?php printf($stamp, $date); ?>
			</span>
			<a href="#edit_review_date" class="edit-review-date hide-if-no-js"><span aria-hidden="true"><?php _e('Edit', 'wpw'); ?></span> <span class="screen-reader-text"><?php _e('Edit date and time', 'wpw'); ?></span></a>
			<fieldset id="reviewtimestampdiv" class="hide-if-js">
				<legend class="screen-reader-text"><?php _e('Date and time', 'wpw'); ?></legend>
				<div class="review-date-wrap">
					<label>
						<span class="screen-reader-text">Month</span>
						<select id="review_mm" name="review_mm">
							<option value="01" data-text="Jan"><?php _e('01-Jan', 'wpw'); ?></option>
							<option value="02" data-text="Feb"><?php _e('02-Feb', 'wpw'); ?></option>
							<option value="03" data-text="Mar"><?php _e('03-Mar', 'wpw'); ?></option>
							<option value="04" data-text="Apr"><?php _e('04-Apr', 'wpw'); ?></option>
							<option value="05" data-text="May"><?php _e('05-May', 'wpw'); ?></option>
							<option value="06" data-text="Jun"><?php _e('06-Jun', 'wpw'); ?></option>
							<option value="07" data-text="Jul"><?php _e('07-Jul', 'wpw'); ?></option>
							<option value="08" data-text="Aug"><?php _e('08-Aug', 'wpw'); ?></option>
							<option value="09" data-text="Sep"><?php _e('09-Sep', 'wpw'); ?></option>
							<option value="10" data-text="Oct"><?php _e('10-Oct', 'wpw'); ?></option>
							<option value="11" data-text="Nov"><?php _e('11-Nov', 'wpw'); ?></option>
							<option value="12" data-text="Dec"><?php _e('12-Dec', 'wpw'); ?></option>
						</select>
					</label>
					<label>
						<span class="screen-reader-text">Day</span>
						<input type="text" id="review_jj" name="review_jj" value="" size="2" maxlength="2" autocomplete="off">
					</label>, 
					<label>
						<span class="screen-reader-text">Year</span>
						<input type="text" id="review_aa" name="review_aa" value="" size="4" maxlength="4" autocomplete="off">
					</label>
				</div>
				
				<input type="hidden" id="review_ss" name="review_ss" value="">
				<input type="hidden" id="review_hidden_mm" name="review_hidden_mm" value="">
				<input type="hidden" id="review_cur_mm" name="review_cur_mm" value="">
				<input type="hidden" id="review_hidden_jj" name="review_hidden_jj" value="">
				<input type="hidden" id="review_cur_jj" name="review_cur_jj" value="">
				<input type="hidden" id="review_hidden_aa" name="review_hidden_aa" value="">
				<input type="hidden" id="review_cur_aa" name="review_cur_aa" value="">
				<input type="hidden" id="review_hidden_hh" name="review_hidden_hh" value="">
				<input type="hidden" id="review_cur_hh" name="review_cur_hh" value="">
				<input type="hidden" id="review_hidden_mn" name="review_hidden_mn" value="">
				<input type="hidden" id="review_cur_mn" name="review_cur_mn" value="">
				<p>
					<a href="#edit_timestamp" class="save-review-date hide-if-no-js button">OK</a>
					<a href="#edit_timestamp" class="cancel-review-date hide-if-no-js button-cancel">Cancel</a>
				</p>
			</fieldset>
		</div>
		
        <?php  
	}
	
	public function save_page_review_date($post_id) {
	    if (!isset($_POST['post_type']) )
	        return $post_id;
	
	    if (!wp_verify_nonce( $_POST['page_review_nonce'], plugin_basename(__FILE__)))
	        return $post_id;
	
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
	        return $post_id;
	
	    if ('post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id))
	        return $post_id;
	    
	    if (!isset($_POST['article_or_box']))
	        return $post_id;
	    else {
	        $mydata = $_POST['article_or_box'];
	        update_post_meta( $post_id, '_wpw_page_review_date', $_POST['article_or_box'], get_post_meta( $post_id, '_article_or_box', true ) );
	    }
	}
	
}