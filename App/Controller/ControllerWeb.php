<?php

namespace App\Controller;

use Core\Interfaces\Request;
use Core\Interfaces\Response;
use Core\Interfaces\RouteHttp;
use Core\Interfaces\View;
use Core\Interfaces\WebPage;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;

class ControllerWeb
{

    /**
     * Current route
     * @var RouteHttp
     */
    #[Inject]
    public RouteHttp $route;

    /**
     * System (NOT PSR) Request object
     * @var Request
     */
    #[Inject]
    public Request $request;

    /**
     * System (NOT PSR) Response object
     * @var Response
     */
    #[Inject]
    public Response $response;

    /**
     * View object
     * @var View
     */
    #[Inject]
    public View $view;

    /**
     * WebPage object
     * @var WebPage
     */
    #[Inject]
    public WebPage $webPage;

    /**
     * Set page header for H1
     * @param string $pageHeader Header text
     * @return self
     */
    public function setPageHeader(string $pageHeader): self
    {
        $this->webPage->setPageHeader($pageHeader);
        return $this;
    }

    /**
     * Set page description meta-tag
     * @param string $description Description text
     * @return self
     */
    public function setPageDescription(string $description): self
    {
        $this->webPage->setPageDescription($description);
        return $this;
    }

    /**
     * Set page Title meta-tag
     * @param string $pageTitle Page title
     * @return self
     */
    public function setPageTitle(string $pageTitle): self
    {
        $this->webPage->setPageTitle($pageTitle);
        return $this;
    }

    /**
     * Set page keywords from string or array
     * @param string|array $keywords Keywords
     * @return self
     */
    public function setPageKeywords(string|array $keywords): self
    {
        $this->webPage->setPageKeywords($keywords);
        return $this;
    }

    public function setImportMap(
            array $vars,
            bool $internal = true,
            string $type = 'importmap'
    ): self
    {
        $this->webPage->setImportMap($vars, $internal, $type);
        return $this;
    }

    /**
     * Set JS script from external by url
     * @param string $address
     * @param bool $header
     * @param string $params
     * @return self
     */
    public function setScriptCdn(
            string $address,
            bool $header = true,
            string $params = ''
    ): self
    {
        $this->webPage->setScriptCdn($address, $header, $params);
        return $this;
    }

    /**
     * Set script from Libs folder in root
     * @param string $scriptName Filename
     * @param bool $header If false - in footer
     * @param string $params Different params
     * @return self
     */
    public function setScriptLib(
            string $scriptName,
            bool $header = true,
            string $params = ''
    ): self
    {
        $this->webPage->setScriptLib($scriptName, $header, $params);
        return $this;
    }

    /**
     * Set script from theme folder
     * @param string $scriptName Filename
     * @param bool $header If false - in footer
     * @param string $params Different params
     * @param string $version
     * @return self
     */
    public function setScript(
            string $scriptName,
            bool $header = true,
            string $params = '',
            string $version = ''
    ): self
    {
        $this->webPage->setScript($scriptName, $header, $params, $version);
        return $this;
    }

    /**
     * Set style from external by url
     * @param string $url URL
     * @return self
     */
    public function setStyleCdn(string $url): self
    {
        $this->webPage->setStyleCdn($url);
        return $this;
    }

    /**
     * Set style from Libs public folder
     * @param string $styleName Filename
     * @return self
     */
    public function setStyleLibs(string $styleName): self
    {
        $this->webPage->setStyleLib($styleName);
        return $this;
    }

    /**
     * Set style from theme folder
     * @param string $styleName Filename
     * @param string $version Version
     * @return self
     */
    public function setStyle(
            string $styleName,
            string $version = ''
    ): self
    {
        $this->webPage->setStyle($styleName, $version);
        return $this;
    }

    /**
     * Set content template to include it in layout
     * @param string $contentTemplate
     */
    public function setContentTemplate(string $contentTemplate): self
    {
        $this->webPage->setAttribute('content', $contentTemplate);
        return $this;
    }

    /**
     * Assign data to template variables
     * @param array|string|object $key Key of variable
     * @param mixed $value Variable content
     * @param bool $check Check for key duplicate in vars
     * @return self
     */
    public function assign(
            array|string|object $key,
            mixed $value = null,
            bool $check = true
    ): self
    {
        $this->view->assign($key, $value, $check);
        return $this;
    }

    /**
     * Render the template
     * @param string $layout Filename of template
     * @param array $vars 
     * @param int $code
     * @param array $headers
     * @param int|null $cacheTTL
     * @return ResponseInterface
     */
    public function render(
            string $layout,
            array $vars = [],
            int $code = 200,
            array $headers = [],
            ?int $cacheTTL = null
    ): ResponseInterface
    {
        return $this->view->render(
                        $layout,
                        $vars,
                        $code,
                        $headers,
                        $cacheTTL
        );
    }

}
