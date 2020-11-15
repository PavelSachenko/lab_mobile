<?php


namespace App\Http\Controllers\Telegram;


use App\Http\Controllers\Controller;
use App\Models\Telegram\Telegram;
use Facade\FlareClient\Api;

class IndexController extends Controller
{
    public function index()
    {
        $telegram = new Api('1204828712:AAEwXWuuwBLaSimKjFpB-RhIBNzYhuDT2XE');
        $result = $telegram->getWebhookUpdate();
        (!empty($result['message']['text'])) ? $text = $result['message']['text'] : $text = '';
        $chatId = $result['message']['chat']['id'];
        (!empty($result['message']['from']['username'])) ? $name = $result['message']['from']['username'] : $name = 'null';
        (!empty($result['message']['from']['first_name'])) ? $firstName = $result['message']['from']['first_name'] : $firstName = 'null';
        (!empty($result['message']['from']['last_name'])) ? $lastName = $result['message']['from']['last_name'] : $lastName = 'null';
        $command = null;
        $query = $result['callback_query']['data'];

        $callback_query = $result['callback_query'];
        $data = $callback_query['data'];
        $message = ['callback_query']['message'];
        $message_id = ['callback_query']['message']['message_id'];
        $chat_id_in = $callback_query['message']['chat']['id'];

        $chat_data = require 'chat_data.php';
        $text = substr($text, 0, (strripos($text, '@') != false) ? strripos($text, '@') : strlen($text));

        switch ($text){
            case '/start':
                if( Telegram::where('chat_id', $chatId)->first() == null)
                $textResponse = "Бот создан для удобного просмотра расписания\n\nДля пользователей: \n" .
                    "1. Первым делом нужно зарегестрировать бота для этого пропишите /settings\n" .
                    "2. После прохождения регистрации - вы можете воспользоваться навигацией с помощью команды /commands\n" .
                    "3. Если возникли ошибки или вопросы напишите мне: @PashaSachenko\n\n" ;

                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $textResponse,
                ]);
                break;
            case '/settings':
                if(Telegram::where('chat_id', $chatId)->first() == null)
                $arr = getFacultyButtons();
                $keyboard = [
                    'inline_keyboard' =>
                        [
                            array_slice($arr, 0, 3),
                            array_slice($arr, 3),
                        ]
                ];
                $encodedKeyboard = json_encode($keyboard);
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => 'Нужно выбрать факультет:' . $data . " : " . $chat_data['faculty'],
                    'reply_markup' => $encodedKeyboard,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/today':
                $lessons = lessonAdd();
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/tomorrow':
                $lessons = lessonAdd('tomorrow');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/monday':
                $lessons = lessonAdd('Monday');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/tuesday':
                $lessons = lessonAdd('Tuesday');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/wednesday':
                $lessons = lessonAdd('Wednesday');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/thursday':
                $lessons = lessonAdd('Thursday');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/friday':
                $lessons = lessonAdd('Friday');
                $parameters = [
                    'chat_id' => $chatId,
                    'text' => $lessons,
                ];
                $telegram->sendMessage($parameters);
                break;
            case '/lesson_call':
                $textResponse = "1я пара: 8:20 - 9:40 \n2я пара: 10:05 - 11:25 \n3я пара: 12:05 - 13:25 \n4я пара: 13:50 - 15:10";
                $textResponse .= "\n5я пара: 15:25 - 16:45 \n6я пара: 17:00 - 18:20 \n7я пара: 18:30 - 19:50";
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $textResponse,
                ]);
                break;
            case '/commands':
                $textResponse = "/today - расписание на сегодня \n/tomorrow - расписание на завтра \n/monday - расписание на понедельник";
                $textResponse .= "\n/tuesday - расписание на вторник \n/wednesday - расписание на среду \n/thursday - расписание на четверг";
                $textResponse .= "\n/friday - расписание на пятницу\n/lesson_call - расписание звонков";
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $textResponse,
                ]);
                break;

                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $textResponse,
                ]);
                break;

        }

    }
}
