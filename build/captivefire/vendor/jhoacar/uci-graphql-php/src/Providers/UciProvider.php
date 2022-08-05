<?php  declare(strict_types=1);namespace UciGraphQL\Providers;abstract class ACTIONS{const SET='set';const DELETE='delete';const RENAME='rename';const ADD_LIST='add_list';const DEL_LIST='del_list';const REVERT='revert';}class UciSection{public $options=[];}abstract class UciProvider{const ALL_INDEXES_SECTION=-5;const IS_OBJECT_SECTION=-10;protected $services=[];abstract public static function getUciConfiguration():array;abstract protected static function getUciSection(&$configSection,$sectionName,$optionName,$content):void;abstract public function dispatchAction($action,$config,$section,$indexSection,$option,$value):array;public function getServices():array{return $this->services;}}