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
     	
     	// Add our review date fields and save them on save_post hook
    	add_action('post_submitbox_misc_actions', array($this, 'page_review_date'));
		add_action('save_post', array($this, 'save_page_review_date'));
     	
	}
	
	public function page_review_date() {
	    global $post, $wp_locale;
		wp_nonce_field(plugin_basename(__FILE__), 'page_review_nonce');
		
		$review_date = (get_post_meta($post->ID, '_wpw_page_review_date', true) ? get_post_meta($post->ID, '_wpw_page_review_date', true) : '0000-00-00');
		$review_date_format = __('M j, Y');
		
		/**
		 * If a review date has not been set, let's set it to six months out (what we're recommending 
		 * content managers review their content). Might make this (6 months) a setting later.
		 */
		if ($review_date == '0000-00-00') {
			$future_date = date_i18n('Y-m-d', strtotime('+6 months'));
			$review_date_array = explode('-', $future_date);
			$review_set = 'notset';
		} else {
			$review_date_array = explode('-', $review_date);
			$review_set = 'set';
		}
		
		// Set the "Review date:" label based off whether the review date has been set or not, or if it's overdue	
		if ($review_date != '0000-00-00') { // review date set
			$stamp = __('Review date: <b>%1$s</b>', 'wpw');
		} elseif (time() > strtotime($review_date) && $review_date != '0000-00-00') { // review date overdue
			$stamp = __('Review date: <span class="overdue"><b>Overdue</b></span>', 'wpw');
		} else { // review date not set
			$stamp = __('Review date: <b>Not set</b>', 'wpw');
		}
		
		$display_date = date_i18n($review_date_format, strtotime($review_date));
		?>
		
        <div class="misc-pub-section curtime misc-pub-curtime">
			<span id="wpw-page-review-date" class="dashicons-before dashicons-welcome-view-site">
				<?php printf($stamp, $display_date); ?>
			</span>
			<a href="#edit_review_date" class="edit-review-date hide-if-no-js"><span aria-hidden="true"><?php _e('Edit', 'wpw'); ?></span> <span class="screen-reader-text"><?php _e('Edit date and time', 'wpw'); ?></span></a>
			<fieldset id="reviewtimestampdiv" class="hide-if-js">
				<legend class="screen-reader-text"><?php _e('Date and time', 'wpw'); ?></legend>
				<?php
				/**
				 * Print our review date fields
				 * 
				 * This code is largely taken from WP's touch_time() function located in wp-admin/includes/template.php
				 * Doc: https://developer.wordpress.org/reference/functions/touch_time/
				 */
				$time_adj = current_time('timestamp');
				$jj = $review_date_array[2];
				$mm = $review_date_array[1];
				$aa = $review_date_array[0];
				
				$month = '<label><span class="screen-reader-text">' . __('Month', 'wpw') . '</span><select id="review_mm" name="review_mm">' . '"\n"';
				for ($i = 1; $i < 13; $i = $i + 1) {
					$monthnum = zeroise($i, 2);
					$monthtext = $wp_locale->get_month_abbrev($wp_locale->get_month($i));
					$month .= "\t\t\t" . '<option value="' . $monthnum . '" data-text="' . $monthtext . '" ' . selected($monthnum, $mm, false) . '>';
					$month .= sprintf(__('%1$s-%2$s', 'wpw'), $monthnum, $monthtext) . "</option>\n";
				}
				$month .= '</select></label>';
				
				$day = '<label><span class="screen-reader-text">' . __('Day', 'wpw') . '</span><input type="text" id="review_jj" name="review_jj" value="' . $jj . '" size="2" maxlength="2" autocomplete="off" /></label>';
				$year = '<label><span class="screen-reader-text">' . __('Year', 'wpw') . '</span><input type="text" id="review_aa" name="review_aa" value="' . $aa . '" size="4" maxlength="4" autocomplete="off" /></label>';
				
				echo '<div class="review-date-wrap">';
				printf(__( '%1$s %2$s, %3$s', 'wpw'), $month, $day, $year);
				echo '<input id="wpw-review-set" type="hidden" name="review_set" value="' . $review_set . '" />';
				echo '</div>';
				?>
				<p>
					<a href="#edit_timestamp" class="save-review-date hide-if-no-js button"><?php _e('OK', 'wpw'); ?></a>
					<a href="#edit_timestamp" class="reset-review-date hide-if-no-js button-cancel"><?php _e('Reset', 'wpw'); ?></a>
					<a href="#edit_timestamp" class="cancel-review-date hide-if-no-js button-cancel"><?php _e('Cancel', 'wpw'); ?></a>
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
	        
	    else {
		    $year = $_POST['review_aa'];
		    $month = $_POST['review_mm'];
		    $day = $_POST['review_jj'];
		    $date = $year . '-' . $month . '-' . $day;
		    
		    if (isset($_POST['review_mm']) && isset($_POST['review_jj']) && isset($_POST['review_aa'])) {
			    $updated_date = $year . '-' . $month . '-' . $day;
		    } else {
			    $updated_date = '0000-00-00';
		    }
		    
	        update_post_meta($post_id, '_wpw_page_review_date', $updated_date, get_post_meta($post_id, '_wpw_page_review_date', true));
	    }
	}
	
}