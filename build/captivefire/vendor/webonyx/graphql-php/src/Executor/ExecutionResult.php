<?php  declare(strict_types=1);namespace GraphQL\Executor;use GraphQL\Error\Error;use GraphQL\Error\FormattedError;use JsonSerializable;use function array_map;class ExecutionResult implements JsonSerializable{public $data;public $errors;public $extensions;private $errorFormatter;private $errorsHandler;public function __construct($data=null,array $errors=[],array $extensions=[]){$this->data=$data;$this->errors=$errors;$this->extensions=$extensions;}public function setErrorFormatter(callable $errorFormatter){$this->errorFormatter=$errorFormatter;return $this;}public function setErrorsHandler(callable $handler){$this->errorsHandler=$handler;return $this;}public function jsonSerialize(){return $this->toArray();}public function toArray($debug=false){$result=[];if(!empty($this->errors)){$errorsHandler=$this->errorsHandler?:static function(array $errors,callable $formatter){return array_map($formatter,$errors);};$result['errors']=$errorsHandler($this->errors,FormattedError::prepareFormatter($this->errorFormatter,$debug));}if($this->data !==null){$result['data']=$this->data;}if(!empty($this->extensions)){$result['extensions']=$this->extensions;}return $result;}}