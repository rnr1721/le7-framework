<?php

namespace le7\Controller\Cli;

use le7\Core\Helpers\FilesystemHelper;
use le7\Controller\ControllerCli;
use le7\Core\Helpers\ConsoleHelper;
use \ZipArchive;

class PublishController extends ControllerCli {

    private string $libsDir;
    private FilesystemHelper $filesystem;
    private ConsoleHelper $consoleMsg;
    private array $urlsVue3 = array(
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.cjs.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.cjs.prod.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.d.ts",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.esm-browser.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.esm-browser.prod.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.esm-bundler.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.global.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.global.prod.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.runtime.esm-browser.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.runtime.esm-browser.prod.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.runtime.esm-bundler.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.runtime.global.js",
        "https://unpkg.com/browse/vue@3.2.36/dist/vue.runtime.global.prod.js",
    );
    private string $urlBootstrap5 = "https://github.com/twbs/bootstrap/archive/refs/heads/main.zip";
    private string $urlFontawesome6 = "https://github.com/FortAwesome/Font-Awesome/archive/refs/heads/6.x.zip";
    private string $urlAxios = "https://github.com/axios/axios/archive/refs/heads/v1.x.zip";

    public function __construct(ConsoleHelper $consoleMsg, FilesystemHelper $filesystem) {
        $this->filesystem = $filesystem;
        $this->consoleMsg = $consoleMsg;
        $this->libsDir = $this->topologyFs->getPublicPath() . DIRECTORY_SEPARATOR . 'libs';
        if (!file_exists($this->libsDir)) {
            mkdir($this->libsDir, 0775, true);
        }
    }

    public function indexAction() {
        $this->stdout(_('Usage') . ': ' . 'php le7.php --c publish:<scriptname>' . "\r\n");
        $this->stdout(_('Available scripts') . ': ' . 'bootstrap5,fontawesome6,vuejs3,axios' . "\r\n");
    }

    public function bootstrap5Action() {
        $this->standardDownload($this->urlBootstrap5, 'bootstrap5', 'bootstrap-main');
    }

    public function fontawesome6Action() {
        $this->standardDownload($this->urlFontawesome6, 'fontawesome6', 'Font-Awesome-6.x');
    }

    public function axiosAction() {
        $this->standardDownload($this->urlAxios, 'axios', 'axios-1.x');
    }

    public function standardDownload(string $url, string $name, string $toRename): bool {
        $ds = DIRECTORY_SEPARATOR;
        $tmpZip = $this->topologyFs->getTempDir() . $ds . $name . '.zip';
        $final = $this->topologyFs->getPublicLibsDir() . $ds . $name;
        $this->filesystem->recursiveRemoveDirectory($final);
        $this->filesystem->downloadFilePhp($url, $tmpZip);
        $zip = new ZipArchive;
        $res = $zip->open($tmpZip);
        if ($res === true) {
            $zip->extractTo($this->topologyFs->getPublicLibsDir());
            $zip->close();
        } else {
            $this->stderr('failed to extract zip archive');
        }
        $dest = $this->topologyFs->getPublicLibsDir() . $ds . $toRename;
        // Delete downloaded zip file
        if (file_exists($tmpZip)) {
            unlink($tmpZip);
        }
        if (file_exists($dest)) {
            rename($dest, $final);
            return true;
        }
        return false;
    }

    public function vuejs3Action() {

        $ds = DIRECTORY_SEPARATOR;

        $destDir = $this->libsDir . $ds . 'vuejs3';

        $this->filesystem->recursiveRemoveDirectory($destDir);

        if (!file_exists($destDir)) {
            mkdir($destDir, 0775, true);
        }

        foreach ($this->urlsVue3 as $url) {
            $filename = basename($url);
            $dest = $destDir . $ds . $filename;
            echo _('Downloading:') . ' ' . $filename . "\r\n";
            $this->filesystem->downloadFileCurl($url, $dest);
        }
        $this->stdout($this->consoleMsg->colorMessage('vue.js 3' . ' ' . _('published'), 'green'));
    }

}
