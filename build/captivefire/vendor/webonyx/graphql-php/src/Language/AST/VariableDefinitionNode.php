<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class VariableDefinitionNode extends Node implements DefinitionNode{public $kind=NodeKind::VARIABLE_DEFINITION;public $variable;public $type;public $defaultValue;}