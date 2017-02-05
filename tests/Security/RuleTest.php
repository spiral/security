<?php
/**
 * Spiral, Core Components
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Tests\Security;

use Spiral\Core\ResolverInterface;
use Spiral\Security\ActorInterface;
use Spiral\Security\Exceptions\RuleException;
use Spiral\Security\Rule;

/**
 * Class RuleTest
 *
 * @package Spiral\Tests\Security
 */
class RuleTest extends \PHPUnit_Framework_TestCase
{
    const OPERATION = 'test';
    const CONTEXT   = [];

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ActorInterface
     */
    private $actor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ResolverInterface
     */
    private $resolver;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Rule
     */
    private $rule;

    protected function setUp()
    {
        $this->actor = $this->createMock(ActorInterface::class);
        $this->resolver = $this->createMock(ResolverInterface::class);
        $this->rule = $this->getMockBuilder(Rule::class)
            ->setConstructorArgs([$this->resolver])
            ->setMethods([Rule::CHECK_METHOD])->getMock();
    }

    /**
     * @param $permission
     * @param $context
     * @param $allowed
     *
     * @dataProvider allowsProvider
     */
    public function testAllows($permission, $context, $allowed)
    {
        $parameters = [
                'actor'      => $this->actor,
                'user'       => $this->actor,
                'permission' => $permission,
                'context'    => $context,
            ] + $context;

        $method = new \ReflectionMethod($this->rule, Rule::CHECK_METHOD);
        $this->resolver
            ->expects($this->once())
            ->method('resolveArguments')
            ->with($method, $parameters)
            ->willReturn([$parameters]);

        $this->rule
            ->expects($this->once())
            ->method(Rule::CHECK_METHOD)
            ->with($parameters)
            ->willReturn($allowed);

        $this->assertEquals($allowed, $this->rule->allows($this->actor, $permission, $context));
    }

    public function testAllowsException()
    {
        $this->expectException(RuleException::class);
        $this->rule->allows($this->actor, static::OPERATION, static::CONTEXT);
    }

    /**
     * @return array
     */
    public function allowsProvider()
    {
        return [
            ['test.create', [], false],
            ['test.create', [], true],
            ['test.create', ['a' => 'b'], false],
            ['test.create', ['a' => 'b'], true],
        ];
    }
}