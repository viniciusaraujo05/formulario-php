<?php

//inclue_once _DIR_."/app/autoload.php";

define("MEGA_EM_BYTES", 1048576); //1MB EM BYTES PARA O ARQUIVO

use io\FileWriter;
use util\Regex;
use http\Request;
use http\Response;

$response = new Response();

try {
    //Valida todos os dados fo formulario usando REGEX::VALIDADE
    
    Regex::validate(Request::get('email'), Regex::EMAIL,
        "Falha na Validação do E-mail");
    Regex::validate(Request::get('senha'), Regex::PASSWORD,
        "Falha na Validação do Senha");    

    if (Request::get('senha') !== Request::get('senha-confirmacao')) {
        throw new Exception("Falha na validação da senha. As senhas devem ser iguais.");
    }    

    Regex::validate(Request::get('nome'), Regex::LASTNAME, "Falha na validação do nome.");
    Regex::validate(Request::get('sobrenome'), Regex::LASTNAME, "Falha na validação do sobrenome.");
    Regex::validate(Request::get('login'), Regex::NICKNAME, "Falha na validação do login.");

    if (Request::get('login') === 'devmedia') {
        throw new Exception('O login "devmedia" já está sendo usado.');
      }
    
      // Validação do arquivo

      $file = Request::file('file');

	if ($file->isValid()) {
		Regex::validate($file->getType(), Regex::TYPE_IMAGE,
			'O arquivo não é uma imagem no formato JPG, GIF ou PNG.');

		$max_file_size = MEGA_EM_BYTES / 3;

		if ($file->getSize() >= $max_file_size) {
			throw new Exception('A imagem não pode ser maior que '
				. number_format(($max_file_size / 1024), 2) . 'KB.');
		}

		$file->rename("upload");
		$writer = new FileWriter();
		$writer->save($file, __DIR__ . "/upload");
	} else if ($file->getError() !== UPLOAD_ERR_NO_FILE) {
		throw new Exception("Erro no upload do arquivo. Código de erro #{$file->getError()}");
	}

	$response->setStatus(Response::STATUS_200,
		"Dados validados com sucesso.");

} catch (Exception $e) {
	$response->setStatus(Response::STATUS_500, $e->getMessage());
}

$response->resolve();

exit;