<?php  declare(strict_types=1);namespace GraphQL\Language\AST;class OperationDefinitionNode extends Node implements ExecutableDefinitionNode,HasSelectionSet{public $kind=NodeKind::OPERATION_DEFINITION;public $name;public $operation;public $variableDefinitions;public $directives;public $selectionSet;}