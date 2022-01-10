<?php

/*No arquivo cadastro.php, ao término da validação configuramos o código de sucesso e a mensagem a serem retornados para o front-end. 
De igual forma, quando uma exceção é lançada, no bloco catch a mensagem de erro 
é adicionada a instância de Response com o código correspondente.
Em todo caso, Response::resolve é invocado imprimindo o json de resposta. Abaixo está esse trecho de código para relembrarmos*/

namespace http;

class Response
{
    const STATUS_200 = 200;
    const STATUS_500 = 500;

    private $message;
    private $code;

    public function __construct()
    {
        $this->message = '';
        $this->code = 0;
    }

    public function setStatus($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function resolve()
    {
        header("Content-type: application/json; charset=utf-8");

        echo json_encode(array(
            "code" => $this->code,
            "message" => $this->message
        ), 1);
    }
}
