<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CategoryTable
{

    private $tableGateway;

    function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAll()
    {
        return $this->tableGateway->select();
    }

    public function getList()
    {
        $list = [];
        $categories = $this->getAll();
        foreach ($categories as $category) {
            $list[$category->getId()] = $category->getName();
        }
        return $list;
    }

    public function get($id)
    {
        $id = (int)$id;
        $rowSet = $this->tableGateway->select(['id_categoria_produto' => $id]);
        $row = $rowSet->current();
        if (!$row) {
            throw new RuntimeException(sprintf('O id %d não foi encontrado.', $id));
        }
        return $row;
    }

    public function save(Category $category)
    {
        $data = [
            'nome_categoria' => $category->getName(),
        ];

        $id = (int)$category->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data, ['id_categoria_produto' => $id]);
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id_categoria_produto' => (int)$id]);
    }
}