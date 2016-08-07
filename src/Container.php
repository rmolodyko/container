<?php declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.08.16
 * Time: 0:46.
 */

namespace samsonframework\container;

use samsonframework\container\metadata\ClassMetadata;
use samsonframework\container\resolver\Resolver;
use samsonframework\filemanager\FileManagerInterface;

/**
 * Class Container.
 */
class Container
{
    /** Controller classes scope name */
    const SCOPE_CONTROLLER = 'controllers';

    /** Service classes scope name */
    const SCOPE_SERVICES = 'services';

    /** @var string[] Collection of available container scopes */
    protected $scopes = [
        self::SCOPE_CONTROLLER => [],
        self::SCOPE_SERVICES => []
    ];

    /** @var ClassMetadata[string] Collection of classes metadata */
    protected $classMetadata = [];

    /** @var FileManagerInterface */
    protected $fileManger;

    /** @var Resolver */
    protected $classResolver;

    /**
     * Container constructor.
     *
     * @param FileManagerInterface $fileManger
     */
    public function __construct(FileManagerInterface $fileManger, Resolver $classResolver)
    {
        $this->fileManger = $fileManger;
        $this->resolver = $classResolver;
    }

    /**
     * Load classes from paths.
     *
     * @param array $paths Paths for importing
     */
    public function loadFromPaths(array $paths)
    {
        // Iterate all paths and get files
        foreach ($this->fileManger->scan($paths, ['php']) as $phpFile) {
            // Read all classes in given file
            $this->loadFromClasses($this->getFileClasses(require_once($phpFile)));
        }
    }

    /**
     * Load classes from class names collection
     * @param string[] $classes Collection of class names for resolving
     */
    public function loadFromClasses(array $classes)
    {
        // Read all classes in given file
        foreach ($classes as $className) {
            // Resolve class metadata
            $this->classMetadata[$className] = $this->resolver->resolve(new \ReflectionClass($className));
            // Store class in defined scopes
            foreach ($this->classMetadata[$className]->scopes as $scope) {
                $this->scopes[$scope][] = $className;
            }
        }
    }

    /**
     * Find class names defined in PHP code.
     *
     * @param string $php PHP code for scanning
     *
     * @return string[] Collection of found class names in php code
     */
    protected function getFileClasses($php) : array
    {
        $classes = array();
        $tokens = token_get_all(is_string($php) ? $php : '');

        for ($i = 2, $count = count($tokens); $i < $count; $i++) {
            if ($tokens[$i - 2][0] === T_CLASS
                && $tokens[$i - 1][0] === T_WHITESPACE
                && $tokens[$i][0] === T_STRING
            ) {
                $classes[] = $tokens[$i][1];
            }
        }

        return $classes;
    }
}
