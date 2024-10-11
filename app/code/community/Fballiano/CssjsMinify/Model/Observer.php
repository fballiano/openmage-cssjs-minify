<?php
/**
 * @category   FBalliano
 * @package    Fballiano_CssjsMinify
 * @copyright  Copyright (c) Fabrizio Balliano (http://fabrizioballiano.com)
 * @license    https://opensource.org/license/osl-3 Open Software License (OSL 3.0)
 */
class Fballiano_CssjsMinify_Model_Observer
{
    public const MINIFIED_FILES_FOLDER = 'fbminify';

    public function httpResponseSendBefore(Varien_Event_Observer $observer): void
    {
        $response = $observer->getResponse();
        $html = $response->getBody();
        if (defined('MAHO_PUBLIC_DIR')) {
            $baseDir = MAHO_PUBLIC_DIR;
        } else {
            $baseDir = Mage::getBaseDir();
        }
        $mediaDir = Mage::getBaseDir('media');
        $mediaUrl = Mage::getBaseUrl('media');
        $minifiedDir = "{$mediaDir}/" . self::MINIFIED_FILES_FOLDER . '/';
        $minifiedUrl = "{$mediaUrl}" . self::MINIFIED_FILES_FOLDER . '/';

        if (!file_exists($minifiedDir)) {
            mkdir($minifiedDir, 0755, true);
        }

        // Process JS
        $pattern = '/(<script.+src\s*=\s*["\'])(.*\.js)(["\'].*>)/iU';
        $html = preg_replace_callback($pattern, function($matches) use ($baseDir, $minifiedDir, $minifiedUrl) {
            $url = $matches[2];
            $urlComponents = parse_url($url);
            $path = $urlComponents['path'];
            if (file_exists($baseDir . $path)) {
                $time = filemtime($baseDir . $path);
                $hash = md5($path) . "-$time.js";
                if (!file_exists($minifiedDir . $hash)) {
                    $minifier = new \MatthiasMullie\Minify\JS($baseDir . $path);
                    $minifier->minify("$minifiedDir/$hash");
                }
                $matches[2] = $minifiedUrl . $hash;
            }
            return $matches[1] . $matches[2] . $matches[3];
        }, $html);

        // Process CSS
        $pattern = '/(<link.+href\s*=\s*["\'])(.*\.css)(["\'].*>)/iU';
        $html = preg_replace_callback($pattern, function($matches) use ($baseDir, $minifiedDir, $minifiedUrl) {
            $url = $matches[2];
            $urlComponents = parse_url($url);
            $path = $urlComponents['path'];
            if (file_exists($baseDir . $path)) {
                $time = filemtime($baseDir . $path);
                $hash = md5($path) . "-$time.css";
                if (!file_exists($minifiedDir . $hash)) {
                    $minifier = new \MatthiasMullie\Minify\CSS($baseDir . $path);
                    $minifier->minify("$minifiedDir/$hash");
                }
                $matches[2] = $minifiedUrl . $hash;
            }
            return $matches[1] . $matches[2] . $matches[3];
        }, $html);

        $response->setBody($html);
    }

    public function dailyCron(): void
    {
        $mediaDir = Mage::getBaseDir('media');
        $minifiedDir = "{$mediaDir}/" . self::MINIFIED_FILES_FOLDER;

        $files = scandir($minifiedDir, SCANDIR_SORT_DESCENDING);
        $lastHash = null;
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fileName = preg_replace('/\.(js|css)$/', '', $file);
            $parts = explode('-', $fileName);
            $hash = $parts[0];

            if ($hash == $lastHash) {
                unlink("{$minifiedDir}/{$file}");
                continue;
            }

            $lastHash = $hash;
        }
    }
}