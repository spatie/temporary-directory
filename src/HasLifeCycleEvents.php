<?php

namespace Spatie\TemporaryDirectory;

trait HasLifeCycleEvents
{
    protected $beforeCreateCallbacks = [];

    protected $afterCreateCallbacks = [];
    protected $beforeDeleteCallbacks = [];
    protected $afterDeleteCallbacks = [];

    public function callBeforeCreateCallbacks(): void
    {

        foreach ($this->beforeCreateCallbacks as $callback) {
            if (is_callable($callback)) {
                $callback($this);
            }
        }
    }

    public function callAfterCreateCallbacks(): void
    {

        foreach ($this->afterCreateCallbacks as $callback) {
            if (is_callable($callback)) {
                $callback($this);
            }
        }
    }

    public function callBeforeDeleteCallbacks(): void
    {

        foreach ($this->beforeDeleteCallbacks as $callback) {
            if (is_callable($callback)) {
                $callback($this);
            }
        }
    }

    public function callAfterDeleteCallbacks(): void
    {

        foreach ($this->afterDeleteCallbacks as $callback) {
            if (is_callable($callback)) {
                $callback($this);
            }
        }
    }

    public function beforeCreate(array|callable $callback): object
    {
        if (! is_array($callback)) {
            $callback = [$callback];
        }

        foreach ($callback as $item) {
            if (is_callable($item)) {
                $this->beforeCreateCallbacks[] = $item;
            }
        }

        return $this;
    }

    public function afterCreate(array|callable $callback): object
    {
        if (! is_array($callback)) {
            $callback = [$callback];
        }

        foreach ($callback as $item) {
            if (is_callable($item)) {
                $this->afterCreateCallbacks[] = $item;
            }
        }

        return $this;
    }

    public function afterDelete(array|callable $callback): object
    {
        if (! is_array($callback)) {
            $callback = [$callback];
        }

        foreach ($callback as $item) {
            if (is_callable($item)) {
                $this->afterDeleteCallbacks[] = $item;
            }
        }

        return $this;
    }

    public function beforeDelete(array|callable $callback): object
    {
        if (! is_array($callback)) {
            $callback = [$callback];
        }

        foreach ($callback as $item) {
            if (is_callable($item)) {
                $this->beforeDeleteCallbacks[] = $item;
            }
        }

        return $this;
    }
}
