<?php declare(strict_types = 1);

/**
 * Test: Schema\Validation\ControllerValidation
 */

require_once __DIR__ . '/../../../bootstrap.php';

use Apitte\Core\Exception\Logical\InvalidSchemaException;
use Apitte\Core\Schema\Builder\SchemaBuilder;
use Apitte\Core\Schema\Validation\ControllerValidation;
use Tester\Assert;
use Tests\Fixtures\Controllers\FoobarController;

// Validate: success
test(function (): void {
	$validation = new ControllerValidation();
	$builder = new SchemaBuilder();

	$c1 = $builder->addController(FoobarController::class);

	Assert::noError(function () use ($validation, $builder): void {
		$validation->validate($builder);
	});
});

// Validate: not an IController
test(function (): void {
	$validation = new ControllerValidation();
	$builder = new SchemaBuilder();

	$c1 = $builder->addController('c1');

	Assert::exception(function () use ($validation, $builder): void {
		$validation->validate($builder);
	}, InvalidSchemaException::class, 'Controller "c1" must implement "Apitte\Core\UI\Controller\IController"');
});
