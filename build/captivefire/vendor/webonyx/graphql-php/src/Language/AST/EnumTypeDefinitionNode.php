<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class EnumTypeDefinitionNode extends Node implements TypeDefinitionNode{public $kind=NodeKind::ENUM_TYPE_DEFINITION;public $name;public $directives;public $values;public $description;}