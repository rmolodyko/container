<?php declare(strict_types = 1);
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 14.08.16 at 20:33
 */
namespace samsonframework\container\annotation;

use samsonframework\container\metadata\PropertyMetadata;

/**
 * Property injection annotation class for marking
 * properties that need injection without type specification.
 *
 * @Annotation
 */
class Injectable implements PropertyInterface
{
    /**
     * Convert to class property metadata.
     *
     * @param PropertyMetadata $propertyMetadata Input metadata
     *
     * @return PropertyMetadata Annotation conversion to metadata
     */
    public function toPropertyMetadata(PropertyMetadata $propertyMetadata)
    {
        // Checks?
    }
}
