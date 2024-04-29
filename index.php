<?php

require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);

if ((isset($uri[2]) && $uri[2] != 'survey' && $uri[2] != 'user' && $uri[2] != 'result') || !isset($uri[3])) {

    header("HTTP/1.1 404 Not Found");

    exit();
}

if ($uri[2] == 'survey') {

    require PROJECT_ROOT_PATH . "/Controller/Api/SurveyController.php";

    $objFeedController = new SurveyController();

    $strMethodName = $uri[3] . 'Action';

    $objFeedController->{$strMethodName}();

} else if ($uri[2] == 'user') {

    require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";

    $objFeedController = new UserController();

    $strMethodName = $uri[3] . 'Action';

    $objFeedController->{$strMethodName}();
    
} else if ($uri[2] == 'result') {
    require PROJECT_ROOT_PATH . "/Controller/Api/ResultController.php";

    $objFeedController = new ResultController();

    $strMethodName = $uri[3] . 'Action';

    $objFeedController->{$strMethodName}();
}
