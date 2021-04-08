<?php

namespace Application\Controller;

use Application\Form\CategoryForm;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController {

    /**
     * @var CategoryTable
     */
    private $table;

    public function __construct(
        CategoryTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel(['categories' => $this->table->getAll()]);
    }

    public function createAction()
    {
        $form = new CategoryForm();
        $form->get('submit')->setValue('Adcionar Categoria');
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ViewModel(['form' => $form]);
        }
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return new ViewModel(['form' => $form]);
        }
        $category = new Category();
        $category->setForm($form->getData());
        $this->table->save($category);
        return $this->redirect()->toRoute('category');
    }

    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('category', ['action' => 'create']);
        }
        try {
            $category = $this->table->get($id);
        } catch (\Exception $exception) {
            return $this->redirect()->toRoute('category', ['action' => 'index']);
        }
        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('class', 'btn-sm btn');
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['id' => $id, 'form' => $form];;
        }
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return ['id' => $id, 'form' => $form];;
        }
        $category->setForm($request->getPost());
        $this->table->save($category);
        return $this->redirect()->toRoute('category');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('category');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $confirm = $request->getPost('confirm', 'Não');
            if ($confirm == 'Sim') {
                $this->table->delete($id);
            }
            $this->redirect()->toRoute('category');
        }
        return ['id' => $id, 'category' => $this->table->get($id)];

        return new ViewModel();
    }
}