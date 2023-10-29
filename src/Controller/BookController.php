<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/book', name: 'book')]
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/searchBooks', name: 'searchBooks')]
    public function searchBooks(Request $request, BookRepository $bookRepository): Response
    {
    $ref = $request->query->get('ref');

    if ($ref) {
        $book = $bookRepository->searchBookByRef($ref);

        if ($book) {
            // Affiche le livre trouvé
            return $this->render('book/show.html.twig', ['book' => $book]);
        } else {
            // Livre non trouvé
            return $this->render('book/book_not_found.html.twig');
        }
    }

    // Gestion du cas où la référence n'a pas été fournie
    return $this->render('book/list_books.html.twig', [
        'books' => $bookRepository->findAll(),
    ]);
    }

    #[Route('/booksListByAuthors', name:'booksListByAuthors')]
    public function booksListByAuthors(BookRepository $bookRepository): Response
    {
    $books = $bookRepository->booksListByAuthors();

    return $this->render('book/list_books_by_authors.html.twig', [
        'books' => $books,
    ]);
    }

    #[Route('/listBooksBefore2023WithAuthor10Books', name:'listBooksBefore2023WithAuthor10Books')]
    public function listBooksBefore2023WithAuthor10Books(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findBooksBefore2023WithAuthorHaving10Books();

        return $this->render('book/list_published_books.html.twig', [
            'books' => $books,
        ]);
    }
}
