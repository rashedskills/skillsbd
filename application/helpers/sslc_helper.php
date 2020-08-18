<?php
	/**
	* SSLCOMMERZ PAYMENT GATEWAY FOR CodeIgniter
	*
	* Module: Pay Via API (CodeIgniter 3.1.6)
	* Developed By: Prabal Mallick
	* Email: prabal.mallick@sslwireless.com
	* Author: Software Shop Limited (SSLWireless)
	*
	**/

	defined('BASEPATH') OR exit('No direct script access allowed');

	define("SSLCZ_STORE_ID", "skill5eeccb9912e97");
	define("SSLCZ_STORE_PASSWD", "skill5eeccb9912e97@ssl");
	//define("SSLCZ_STORE_ID", "skillsbdlive");
	//define("SSLCZ_STORE_PASSWD", "5F324995C879E28304");

	# SESSION & VALIDATION API
	define("SSLCZ_SESSION_API", ".sslcommerz.com/gwprocess/v4/api.php");
	define("SSLCZ_VALIDATION_API", ".sslcommerz.com/validator/api/validationserverAPI.php");

	# IF SANDBOX TRUE, THEN IT WILL CONNECT WITH SSLCOMMERZ SANDBOX (TEST) SYSTEM
	define("SSLCZ_IS_SANDBOX", true);
