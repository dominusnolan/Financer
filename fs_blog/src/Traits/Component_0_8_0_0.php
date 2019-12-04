<?php

namespace ComposePress\Core\Traits;

use ComposePress\Core\Exception\ComponentInitFailure;
use ComposePress\Core\Exception\ComponentMissing;
use ComposePress\Core\Exception\Plugin;
/**
 * Trait Component_0_8_0_0
 *
 * @package ComposePress\Core\Traits
 */
trait Component_0_8_0_0
{
    use BaseObject_0_8_0_0;
    /**
     * @var \ComposePress\Core\Abstracts\Plugin_0_8_0_0
     */
    private $plugin;
    /**
     * @var \ComposePress\Core\Traits\Component_0_8_0_0
     */
    private $parent;
    /**
     */
    public function __destruct()
    {
        $this->plugin = null;
        $this->parent = null;
    }
    /**
     * jQuery inspired method to get the first parent component that is an instance of the given class
     *
     * @param $class
     * @return bool|\ComposePress\Core\Traits\Component_0_8_0_0
     */
    public function get_closest($class)
    {
        $parent = $this;
        while ($parent->has_parent() && !is_a($parent, $class)) {
            $parent = $parent->get_parent();
        }
        if ($parent === $this || !is_a($parent, $class)) {
            return false;
        }
        return $parent;
    }
    /**
     * Return if the current component has a parent or not
     *
     * @return bool
     */
    public function has_parent()
    {
        return null !== $this->parent;
    }
    /**
     * @return \ComposePress\Core\Traits\Component_0_8_0_0
     */
    public function get_parent()
    {
        return $this->parent;
    }
    /**
     * @param \ComposePress\Core\Traits\Component_0_8_0_0 $parent
     */
    public function set_parent($parent)
    {
        $this->parent = $parent;
    }
    /**
     * @param string $class
     * @param mixed $args,...
     * @return mixed
     * @throws \ComposePress\Core\Exception\Plugin
     */
    public function create_component($class, $args = array())
    {
        $arg_list = func_get_args();
        array_shift($arg_list);
        foreach ($arg_list as $key => $arg) {
            $arg_list[$key] = [$arg];
        }
        if (0 < count($arg_list)) {
            $arg_list = call_user_func_array('array_merge', $arg_list);
        }
        $component = $this->create_object($class, $arg_list);
        $component->set_parent($this);
        return $component;
    }
    /**
     * @param $class
     * @param array $args
     * @return mixed
     * @throws \ComposePress\Core\Exception\Plugin
     */
    public function create_object($class, $args = array())
    {
        return $this->get_plugin()->container->create($class, $args);
    }
    /**
     * Magical utility method that will walk up the reference chain to get the master Plugin instance and cache it in $plugin
     *
     * @return \ComposePress\Core\Abstracts\Plugin_0_8_0_0
     * @throws \ComposePress\Core\Exception\Plugin
     */
    public function get_plugin()
    {
        if (null === $this->plugin) {
            $parent = $this;
            while ($parent->has_parent()) {
                $parent = $parent->get_parent();
            }
            $this->plugin = $parent;
        }
        if ($this->plugin === $this && !$this instanceof \ComposePress\Core\Abstracts\Plugin_0_8_0_0) {
            throw new Plugin(sprintf('Plugin property on %s is equal to self. Did you forget to set the parent or create a getter?', $this->get_full_class_name()));
        }
        if (!$this->plugin instanceof \ComposePress\Core\Abstracts\Plugin_0_8_0_0) {
            throw new Plugin(sprintf('Parent property on %s not set. Did you forget to set the parent?', $this->get_full_class_name()));
        }
        return $this->plugin;
    }
    /**
     * The super init method magic happens
     *
     * @return bool|\Exception
     * @throws \ReflectionException
     */
    public function init()
    {
        try {
            if ($this->is_error($result = $this->link_components())) {
                return $result;
            }
        } catch (\Exception $e) {
            return $e;
        }
        if ($this->is_error($result = $this->init_components())) {
            return $result;
        }
        /**
         * @noinspection DynamicInvocationViaScopeResolutionInspection
         */
        return static::setup();
    }
    protected function is_error($value)
    {
        return false === $value || is_wp_error($value) || $value instanceof \Exception;
    }
    /**
     * Setup components
     *
     * @return bool
     * @throws \ReflectionException
     */
    protected function link_components()
    {
        /**
         * @noinspection DynamicInvocationViaScopeResolutionInspection
         */
        if ($this->is_error($result = static::load_components())) {
            return $result;
        }
        $components = $this->get_components();
        $this->set_component_parents($components);
        return true;
    }
    /**
     * Lazy load components possibly conditionally
     *
     * @return bool
     */
    protected function load_components()
    {
        return true;
    }
    /**
     * Get all components with a getter and that uses the Component trait
     *
     * @return array|\ReflectionProperty[]
     * @throws \ReflectionException
     */
    protected function get_components()
    {
        static $cache = array();
        $hash = spl_object_hash($this);
        if (isset($cache[$hash])) {
            return $cache[$hash];
        }
        $components = (new \ReflectionClass($this))->getProperties();
        $components = array_map(
            /**
             * @param \ReflectionProperty $property
             * @return string
             */
            static function ($property) {
                return $property->name;
            },
            $components
        );
        $components = array_filter($components, [$this, 'is_component']);
        $components = array_map(
            /**
             * @param \ReflectionProperty $component
             * @return \ComposePress\Core\Traits\Component_0_8_0_0
             */
            function ($component) {
                $getter = "get_{$component}";
                return $this->{$getter}();
            },
            $components
        );
        if (!empty($components)) {
            $components = array_map(static function ($component) {
                if (!is_array($component)) {
                    return [$component];
                }
                return $component;
            }, $components);
            $components = call_user_func_array('array_merge', $components);
            $components = array_filter($components, [$this, 'is_component']);
        }
        $cache[$hash] = $components;
        return $components;
    }
    /**
     * Set the parent reference for the given components to the current component
     *
     * @param $components
     */
    protected function set_component_parents($components)
    {
        /**
         * @var \ComposePress\Core\Traits\Component_0_8_0_0 $component
         */
        foreach ($components as $component) {
            $component->set_parent($this);
        }
    }
    /**
     * Run init
     *
     * @return bool|\ComposePress\Core\Exception\ComponentInitFailure
     * @throws \ReflectionException
     */
    protected function init_components()
    {
        /**
         * @var \ComposePress\Core\Abstracts\Component_0_8_0_0[] $components
         */
        $components = $this->get_components();
        foreach ($components as $component) {
            if ($result = $this->try_init($component)) {
                return $result;
            }
        }
        return true;
    }
    /**
     * @param $component \ComposePress\Core\Traits\Component_0_7_6_1
     * @param null|\WP_Error|bool|\Exception $error
     * @return bool|\ComposePress\Core\Exception\ComponentInitFailure|\Exception|void
     * @throws \ReflectionException
     */
    protected function try_init($component, $error = null)
    {
        $result = null !== $error ? $error : $component->init();
        if ($this->is_error($result)) {
            if ($result instanceof \Exception) {
                return $result;
            }
            $message = 'Component %s for parent %s failed to initialize!';
            $args = [$component->get_full_class_name(), $this->get_full_class_name()];
            if ($result) {
                $message .= ' Error: %s';
                /**
                 * @var \WP_Error $result
                 */
                $args[] = $result->get_error_message();
            }
            return new ComponentInitFailure(vsprintf($message, $args));
        }
    }
    /**
     * Method to overload to put in component code
     *
     * @return bool
     */
    public function setup()
    {
        return true;
    }
    /**
     * @param string|\ComposePress\Core\Traits\Component_0_8_0_0 $component
     * @param bool $use_cache
     * @return bool|mixed
     * @throws \ReflectionException
     */
    protected function is_component($component, $use_cache = true)
    {
        static $cache = array();
        if (!is_object($component)) {
            if (!is_string($component)) {
                return false;
            }
            $getter = 'get_' . $component;
            if (!(method_exists($this, $getter) && (new \ReflectionMethod($this, $getter))->isPublic())) {
                return false;
            }
            $component = $this->{$getter}();
        }
        /**
         * @noinspection CallableParameterUseCaseInTypeContextInspection
         */
        if (is_array($component)) {
            $count = count(array_filter($component, function ($component) {
                return $this->is_component($component);
            }));
            return $count > 0 && $count === count($component);
        }
        if (!is_object($component)) {
            return false;
        }
        if ($component instanceof \stdClass) {
            return false;
        }
        $hash = spl_object_hash($component);
        if ($use_cache && isset($cache[$hash])) {
            return $cache[$hash];
        }
        $trait = __TRAIT__;
        $used = class_uses($component);
        if (!isset($used[$trait])) {
            $parents = class_parents($component);
            while (!isset($used[$trait]) && $parents) {
                //get trait used by parents
                $used = class_uses(array_pop($parents));
            }
        }
        $cache[$hash] = in_array($trait, $used, true);
        return $cache[$hash];
    }
    /**
     * Load any property on the current component based on its string value as the class via the container
     *
     * @param string $component
     * @param array $args
     * @return bool
     * @throws \ComposePress\Core\Exception\ComponentMissing
     * @throws \ComposePress\Core\Exception\Plugin
     */
    protected function load($component, $args = array())
    {
        $args = (array) $args;
        if (!property_exists($this, $component)) {
            return false;
        }
        $class = $this->{$component};
        if (!is_string($class) && !is_array($class)) {
            return false;
        }
        $class = (array) $class;
        foreach ($class as $index => $class_element) {
            if (!is_string($class_element)) {
                return false;
            }
            if (!class_exists($class_element)) {
                throw new ComponentMissing(sprintf('Can not find class "%s" for Component "%s" in parent Component "%s"', $class_element, $component, __CLASS__));
            }
            $class[$index] = $this->create_object($class_element, $args);
        }
        if (1 === count($class)) {
            $class = array_pop($class);
        }
        $this->{$component} = $class;
        return true;
    }
    /**
     * Utility method to see if a component property is loaded
     *
     * @param string $component
     * @return bool
     */
    protected function is_loaded($component)
    {
        if (!property_exists($this, $component)) {
            return false;
        }
        $property = $this->{$component};
        $property = is_array($property) ? $property : [$property];
        if (0 === count($property)) {
            return false;
        }
        foreach ($property as $item) {
            if (!is_object($item)) {
                return false;
            }
            if ($item instanceof \stdClass) {
                return false;
            }
        }
        return true;
    }
}