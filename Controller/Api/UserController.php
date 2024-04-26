
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

                $user_id = 1;
                if (isset($input['user_id'])) {
                    $user_id = $input['user_id'];
                    $age = $input['age'];
                }

                $userModel = new UserModel();

                $user = $userModel->setAllUserData($input);

                $responseData = json_encode("Update user data successfully.");
            } catch (Error $e) {

                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(
                $responseData,
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

                $input = json_decode(file_get_contents('php://input'), true);

                $user_id = 1;
                if (isset($arrQueryStringParams['user']) && $arrQueryStringParams['user']) {
                    $user_id = $arrQueryStringParams['user'];
                }

                $userModel = new UserModel();

                $user = $userModel->createUser($user_id);

                $responseData = json_encode("Created user successfully.");
            } catch (Error $e) {

                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(
                $responseData,
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
 
                 $input = json_decode(file_get_contents('php://input'), true);
 
                 $user_id = 1;
                 $age = 5;
                 if (isset($arrQueryStringParams['user']) && $arrQueryStringParams['user'] && isset($arrQueryStringParams['age']) && $arrQueryStringParams['age']) {
                    $user_id = $arrQueryStringParams['user'];
                    $age = $arrQueryStringParams['age'];
                }
 
                 $userModel = new UserModel();
 
                 $user = $userModel->setUserAge($user_id, $age);
 
                 $responseData = json_encode("Set age of user successfully.");
             } catch (Error $e) {
 
                 $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
 
                 $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
             }
         }
 
         // send output
 
         if (!$strErrorDesc) {
 
             $this->sendOutput(
                 $responseData,
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
