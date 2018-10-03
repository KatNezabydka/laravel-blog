<?php


class FileCatAPI {

	public $api_url = false;
	public $api_token = false;


	function __construct($api_url, $api_token) {
		$this->api_url = $api_url;
		$this->api_token = $api_token;
	}

	function ls() {
		if ($this->api_url == false || $this->api_token == false) {
			return false;
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_URL => $this->api_url . '/fs',
			CURLOPT_HTTPHEADER => array('Api-Token: ' . $this->api_token)
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	function upload($filepath, $folder_id = null) {
		$name = basename($filepath);
		//подготовка пространства для загрузки файла
		$data = array("file_name" => $name,
			"file_size" => filesize($filepath),
			"folder_id" => $folder_id);
		$data_string = json_encode($data);
var_dump($this->api_url);die;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_VERBOSE => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $data_string,
			CURLOPT_URL => $this->api_url . '/upldreq',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string),
				'Api-Token: ' . $this->api_token
		)));										 
		$response = curl_exec($curl);
		curl_close($curl);
		
		//загрузка файла

		$upldreq_url = json_decode($response) -> link;
		$data = array("file" => $upldreq_url,
			"file_path" => $filepath,
			);
		$data_string = json_encode($data);

		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// 	CURLOPT_VERBOSE => true,
		// 	CURLOPT_SSL_VERIFYPEER => false,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_POST => true,
		// 	CURLOPT_POSTFIELDS => $data_string,
		// 	CURLOPT_URL => $this->api_url . '/upldreq',//другой зарос
		// 	CURLOPT_HTTPHEADER => array(
		// 		'Content-Type: application/json',
		// 		'Content-Length: ' . strlen($data_string),
		// 		'Api-Token: ' . $this->api_token
		// )));										 
		// $response = curl_exec($curl);
		// curl_close($curl);
		
		return $response_url;
	}
	
																															 
}

// $api = new FileCatApi("https://api.fc.4crp.com", "1000016_fceizJI9Gyly2J5g2iou");
// var_dump($api->upload(getcwd()."/public/albums/1.rar"));
// #var_dump($api->ls());//по идее эта штука должна возвращать UID только что загруженного файла
// //тут надо собрать публичную ссылку на скачивание  методом https://fc.4crp.com//d/UID