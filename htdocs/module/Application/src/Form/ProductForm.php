<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ProductForm extends Form
{
    private $category;

    public function __construct(
    )
    {
        parent::__construct('product', []);
        $this->createForm();
    }

    private function createForm() {
        $this->add(new Element\Hidden('id'));
        $this->add(new Element\Select('category',['label' => 'Categoria']));
        $this->add(new Element\Text('name', ['label' => 'Nome']));
        $this->add(new Element\Number('value', [
            'label' => 'Valor',
            'min' => '0.00',
            'step' => '0.01',
        ]));
        $this->add(new Element\Submit('submit', [
            'value' => 'Salvar',
            'id' => 'submitbutton',
        ]));

    }
}