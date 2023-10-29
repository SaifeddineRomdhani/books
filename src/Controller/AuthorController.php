<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/author', name:'author')]
class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/listAuthorsByEmail', name: 'listAuthorsByEmail')]
    public function listAuthorsByEmail(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->listAuthorByEmail();

        return $this->render('author/listAuthorsByEmail.html.twig', [
            'authors' => $authors,
        ]);
    }
    #[Route('/addauthor', name: 'addauthor')]
    public function addAuthor(ManagerRegistry $mr, Request $req):Response{
        $s= new Author (); // 1- instance
        $form=$this->createForm(AuthorFormType::class,$s); //2- création du formulaire 
        $form->handleRequest($req); // 3- analyze request et récupérer les données
        if($form->isSubmitted()){
            $em=$mr->getManager(); //4-persist+flush
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('listAuthorsByEmail');
        }
        return $this->render('author/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}
