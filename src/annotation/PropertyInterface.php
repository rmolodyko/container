<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 06.08.16 at 14:37
 */
namespace samsonframework\container\annotation;

use samsonframework\container\metadata\PropertyMetadata;

interface PropertyInterface
{
    /**
     * Convert to class property metadata.
     *
     * @param PropertyMetadata $metadata Input metadata
     *
     * @return PropertyMetadata Annotation conversion to metadata
     */
    public function toMetadata(PropertyMetadata $metadata);
}
