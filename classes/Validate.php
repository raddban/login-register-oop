<?php

class Validate
{
    private $passed = false,
            $errors = [],
            $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function check($source, $items = [])
    {
        foreach ($items as $item => $rules)
        {
            foreach ($rules as $rule => $rule_value)
            {
                $value = trim($source[$item]);
                $item = escape($item);

                if ($rule === 'required' && empty($value))
                {
                    $this->addError("{$item} is required");
                }elseif (!empty($value))
                {
                    switch ($rule)
                    {
                        case 'min':
                            if (strlen($value) < $rule_value)
                            {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value)
                            {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value])
                            {
                                $this->addError("{$rule_value} must match {$item} ");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->count())
                            {
                                $this->addError("{$item} already exist.");
                            }
                            break;
                    }
                }
            }
        }
        if (empty($this->errors))
        {
            $this->passed = true;
        }
        return $this;
    }

    private function addError($error)
    {
        $this->errors[] = $error;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function passed()
    {
        return $this->passed;
    }
}