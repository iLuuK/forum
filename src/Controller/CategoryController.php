<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Trait\RoleTrait;
use App\Controller\Trait\DeleteTrait;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/category', name: 'category-')]
class CategoryController extends AbstractController
{
    use RoleTrait;
    use DeleteTrait;

    #[Route('/', name: 'main')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findByNoParent()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($category->getTitle())->lower();
            $category->setSlug($slug);
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie ajouté !');
            return $this->redirectToRoute('category-main');
        }

        return $this->render('category/add.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit')]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($category->getTitle())->lower();
            $category->setSlug($slug);
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie modifié !');
            return $this->redirectToRoute('category-main');
        }

        return $this->render('category/edit.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    
    #[Route('/{slug}/delete', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Category $category): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $this->deleteCategory($entityManager, $category);
        $this->addFlash('success', 'Catégorie supprimé !');

        return $this->redirectToRoute('category-main');
    }
}
