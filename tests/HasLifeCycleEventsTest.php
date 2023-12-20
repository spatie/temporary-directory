<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Spatie\TemporaryDirectory\HasLifeCycleEvents;

class HasLifeCycleEventsTest extends TestCase
{
    use HasLifeCycleEvents;

    public static $callbackCalled = false;
    public static $randomStringForTest = "asd";
    public $callback;


    protected function setUp(): void
    {
        parent::setUp();

        $this->callback = static function ($instance) {
            // make sure its being runned, really, really sure.
            $instance::$randomStringForTest = substr(md5(microtime()), 0, 5);
            $instance::$callbackCalled = true;
        };
    }

    public function testCallBeforeCreateCallbacks(): void
    {
        self::$callbackCalled = false;
        $this->beforeCreate($this->callback);
        $this->callBeforeCreateCallbacks();
        $this->assertTrue(self::$callbackCalled);
        self::assertMatchesRegularExpression('/^[a-z0-9]{5}$/', self::$randomStringForTest);

    }

    public function testCallAfterCreateCallbacks(): void
    {
        self::$callbackCalled = false;

        $this->afterCreate($this->callback);
        $this->callAfterCreateCallbacks();
        $this->assertTrue(self::$callbackCalled);
        self::assertMatchesRegularExpression('/^[a-z0-9]{5}$/', self::$randomStringForTest);

    }

    public function testCallBeforeDeleteCallbacks(): void
    {
        self::$callbackCalled = false;

        $this->beforeCreate($this->callback);
        $this->callBeforeCreateCallbacks();
        $this->assertTrue(self::$callbackCalled);
        self::assertMatchesRegularExpression('/^[a-z0-9]{5}$/', self::$randomStringForTest);

    }

    public function testCallAfterDeleteCallbacks(): void
    {
        self::$callbackCalled = false;

        $this->afterCreate($this->callback);
        $this->callAfterCreateCallbacks();
        $this->assertTrue(self::$callbackCalled);
        self::assertMatchesRegularExpression('/^[a-z0-9]{5}$/', self::$randomStringForTest);

    }
}
