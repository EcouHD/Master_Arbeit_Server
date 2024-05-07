
<?php

class UserController extends BaseController
{

    /**
     * "user/updateUserData" Endpoint - update user data on database
     */

    public function updateDataAction()
    {
        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'PATCH') {
            try {

                $input = json_decode(file_get_contents('php://input'), true);

                $userModel = new UserModel();

                $userModel->setAllUserData($input);

                $responseData = "Update user data successfully.";
            } catch (Error $e) {

                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(
                json_encode(array('message' => $responseData)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {

            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "user/createUserData" Endpoint - set user data on database
     */

    public function createUserAction()
    {
        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'POST') {
            try {

                $uuid = 1;
                if (isset($arrQueryStringParams['uuid']) && $arrQueryStringParams['uuid']) {
                    $uuid = $arrQueryStringParams['uuid'];
                }

                $userModel = new UserModel();

                $userModel->createUser($uuid);

                $responseData = "Created user successfully.";
            } catch (Error $e) {

                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(
                json_encode(array('message' => $responseData)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {

            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "user/setAge" Endpoint - set age to user data on database
     */

    public function setAgeAction()
    {
        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'PATCH') {
            try {

                $uuid = "";
                $age = 0;
                if (isset($arrQueryStringParams['uuid']) && $arrQueryStringParams['uuid'] && isset($arrQueryStringParams['age']) && $arrQueryStringParams['age']) {
                    $uuid = $arrQueryStringParams['uuid'];
                    $age = $arrQueryStringParams['age'];
                }

                $userModel = new UserModel();

                $userModel->setUserAge($uuid, $age);

                $responseData = "Set age of user successfully.";
            } catch (Error $e) {

                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(
                json_encode(array('message' => $responseData)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {

            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
