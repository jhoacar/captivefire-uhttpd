<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class EnumTypeExtensionNode extends Node implements TypeExtensionNode{public $kind=NodeKind::ENUM_TYPE_EXTENSION;public $name;public $directives;public $values;}