<?php
/*As informações enviadas por um formulário ficam contidas nos arrays superglobais $_GET e $_POST, dependendo do método de envio. 
Nesse exemplo adicionamos a esses arrays uma camada extra de abstração através da classe Request.
 A partir dela podemos ler os valores em $_GET e $_POST, com a opção retornar um valor padrão, 
 caso não seja encontrado. Com isso garantimos que sempre trabalharemos com valores conhecidos, o que facilita o código de validação.

Tendo em vista a limitação do envio por POST, devido a adição da imagem, 
verificamos primeiro a presença da chave, informada para o método get, 
no array $_POST. Caso não seja encontrada, faremos uma verificação adicional no array $_GET, como vemos no código a seguir:
*/

namespace http;

use io\File;

class Request
{
    public static function get($key, $default = null)
    {
        if (isset($_POST[$key])) {
            return trim($_POST[$key]);
        }

        if (isset($_GET[$key])) {
            return trim($_GET[$key]);
        }

        return $default;
    }

    public static function file($key)
    {
        if (isset($_FILES[$key])) {
            return new File(
                $_FILES[$key]['name'],
                $_FILES[$key]['tmp_name'],
                $_FILES[$key]['size'],
                $_FILES[$key]['type'],
                $_FILES[$key]['error']
            );
        }

        return new File(null, null, null, null, null);
    }
}
