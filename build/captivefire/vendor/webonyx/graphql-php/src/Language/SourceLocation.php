<?php  declare(strict_types=1);namespace GraphQL\Language;use JsonSerializable;class SourceLocation implements JsonSerializable{public $line;public $column;public function __construct($line,$col){$this->line=$line;$this->column=$col;}public function toArray(){return['line' =>$this->line,'column' =>$this->column,];}public function toSerializableArray(){return $this->toArray();}public function jsonSerialize(){return $this->toSerializableArray();}}