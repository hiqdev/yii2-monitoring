<?php

declare(strict_types=1);

namespace hiqdev\yii2\monitoring\tests\unit;

use hiqdev\yii2\monitoring\Module;
use yii\base\ErrorException;
use yii\log\Logger;

class ModuleTest extends TestCase
{
    private Module $module;

    protected function setUp(): void
    {
        parent::setUp();
        $module = $this->getMockBuilder(Module::class)
            ->setConstructorArgs(['monitoring'])
            ->onlyMethods(['getDebugUrl'])
            ->getMock();
        $module->method('getDebugUrl')->willReturn('test-url');
        $this->module = $module;
    }

    /**
     * Tests specifically that no ErrorException is thrown when using a float timestamp
     *
     * @return void
     */
    public function testPrepareMessageDataDoesNotThrowErrorOnFloatTimestamp(): void
    {
        try {
            $message = $this->createMessageWith(1627484400.123456);
            $this->module->prepareMessageData($message);
            $this->assertTrue(true); // If we get here, no exception was thrown
        } catch (ErrorException $e) {
            $this->fail('ErrorException was thrown: ' . $e->getMessage());
        }
    }

    private function createMessageWith($timestamp): array
    {
        $traces = [
            ['file' => '/path/to/file.php', 'line' => 123],
            ['file' => '/path/to/another.php', 'line' => 456],
        ];

        return [
            'Test message',
            Logger::LEVEL_ERROR,
            'application',
            $timestamp,
            $traces,
            'throwable' => null,
            'debugUrl' => 'test-url',
        ];
    }
}
