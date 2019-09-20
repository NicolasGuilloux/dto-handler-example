<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\DummyEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 *
 * @package   App\Controller
 * @author    Nicolas Guilloux <nicolas.guilloux@protonmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $dummyEntities = $entityManager->getRepository(DummyEntity::class)->findAll();

        return $this->render('index.html.twig',
            [
                'entities' => $dummyEntities,
            ]
        );
    }
}