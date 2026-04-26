<?php
/**
 * MVC Router Class
 */
class Router {
    public function dispatch() {
        // We must bring the global $conn and $sys variables into scope 
        // so that the included view files can use them natively just like the old structure.
        global $conn, $sys, $current_page_name;

        // Ensure session is started natively for legacy scripts
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($view)) {
            $uri = $_GET['url'] ?? '';
            $uri = trim($uri, '/');

            if ($uri === '' || $uri === 'home' || $uri === 'index' || $uri === 'index.php' || $uri === 'Menshubprime') {
                $view = 'home';
            } else {
                $segments = explode('/', $uri);
                $route = trim(filter_var($segments[0], FILTER_SANITIZE_URL), '/');
                $slug = (isset($segments[1])) ? trim(filter_var($segments[1], FILTER_SANITIZE_URL), '/') : '';

                // REDUNDANT BLOG MAPPING FOR SAFETY
                if ($route === 'blog' || $route === 'blogs') {
                    if (empty($slug)) {
                        $view = 'blog';
                    } else {
                        $view = 'blog-single';
                        $_GET['slug'] = $slug;
                    }
                } else {
                    $routeMap = [
                        'product' => 'product',
                        'category' => 'category',
                        'digital-product' => 'digital-product-single',
                        'brand-store' => 'brand-store',
                        'video' => 'video-single',
                        'review-3d' => 'review-3d',
                        'checkout' => 'checkout' 
                    ];

                    if (isset($routeMap[$route])) {
                        $view = $routeMap[$route];
                        if ($route === 'brand-store') {
                            $_GET['brand'] = $slug;
                        } elseif ($route !== 'checkout' && !empty($slug)) {
                            $_GET['slug'] = $slug;
                        }
                    } else {
                        $view = $route;
                    }
                }
            }
        }

        $current_page_name = $view . '.php';
        $viewFile = ROOT_PATH . '/resources/views/pages/' . $view . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            // Include a proper 404 handling logic here
            header("HTTP/1.0 404 Not Found");
            $errorFile = ROOT_PATH . '/resources/views/pages/404.php';
            if (file_exists($errorFile)) {
                require $errorFile;
            } else {
                echo "<h1>404 Not Found</h1>";
                echo "<p>The requested page '$view' could not be found.</p>";
            }
        }
    }
}
?>
