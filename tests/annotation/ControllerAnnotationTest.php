<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 06.08.16 at 12:24
 */
namespace samsonframework\container\tests\annotation;

use samsonframework\container\annotation\Controller;
use samsonframework\container\ContainerBuilder;
use samsonframework\container\metadata\ClassMetadata;
use samsonframework\container\tests\TestCase;

class ControllerAnnotationTest extends TestCase
{
    public function testToMetadata()
    {
        $scope = new Controller();
        $metadata = new ClassMetadata();
        $scope->toClassMetadata($metadata);
        static::assertEquals(true, in_array(ContainerBuilder::SCOPE_CONTROLLER, $metadata->scopes));
    }
}
