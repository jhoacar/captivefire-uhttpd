<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class IntValueNode extends Node implements ValueNode{public $kind=NodeKind::INT;public $value;}