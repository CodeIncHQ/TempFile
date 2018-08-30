<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2018 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material is strictly forbidden unless prior    |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     30/08/2018
// Project:  TempFile
//
declare(strict_types=1);
namespace CodeInc\TempFile;

/**
 * Class TempFile
 *
 * @package CodeInc\TempFile
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class TempFile
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $parentDir;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $selfDestruct;

    /**
     * TempFile constructor.
     *
     * @param string $prefix
     * @param null|string $parentDir
     * @param bool $selfDestruct
     */
    public function __construct(?string $prefix = '', ?string $parentDir = null, bool $selfDestruct = true)
    {
        $this->prefix = $prefix ?? '';
        $this->selfDestruct = $selfDestruct;
        $this->parentDir = $parentDir ?? sys_get_temp_dir();
        $this->createTempFile();
    }

    /**
     * Destructs the temporary file.
     */
    public function __destruct()
    {
        if ($this->selfDestruct && file_exists($this->path)) {
            if (!unlink($this->path)) {
                throw new \RuntimeException(
                    sprintf("Unable to delete the temporary file '%s'", $this->path)
                );
            }
        }
    }

    /**
     * Returns the file's path.
     *
     * @return string
     */
    public function __toString():string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isSelfDestruct():bool
    {
        return $this->selfDestruct;
    }

    /**
     * Creates the temporary file.
     */
    private function createTempFile():void
    {
        $this->path = tempnam($this->parentDir, $this->prefix);
        if (!$this->path) {
            throw new \RuntimeException(
                sprintf("Unable to create a temporary file in '%s' using tempnam()", $this->parentDir)
            );
        }
    }

    /**
     * @return string
     */
    public function getPath():string
    {
        return $this->path;
    }

    /**
     * @uses file_get_contents()
     * @return string
     */
    public function getContents():string
    {
        return file_get_contents($this->path);
    }

    /**
     * @uses file_put_contents()
     * @param array|string|resource $data
     * @return bool|int
     */
    public function putContents($data)
    {
        return file_put_contents($this->path, $data);
    }

    /**
     * @uses filesize()
     * @return int
     */
    public function getSize():int
    {
        return filesize($this->path);
    }

    /**
     * @return string
     */
    public function getParentDir():string
    {
        return $this->parentDir;
    }

    /**
     * @return string
     */
    public function getPrefix():string
    {
        return $this->prefix;
    }
}