<?
// Functions for GMWP+

function add_support_caps() {
    // gets the GMWP+ user's Support role
    $role = get_role( 'subscriber' );
    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'view_ticket' );
    $role->add_cap( 'create_ticket' );
    $role->add_cap( 'close_ticket' );
    $role->add_cap( 'reply_ticket' );
    $role->add_cap( 'attach_files' ); 
}
add_action( 'admin_init', 'add_support_caps');
// #F1
// Register User Contact Methods
function GOS_ui_api_objects( $user_contact_method ) {

	$user_contact_method['ui_licensekey_api'] = __( 'User License Key', 'text_domain', true);
	$user_contact_method['ui_pp:donations'] = __( 'Paypal Email Address', 'text_domain' );
	//$user_contact_method['ui_ppin_key'] = __( 'User UPiK Code', 'text_domain' );
	$user_contact_method['ui_goldpay_account'] = __( 'User Billing Account Number', 'text_domain' );

	return $user_contact_method;

}
add_filter( 'user_contactmethods', 'GOS_ui_api_objects' );
// #F2
// Register oEmbed providers 
function adsonlineco_oembed_provider() {

	wp_oembed_add_provider( 'http://adsonline.co/', 'http://adsonline.co/embed/', false );

}
add_action( 'init', 'adsonlineco_oembed_provider' );
// #F3


// This is the secret key for API authentication. You configured it in the settings menu of the license manager plugin.
define('YOUR_SPECIAL_SECRET_KEY', '5861fce2699be1.02376264'); //Rename this constant name so it is specific to your plugin or theme.
$rServer = ''. $_SERVER['SERVER_NAME'] .'';
// This is the URL where API query request will be sent to. This should be the URL of the site where you have installed the main license manager plugin. Get this value from the integration help page.
define('YOUR_LICENSE_SERVER_URL', 'http://goldfash.org'); //Rename this constant name so it is specific to your plugin or theme.

// This is a value that will be recorded in the license manager data so you can identify licenses for this item/product.
define('YOUR_ITEM_REFERENCE', 'My GMWP+ Portal'); //Rename this constant name so it is specific to your plugin or theme.


add_action( 'show_user_profile', 'GSETapi_extra_profile_fields' );
add_action( 'edit_user_profile', 'GSETapi_extra_profile_fields' );
 
