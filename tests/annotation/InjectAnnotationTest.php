<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 06.08.16 at 12:24
 */
namespace samsonframework\container\tests\annotation;

use samsonframework\container\annotation\Inject;
use samsonframework\container\metadata\ClassMetadata;
use samsonframework\container\metadata\PropertyMetadata;
use samsonframework\container\tests\classes\Car;
use samsonframework\container\tests\classes\CarController;
use samsonframework\container\tests\classes\DriverInterface;
use samsonframework\container\tests\classes\FastDriver;
use samsonframework\container\tests\TestCase;

class InjectAnnotationTest extends TestCase
{
    public function testPropertyViolatingInheritance()
    {
        $this->expectException(\InvalidArgumentException::class);
        $inject = new Inject(['value' => CarController::class]);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = Car::class;
        $inject->toPropertyMetadata($propertyMetadata);
    }

    public function testPropertyWithoutTypeHint()
    {
        $inject = new Inject(['value' => Car::class]);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(Car::class, $propertyMetadata->dependency);
    }

    public function testPropertyWithoutClassNameWithInterfaceTypeHint()
    {
        $this->expectException(\InvalidArgumentException::class);

        $inject = new Inject(['value' => '']);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = DriverInterface::class;
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(null, $propertyMetadata->dependency);
    }

    public function testPropertyWithClassNameWithInterfaceTypeHint()
    {
        $inject = new Inject(['value' => FastDriver::class]);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = DriverInterface::class;
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(FastDriver::class, $propertyMetadata->dependency);
    }

    public function testPropertyWithoutClassNameWithTypeHint()
    {
        $inject = new Inject(['value' => '']);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = FastDriver::class;
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(FastDriver::class, $propertyMetadata->dependency);
    }

    public function testPropertyWithNamespaceClassNameWithSlash()
    {
        $inject = new Inject(['value' => '\\' . FastDriver::class]);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = FastDriver::class;
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(FastDriver::class, $propertyMetadata->dependency);
    }

    public function testPropertyWithNamespaceInheritance()
    {
        $inject = new Inject(['value' => Car::class]);
        $propertyMetadata = new PropertyMetadata(new ClassMetadata());
        $propertyMetadata->typeHint = Car::class;
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(Car::class, $propertyMetadata->dependency);
    }

    public function testPropertyWithoutNamespaceInheritance()
    {
        $inject = new Inject(['value' => 'Car']);
        $classMetadata = new ClassMetadata();
        $classMetadata->nameSpace = (new \ReflectionClass(Car::class))->getNamespaceName();
        $propertyMetadata = new PropertyMetadata($classMetadata);
        $propertyMetadata->typeHint = 'Car';
        $inject->toPropertyMetadata($propertyMetadata);

        static::assertEquals(Car::class, $propertyMetadata->dependency);
    }

//    public function testPropertyServiceNameValue()
//    {
//        $inject = new Inject(['value' => 'car_service']);
//        $classMetadata = new ClassMetadata();
//        $classMetadata->nameSpace = (new \ReflectionClass(Car::class))->getNamespaceName();
//        $propertyMetadata = new PropertyMetadata($classMetadata);
//        $propertyMetadata->typeHint = 'Car';
//        $inject->toPropertyMetadata($propertyMetadata);
//
//        static::assertEquals(Car::class, $propertyMetadata->dependency);
//    }
}
