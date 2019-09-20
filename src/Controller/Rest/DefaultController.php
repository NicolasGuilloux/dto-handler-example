<?php declare(strict_types=1);

namespace App\Controller\Rest;

use App\DataTransferObject\DummyDto;
use App\Entity\DummyEntity;
use App\Repositories\DummyEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class DefaultController
 *
 * @package   App\Controller\Rest
 * @author    Nicolas Guilloux <nicolas.guilloux@protonmail.com>
 * @copyright 2014 - 2019 RichCongress (https://www.richcongress.com)
 */
class DefaultController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/rest/with-validation")
     *
     * @param DummyDto               $dummyDto
     * @param DummyEntityRepository  $dummyEntityRepository
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function postWithValidationAction(
        DummyDto $dummyDto,
        DummyEntityRepository $dummyEntityRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $dummyEntity = DummyEntity::createFromDto($dummyDto);

        $entityManager->persist($dummyEntity);
        $entityManager->flush();

        $dummyEntityRepository->deleteOldOnes(100);

        $view = new View($dummyEntity);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/rest/handled-validation")
     *
     * @ParamConverter(
     *      name="dummyDto",
     *      converter="data_transfer_object_converter",
     *      options={"violations": "violations"}
     * )
     *
     * @param DummyDto                         $dummyDto
     * @param ConstraintViolationListInterface $violations
     *
     * @return Response
     */
    public function postHandledValidationAction(
        DummyDto $dummyDto,
        ConstraintViolationListInterface $violations
    ): Response {
        $view = new View(
            [
                'errors' => $violations,
            ]
        );

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/rest/without-validation")
     *
     * @ParamConverter(
     *      name="dummyDto",
     *      converter="data_transfer_object_converter",
     *      options={"validate": false}
     * )
     *
     * @param DummyDto $dummyDto
     *
     * @return Response
     */
    public function postWithoutValidationAction(DummyDto $dummyDto): Response
    {
        $view = new View(
            [
                'message' => 'The DTO is not validated at all.',
                'dto'     => [
                    'name'        => $dummyDto->name,
                    'age'         => $dummyDto->age,
                    'isBeautiful' => $dummyDto->isBeautiful,
                    'links'       => $dummyDto->links,
                ]
            ]
        );

        return $this->handleView($view);
    }
}