<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;


class BobotController extends Controller{

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Configuration for the BotMan WebDriver
        $config = [];

        // Create BotMan instance
        $botman = BotManFactory::create($config);

        // Give the bot some things to listen for.
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) {
            $bot->reply('Hello!');
        });
        $botman->hears('(How are you|labess?|Cava?)', function (BotMan $bot) {
            $bot->reply('Fine!');
        });

        // Set a fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand.');
        });

        // Start listening
        $botman->listen();

        return new Response();
    }
    
    /**
     * @Route("/Chat", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('chat_bot/homepage.html.twig');
    }
    
    /**
     * @Route("/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('chat_bot/chat_frame.html.twig');
    }
}