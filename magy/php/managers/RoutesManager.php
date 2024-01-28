<?php

namespace Magy\Managers;

use stdClass;

/**
 * Provides routing
 */
class RoutesManager
{
    private $controllers = [];

    public function __construct()
    {
        $path = CONFIG_PATH . 'Routing/';
        $fileList = scandir($path);
        $fileCount = sizeof($fileList);
        for ($i = 2; $i < $fileCount; $i++) {
            include $path . $fileList[$i];
        }
    }

    /**
     * Returns the namespace of an API Request from the given route
     * @param string $url The route
     * @return string If there is any API Request, returns its namespace. Else returns null
     */
    public function getAPIRequest(string $url): string|null
    {
        $url = explode('/', $url);

        $componentsCount = sizeof($url);
        $path = API_PATH;
        $ns = 'App\\API';
        for ($i = 0; $i < $componentsCount; $i++) {
            $fileList = scandir($path);
            $fileCount = sizeof($fileList);

            if ($i == $componentsCount - 1) {
                $url[$i] .= '.php';
            }

            for ($j = 0; $j < $fileCount; $j++) {
                if (strtolower($fileList[$j]) == strtolower($url[$i])) {
                    $path .= $fileList[$j];
                    if (!is_file($path)) {
                        $path .= '/';
                        $ns .= '\\' . $url[$i];
                    }

                    if ($i == $componentsCount - 1) {
                        return $ns . '\\' . str_replace('.php', '', $fileList[$j]);
                    } else break;
                }
            }
        }

        return null;
    }

    /**
     * Check if a page exists on this route
     * @param string The route
     * @return bool
     */
    public function pageExists(string $url): bool
    {
        if (file_exists(VIEW_PATH . $url . ".html")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the page content. If the route is linked to a controller, execute the controller
     * @param string $url The route
     * @return string The resulting content of the page
     */
    public function getPageContent(string $url): string
    {
        if (isset($this->controllers[$url])) {
            $ctrlClass = $this->controllers[$url];
            $controller = new $ctrlClass(file_get_contents(VIEW_PATH . $url . ".html"));
            $content = $controller->getContent();
        } else {
            $content = file_get_contents(VIEW_PATH . $url . ".html");
        }

        return $content;
    }
    /**
     * Config Only. Link a route to a controller class
     * @param string $pageName The route
     * @param stdClass $controllerClass The controller class
     */
    public function setController($pageName, $controllerClass): void
    {
        $this->controllers[$pageName] = $controllerClass;
    }
}
