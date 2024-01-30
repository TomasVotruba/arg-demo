<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use PhpParser\Node;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Utils\Rector\Tests\Rector\SomeArgRector\SomeArgRectorTest
 */
final class SomeArgRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('// @todo fill the description', [
            new CodeSample(
                <<<'CODE_SAMPLE'
// @todo fill code before
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
// @todo fill code after
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // @todo select node type
        return [Node\Expr\MethodCall::class];
    }

    /**
     * @param Node\Expr\MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $this->isName($node->name, 'assertSnapshot')) {
            return null;
        }

        if (! $node->var instanceof Node\Expr\MethodCall) {
            return null;
        }

        // $testedCaller: $anotherClass->someMethod()
        $testedCaller = $node->var;
        $testedCallerType = $this->getType($testedCaller->var);

        // object type
        if (! $testedCallerType instanceof \PHPStan\Type\ObjectType) {
            return null;
        }

        // "AnotherClass"
        $testedClassName =  $testedCallerType->getClassName();
        // "someMethod"
        $testedMethodName = $this->getName($testedCaller->name);

        // call with refrelctoin
        // $testedMethodReflectoin = new \ReflectionMethod($testedClassName, $testedMethodName);
        $result = [1234]; // $testedMethodReflectoin->invoke();


        // helper to create Arg from any scalar value
        $args = $this->nodeFactory->createArgs([$result]);
        $node->args = array_merge($args, $node->args);

        return $node;
    }
}
