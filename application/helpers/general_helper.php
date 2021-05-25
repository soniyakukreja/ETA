<?php
include APPPATH.'third_party/phonenumber/autoload.php';
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\Phonenumber\PhoneNumberParseException;

function encrypt_pass($inputpassword){

	$cryptKey =  '!@#$&*qJB0r7354000021xG03efyCp!@#$&*85';
	$method = "AES-256-CBC";
	$iv = md5(md5($cryptKey));
	$password = openssl_encrypt($inputpassword, $method, md5($cryptKey), 0, hex2bin($iv));
	return $password;
       
}

function get_ymd_format($date){
  if(!empty($date)){
    $dateArra = explode('/',$date);
    return $dateArra[2].'-'.$dateArra[0].'-'.$dateArra[1];
  }
}

function get_ym_start($date){
  if(!empty($date)){
    $dateArra = explode('/',$date);
    return $dateArra[1].'-'.$dateArra[0].'-01';
  }    
}

function get_ym_end($date){
  if(!empty($date)){
    $dateArra = explode('/',$date);
    $enddate = $dateArra[1].'-'.$dateArra[0];
    return date('Y-m-t',strtotime($dateArra[1].'-'.$dateArra[0].'-01'));
  }    
}

function compare_dates($from,$to){
	if(strtotime($from)>strtotime($to)){
		return false;
	}else{
		return true;
	}
}

function pass_strength($password){

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
	    return false;
	}else{
	    return true;
	}
}

/**
* [To encode string]
* @param string $str
*/
if(!function_exists('encoding')){
  function encoding($str){
    $one = serialize($str);
    $two = @gzcompress($one,9);
    $three = addslashes($two);
    $four = base64_encode($three);
    $five = strtr($four, '+/=', '-_.');
    return $five;
  }
}

/**
* [To decode string]
* @param string $str
*/

if (!function_exists('decoding')){
  function decoding($str){
    $one = strtr($str, '-_.', '+/=');
    $two = base64_decode($one);
    $three = stripslashes($two);
    $four = @gzuncompress($three);
    if ($four == '') {
      return "z1"; 
    } else {
      $five = unserialize($four);
      return $five;
    }
  }
}

/**
 * create a encoded id for sequrity pupose 
 * 
 * @param string $id
 * @param string $salt
 * @return endoded value
 */
if (!function_exists('encode_id')) {

    function encode_id($id, $salt) {
        $ci = get_instance();
        return $ci->encryption->encrypt($id);

    }

}

/**
 * decode the id which made by encode_id()
 * 
 * @param string $id
 * @param string $salt
 * @return decoded value
 */
if (!function_exists('decode_id')) {

    function decode_id($id, $salt) {
        $ci = get_instance();
        return $ci->encryption->decrypt($id);
    }

}

if (!function_exists('resource_id')) {

    function resource_id($utype) {
        $ci = get_instance();
        $ci->userdata = $ci->session->userdata('userdata');
        $uid = $ci->userdata['user_id'];
        $my_role = $ci->userdata['urole_id'];
        $user_level = $ci->userdata['user_level'];
        $data = $ci->db->select('roleprefix')->from('user_role')->where(array('urole_id'=>$my_role))->get()->row_array();

        switch ($utype) { 
        case 'staff':

            if($ci->userdata['urole_id']==1){
                $ucount = $ci->db->select('Count(`user_id`) AS total')->from('user')->where(array('urole_id'=>1,'user_level'=>$my_role))->get()->row_array();

            }elseif($ci->userdata['urole_id']==2){
                $ucount = $ci->db->select('Count(`user_id`) AS total')->from('user')->where(array('urole_id'=>2,'user_level'=>$my_role))->get()->row_array();

            }elseif($ci->userdata['urole_id']==3){
                $ucount = $ci->db->select('Count(`user_id`) AS total')->from('user')->where(array('urole_id'=>3,'user_level'=>$my_role))->get()->row_array();

            }

            $no = intval($ucount['total']);
            $no++;
            $pre = $data['roleprefix'].'-U'.$no;

            break;
        case 'licensee':

            $ucount = $ci->db->select('Count(`user_id`) AS total')->from('licensee')->get()->row_array();
            $no = intval($ucount['total']);
            $no++;
            $pre = 'L'.$no;
            break;
        case 'IA':

            $ucount = $ci->db->select('Count(`user_id`) AS total')->from('indassociation')->get()->row_array();
            $no = intval($ucount['total']);
            $no++;
            $pre = 'IA'.$no;
            break;    
        
        case 'consumer':

            $ucount = $ci->db->select('Count(`user_id`) AS total')->from('user')->where(array('urole_id'=>'4'))->get()->row_array();
            $no = intval($ucount['total']);
            $no++;
            $pre = 'C'.$no;
            break;  

        case 'supplier':
            $ucount = $ci->db->select('Count(`user_id`) AS total')->from('user')->where(array('urole_id'=>'5'))->get()->row_array();
            $no = intval($ucount['total']);
            $no++;
            $pre = 'S'.$no;
            break;                  
        }
        return $pre;
    }

}

