<?php

namespace Application\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Product implements ArraySerializableInterface
{
    private $id;
    private $idCategory;
    private $date;
    private $name;
    private $value;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;
        return $this;
    }

    public function getIdCategory()
    {
        return $this->idCategory;
    }

    private function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
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

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function exchangeArray(array $array)
    {
        $this
            ->setId($array['id_produto'])
            ->setIdCategory($array['id_categoria_produto'])
            ->setDate($array['data_produto'])
            ->setName($array['nome_produto'])
            ->setValue($array['valor_produto']);

        return $this;
    }

    public function setForm($data)
    {
        $this
            ->setId($data['id'])
            ->setName($data['name'])
            ->setIdCategory($data['category'])
            ->setDate($data['date'])
            ->setValue($data['value']);

        return $this;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'idCategory' => $this->getIdCategory(),
            'date' => $this->getDate(),
            'name' => $this->getName(),
            'value' => $this->getValue(),
        ];
    }
}
