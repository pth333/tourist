<?php

namespace App\Services;

use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Intent;
use Google\Cloud\Dialogflow\V2\IntentView;
use Google\Cloud\Dialogflow\V2\IntentsClient;
use Google\Cloud\Dialogflow\V2\Intent_Message;
use Google\Cloud\Dialogflow\V2\Intent_Message_Text;
use Google\Cloud\Dialogflow\V2\Intent_TrainingPhrase;
use Google\Cloud\Dialogflow\V2\Intent_TrainingPhrase_Part;
use Google\Cloud\Dialogflow\V2\AgentsClient;

class DialogflowService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $filePath = public_path('dialogflow' . DIRECTORY_SEPARATOR . env('GOOGLE_FILE_NAME') . '.json');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $filePath);
        if (!file_exists($filePath)) {
            throw new \Exception('Tệp JSON không tồn tại: ' . $filePath);
        }
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $filePath);
    }

    public function createIntents($request)
    {
        $intentsClient = new IntentsClient();
        $displayName = $request->name;
        $questions = explode(',', $request->questions);
        $answers = explode(',', $request->answers);
        $trainingPhrasesInput = $questions;
        $trainingPhrasesInput = [];
        $answers = [];

        try {
            $formattedParent = $intentsClient->projectAgentName(getenv('GOOGLE_PROJECT_ID'));
            $trainingPhrases = [];
            foreach ($trainingPhrasesInput as $trainingPhrase) {
                $part = new Intent_TrainingPhrase_Part();
                $part->setText($trainingPhrase);
                $trainingPhrase = new Intent_TrainingPhrase();
                $trainingPhrase->setParts([$part]);
                $trainingPhrases[] = $trainingPhrase;
            }

            $responseAnswers = [];

            $text = new Intent_Message_Text();
            $text->setText($answers);
            $message = new Intent_Message();
            $message->setText($text);

            $intent = new Intent();
            $intent->setDisplayName('intent-name-to-be-displayed');
            $intent->setTrainingPhrases($trainingPhrases);
            $intent->setMessages([$message]);

            $response = $intentsClient->createIntent($formattedParent, $intent);
        } catch (ApiException $e) {
            return false;
            exit();
        } finally {
            $intentsClient->close();
        }
        dd(substr($response->getName(), strrpos($response->getName(), '/') + 1));
    }
}
