<?php

use GuzzleHttp\Client;

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . './libraries/Google_recaptcha/autoload.php';


class Auth extends MX_Controller {
    public $tb_users;
    public $tb_staff;
    private $apiKey;
    private $apiSecret;
    private $apiEndpoint;

	public function __construct()
	{
        if (session('uid')  ) {
            redirect(client_url('dashboard'));
        }
		parent::__construct();
		$this->load->model(get_class($this) . '_model', 'model');

        if (get_option("enable_goolge_recapcha", '') && get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $this->recaptcha = new \ReCaptcha\ReCaptcha(get_option('google_capcha_secret_key'));
        }

        $this->tb_users = USERS;
        $this->tb_staff = STAFFS;

        $this->apiKey       = 'KEY-u09vnjpvwh9e8jk5636ep7myftlxc4rz';
        $this->apiSecret    = 'y7BL0uiBSaHBp7wS';

        $this->apiEndpoint  = 'https://portal.adnsms.com/api/v1/secure/send-sms';
	}

	public function index()
	{
		redirect (cn('signin'));		
	}

	public function signin()
	{
		$data = array();
        $this->template->set_layout('auth');
        $this->template->build('signin', $data);
	}
	public function signin_process()
	{
		_is_ajax(get_class($this));
        $phone = post("phone");
        $password = md5(post("password"));
        

        if ($phone == "") {
            ms(array(
                "status" => "error",
                "message" => lang("phone_is_required"),
            ));
        }

        if ($password == "") {
            ms(array(
                "status" => "error",
                "message" => lang("Password_is_required"),
            ));
        }

        if (isset($_POST['g-recaptcha-response']) && get_option("enable_goolge_recapcha", '') && get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $resp = $this->recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("please_verify_recaptcha"),
                ));
            }
        }

        $user = $this->model->get("id, status, ids, phone, password", $this->tb_users, ['phone' => $phone]);

        $error = false;
        if (!$user) {
            $error = true;
        } else {
            if ($user->password == md5(post("password"))) {
                $this->db->update($this->tb_users, ['password' => $this->model->app_password_hash(post("password"))], ['id' => $user->id]);
                $error = false;
            } else {
                if ($this->model->app_password_verify(post("password"), $user->password)) {
                    $error = false;
                } else {
                    $error = true;
                }
            }
        }

        if (!$error) {
            if ($user->status != 1) {
                ms(array(
                    "status" => "error",
                    "message" => lang("your_account_has_not_been_activated"),
                ));
            }
            $this->set_login($phone);
            ms(array(
                "status" => "success",
                "message" => lang("Login_successfully"),
            ));
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("phone_and_password_doesnt_match_any_account"),
            ));
        }
	}
	private function set_login($phone)
    {
        
        if (is_array($phone)) {
            $phone = implode('', $phone);  
        }

        if (!is_string($phone)) {
            ms(array('status' => 'error', 'message' => lang("Invalid phone number.")));
        }

        $user = $this->model->get("id, status, ids, email, password, last_name, first_name", $this->tb_users, ['phone' => $phone]);

        if (!$user) {
            ms(array('status' => 'error', 'message' => lang("User not found.")));
        }

        set_session("uid", $user->id);
        $data_session = array(
            'id'   => $user->id,
            'phone' => $user->phone,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        );
        set_session('user_current_info', $data_session);
        set_cookie("sessionData", json_encode($data_session), 1209600);

        $this->model->history_ip($user->id);

        $remember = post("remember");
        if (!empty($remember)) {
            set_cookie("c_cookie_email", encrypt_encode(post("email")), 1209600);
            set_cookie("c_cookie_pass", encrypt_encode(post("password")), 1209600);
        } else {
            delete_cookie("c_cookie_email");
            delete_cookie("c_cookie_pass");
        }

        $this->db->update($this->tb_users, ['reset_key' => ids()], ['id' => $user->id]);

        ms(array('status' => 'success', 'message' => lang("Login successful!"), 'redirect' => cn('dashboard')));
    }

	public function signup()
    {
        $data = array();
        $this->template->set_layout('auth');
        $this->template->build('signup', $data);
    }

    public function signup_process()
    {

        
        $first_name = post('first_name');
        $last_name = post('last_name');
        $phone = post('phone');
        $password = post('password');
        $re_password = post('re_password');
        if ($first_name == '' || $last_name == '' || $password == '' || $phone == '') {
            ms(array(
                'status' => 'error',
                'message' => lang("please_fill_in_the_required_fields"),
            ));
        }

        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            ms(array(
                'status' => 'error',
                'message' => lang("only_letters_and_white_space_allowed"),
            ));
        }

        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            ms(array(
                'status' => 'error',
                'message' => lang("only_letters_and_white_space_allowed"),
            ));
        }

        $pattern = '/^[+]?[0-9]{1,4}?[-.\s]?[0-9]{1,11}$/';
        if (!preg_match($pattern, $phone)) {
            ms(array(
                'status' => 'error',
                'message' => lang("invalid_phone_format"),
            ));
        }
        if ($password != '') {
            if (strlen($password) < 6) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }

            if ($re_password != $password) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("Password do not match"),
                ));
            }
        }
        $data = array(
            'first_name' => $first_name,
			'last_name' => $last_name,
			'phone' => $phone,
			'password' => $password,
		);

        $res = $this->set_signup($data);

        if ($res['status'] === 'success') {
            $this->session->set_userdata([
                'phone' => $phone,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);
        }

        ms(array(
            'status' => $res['status'],
            'message' => $res['message'],
            'redirect' => cn('auth/verify'),
        ));
    }


    private function set_signup($values)
    {
        $otp = rand(100000, 999999); 
        $data = [
            "ids" => ids(),
            "first_name" => $values['first_name'],
            "last_name" => $values['last_name'],
            "phone" => $values['phone'],
            "password" => $this->model->app_password_hash($values['password']),
            "status" => 0, 
            "otp" => $otp,
            "otp_expiry" => date("Y-m-d H:i:s", strtotime("+5 minutes")),
            "history_ip" => get_client_ip(),
            "api_credentials" => json_encode([
                'apikey' => create_random_string_key(13),
                'secretkey' => create_random_string_key(8, 'number'),
            ]),
            "more_information" => json_encode([
                'business_name' => '',
                'business_email' => '',
                'business_logo' => '',
                'website' => '',
            ]),
        ];

        if (!empty($refferal_id = session('refferal_id'))) {
            $us_id = $this->model->get('id,ids', USERS, ['ids' => $refferal_id]);
            if (!empty($us_id)) {
                $data['ref_id'] = $us_id->id;
            }
        }

        if ($data['phone'] != '') {
            $checkUserPhone = $this->model->get('phone, ids', $this->tb_users, ["phone" => $data['phone']]);
            if (!empty($checkUserPhone)) {
                return [
                    'status' => 'error',
                    'message' => lang("An_account_for_the_specified_phone_already_exists_Try_another_phone")
                ];
            }

            if ($this->db->insert($this->tb_users, $data)) {
                $uid = $this->db->insert_id();

                if (get_option('is_signup_bonus') == 1) {
                    $this->model->add_affiliate_bonus($uid, get_option('signup_bonus_amount'));
                }

                $smsResponse = $this->send_sms($values['phone'], "Your OTP is: $otp");
                if ($smsResponse['status']) {
                    if (get_option("is_new_user_phone", '')) {
                        $subject = get_option('phoen_new_registration_subject', '');
                        $subject = str_replace("{{website_name}}", get_option("website_name", "your site"), $subject);

                        $email_content = get_option('phone_new_registration_content', '');
                        $email_content = str_replace("{{user_firstname}}", $data['first_name'], $email_content);
                        $email_content = str_replace("{{user_lastname}}", $data['last_name'], $email_content);
                        $email_content = str_replace("{{website_name}}", get_option("website_name", "your site"), $email_content);
                        $email_content = str_replace("{{user_phone}}", $data['phone'], $email_content);

                        $mail_params = [
                            'template' => [
                                'subject' => $subject,
                                'message' => $email_content,
                                'type' => 'default',
                            ],
                        ];
                        $staff_mail = $this->model->get("id, email", $this->tb_staff, [], "id", "ASC")->email;
                        if ($staff_mail) {
                            $send_message = $this->model->send_mail_template($mail_params['template'], $staff_mail);
                            if ($send_message) {
                                return ["status" => "error", "message" => $send_message];
                            }
                        }
                    }
                    return ['status' => 'success', 'message' => lang("Signup successful, please verify your OTP")];
                    
                } else {
                    return ['status' => 'error', 'message' => lang("Failed to send OTP, please try again")];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later")
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later")
            ];
        }
    }

    public function verify()
    {
        $data = [];
        $this->template->set_layout('auth');
        $this->template->build('verify', $data);
    }

    public function verify_otp()
    {
        $phone = $this->session->userdata('phone');
    
        if (!isset($phone) || empty($phone)) {
            ms(array('status' => 'error', 'message' => lang("Phone number not found in session.")));
        }
    
    
        if (is_array($phone)) {
            $phone = implode('', $phone);  
        }
    
        $otp = post('otp');
        if (!$otp) {
            ms(array('status' => 'error', 'message' => lang("OTP not provided.")));
        }
    
        if (!is_string($phone)) {
            ms(array('status' => 'error', 'message' => lang("Phone number is invalid.")));
        }
    
        $user = $this->db->get_where($this->tb_users, ['phone' => $phone])->row();
    
        if (!$user) {
            ms(array('status' => 'error', 'message' => lang("User not found.")));
        }
    
        if ($user->otp == $otp && strtotime($user->otp_expiry) > time()) {
            $update_result = $this->db->update($this->tb_users, ['status' => 1,  'phone_varified_at' => now()], ['id' => $user->id]);
    
            if (!$update_result) {
                log_message('error', 'Database update failed: ' . print_r($this->db->error(), true));
            }
    
            $this->session->set_userdata([
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
            ]);
    
            $this->set_login(['phone' => $user->phone]);
    
            ms(array('status' => 'success', 'message' => lang("OTP verified successfully!"), 'redirect' => cn('dashboard')));
        } else {
            ms(array('status' => 'error', 'message' => lang("Invalid or expired OTP.")));
        }
    }
    
    public function send_sms($phoneNumber, $message)
    {
        $url = $this->apiEndpoint;
        $postData = [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'request_type' => 'OTP',
            'message_type' => 'TEXT',
            'mobile' => $phoneNumber,
            'message_body' => $message,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'API-Key: ' . $this->apiKey,
            'API-Secret: ' . $this->apiSecret,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['api_response_code']) && $responseData['api_response_code'] == 200) {
            return ['status' => true, 'message' => 'OTP sent successfully'];
        } else {
            return ['status' => false, 'message' => 'Failed to send OTP'];
        }
    }

	public function google_process()
	{
		
		$clientId = get_option('google_auth_clientId','31814200114-qhja6vdp2ckv8r2ibul4ub51e62hucgv.apps.googleusercontent.com');
		$clientSecret = get_option('google_auth_clientSecret','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');
		$redirectUri = 'https://uniquepaybd.com/auth/google_process';

		// Step 1: Redirect the user to Google's OAuth consent page
		if (!isset($_GET['code'])) {
		    $authUrl = 'https://accounts.google.com/o/oauth2/auth?' .
		        'client_id=' . $clientId .
		        '&redirect_uri=' . urlencode($redirectUri) .
		        '&scope=openid email profile' .
		        '&response_type=code';
		    
		    header('Location: ' . $authUrl);
		    exit;
		}

		// Step 2: Handle the callback from Google
		if (isset($_GET['code'])) {
		    $code = $_GET['code'];
		    
		    // Step 3: Exchange the code for an access token
		    $tokenUrl = 'https://accounts.google.com/o/oauth2/token';
		    $postData = [
		        'code' => $code,
		        'client_id' => $clientId,
		        'client_secret' => $clientSecret,
		        'redirect_uri' => $redirectUri,
		        'grant_type' => 'authorization_code',
		    ];
		    
		    $ch = curl_init($tokenUrl);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		    $response = curl_exec($ch);
		    curl_close($ch);
		    
		    $tokenData = json_decode($response, true);

		    
		    // Step 4: Use the access token to get user info
		    if (isset($tokenData['access_token'])) {
		        $userInfoUrl = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $tokenData['access_token'];
		        
		        $ch = curl_init($userInfoUrl);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        $userInfo = curl_exec($ch);
		        curl_close($ch);
		        
		        $userInfoData = json_decode($userInfo, true);

        		$user = $this->model->get("id, status", $this->tb_users, ['email' => $userInfoData['email'] ]);
        		if (!$user) {
        			// signup here...
        			$data = array(
                        'first_name' => $userInfoData['given_name'],
        				'last_name' => $userInfoData['family_name'],
        				'email' => $userInfoData['email'],
        				'password' => '123456',
        			);

        			$res = $this->set_signup($data);

        			$this->session->set_flashdata('message',$res);

        			$avatar = save_web_image($userInfoData['picture'],"avatar.jpg");
        			$this->db->update($this->tb_users, ['avatar' => $avatar], ['email' => $userInfoData['email']]);
        		

            		redirect(cn('user'));

        			
        		}else{
                    if ($user->status!=1) {
                        $this->session->set_flashdata('message',array('message'=>'Your account is deactivated. Contact with Administrator','status'=>'warning'));
                        redirect(cn('signin'));
                    }

        			$this->session->set_flashdata('message',array('message'=>'Login successfully','status'=>'success'));
            		$this->set_login($userInfoData['email']);
            		redirect(cn('user'));
        		}
		    }else{
        		$this->session->set_flashdata('message',array('message'=>'Authentication Failed','status'=>'error'));
            	redirect(cn('auth'));
		    	
		    } 

		}
	}

    public function activation($activation_key = "")
    {
        $user = $this->model->get("id, first_name, last_name, timezone, email, activation_key", $this->tb_users, "activation_key = '" . $activation_key . "'");
        if (!empty($user)) {
            $this->db->update($this->tb_users, ['status' => 1, 'activation_key' => 1], ['id' => $user->id]);
            /*----------  Check is send welcome email or not  ----------*/
            if (get_option("is_welcome_email", '')) {
                $check_send_email_issue = $this->model->send_email(get_option('email_welcome_email_subject', ''), get_option('email_welcome_email_content', 0), $user->id);
                if ($check_send_email_issue) {
                    ms(array(
                        "status" => "error",
                        "message" => $check_send_email_issue,
                    ));
                }
            }

            /*----------  Send email notificaltion for Admin  ----------*/
            if (get_option("is_new_user_email", '')) {

                $subject = get_option('email_new_registration_subject', '');
                $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);

                $email_content = get_option('email_new_registration_content', '');
                $email_content = str_replace("{{user_firstname}}", $user->first_name, $email_content);
                $email_content = str_replace("{{user_lastname}}", $user->last_name, $email_content);
                $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);
                $email_content = str_replace("{{user_timezone}}", $user->timezone, $email_content);
                $email_content = str_replace("{{user_email}}", $user->email, $email_content);

                $mail_params = [
                    'template' => [
                        'subject' => $subject,
                        'message' => $email_content,
                        'type' => 'default',
                    ],
                ];
                $staff_mail = $this->model->get("id, email", $this->tb_staff, [], "id", "ASC")->email;
                if ($staff_mail) {
                    $send_message = $this->model->send_mail_template($mail_params['template'], $staff_mail);
                    if ($send_message) {
                        return ["status" => "error", "message" => $send_message];
                    }
                }
            }
            $this->session->set_flashdata('message',array('message'=>'your account activated successfully','status'=>'success'));

            redirect(cn("signin"));

        } else {
            redirect(cn("signin"));
        }
    }
    public function forgot_password()
    {
        $data = array();
        $this->template->set_layout('auth');
        $this->template->build('forgot_password', $data);
    }
    public function reset_password()
    {
        /*----------  check users exists  ----------*/
        $reset_key = segment(3);
        $user = $this->model->get("id, ids, email", $this->tb_users, "reset_key = '{$reset_key}'");
        if (!empty($user)) {
            // redirect to change password page
            $data = array(
                "reset_key" => $reset_key,
            );
            $this->template->set_layout('auth');
            $this->template->build('change_password', $data);
        } else {
            redirect(cn("signin"));
        }
    }
    public function ajax_forgot_password()
    {
        _is_ajax(get_class($this));
        $email = post("email");

        if ($email == "") {
            ms(array(
                "status" => "error",
                "message" => lang("email_is_required"),
            ));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ms(array(
                "status" => "error",
                "message" => lang("invalid_email_format"),
            ));
        }

        if (isset($_POST['g-recaptcha-response']) && get_option("enable_goolge_recapcha", '') && get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $resp = $this->recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("please_verify_recaptcha"),
                ));
            }
        }

        $user = $this->model->get("*", USERS, "email = '{$email}'");
        if (!empty($user)) {
            $email_error = $this->model->send_email(get_option("email_password_recovery_subject", ""), get_option("email_password_recovery_content", ""), $user->id);

            if ($email_error) {
                ms(array(
                    "status" => "error",
                    "message" => $email_error,
                ));
            }

            ms(array(
                "status" => "success",
                "message" => lang("we_have_send_you_a_link_to_reset_password_and_get_back_into_your_account_please_check_your_email"),
            ));
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("the_account_does_not_exists"),
            ));
        }
    }

    public function ajax_reset_password($reset_key = "")
    {
        _is_ajax(get_class($this));
        $user = $this->model->get("id, ids, email", $this->tb_users, "reset_key = '{$reset_key}'");
        $password = post('password');
        $re_password = post('re_password');

        if ($password == '' || $re_password == '') {
            ms(array(
                'status' => 'error',
                'message' => lang("please_fill_in_the_required_fields"),
            ));
        }

        if ($password != '') {
            if (strlen($password) < 6) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }

            if ($re_password != $password) {
                ms(array(
                    'status' => 'error',
                    'message' => lang("New Password & Confirm Password do not match"),
                ));
            }
        }

        if (!empty($user)) {
            $data = array(
                "password" => $this->model->app_password_hash($password),
                "reset_key" => ids(),
            );

            $this->db->update($this->tb_users, $data, "id = '" . $user->id . "'");
            if ($this->db->affected_rows() > 0) {
                ms(array(
                    "status" => "success",
                    "message" => lang("your_password_has_been_successfully_changed"),
                ));
            } else {
                ms(array(
                    "status" => "Failed",
                    "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
                ));
            }
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
            ));
        }
    }


}
