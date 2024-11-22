<?php


class Request
{

    public $uri;
    public $method;

    public $data;
    public $v_alias;

    function __construct()
    {

        $this->uri = $_SERVER['REQUEST_URI'];
        $this->data = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->v_alias = $this->v_alias();
    }

    public function validate($rules)
    {
        $data = [];
        foreach ($rules as $key => $rule) { // key and rule defined by user
            $v_rules = explode("|", $rule); // explode the rules
            foreach ($v_rules as $v_rule) {
                $params = [];
                if (str_contains($v_rule, ':')) {

                    [$v_rule, $params] = explode(':', $v_rule); // 'rule_alias:param, param'
                    //parmas,params >> [$parsms, params]
                    $params = explode(",", $params);
                }
                $this->v_alias[$v_rule]($key, $params); // each rule check with alias and run the function
                $data[$key] = request()->data[$key];
            }
        }

        return $data;
    }

    function v_alias()
    {
        return [
            'unique' => 'unique',
            'required' => 'require_data',
        ];
    }
}
