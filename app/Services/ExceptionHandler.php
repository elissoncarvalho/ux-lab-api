<?php

namespace App\Services;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class ExceptionHandler {

	/**
	 * Processa um exception e grava um LOG no sistema
	 * @param  Exception 	$e     		Objeto do tipo Exception
	 * @param  string 		$msg      	Mensagem a ser exibida
	 * @param  string 		$level 		Nível de erro (RFC 5424: debug, info, notice, warning, error, critical, alert)
	 * @return array 			        Array com processado com todas as mensagens
	 */
	public static function process($e, $msg, $full = true){

		if(!is_null($e)){

			$app_env = env('APP_ENV', 'production');

			//Gera um array de todo o rastro percorrido pelo sistema
			$trace = explode("\n", $e->getTraceAsString());

			//Verifica erro de SQL
			$mensagem = self::sqlErrors($e->getCode());

			if(strlen($mensagem) > 0){
				$msg = $mensagem;
			}

        	//Gera retorno
			$retorno = [
	            'status'=>'error', 
                'msg'=>$msg, 
                'code'=>$e->getCode(), 
                'description'=>utf8_encode($e->getMessage()),
                'line'=>$e->getLine()
            ];

            if($full){
            	$retorno['file'] = $e->getFile();
                $retorno['line'] = $e->getLine();
                $retorno['hint'] = method_exists($e, 'getHint') ? $e->getHint() : null;
                $retorno['error_type'] = method_exists($e, 'getErrorType')  ? $e->getErrorType() : null;
                $retorno['trace'] = (isset($app_env) && $app_env == "local") ? $trace : [];

                //Gera o array de errors, quebrando a mensagem no \n
	            $errors = explode("\n", utf8_encode($e->getMessage()));

	            if(count($errors) >= 2){
	            	$retorno['errors'] = $errors;
	            }
            }

	        //Gera o LOG completo
	        $log = sprintf(
	        	'FILE: %s | LINE: %s | CODE: %s | MESSAGE: %s | DESCRIPTION: %s',
	        	$e->getFile(),
	        	$e->getLine(),
	        	$e->getCode(),
	        	$msg,
	        	$e->getMessage()	
	        );

	    }else{
	    	$retorno = true;
	    	$log = [];
	    }

	    return $retorno;	
	}

	/**
	 * Lista de erros do SQLSTATE
	 * @param  int $code    SQLSTATE error
	 * @return msg          Mensagem do erro
	 */
	public static function sqlErrors($code){
			
		if($code == 23502){
			//	not_null_violation
			$msg = "Existem valores obrigatórios não preenchidos";
		}elseif($code == 23503){
			// foreign_key_violation
			$msg = "Os valores relacionais não são válidos";
		}elseif($code == 23505){
			//	unique_violation
			$msg = "Já existem dados com esses mesmos valores no sistema. Não é permitido gravar dados duplicados";
		}elseif($code == 23514){
			// 	check_violation
			$msg = "Os valores informados não são válidos / não pertencem ao grupo de valores permitidos";
		}
		else{
			//	Código desconhecido
			$msg = "";
		}

		return $msg;
	}
}
