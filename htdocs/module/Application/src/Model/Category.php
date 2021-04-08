<?php

namespace Application\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Category implements ArraySerializableInterface
{

    private $id;
    private $name;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function exchangeArray(array $array)
    {
        $this
            ->setId($array['id_categoria_produto'])
            ->setName($array['nome_categoria']);

        return $this;
    }

    public function setForm($data)
    {
        $this
            ->setId($data['id'])
            ->setName($data['name']);

        return $this;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}