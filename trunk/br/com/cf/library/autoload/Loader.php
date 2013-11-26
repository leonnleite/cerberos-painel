<?php

/**
 * Loader class file
 *
 * @version 1.0
 * @author Sebastian Potasiak <sebastian.potasiak@gmail.com>
 * @copyright (c) 2012 Sebastian Potasiak
 * @license GNU/GPL
 */

/**
 * Loader
 */
class Loader
{

    /**
     * Include paths
     *
     * @var string[]
     */
    protected $_includePaths = array();

    /**
     * Class file extensions
     *
     * @var string[]
     */
    protected $_fileExtensions = array();

    /**
     * Loaded classes
     *
     * @var string[string]
     */
    protected $_loadedClasses = array();

    /**
     * Set include path
     *
     * @param string    $includePath    Include path
     * @param bool      $prepend        TRUE to assign path at first place
     * @return Loader
     */
    public function setIncludePath ($includePath, $prepend = true)
    {
        if (substr($includePath, -1, 1) != DIRECTORY_SEPARATOR) {
            $includePath .= DIRECTORY_SEPARATOR;
        }

        if ($prepend) {
            array_unshift($this->_includePaths, $includePath);
        } else {
            array_push($this->_includePaths, $includePath);
        }

        return $this;
    }

// end setIncludePath();

    /**
     * Get include paths
     *
     * @return string[]
     */
    public function getIncludePaths ()
    {
        return $this->_includePaths;
    }

// end getIncludePaths();

    /**
     * Set class file extension
     *
     * @param string    $fileExtension  File extension
     * @param bool      $prepend        TRUE to assign extension at first place
     * @return Loader
     */
    public function setFileExtension ($fileExtension, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->_fileExtensions, $fileExtension);
        } else {
            array_push($this->_fileExtensions, $fileExtension);
        }

        return $this;
    }

// end setFileExtension();

    /**
     * Get class file extensions
     *
     * @return string[]
     */
    public function getFileExtensions ()
    {
        return $this->_fileExtensions;
    }

// end getFileExtensions();

    /**
     * Load class file
     *
     * @param string $className Class name
     * @return Loader
     * @throws OutOfRangeException
     */
    public function load ($className)
    {
        if (!isset($this->_loadedClasses[$className])) {
            $classPath = str_replace(
                    array('\\', '_'), DIRECTORY_SEPARATOR, trim($className, '\\_')
            );

            $fileExtensions = (empty($this->_fileExtensions)) ? '.*' : '{' . implode(',', $this->_fileExtensions) . '}';

            $fileFound = '';

            foreach ($this->_includePaths as $includePath) {
                $files = glob(
                        $includePath . $classPath . $fileExtensions, \GLOB_BRACE
                );

                if ($files) {
                    if (is_file($files[0])) {
                        $fileFound = array_shift($files);
                        break;
                    }
                }
            }

            if (!$fileFound) {
                throw new OutOfRangeException(
                        sprintf('Class %s file cannot be found.', $className)
                );
            }

            require_once $fileFound;
            $this->_loadedClasses[$className] = $fileFound;

            return $this;
        }
    }

// end load();

    /**
     * Register autoload function
     *
     * @return Loader
     */
    public function register ()
    {
        spl_autoload_register(array($this, 'load'));

        return $this;
    }

// end register();

    /**
     * Unregister autoload function
     *
     * @return Loader
     */
    public function unregister ()
    {
        spl_autoload_unregister(array($this, 'load'));

        return $this;
    }

// end unregister();
}

// end Loader;