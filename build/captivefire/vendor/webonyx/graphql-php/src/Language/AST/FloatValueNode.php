<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class FloatValueNode extends Node implements ValueNode{public $kind=NodeKind::FLOAT;public $value;}