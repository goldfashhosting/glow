<?
//[wpb-random-posts]
function header_rand_posts() { 

$args = array(
	'post_type' => 'post',
	'orderby'	=> 'rand',
	'posts_per_page' => 1, 
	);

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {

$string .= '<!-- Start Random Article --!>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$string .= '<a href="'. get_permalink() .'">Random Article</a>';
	}
	$string .= '<!-- End Random Article --!>';
	/* Restore original Post Data */
	wp_reset_postdata();
} else {

$string .= 'no posts found';
}

return $string; 
} 

add_shortcode('wpb-random-posts','header_rand_posts');
add_filter('widget_text', 'do_shortcode'); 
//[subscriptioninfo]
function wpmu_psi_dashboard_widget_display() {
global $psts, $wpdb, $current_site, $blog_id;
  		$levels = (array)get_site_option('psts_levels');
  		$current_level = $psts->get_level($blog_id);
      $expire = $psts->get_expire($blog_id);
      $result = $wpdb->get_row("SELECT * FROM {$wpdb->base_prefix}pro_sites WHERE blog_ID = '$blog_id'");
      if ($result) {
				if ($result->term == 1 || $result->term == 3 || $result->term == 12)
	        $term = sprintf(__('Every %s. month', 'psts'), $result->term);
	      else
	        $term = $result->term;
			} else {
				$term = 0;
			}

      if ($expire && $expire > time()) {
        echo '<p><strong>'.__('Current GMWP+ Site Status', 'psts').'</strong></p>';

        echo '<ul>';
				if ($expire > 2147483647)
					echo '<li>'.__('Expires: <strong>Never</strong>', 'psts').'</li>';
				else
        	echo '<li>'.sprintf(__('Expires: <strong>%s</strong>', 'psts'), date(get_option('date_format'), $expire)).'</li>';

        echo '<li>'.sprintf(__('Subscription: <strong>%s</strong>', 'psts'), @$levels[$current_level]['name']).'</li>';
        if ($result->gateway)
					echo '<li>'.sprintf(__('Payment Gateway: <strong>Auto Billing</strong>', 'psts'), $result->gateway).'</li>';
        if ($term)
        	echo '<li>'.sprintf(__('Payment Term: <strong>%s</strong>', 'psts'), $term).'</li>';
        echo '</ul>';

      } else if ($expire && $expire <= time()) {
        echo '<p><strong>'.__('Expired Pro Site', 'psts').'</strong></p>';

        echo '<ul>';
        echo '<li>'.sprintf(__('Pro Site privileges expired on: <strong>%s</strong>', 'psts'), date(get_option('date_format'), $expire)).'</li>';

        echo '<li>'.sprintf(__('Previous Level: <strong>%s</strong>', 'psts'), $current_level . ' - ' . @$levels[$current_level]['name']).'</li>';
        if ($result->gateway)
					echo '<li>'.sprintf(__('Previous Payment Gateway: <strong>%s</strong>', 'psts'), $result->gateway).'</li>';
        if ($term)
					echo '<li>'.sprintf(__('Previous Payment Term: <strong>%s</strong>', 'psts'), $term).'</li>';
        echo '</ul>';

      } else {
        echo '<p><strong>"'.get_blog_option($blog_id, 'blogname').'" '.__('has never been a Pro Sites blog.', 'psts').'</strong></p>';
		}
}
add_shortcode('subscriptioninfo', 'wpmu_psi_dashboard_widget_display');
//[ab:verify]
function gos_site_autobilling_v1() {
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 
if ( $url === ''. $protocol .'http://legal.god1st.cloud/autobilling/?success=ppa.ab' && ! empty( $_REQUEST['success'] ) && $_REQUEST['success'] === 'ppa.ab' ) {
echo ('<h1>Thank You. Your <font color="green">AutoBilling+</font> Setup is <font color="green">Complete</font>.</h1>
<h3>Starting May 1, 2017, you will receive a <font color="green">5%</font> <small><i>pre-tax</i></small> <font color="green">discount</font> for one (1) invoice <font color="green">+</font> you will receive a single or split invoice(s) between the 1st & 15th of each month for your active services and past due invoices.</h3>
<h4>You may view, modify and remove existing Agreements below. </h4>');
}

if ( $url === ''. $protocol .'http://legal.god1st.cloud/autobilling/?cancelled=ppa.ab' && ! empty( $_REQUEST['cancelled'] ) && $_REQUEST['cancelled'] === 'ppa.ab' ) {
echo ('<h1>oopsie it looks like something went wrong.</h1><br />
<h3>Your <font color="red">AutoBilling+</font> Setup is <font color="red">Incomplete</font>, To get <font color="green">5%</font> off per month click the Automatic Billing Button Below.</h3><br />');
}


}
add_shortcode('ab:verify', 'gos_site_autobilling_v1');
//[installment]
function gos_site_ippid() {
echo ('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="3T6HTFDEXNHGQ">
<table>
<tr><td><input type="hidden" name="on0" value="plan"></td></tr>
<tr><td><input type="hidden" name="os0" value ="option_0"></td></tr>
<tr><td></td><tr><td></td></tr><tr><td></td><td>
<table>
<tr></tr>
<tr></tr><tr><td><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_installment_plan_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></td></tr></table>
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
');
}
add_shortcode('installment', 'gos_site_ippid');
//[xxsubscriptioninfo]
function gos_site_stat_v1() {
echo ('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="EFBWZQFGVNBY2">
<table>
<tr><td><input type="hidden" name="on0" value="GMWP+ Billing"></td></tr><tr><td></select> </td></tr>
</table>
<table>
</table>
<table><tr></tr><tr><td><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_auto_billing_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></td></tr></table>
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>');

}
add_shortcode('xxsubscriptioninfo', 'gos_site_stat_v1');
//[gos-donate]
function GOS_Donate() {
	
$paypal = get_the_author_meta( 'gsetapipp' );
if (!empty($paypal)) {
$ppe = $paypal ;
} else {
$ppe = 'ia-oceo-001@io.goldfash.com';
}

$author[name] = get_the_author_meta( 'display_name' ); 
$author[id] = get_the_author_meta( 'ID' ); 
$ui[authorid] = $author[name];
$ui[authorname] = $author[id];
echo ('<br />
<p> Support '.  $author[name] .'</p>');
echo ('<form action="https://www.paypal.com/cgi-bin/webscr" target=_"blank" method="post">

    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business"
        value="'. $ppe .'">

    <!-- Specify a Donate button. -->
    <input type="hidden" name="cmd" value="_donations">

    <!-- Specify details about the contribution -->
    <input type="hidden" name="item_name" value="Donation to '.$author[name] .' via G1.C Network ">
    <input type="hidden" name="item_number" value="G1C.Donate#G1C-.'. $author[name] .'/GlbUid.'. $author[id] .'/">
    <input type="hidden" name="currency_code" value="USD">

    <!-- Display the payment button. -->
    <input type="image" name="submit"
    src="http://god1st.cloud/static.imgs/i/PayPal-Donate-Button.png" width="150" height="150"
    alt="Donate">
    <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form>') ;


}
add_shortcode( 'gos-donate', 'GOS_Donate' );
//[smsmsg]
function GOS_fr_ui_smsmsg() {
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 
if ( $url === ''. $protocol .'goldfash.org/invitation-subscription-successful/?obj=smsverify' && ! empty( $_REQUEST['obj'] ) && $_REQUEST['obj'] === 'smsverify' ) {
   echo do_shortcode ('[su_service title="Verification Process" icon="icon: mobile-phone" icon_color="#ff0a0a" size="40"]If you have not done so already,  <br> 
Please verify your mobile number by<br>
hitting the subscribe button. <br>
<small><strong>*You should only see the subscribe button<br />
 if you have just completed our invitation form. <br />
Please do not leave this page until you <br />have verified your mobile number.</strong></small>
[/su_service]') ;
}
//

}
add_shortcode( 'smsmsg', 'GOS_fr_ui_smsmsg' ); 
//[mysites]
function GOS_fr_ui_xmysites() {

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST']; 
// . $_SERVER['REQUEST_URI'];


if ( $url === ''. $protocol .'legal.god1st.cloud' && ! empty( $_REQUEST['obj'] ) && $_REQUEST['obj'] === 'mysites' ) {
   $current_user = wp_get_current_user();
 if (is_user_logged_in() === true ) {
        // logged in.
         $user_blogs = get_blogs_of_user( $current_user->ID );
 echo '<div id="ct_section_33_post_298" class="ct-section"><div class="ct-section-inner-wrap"><div id="ct_div_block_36_post_298" class="ct-div-block">';
 //echo '<div id="ct_section_2_post_243" class="ct-section"><div class="ct-section-inner-wrap">';
 // echo ''.$blog_details->blog_id.''.$blog_details->blogname.'.';
  echo ' '.$current_user->user_firstname.'\'s GMWP+ Sites:<br />';
foreach ($user_blogs AS $user_blog) {
 /*echo '<div id="ct_div_block_10_post_243" class="ct-div-block box-actions-box"><h3 id="ct_headline_11_post_243" class="ct-headline box-actions-title"> '.$user_blog->blogname.'</h3><div id="ct_text_block_12_post_243" class="ct-text-block box-actions-text">GoldFash Url : <a href="'. $user_blog->siteurl .'">'. $user_blog->siteurl .'</a><br></div><a id="ct_link_text_13_post_243" class="ct-link-text box-actions-button" href="'. $user_blog->siteurl.'/wp-admin" target="_self">Dashboard</a> <a href="?obj=mysites&bid='. $user_blog->userblog_id .'" id="ct_link_text_13_post_243" class="ct-link-text box-actions-button" target="_self">Modify</a></div>';*/
 echo '<div id="ct_div_block_37_post_298" class="ct-div-block person-square-small-container"><div id="ct_div_block_39_post_298" class="ct-div-block person-square-small-content"><h3 id="ct_headline_40_post_298" class="ct-headline person-square-small-title">'.$user_blog->blogname.'</h3><h4 id="ct_headline_41_post_298" class="ct-headline person-square-small-subtitle"><a href="'. $user_blog->siteurl.'/wp-admin" target="_self">Dashboard</a></h4><div id="ct_text_block_42_post_298" class="ct-text-block person-square-small-text"> Web Address : <a href="'. $user_blog->siteurl .'">'. $user_blog->siteurl .'</a> <br /><a href="https://www.facebook.com/sharer/sharer.php?u='. urlencode(''. $user_blog->siteurl .'') .'" target="_blank"><img src="http://www.freeiconspng.com/uploads/facebook-logo-png-20.png" width="70"></a> <a target="_blank" href="http://twitter.com/share?text=Visit+my+website+&url='. urlencode(''. $user_blog->siteurl .'') .'&hashtags=G1CNetwork,GoldFash,FreeSites"><img src="https://cdn1.iconfinder.com/data/icons/iconza-circle-social/64/697029-twitter-512.png" width="70"></a> <br /> <a href="http://goldfash.org/enterprise-site?obj=mysites&bid='. $user_blog->userblog_id .'" target="_self">Modify</a></div></div></div>';
 echo '</div></div>';
    }
    
  
    
    
    
    
    } else {
        // Not Logged in.
      
 echo '<meta http-equiv="refresh" content="0; URL=http://legal.god1st.cloud/wp-login.php?redirect_to='. urlencode('//legal.god1st.cloud?obj=mysites') .'" />';
	    
    
	

}
}
//

echo '</div></div>';
}
//
add_shortcode( 'mysites', 'GOS_fr_ui_xmysites' ); 
//[gos]
function GOS_fr_ui_actions() {
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 
if ( $url === ''. $protocol .'goldfash.org/invitation-subscription-successful/?obj=smsverify' && ! empty( $_REQUEST['obj'] ) && $_REQUEST['obj'] === 'smsverify' ) {
   return '<center><script src="https://code.jquery.com/jquery-1.10.2.js"></script><script type="text/javascript" src="http://gold2gk.com/sms/getwbf.php?wbfid=293e83f3b004d"></script><img src="http://gold2gk.com/sms/images/subscribe.png" id="mynm_id" style="cursor:pointer"/></center>
';
}
//

}
add_shortcode( 'gos', 'GOS_fr_ui_actions' ); 
//
