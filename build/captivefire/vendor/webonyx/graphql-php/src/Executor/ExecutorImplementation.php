<?php  declare(strict_types=1);namespace GraphQL\Executor;use GraphQL\Executor\Promise\Promise;interface ExecutorImplementation{public function doExecute():Promise;}