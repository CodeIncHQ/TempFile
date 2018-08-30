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
namespace CodeInc\TempFile\Tests;
use CodeInc\TempFile\TempFile;
use PHPUnit\Framework\TestCase;


/**
 * Class TempFileTest
 *
 * @package CodeInc\TempFile\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class TempFileTest extends TestCase
{
    public function testDefaultFileCreation():void
    {
        $tempFile = new TempFile();
        $tempFilePath = $tempFile->getPath();
        self::assertFileExists($tempFilePath);
        self::assertStringStartsWith(realpath(sys_get_temp_dir()), $tempFilePath);
        self::assertEquals(sys_get_temp_dir(), $tempFile->getParentDir());
        unset($tempFile);
        self::assertFileNotExists($tempFilePath);
    }

    public function testCustomPrefix():void
    {
        $tempFile = new TempFile('test_');
        self::assertEquals('test_', $tempFile->getPrefix());
        self::assertStringStartsWith('test_', basename($tempFile->getPath()));
    }

    public function testCustomDirectory():void
    {
        $customDir = __DIR__.'/temp';
        self::assertDirectoryIsWritable($customDir);
        $tempFile = new TempFile('', $customDir);
        self::assertStringStartsWith($customDir, $tempFile->getPath());
        self::assertEquals($customDir, $tempFile->getParentDir());
        self::assertFileExists($tempFile->getPath());
    }

    public function testNonSelfDestructive():void
    {
        $tempFile = new TempFile(null, null, false);
        $tempFilePath = $tempFile->getPath();
        self::assertFalse($tempFile->isSelfDestruct());
        unset($tempFile);
        self::assertFileExists($tempFilePath);
        unlink($tempFilePath);
    }

    public function testWritingReadingContent():void
    {
        $tempFile = new TempFile();
        $randomContent = hash('sha256', uniqid('', true));
        self::assertEmpty($tempFile->getContents());
        $tempFile->putContents($randomContent);
        self::assertEquals($tempFile->getSize(), strlen($randomContent));
        self::assertEquals($tempFile->getContents(), $randomContent);
        $tempFile->putContents('');
        self::assertEmpty($tempFile->getContents());
    }
}