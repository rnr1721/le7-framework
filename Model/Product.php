<?php

namespace le7\Model;

class Product extends \le7\Custom\Model {

    public function check_name($data) {
        $this->errors[] = "Name not cororororewct".$data;
        throw new \Exception("Name not corrrrect");
    }

    public static function getRules(): array {
        return array(
            'id' => [
                'label' => 'ID',
                'validate' => ''
            ],
            'sku' => [
                'label' => _('Product SKU'),
                'validate' => 'minlength:3|maxlength:10',
                'unique' => true,
                'check' => false
            ],
            'name' => [
                'label' => _('Product name'),
                'validate' => 'minlength:3|maxlength:20',
                'unique' => false,
                'check' => false
            ],
            'price' => [
                'label' => _('Product price'),
                'validate' => 'numeric',
                'unique' => false,
                'check' => false,
                'default' => 0.01
            ],
            'owner' => [
                'label' => _('Owner'),
                'validate' => 'required',
                'unique' => false,
                'check' => false,
                'default' => 'ElectroHouse'
            ],
        );
    }

}
