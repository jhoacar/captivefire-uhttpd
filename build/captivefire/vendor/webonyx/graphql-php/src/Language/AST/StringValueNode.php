<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class StringValueNode extends Node implements ValueNode{public $kind=NodeKind::STRING;public $value;public $block;}