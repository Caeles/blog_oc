<?php

namespace App\HTML;

class Form{
    
    
    private $data;//contient les données du formulaire
    private $errors;
    public function __construct($data, array $errors){
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string  $label): string {

        $value = $this->getValue($key); 
        $type = $key === "password" ? "password" : "text";
        return <<<HTML
        <div class="form-grtoup">
        <label for="field{$key}">{$label}</label>
            <input type="{$type}" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
            {$this->getErrorsFeedback($key)}
        </div>
        HTML;
    }

    public function textarea(string $key, string  $label): string {
        $value = $this->getValue($key);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return <<<HTML
        <div class="form-grtoup">
        <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
            {$this->getErrorsFeedback($key)}
        </div>
        HTML;
    }

    private function getValue(string $key){
        if(is_array($this->data)){
            return $this->data[$key]  ?? null;
        }
        $method = 'get' . str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
        $value =   $this->data->$method();
        if($value instanceof \DateTimeInterface){
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass (string $key): string {
        $inputClass = 'form-control';
        if(isset($this->errors[$key])){
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorsFeedback (string $key): string {
        $invalidFeedback = '';
        if(isset($this->errors[$key])){
            if(is_array($this->errors[$key])){
                $error = implode('<br>', $this->errors[$key]);
            }else{
                $error = $this->errors[$key];
            }
            $invalidFeedback = '<div class="invalid-feedback">' . $error  . '</div>' ;
        }
        return $invalidFeedback;
    }
    
    public function select (string $key, string $label, array $options = [], bool $multiple = false): string{
        
        $optionsHTML = [];
        $value = $this->getValue($key);
        
        if (!is_array($value)) {
            $value = [$value];
        }
        
        foreach($options as $k => $v){
            $selected = in_array($k, $value) ? " selected" : "";
            $optionsHTML[] = "<option value=\"$k\"$selected>$v</option>" ;
        }
        $optionsHTML = implode('', $optionsHTML);
        
        $multipleAttr = $multiple ? " multiple" : "";
        $name = $multiple ? "{$key}[]" : $key;
        
        return <<<HTML
        <div class="form-group">
        <label for="field{$key}">{$label}</label>
            <select id="field{$key}" class="{$this->getInputClass($key)}" name="{$name}" required{$multipleAttr}>{$optionsHTML}</select>
            {$this->getErrorsFeedback($key)}
        </div>
        HTML;
    }
}