<?php

	require 'vendor/autoload.php';

	use Aws\S3\S3Client;
	use Aws\S3\S3Exception;

	if( isset( $_GET['key_image'] ) ){

		$key_image = $_GET['key_image'];
		$key_operacao = $_GET['opr'];
		$key_seguradora = $_GET['seg'];

		$bucketName = 'satcompany';
		$IAM_KEY = 'xxx';
		$IAM_SECRET = 'xxx';

		try{

			$s3 = S3Client::factory(
				array(
					'credentials' => array(
						'key' => $IAM_KEY,
						'secret' => $IAM_SECRET
					),
					'version' => 'latest',
					'region' => 'sa-east-1'
				)
			);

		}catch(Exception $e){

			die("Error: ".$e->getMessage());

		}

		if($key_operacao == 1 && $key_seguradora == 21 ){
			$cmd = $s3->getCommand('GetObject', [
			    'Bucket' => 'instalador.tipo.10',
			    'Key'    => $key_image
			]);
		}else if($key_operacao == 1 && $key_seguradora != 21){
			$cmd = $s3->getCommand('GetObject', [
			    'Bucket' => 'instalador.tipo.10',
			    'Key'    => $key_image
			]);
		}else if($key_operacao == 4 ){
			$cmd = $s3->getCommand('GetObject', [
			    'Bucket' => 'instalador.tipo.11',
			    'Key'    => $key_image
			]);
		}else if($key_operacao == 2 || $key_operacao == 3 ){
			$cmd = $s3->getCommand('GetObject', [
			    'Bucket' => 'instalador.tipo.11',
			    'Key'    => $key_image
			]);
		}



		$request = $s3->createPresignedRequest($cmd, '+20 minutes');


		// Get the actual presigned-url
		$presignedUrl = (string) $request->getUri();

		echo $presignedUrl;


	}else{

		echo '<div style="margin-top:200px"><center><h3>Erro!<br /><small>Parâmetro [key_image] não informado!</small></h3></div>';

	}

	//$url = $s3Client->getObjectUrl('my-bucket', 'my-key');

	/*
	$result = $s3->listObjects(array('Bucket' => $bucketName));

	foreach( $result['Contents'] as $obj ){

		$url = $s3->getObjectUrl($bucketName, $obj['Key']);
		echo $url.$obj['Key'];

	}
	*/