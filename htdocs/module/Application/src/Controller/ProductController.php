<?php

namespace Application\Controller;

use Application\Form\ProductForm;
use Application\Model\CategoryTable;
use Application\Model\Product;
use Application\Model\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController {

    /**
     * @var ProductTable
     */
    private $productTable;
    /**
     * @var CategoryTable
     */
    private $categoryTable;

    public function __construct(
        ProductTable $productTable,
        CategoryTable $categoryTable
    )
    {
        $this->productTable = $productTable;
        $this->categoryTable = $categoryTable;
    }

    public function indexAction()
    {
        return new ViewModel(['products' => $this->productTable->getAll()]);
    }

    public function createAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Adcionar Produto');
        $form->get('category')->setValueOptions($this->categoryTable->getList());

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ViewModel(['form' => $form]);
        }
        $product = new Product();
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return new ViewModel(['form' => $form]);
        }
        $product->setForm($request->getPost());
        $this->productTable->save($product);
        return $this->redirect()->toRoute('product');
    }

    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('product', ['action' => 'create']);
        }
        try {
            $product = $this->productTable->get($id);
        } catch (\Exception $exception) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }
        $form = new ProductForm();
        $form->bind($product);
        $form->get('category')->setValueOptions($this->categoryTable->getList());
        $form->get('submit')->setAttribute('class', 'btn-sm btn');
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['id' => $id, 'form' => $form];
        }
        $request = $this->getRequest();
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return ['id' => $id, 'form' => $form];
        }
        $product->setForm($request->getPost());
        $this->productTable->save($product);
        return $this->redirect()->toRoute('product');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('product');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $confirm = $request->getPost('confirm', 'Não');
            if ($confirm == 'Sim') {
                $this->productTable->delete($id);
            }
            $this->redirect()->toRoute('product');
        }
        return ['id' => $id, 'product' => $this->productTable->get($id)];

        return new ViewModel();
    }

    public function categoryAction()
    {
        $idCategory = (int) $this->params()->fromRoute('id', 0);
        if (0 === $idCategory) {
            return $this->redirect()->toRoute('product');
        }
        $category = $this->categoryTable->get($idCategory);
        $products = $this->productTable->getList($idCategory);
        return new ViewModel(['products' => $products, 'name' => $category->getName()]);

    }
}