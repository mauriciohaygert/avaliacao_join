<?php

namespace Application\Model;

use http\Exception\RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProductTable
{
	
	private $tableGateway;

	function __construct(TableGatewayInterface $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function getAll(){
		return $this->tableGateway->select();
	}

	public function getList($idCategory){
		return $this->tableGateway->select("id_categoria_produto = '$idCategory'");
	}

	public function get($id){
	    $id = (int) $id;
	    $rowSet = $this->tableGateway->select(['id_produto' => $id]);
	    $row = $rowSet->current();
	    if (!$row) {
	        throw new RuntimeException(sprintf('O id %d não foi encontrado.', $id));
        }
	    return $row;
    }

    public function save(Product $product)
    {
        $data = [
            'id_categoria_produto' => $product->getIdCategory(),
            'data_cadastro' => date('Y/m/d'),
            'nome_produto' => $product->getName(),
            'valor_produto' => $product->getValue(),
        ];

        $id = (int) $product->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data, ['id_produto' => $id]);
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id_produto' => (int)$id]);
    }
}