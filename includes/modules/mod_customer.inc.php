<?php

class mod_customer extends abs_module
{
    private $_get_address_cache;

    public function __construct()
    {

        $this->_get_address_cache = &session::$data['get_address_cache'];

        $this->load();
    }

    public function get_address($fields)
    {

        if (empty($this->modules)) return false;

        $checksum = md5(http_build_query($fields));
        if (isset($this->_get_address_cache[$checksum])) {
            return $this->_get_address_cache[$checksum];
        }

        foreach ($this->modules as $module) {

            if (!method_exists($module, 'get_address')) continue;

            if ($result = $module->get_address($fields)) {
                if (is_array($result) && empty($result['error'])) {
                    foreach ($result as $key => $value) {
                        if (!empty($result[$key])) $fields[$key] = $result[$key];
                    }
                }
            }
        }

        $this->_get_address_cache[$checksum] = $fields;

        return $fields;
    }

    public function validate(&$fields)
    {

        if (empty($this->modules)) return false;

        foreach ($this->modules as $module) {
            if (!method_exists($module, 'validate')) continue;

            $result = $module->validate($fields);

            if (!empty($result['error'])) return $result;

            if (is_array($result)) {
                $fields = array_replace($fields, array_intersect_key($result, $fields));
            }
        }

        return true;
    }

    public function update($fields, $old_fields = null)
    {

        if (empty($this->modules)) return false;

        foreach ($this->modules as $module) {
            if (!method_exists($module, 'update')) continue;
            $module->update($fields, $old_fields);
        }
    }

    public function delete($fields)
    {

        if (empty($this->modules)) return false;

        foreach ($this->modules as $module) {
            if (!method_exists($module, 'delete')) continue;
            $module->delete($fields);
        }
    }

    public function run($method_name, $module_id)
    {
        if (method_exists($this->modules[$module_id], $method_name)) {
            return call_user_func_array([$this->modules[$module_id], $method_name], array_slice(func_get_args(), 2));
        }
    }
}