if (!function_exists('getCustomerOrderCount')) {
    function getCustomerOrderCount($uid){
        $ci = get_instance();
        $data = $ci->db->select("COUNT('orders_id') AS total_orders")->from('orders')->where(array('createdby'=>$uid))->get()->row_array();
        
        if(!empty($data['total_orders'])){
            return $data['total_orders'];
        }else{
            return 0;
        }
    }
}


if (!function_exists('validatePhone')) {

    function validatePhone($phone,$phonecods){

        $return = true;
        $phone = trim($phone);
        $phone_codes = trim($phonecods);

        try{
            $phonenumber  = preg_replace('/[^\p{L}\p{N}\s]/u', '', $phone); 
            $phonenumber  = str_replace(' ', '', $phonenumber);
             
            $phonecodes  = explode("-",$phonecods);
            $phonecodes = $phonecodes[0];
              
            $phone_code_lenght = strlen($phonecodes);
            $get_phone  = substr($phonenumber, 0, $phone_code_lenght);
           
            if($get_phone==$phonecodes){
                $removecode = '+'.$phonenumber;
            }else{
                $removecode = '+'.$phonecodes.$phonenumber;
            }

            $number = PhoneNumber::parse(".$removecode.");
            if (! $number->isValidNumber()) {
             // strict check relying on up-to-date metadata library
                // $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
                // echo json_encode($return); exit;
                $return = false;
            }else{
                $finalnum = $number->format(PhoneNumberFormat::INTERNATIONAL);
                $finalnum = str_replace('-', " ", $finalnum);

                return $finalnum;
            }    
        }catch (PhoneNumberParseException $e) {
            // $return = array('success'=>false,'msg'=>"Invalid Phone number for this country");
            // echo json_encode($return); exit;
            $return =  false;
        }
        return $return;

    }
}
if (!function_exists('getcountry_data')){
	function getcountry_data($country_id){
		$ci = get_instance();
        return $ci->db->select("country_codes,country_name,phone_codes")->from('country')->where(array('id'=>$country_id))->get()->row_array();
	}
}

if(!function_exists('gmdate_to_mydate')){
    function gmdate_to_mydate($gmdate,$localtimzone){
    /* $gmdate must be in YYYY-mm-dd H:i:s format*/
    date_default_timezone_set($localtimzone);
    $timezone=date_default_timezone_get();
    $userTimezone = new DateTimeZone($timezone);
    $gmtTimezone = new DateTimeZone('GMT');
    $myDateTime = new DateTime($gmdate, $gmtTimezone);
    $offset = $userTimezone->getOffset($myDateTime);
    return date("Y-m-d H:i:s", strtotime($gmdate)+$offset);
    }
}

if(!function_exists('meta_title')){
    function meta_title(){
        $ci = get_instance();
        $seg1 = $ci->uri->segment(1);
        $seg2 = $ci->uri->segment(2);
       // echo $seg1.$seg2; exit;

        $url = $seg1;
        if(!empty($seg2)){ $url .= '/'.$seg2; }

        switch ($url) {
          case 'dashboard':
            $meta_title = 'Dashbaord';
            break;
          case 'staff/allstaff':
            $meta_title = 'Staff';
            break;
          case 'staff/editstaff':
            $meta_title = 'Edit Staff';
            break;          
          case 'licensee/viewlicensee':
            $meta_title = 'Licensee';
            break;
          case 'reports/general_transaction_report':
            $meta_title = 'General Transaction Report';
            break;            
          case 'product/product':
            $meta_title = 'Product';
            break;   
          case 'audit/audit':
            $meta_title = 'Audit';
            break; 
          case 'product/int_expression':
            $meta_title = 'Expressions of interest';
            break; 
          case 'product/category':
            $meta_title = 'Product category';
            break;             
          case 'product/formtemplate':
            $meta_title = 'Form Template';
            break;             
          case 'product/addproduct':
            $meta_title = 'Product category';
            break;             
          case 'product/addcategory':
            $meta_title = 'Product add category';
            break;             
          case 'product/formtemplate/addnew':
            $meta_title = 'Add form Template';
            break;             
          case 'marketing/page_ads':
            $meta_title = 'Page Advertisement';
            break;             
          case 'shop':
            $meta_title = 'Shop';
            break;   
          case 'cart':
            $meta_title = 'Cart';
            break;   
          case 'shop/checkout':
            $meta_title = 'Checkout';
            break;   
          case 'shop/prod_detail':
            $meta_title = 'Product Detail';
            break;   
          case 'myprofile':
            $meta_title = 'My Profile';
            break;   
          case 'consumer/orderHistory':
            $meta_title = 'Order History';
            break;   
         case 'order-summary':
            $meta_title = 'Order Summary';
            break;   
         case 'consumer/ticket':
            $meta_title = 'Ticket';
            break;   
         case 'consumer/consumer':
            $meta_title = 'Consumer';
            break;   

          default:
            $meta_title = '';
        }

        return $meta_title.=' | ETA Global';

        
    }
}




 ?>