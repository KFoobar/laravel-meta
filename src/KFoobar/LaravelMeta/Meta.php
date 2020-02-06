<?php

namespace KFoobar\LaravelMeta;

use KFoobar\LaravelMeta\TagContructor;

class Meta
{
    protected $metas = [];
    protected $title;

    private $_constructor;

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->metas['csrf-token'] = csrf_token();
    }

    /**
     * Magic getters and setters.
     *
     * @param string $method
     * @param array $params
     *
     * @return mixed
     */
    public function __call(string $method, array $params = [])
    {
        $property = lcfirst(substr($method, 3));

        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->get($property, $params[0] ?? null);
        }

        if (strncasecmp($method, 'set', 3) === 0) {
            return $this->set($property, $params[0] ?? null);
        }

        return false;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     */
    public function setTitle(string $title = null)
    {
        $this->title = trim($title);
    }

    /**
     * Gets the title.
     *
     * @param string $default
     *
     * @return string
     */
    public function getTitle(string $default = null)
    {
        return ($this->title) ? $this->title : $default;
    }

    /**
     * Sets the value of a propery.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        $method = sprintf('set%s', ucfirst($key));

        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } elseif (property_exists($this, $key)) {
            $this->{$key} = $value;
        } else {
            $this->metas[$key] = $value;
        }
    }

    /**
     * Gets value of a property.
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    public function get(string $key, string $default = null)
    {
        $method = sprintf('get%s', ucfirst($key));

        if (method_exists($this, $method)) {
            return $this->{$method}($default);
        } elseif (property_exists($this, $key)) {
            return !empty($this->{$key}) ? $this->{$key} : $default;
        }

        return !empty($this->metas[$key]) ? $this->metas[$key] : $default;
    }

    /**
     * Check if a propery or key exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key)
    {
        if (property_exists($this, $key)) {
            return true;
        }

        return (!empty($this->metas[$key])) ? true : false;
    }

    /**
     * Generates HTML for the tag/key.
     *
     * @param string $key
     * @param string $default
     *
     * @return string | void
     */
    public function tag(string $key, string $default = null)
    {
        if (is_null($value = $this->get($key, $default))) {
            return;
        }

        if (!$this->_constructor instanceof TagContructor) {
            $this->_constructor = new TagContructor;
        }

        return $this->_constructor->getTag($key, $value);
    }
}
