<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Teebb\CoreBundle\Entity\Content;
use Teebb\CoreBundle\Repository\BaseContentRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $title = $request->get('title', '');

        /**@var BaseContentRepository $baseContentRepo * */
        $baseContentRepo = $em->getRepository(Content::class);

        $criteria = [];
        if ($title !== '') {
            $criteria = ['title' => '%' . $title . '%'];
        }

        /**@var Pagerfanta $paginator**/
        $paginator = $baseContentRepo->createPaginator($criteria, ['id' => 'DESC']);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $this->render('front/search_results.html.twig', [
            'keyword' => $title,
            'paginator' => $paginator
        ]);
    }
}
