<?php

class ResultController extends BaseController

{
    /**
     * "/result/sendQuestionResult" Endpoint - receive data of user
     * and calculate final answer with the help of the gazedata
     */
    public function sendQuestionResultAction()
    {

        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {

                $input = json_decode(file_get_contents('php://input'), true);

                if (isset($input['user_id']) && isset($input['answer']) && isset($input['gazeData'])) {
                    $userModel = new UserModel();

                    // get user to have info about positions and size of radioButtons
                    $user = $userModel->getUser($input['user_id']);

                    if (!empty($user)) {
                        $answer = $this->calculateAnswer($user[0], $input['gazeData'], $input['answer']);

                        $resultModel = new ResultModel();

                        $result = $resultModel->getResults($input['survey_id'], $user[0]['user_id'], $input['question_id']);

                        if (empty($result)) {
                            $resultModel->saveResult($input['survey_id'], $user[0]['user_id'], $input['question_id'], $answer);
                            $responseData = "Saved answer ({$answer}) successfully on server.";
                        } else {
                            $resultModel->updateAnswer($result[0]['results_id'], $answer);
                            $responseData = "Updated answer ({$answer}) successfully on server.";
                        }
                    } else {
                        $responseData = "No user found for user_id: {$input['user_id']} in database.";
                    }
                } else {
                    $responseData = "Some input is missing and therefore the request did not succeed.";
                }
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
     * helper function to calculate the answer in consideration of the gazeData
     */
    private function calculateAnswer($user, $gazeData, $answer)
    {

        $calculatedAnswer = $answer;


        // check if the position and size of the buttons are set
        if (isset($user['radioButton1_x'])) {
            $radioButton1_counter = 0;
            $radioButton2_counter = 0;
            $radioButton3_counter = 0;
            $radioButton4_counter = 0;
            $radioButton5_counter = 0;

            foreach ($gazeData as $point) {
                if ($point['x'] >= $user['radioButton1_x'] && $point['x'] <= ($user['radioButton1_x'] + $user['radioButton1_width'])) {
                    if ($point['y'] >= $user['radioButton1_y'] && $point['y'] <= ($user['radioButton1_y'] + $user['radioButton1_height'])) {
                        $radioButton1_counter++;
                    }
                }
                if ($point['x'] >= $user['radioButton2_x'] && $point['x'] <= ($user['radioButton2_x'] + $user['radioButton2_width'])) {
                    if ($point['y'] >= $user['radioButton2_y'] && $point['y'] <= ($user['radioButton2_y'] + $user['radioButton2_height'])) {
                        $radioButton2_counter++;
                    }
                }
                if ($point['x'] >= $user['radioButton3_x'] && $point['x'] <= ($user['radioButton3_x'] + $user['radioButton3_width'])) {
                    if ($point['y'] >= $user['radioButton3_y'] && $point['y'] <= ($user['radioButton3_y'] + $user['radioButton3_height'])) {
                        $radioButton3_counter++;
                    }
                }
                if ($point['x'] >= $user['radioButton4_x'] && $point['x'] <= ($user['radioButton4_x'] + $user['radioButton4_width'])) {
                    if ($point['y'] >= $user['radioButton4_y'] && $point['y'] <= ($user['radioButton4_y'] + $user['radioButton4_height'])) {
                        $radioButton4_counter++;
                    }
                }
                if ($point['x'] >= $user['radioButton5_x'] && $point['x'] <= ($user['radioButton5_x'] + $user['radioButton5_width'])) {
                    if ($point['y'] >= $user['radioButton5_y'] && $point['y'] <= ($user['radioButton5_y'] + $user['radioButton5_height'])) {
                        $radioButton5_counter++;
                    }
                }
            }

            $sum = $radioButton1_counter + $radioButton2_counter + $radioButton3_counter + $radioButton4_counter + $radioButton5_counter;
            if ($sum > 0) {
                $radioButton1_percentage = $radioButton1_counter / $sum;
                $radioButton2_percentage = $radioButton2_counter / $sum;
                $radioButton3_percentage = $radioButton3_counter / $sum;
                $radioButton4_percentage = $radioButton4_counter / $sum;
                $radioButton5_percentage = $radioButton5_counter / $sum;
                // $array_percentages = array($radioButton1_percentage, $radioButton2_percentage, $radioButton3_percentage, $radioButton4_percentage, $radioButton5_percentage);
                // $highest_percentage = max($array_percentages);



                // take all looked at radioButtons in the calculation of the answer
                $weightOfGaze = 0.1;
                $calculatedAnswer = ($answer + $weightOfGaze * ($radioButton1_percentage * 1 + $radioButton2_percentage * 2 + $radioButton3_percentage * 3 + $radioButton4_percentage * 4 + $radioButton5_percentage * 5)) / (1 + $weightOfGaze);
            }
        }

        return $calculatedAnswer;
    }
}
