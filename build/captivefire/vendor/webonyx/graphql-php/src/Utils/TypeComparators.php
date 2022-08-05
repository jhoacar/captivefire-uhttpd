<?php  declare(strict_types=1);namespace GraphQL\Utils;use GraphQL\Type\Definition\AbstractType;use GraphQL\Type\Definition\CompositeType;use GraphQL\Type\Definition\ListOfType;use GraphQL\Type\Definition\NonNull;use GraphQL\Type\Definition\ObjectType;use GraphQL\Type\Definition\Type;use GraphQL\Type\Schema;class TypeComparators{public static function isEqualType(Type $typeA,Type $typeB){if($typeA ===$typeB){return true;}if($typeA instanceof NonNull &&$typeB instanceof NonNull){return self::isEqualType($typeA->getWrappedType(),$typeB->getWrappedType());}if($typeA instanceof ListOfType &&$typeB instanceof ListOfType){return self::isEqualType($typeA->getWrappedType(),$typeB->getWrappedType());}return false;}public static function isTypeSubTypeOf(Schema $schema,$maybeSubType,$superType){if($maybeSubType ===$superType){return true;}if($superType instanceof NonNull){if($maybeSubType instanceof NonNull){return self::isTypeSubTypeOf($schema,$maybeSubType->getWrappedType(),$superType->getWrappedType());}return false;}if($maybeSubType instanceof NonNull){return self::isTypeSubTypeOf($schema,$maybeSubType->getWrappedType(),$superType);}if($superType instanceof ListOfType){if($maybeSubType instanceof ListOfType){return self::isTypeSubTypeOf($schema,$maybeSubType->getWrappedType(),$superType->getWrappedType());}return false;}if($maybeSubType instanceof ListOfType){return false;}return Type::isAbstractType($superType)&&$maybeSubType instanceof ObjectType &&$schema->isPossibleType($superType,$maybeSubType);}public static function doTypesOverlap(Schema $schema,CompositeType $typeA,CompositeType $typeB){if($typeA ===$typeB){return true;}if($typeA instanceof AbstractType){if($typeB instanceof AbstractType){foreach($schema->getPossibleTypes($typeA)as $type){if($schema->isPossibleType($typeB,$type)){return true;}}return false;}return $schema->isPossibleType($typeA,$typeB);}if($typeB instanceof AbstractType){return $schema->isPossibleType($typeB,$typeA);}return false;}}