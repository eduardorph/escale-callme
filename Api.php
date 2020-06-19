<?php
add_action('wp_ajax_escale_claro_callme', 'escale_claro_callme');
add_action('wp_ajax_nopriv_escale_claro_callme', 'escale_claro_callme');

function escale_claro_callme(){
	check_ajax_referer( 'escale_callme_3546245624', 'security' );

	global $wpdb;

	$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
	$url_base = $base_url . $_SERVER["REQUEST_URI"];

	$options = get_option( 'ecc_settings' );
	$api_url = $options['callme_api_url'];
	$api_key = $options['callme_api_key'];
	

	$nome = !empty($_POST["nome"]) ? $_POST["nome"] : "Cliente";
	$cep = !empty($_POST["cep"]) ? preg_replace('/\D/', '', $_POST["cep"]) : null;
	$email = !empty($_POST["email"]) ? $_POST["email"] : null;
	$url = !empty($_POST["url"]) ? $_POST["url"] : $url_base;
	$campanha = !empty($_POST["campanha"]) ? $_POST["campanha"] : 'Campanha';
	$cid = !empty($_POST["cid"]) ? $_POST["cid"] : null;

	if (substr($url, -1) == "/") {
		$url = substr($url, 0, -1);
	}

	$status_code = '';
	$message = '';


	$company = 'CLARO';
	$channel = 'FORMULARIO_WEB';


	$result = array();

	if (!empty($_POST["telefone"])) {

		$telefone = preg_replace('/\D/', '', $_POST["telefone"]);

		if (strlen($telefone) < 10 || strlen($telefone) > 11) {
			$result["error"] = "telefone";
			echo json_encode($result);
			die;
		}
		
	}else{
		$result["error"] = "telefone";
		echo json_encode($result);
		die;
	}


	if (!empty($_POST["cpf"])) {

		$cpf = preg_replace('/\D/', '', $_POST["cpf"]);

		if (strlen($cpf) !== 11) {
			$result["error"] = "cpf";
			echo json_encode($result);
			die;
		}
		
	}else{
		$result["error"] = "cpf";
		echo json_encode($result);
		die;
	}



	$curl = new Curl;


	$params = array(
		'data' => array(
			'company' => $company,
			'channel' => $channel,
			'url' => $url,
			'googleClientID' => $cid,
			'mediaId' => $campanha,
			'name' => $nome,
			'cpf' => $cpf,
			'phone' => $telefone,
			'email' => $email
		)
	);

	$headers = array(
		'Content-Type: application/json',
		'accept: application/json',
		'x-client-key: '.$api_key
	);

	$resposta = $curl->httpPost($api_url, json_encode($params), $headers);

	$resp = json_decode($resposta, true);

	$transactionId = isset($resp["transactionId"]) ? $resp["transactionId"] : '';

	// Verifica se existe erro
	if (isset($resp["data"])) {
		$status_code = "201";
		$message = $resp["data"]["idTransacao"];

		$result["success"] = true;
	}

	if (isset($resp["error"])) {
		$status_code = $resp["error"]["httpCode"];
		$message = $resp["error"]["message"]." -- ".$resp["error"]["detailedMessage"];

		$result["error"] = "callme";
	}

	date_default_timezone_set("America/Sao_Paulo");
	// $wpdb->show_errors();
	$wpdb->insert( 
	    $wpdb->prefix . 'escale_callme_leads', 
	    array( 
	        'company'     => $company,
	        'channel'     => $channel,
	        'url'     => $url,
	        'googleClientID'     => $cid,
	        'mediaId'     => $campanha,
	        'name'     => $nome,
	        'cpf'     => $cpf,
	        'phone'     => $telefone,
	        'email'     => $email,
	        'postcode'     => $cep,
	        'status_code'     => $status_code,
	        'message'     => $message,
	        'transactionId'     => $transactionId,
	        'created_at'      => date("Y-m-d H:i:s")
	    )
	);

	echo json_encode($result);
	
	die();
}