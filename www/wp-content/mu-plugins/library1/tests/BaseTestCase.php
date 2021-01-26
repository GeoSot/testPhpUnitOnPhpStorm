<?php
namespace Tests\Sample\Library1;

use Illuminate\Support\Str;
use Mockery;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

abstract class BaseTestCase extends TestCase
{
    use ProphecyTrait;

    public function tearDown(): void
    {
        \WP_Mock::tearDown();

        if (class_exists('Mockery'))
        {
            if ($container = Mockery::getContainer())
            {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            try
            {
                Mockery::close();
            }
            catch (Mockery\Exception\InvalidCountException $e)
            {
                if (! Str::contains($e->getMethodName(), ['doWrite', 'askQuestion']))
                {
                    throw $e;
                }
            }
        }
    }

    public static function setUpBeforeClass(): void
    {
        Display::info('-- ' . static::class);
    }

    public function setUp(): void
    {
        \WP_Mock::setUp();
        parent::setUp();
        $this->displayMethodName();
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param $instance
     * @param string $property
     *
     * @return mixed
     */
    protected function getReflectionProperty($instance, string $property)
    {
        $ref = new ReflectionClass($instance);
        $refProperty = $ref->getProperty($property);
        $refProperty->setAccessible(true);
        return $refProperty->getValue($instance);
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param $instance
     * @param string $method
     * @param array $args
     *
     * @return mixed
     */
    protected function execReflectionMethod($instance, string $method, array $args = [])
    {
        $class = is_object($instance) ? \get_class($instance) : $instance;
        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        if ($method->isStatic())
        {
            return empty($args) ? $method->invoke(null) : $method->invokeArgs(null, $args);
        }
        return empty($args) ? $method->invoke($instance) : $method->invokeArgs($instance, $args);
    }

    protected function displayMethodName(): void
    {
        $testName = str_replace(["test", "_"], ["", " "], $this->getName());
        $testName = preg_replace_callback("/[a-zA-Z0-9]{3,}\b/", function ($match) {
            return ucfirst($match[0]);
        }, $testName);

        Display::echo("  ->  {$testName}");
    }
}

