<?php

class SurveyController extends BaseController

{

    /**

* "/survey/listNames" Endpoint - Get list of surveys

*/

    public function listNamesAction()

    {

        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {

            try {

                $surveyModel = new SurveyModel();

                $intLimit = 10;

                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {

                    $intLimit = $arrQueryStringParams['limit'];

                }

                $arrSurveys = $surveyModel->getSurveyNames($intLimit);

                $responseData = json_encode($arrSurveys);

            } catch (Error $e) {

                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';

                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

            }

        } else {

            $strErrorDesc = 'Method not supported';

            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }

        // send output

        if (!$strErrorDesc) {

            $this->sendOutput(

                $responseData,

                array('Content-Type: application/json', 'HTTP/1.1 200 OK')

            );

        } else {

            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 

                array('Content-Type: application/json', $strErrorHeader)

            );

        }

    }

    /**
     * "survey/getSelected" Endpoint - get selected survey
     */

    public function getSelectedAction() 
    {
	$strErrorDesc = '';

	$requestMethod = $_SERVER["REQUEST_METHOD"];

	$arrQueryStringParams = $this->getQueryStringParams();

	if(strtoupper($requestMethod) == 'GET') {

		try{

			$surveyModel = new SurveyModel();

			$surveyName = 'default';

			if (isset($arrQueryStringParams['name']) && $arrQueryStringParams['name']) {
				$surveyName = $arrQueryStringParams['name'];

			}

			$survey = $surveyModel->getSurvey($surveyName);

			$responseData = json_encode($survey);

		} catch (Error $e) {

			$strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';

			$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
		}

	} else {

		$strErrorDesc = 'Method not supported';

		$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

	}
	// send output
	
	if(!$strErrorDesc) {

		$this->sendOutput(
			$responseData, 
			array('Content-Type: application/json', 'HTTP/1.1 200 OK')
		);
	} else {

		$this->sendOutput(json_encode(array('error' => $strErrorDesc)),
			array('Content-Type: application/json', $strErrorHeader)
		);
	}

    }

    /**
     * "/survey/sendQuestionResult" Endpoint - receive data of user
     * and calculate final answer with the help of the gazedata
     */
    public function sendQuestionResultAction() {

	$strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

	if(strtoupper($requestMethod) == 'POST') {
		try{

			$input = json_decode(file_get_contents('php://input'), true);
			// not sure if you can get the data here like this because we called this php file from the input.php
			// we need to execute SELECT statement for getting the UI positions of the user
			// followed by putting the gazedata into context --> which answer was looked at the most

                } catch (Error $e) {

                        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';

                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }

	}

	// send output
        
        if(!$strErrorDesc) {
                                       
                $this->sendOutput(
                        json_encode(array('message' => 'Testing if POST works')), 
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        } else {

                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                        array('Content-Type: application/json', $strErrorHeader)
                );
        }

    }


}

