<?php declare(strict_types = 1);

namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Type;

class ArraySpliceFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{

	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return $functionReflection->getName() === 'array_splice';
	}

	public function getTypeFromFunctionCall(
		FunctionReflection $functionReflection,
		FuncCall $functionCall,
		Scope $scope
	): Type
	{
		if (!isset($functionCall->getArgs()[0])) {
			return ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->getArgs(), $functionReflection->getVariants())->getReturnType();
		}

		$arrayArg = $scope->getType($functionCall->getArgs()[0]->value);

		return new ArrayType($arrayArg->getIterableKeyType(), $arrayArg->getIterableValueType());
	}

}
