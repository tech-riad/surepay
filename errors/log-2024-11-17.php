ERROR - 2024-11-17 13:48:38 --> Retrieved phone from session: 01750114128
ERROR - 2024-11-17 13:48:38 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT `id`, `status`, `ids`, `email`, `password`, `last_name`, `first_name`
FROM `general_users`
WHERE `phone` = Array
ERROR - 2024-11-17 13:48:38 --> Severity: error --> Exception: Call to a member function row() on bool D:\xampp\htdocs\surepay\app\core\MY_Model.php 64
ERROR - 2024-11-17 13:52:37 --> Retrieved phone from session: 01750114128
ERROR - 2024-11-17 13:55:24 --> Retrieved phone from session: 01750114128
ERROR - 2024-11-17 14:33:43 --> Query error: Duplicate entry '1750114128' for key 'phone' - Invalid query: INSERT INTO `general_users` (`ids`, `first_name`, `last_name`, `phone`, `password`, `status`, `otp`, `otp_expiry`, `history_ip`, `api_credentials`, `more_information`) VALUES ('51ccc76393adf4aadd9c8f8fb3cfaacf', 'Riad', 'khan', '01750114128', '$2a$08$1NLUtb4rjfdGpEjB11ESTu2zIaXRCA7w3qrGnnsgJwLZ0X23jJiwm', 0, 453567, '2024-11-17 14:38:43', '::1', '{\"apikey\":\"I8GO0GaTltYPL\",\"secretkey\":\"50455899\"}', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}')
ERROR - 2024-11-17 14:35:12 --> Query error: Duplicate entry '1750114128' for key 'phone' - Invalid query: INSERT INTO `general_users` (`ids`, `first_name`, `last_name`, `phone`, `password`, `status`, `otp`, `otp_expiry`, `history_ip`, `api_credentials`, `more_information`) VALUES ('e0c021521afc570d2623603c31fe6b88', 'Riad', 'khan', '01750114128', '$2a$08$QFXP1YUW0WHStbrxNGjs1eZSDrYMaewDm5V3d0bgmk33omuaYj7HW', 0, 880854, '2024-11-17 14:40:12', '::1', '{\"apikey\":\"X4HQ5YaN4DHrG\",\"secretkey\":\"29790851\"}', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}')
ERROR - 2024-11-17 16:08:55 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 49
ERROR - 2024-11-17 16:08:55 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 83
ERROR - 2024-11-17 16:08:55 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 113
ERROR - 2024-11-17 16:09:36 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 49
ERROR - 2024-11-17 16:09:36 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 83
ERROR - 2024-11-17 16:09:36 --> Severity: Warning --> in_array() expects parameter 2 to be array, null given D:\xampp\htdocs\surepay\app\modules\admin\models\Staffs_model.php 113
