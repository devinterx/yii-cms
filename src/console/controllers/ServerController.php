<?php namespace console\controllers;

use yii\console\Controller;

/**
 * Class ServerController
 *
 * @package console\controllers
 */
class ServerController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $root web root location relative to Yii app root.
     * @param string $host hostname of the server.
     * @param int|string $port port to listen for connections.
     */
    public function actionIndex($root = 'web', $host = 'localhost', $port = 8080)
    {
        $basePath = \Yii::$app->basePath;

        $webRoot = dirname(dirname($basePath)) . DIRECTORY_SEPARATOR . $root;

        echo "Yii dev server started on http://{$host}:{$port}/\n";
        echo "Document root is \"{$webRoot}\"\n";

        /** @noinspection PhpExpressionResultUnusedInspection */
        passthru('"' . PHP_BINARY . '"' . " -S {$host}:{$port} -t \"{$webRoot}\"") . "\n";
    }
}
