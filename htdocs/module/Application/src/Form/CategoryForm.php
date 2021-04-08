<?php

namespace Application\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class CategoryForm extends Form
{

        public function __construct()
        {
            parent::__construct('category', []);
            $this->add(new Hidden('id'));
            $this->add(new Text('name', ['label' => 'Nome']));

            $submit = new Submit('submit');
            $submit->setAttributes(['value' => 'Salvar', 'id' => 'submitbutton']);
            $this->add($submit);
        }
}