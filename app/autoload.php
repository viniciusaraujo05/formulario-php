<?php

/*No PHP, para referenciar o arquivo no qual uma classe foi declarada, utilizamos uma função autoload. 
Essa função é um ponto central para o carregamento de todas as classes da aplicação. 
Existem diversas implementações possíveis para um autoload, dependendo da organização da aplicação.
 Uma das mais comuns é esta abaixo, que utiliza o nome e o namespace da classe para construir sua localização:*/

spl_autoload_register(function ($class) { // é a função nativa do PHP para o registro de funções autoload.
		$base_dir = __DIR__ . '/';

		$file = $base_dir . str_replace('\\', '/', $class) . '.php';

		if (file_exists($file)) { //Verificamos a existência do arquivo para carregá-lo com require.
			require $file;
		}
});