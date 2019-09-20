<?php declare(strict_types=1);

namespace App\DataTransferObject;

use App\Entity\DummyEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DummyDto
 *
 * @package   App\DataTransferObject
 * @author    Nicolas Guilloux <nicolas.guilloux@protonmail.com>
 * @copyright 2014 - 2019 RichCongress (https://www.richcongress.com)
 */
final class DummyDto
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public $name;

    /**
     * @var integer
     *
     * @Assert\Type("int")
     * @Assert\LessThan("100")
     */
    public $age;

    /**
     * @var boolean
     *
     * @Assert\Type("bool")
     */
    public $isBeautiful;

    /**
     * @var array|DummyEntity[]
     *
     * @Assert\Count(max=2)
     * @Assert\All(
     *      @Assert\Type("App\Entity\DummyEntity")
     * )
     */
    public $links;
}