function GSETapi_extra_profile_fields( $user ) { ?>
 <? 
  global $current_user ;
 get_currentuserinfo();
$ui[login] = $current_user->user_login; 
$ui[email] = $current_user->user_email;
$ui[badge] = $current_user->user_level;
$ui[firstname] = $current_user->user_firstname;
$ui[lastname] = $current_user->user_lastname;
$ui[displayname] = $current_user->display_name;
$ui[gblid] = $current_user->ID; 
$userid = '';
if(!empty($_GET[user_id])){
$userid = $_REQUEST[user_id];
}else{
$userid = get_the_author_id()  ;
}if(empty($userid )){
$userid = $ui[gblid] = $current_user->ID; 
}
$bar = get_user_option( 'ui_licensekey_api', $userid );
	$abar = get_user_option( 'gsetapiac', $userid );
	$abarpin = get_user_option( 'gsetapiacpin1', $userid );
	
	$quikaccess = get_user_option( 'gsetqacb', $userid );
	$uitype = get_user_option( 'gsetapiuitype', $userid );
	$g2gkapi = get_user_option( 'gold2gkapi', $userid );
	$monumber = get_user_option( 'gsetapimn', $userid );
	$ppemail = get_user_option( 'ui_pp:donations', $userid );
	$autobp = get_user_option( 'gsetaubp', $userid );
	$autobphone = get_user_option( 'gsetaubphone', $userid );

	$license_key = $bar;
	$access_code = $abar;
	$qas = $quikaccess;



?>

<h3> </h3>
 
    <table class="form-table">
 
 	 <tr>
            <th><label for="gsetapilc">Mobile Number</label></th>
 
            <td>
                <input type="text" name="gsetapimn" id="gsetapimn" value="<?
                
                echo $monumber; 
                
                ?>" class="regular-text" /><br />
                <span class="description">Please enter your Mobile Number.</span>
            </td>
        </tr>
        
          <tr>
            <th><label for="gsetaubphone">Phone Provider</label></th>
 
            <td>
            <?
                if (empty($autobphone)){ 
                
                echo '<select name="gsetaubphone" id="gsetaubphone">
    <option value="@vtext.com">Verizon</option>
    <option value="@tmomail.net">T-Mobile</option>
    <option value="@txt.att.net">AT&T</option>
    <option value="@vmobl.com">Virgin Mobile</option>
    <option value="@mymetropcs.com">MetroPCS</option>
    <option value="@mmst5.tracfone.com">TracFone</option>
    <option value="@myboostmobile.com">Boost Mobile</option>
    <option value="@mms.cricketwireless.net">Cricket</option>
    <option value="@ptel.com">Ptel</option>
    <option value="@text.republicwireless.com">Republic Wireless</option>
    <option value="@msg.fi.google.com">Google Fi</option>
    <option value="@message.ting.com">Ting</option>
    <option value="@tms.suncom.com">Suncom</option>
    <option value="@email.uscc.net">U.S. Cellular</option>
    <option value="@cingularme.com">Consumer Cellular</option>
    <option value="@cspire1.com">C-Spire</option>
    <option value="@vtext.com">PagePlus</option>
  </select><br />
                <span class="description">Please select your mobile phone provider.</span>'; 
                }else{
                echo  $autobphone ; 
                }                ?>
                 
            </td>
        </tr>
        
         <tr>
            <th><label for="gsetapilc">AutoBilling+</label></th>
 
            <td>
            <?
                if (empty($autobp)){ 
                
                echo '<select name="gsetaubp" id="gsetaubp">
    <option value="0">Disabled</option>
    <option value="1">1st</option>
    <option value="2">2nd</option>
    <option value="3">3rd</option>
    <option value="4">4th</option>
    <option value="5">5th</option>
    <option value="6">6th</option>
    <option value="7">7th</option>
    <option value="8">8th</option>
    <option value="9">9th</option>
    <option value="10">10th</option>
    <option value="11">11th</option>
    <option value="12">12th</option>
    <option value="13">13th</option>
    <option value="14">14th</option>
    <option value="15">15th</option>
  </select><br />
  		 <span class="description">Please select your autobilling Payment Date.</span>'; 
                }else{
                echo 'Your AutoBilling+ bill is due on the '. $autobp .' day of the each month. All AutoBilling+ Invoices are ran and issued automatically '; 
                }
                
                ?>
                 
            </td>
        </tr>
       
        
        <tr>
            <th><label for="gsetapilc">Paypal Email</label></th>
 
            <td>
                <input type="text" name="gsetapipp" id="gsetapipp" value="<?
                
                echo $ppemail; 
                
                ?>" class="regular-text" disabled/><br />
                <span class="description">Your Paypal Email Address used to accept donations.</span>
            </td>
        </tr>
        
       
 
 	<tr>
            <th><label for="gsetapiac">Access Key</label></th>
 
            <td>
                <input type="password" name="gsetapiac" id="gsetapiac" value="<?=$abar?>" class="class="form-control" id="pwd" /><br />
                <span class="description">Please enter your Access Key.</span>
            </td>
        </tr>
        <tr>
            <th><label for="gsetqacb">Quik-Access</label></th>
 
            <td>
            
                <?
                if ($qas == 'active'){ ?>
               <?
             echo '<select name="gsetqacb" id="gsetqacb">
    <option value="active">Enabled</option>
    <option value="">Disable</option>
    
    
  </select><br />'; ?>
                <? }else{ ?>
                <?
             echo '<select name="gsetqacb" id="gsetqacb">
    <option value="">Disabled</option>
    <option value="active">Enabled</option>
    
    
  </select><br />'; ?>
               
             <?   }
                ?>
                
                <span class="description">With Quik-Access enabled, you can bypass entering your Personal Pin.<br /><small> </span>
            </td>
        </tr>
      

<?
if ($_GET['rdr'] == "yy0"){ ?>
      <script>
setTimeout(function() {
  window.location.href = "?page=gfax&iDChecker=<?=$_SESSION{guid}?>&";
}, 10);
</script>
<?
	echo('');
	}else{
	echo ('');
	}
	?>



<? 
if (empty($bar) && (!empty($_GET['create_license'])) ){
 
		  /*** Mandatory data ***/ 
// Post URL 
$postURL = "http://goldfash.org"; 
// The Secret key 
$secretKey = "5861fce2699b29.19167551"; 

/*** Optional Data ***/ 
$url = site_url();


// prepare the data 
$data = array (); 
$data['secret_key'] = $secretKey; 
$data['key'] = base64_decode($_GET['kk3']);
$data['slm_action'] = 'slm_create_new'; 
$data['email'] = $ui[email]; 
$data['company_name'] = $access_code;
$data['first_name'] = $ui[firstname]; 
$data['last_name'] = $ui[lastname]; 
$data['txn_id'] = base64_decode($_GET["suit"]);
$data['upin'] = $abarpin;
$data['max_allowed_domains'] = base64_decode($_GET["mdd"]);
$name = 'GLDFASH';
$nameLength = strlen($name); // gets the length of the name
$randomNumber = rand(0, $nameLength - 1); // generates a random number no longer than the name length
$randomLetter = substr($name, $randomNumber, 1); // gets the substring of one letter based on that random number
echo($randomLetter);
function randomString() {
    $alphabet = "0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    $array_lengths = array(5,3,5,4);
    foreach($array_lengths as $v){
      for ($i = 0; $i < $v; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      $pass[] = $randomLetter;
    }
    return rtrim(implode($pass),'-'); //turn the array into a string
}
//echo randomString();

 $data['license_key'] = '' . randomString() . ':'. $randomLetter .'';


// send data to post URL 
$ch = curl_init ($postURL); 
curl_setopt ($ch, CURLOPT_POST, true); 
curl_setopt ($ch, CURLOPT_POSTFIELDS, $data); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
$returnValue = curl_exec ($ch); 

// Process the return values 
//var_dump($returnValue);
$license_data = json_decode(($returnValue));

$_SESSION['iHaveAKeyLC'] = $license_data->key; 
  //$wp_mail( $to, $subject, $message, $headers, $attachments );
  echo('
<script type="text/javascript">
<!--
window.location = "?oiHaveALK='. urlencode(base64_encode($license_data->key)) .'&suit='. $_GET["suit"] .'&updated=true"
//-->
</script>
');
}
        else{
      
    
           // echo('<br />
      
       // <a href="?create_license=1" value="Create License Key" class="button-primary">CL </a>');
            echo('<br /><small>Please Note: License Keys Costs <a href="#">See Pricing</a>. Each Network can consist of only 25 license keys*.</small></p></form>');
        }

    
?>




        <tr>
            <th><label for="gsetapiac">API App uPin</label></th>
 
            <td>
            
            <div class="form-group">
    <label class="control-label col-sm-2" for="email"></label>
    <div class="col-sm-10">
      <p class="form-control-static"><?
                if (!empty($abarpin)){ 
                echo $abarpin; 
                }else{
              echo ('uPin Not Set yet');
                } ?>
                </p>
    </div>
  </div>
  
  <input type="hidden" name="gold2gkapi" id="gold2gkapi" value="<?
                if (isset($_GET['gold2gk::api'])){ 
                echo $_GET['gold2gk::api']; 
                }else{
                echo ($g2gkapi); 
                } ?>" class="regular-text" />
  
  
  <input type="hidden" name="gsetapiuitype" id="gsetapiuitype" value="<?
                if (!empty($uitype)){ 
                echo $uitype; 
                }else{
                echo base64_decode($_GET['suit']); 
                } ?>" class="regular-text" />
                
                <input type="hidden" name="gsetapiacpin1" id="gsetapiacpin1" value="<?
                if (!empty($abarpin)){ 
                echo $abarpin; 
                }else{
                echo md5('G1.C:GoldFash:RaFco');
                echo uniqid(''. date("Y-m-d.h:i:sa") .'-', true); 
                } ?>" class="regular-text" /><br />
                <span class="description">Your uPin helps keep your experience running smoothly.</span>
            </td>
        </tr>
        
    </table>
<?php }
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
 
function my_save_extra_profile_fields( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
  //  update_usermeta( absint( $user_id ), 'gsetapilc', wp_kses_post( $_POST['gsetapilc'] ) );
    update_usermeta( absint( $user_id ), 'gsetapiac', wp_kses_post( $_POST['gsetapiac'] ) );
    update_usermeta( absint( $user_id ), 'gsetapiacpin1', wp_kses_post( $_POST['gsetapiacpin1'] ) );
    update_usermeta( absint( $user_id ), 'gsetqacb', wp_kses_post( $_POST['gsetqacb'] ) );
    update_usermeta( absint( $user_id ), 'gsetapiuitype', wp_kses_post( $_POST['gsetapiuitype'] ) );
     update_usermeta( absint( $user_id ), 'gold2gkapi', wp_kses_post( $_POST['gold2gkapi'] ) );
     update_usermeta( absint( $user_id ), 'gsetapimn', wp_kses_post( $_POST['gsetapimn'] ) );
     update_usermeta( absint( $user_id ), 'gsetapipp', wp_kses_post( $_POST['gsetapipp'] ) );
      update_usermeta( absint( $user_id ), 'gsetaubp', wp_kses_post( $_POST['gsetaubp'] ) );
   
}
    
add_action('admin_menu', 'slm_sample_license_menu');

function slm_sample_license_menu() {
    add_options_page('Activation Menu', 'Activation', 'read', __FILE__, 'sample_license_management_page');
}

function sample_license_management_page() {

	 global $current_user;
      get_currentuserinfo();
	
	$s6 = "{$_SERVER['HTTP_HOST']}";
      	$url = $s6;

	$email = $current_user->user_email;
	$firstname = $current_user->user_firstname; 
	$lastname = $current_user->user_lastname;
	$bar = get_user_option( 'ui_licensekey_api', get_current_user_id() );
	$abar = get_user_option( 'gsetapiac', get_current_user_id() );
     
    //
    echo '<div class="wrap">';
    echo '<h2>G Sync</h2>';

    /*** License activate button was clicked ***/
    if (isset($_REQUEST['activate_license'])) {
        $license_key = $_REQUEST['sample_license_key'];

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_activate',
            'secret_key' => YOUR_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $url,
            'txn_id' => $uitype,
	    'item_reference' => urlencode(YOUR_ITEM_REFERENCE)
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

      //  var_dump($response); //uncomment it if you want to look at the full response
        
        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));
        
        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data
        
        if($license_data->result == 'success'){//Success was returned for the license activation
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />'.$license_data->message;
            
            //Save the license key in the options table
            update_option('sample_license_key', $license_key); 
		

            
            
        }
        else{
            //Show error to the user. Probably entered incorrect license key.
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br />The following message was returned from the server: '.$license_data->message;
        }

    }
    /*** End of license activation ***/
    
    /*** License activate button was clicked ***/
    if (isset($_REQUEST['deactivate_license'])) {
        $license_key = $_REQUEST['sample_license_key'];

        // API query parameters
        $api_params = array(
            'slm_action' => 'slm_deactivate',
            'secret_key' => YOUR_SPECIAL_SECRET_KEY,
            'license_key' => $license_key,
            'registered_domain' => $url,
            'item_reference' => urlencode(YOUR_ITEM_REFERENCE),
        );

        // Send query to the license manager server
        $query = esc_url_raw(add_query_arg($api_params, YOUR_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

        // Check for error in the response
        if (is_wp_error($response)){
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response
        
        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));
        
        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data
        
        if($license_data->result == 'success'){//Success was returned for the license activation
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br /> '.$license_data->message;
            
            //Remove the licensse key from the options table. It will need to be activated again.
            update_option('sample_license_key', '');
        }
        else{
            //Show error to the user. Probably entered incorrect license key.
            
            //Uncomment the followng line to see the message that returned from the license server
            echo '<br /> '.$license_data->message;
        }
        
    }
    /*** End of sample license deactivation ***/
    $options = get_option( 'G2SETAPI_settings' );
    ?>
    

   
  
  
  
  
     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Gold2GKPaDs-300x250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-7131719724085705"
     data-ad-slot="6746177279"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="sample_license_key"></label></th>
                <td ><input class="regular-text" type="hidden" id="sample_license_key" name="sample_license_key"  value="<? echo $bar ; ?>" ></td>
            </tr>
        </table>
       
		
        <p class="submit">
            <input type="submit" name="activate_license" value="Sync" class="button-primary" />
            <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
        </p>
    </form>
    <?php
    
    echo '</div>';
    $bar = get_user_option( 'ui_licensekey_api', get_current_user_id() );
 
if (  $bar == '' ) {
    echo 'You do not have a license key saved.'. $bar .' ';
} else {
    echo 'Your License Key: '. $bar .'';
}

// #



add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function() {
if ( is_plugin_active( 'domain-mapping/domain-mapping.php' ) ) {
require('/public_html/goldfash.org/wp-content/plugins/proposals/meta-boxes/init.php'); 
}
	//include 'ADSFooter.php'; 
	//include 'footerjs.php';
	
}
}
