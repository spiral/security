<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 */

namespace Spiral\Security;


use Spiral\Core\ResolverInterface;

/**
 * Class RuleTest
 *
 * @package Spiral\Security
 */
class RuleTest extends \PHPUnit_Framework_TestCase
{
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
        /** @var ActorInterface $actor */
        $actor = $this->createMock(ActorInterface::class);

        $parameters = [
                'actor'      => $actor,
                'user'       => $actor,
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

        $this->assertEquals($allowed, $this->rule->allows($actor, $permission, $context));
    }

    /**
     * @return array
     */
    public function allowsProvider()
    {
        return [
            ['foo.create', [], false],
            ['foo.create', [], true],
            ['foo.create', ['a' => 'b'], false],
            ['foo.create', ['a' => 'b'], true],
        ];
    }
}