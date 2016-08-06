<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 06.08.16 at 11:13
 */
namespace samsonframework\container\tests\classes;

use \samsonframework\container\annotation\Inject;
use \samsonframework\container\annotation\Controller;

/**
 * Class Controller
 * @Controller()
 * @package samsonframework\di\tests\classes
 */
class CarController
{
    /**
     * @var Car
     * @Inject()
     */
    protected $car;
}