<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class VariableNode extends Node implements ValueNode{public $kind=NodeKind::VARIABLE;public $name;}