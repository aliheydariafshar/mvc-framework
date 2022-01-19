<?php


namespace System\Request;


use System\Request\Traits\HasFileValidationRules;
use System\Request\Traits\HasRunValidation;
use System\Request\Traits\HasValidationRules;

class Request
{
    use HasValidationRules, HasFileValidationRules, HasRunValidation;

    protected $errorExist = false;
    protected $request;
    protected $files = null;
    protected $errorVariablesName = [];

    public function __construct()
    {
        if (isset($_POST)) {
            $this->postAttributes();
        }
        if (!empty($_FILES)) {
            $this->files = $_FILES;
        }

        $rules = $this->rules();
        !empty($rules) ? $this->run($rules) : null;
        $this->errorRedirect();
    }

    protected function rules()
    {
        return [];
    }

    public function file($name)
    {
        return isset($this->files[$name]) ? $this->files[$name] : false;
    }

    protected function postAttributes()
    {
        foreach ($_POST as $key => $value) {
            $this->key = htmlentities($value);
            $this->request[$key] = htmlentities($value);
        }
    }

    protected function run(array $rules)
    {
        foreach ($rules as $attr => $values) {
            $ruleArray = explode('|', $values);
            if (in_array('file', $ruleArray)) {
                unset($ruleArray[array_search('file', $ruleArray)]);
                $this->fileValidation($attr, $ruleArray);
            } elseif (in_array('number', $ruleArray)) {
                $this->numberValidation($attr, $ruleArray);
            } else {
                $this->normalValidation($attr, $ruleArray);
            }
        }
    }

    private function errorRedirect()
    {
    }
}