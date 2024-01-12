<?php

namespace App\Services;

use App\Clients\HeadHunterClient;
use App\Clients\SkorozvonClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HeadHunterService
{
    public function __construct(
        private readonly HeadHunterClient $client,
        private readonly SkorozvonClient $skorozvonClient
    )
    {
    }

    /**
     * Обработка запроса с колбек эндроинта hh ru
     *
     * @param array $queryData
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function apply(array $queryData): void
    {
        $resume = $this->getResumeDataById($queryData['payload']['resume_id']);
        $phone = $this->getPhoneByResume($resume);
        $name = $this->getNameByResume($resume);
        $this->skorozvonClient->addLead($phone, $name);
    }

    /**
     * @param array $resume
     * @return string|null
     */
    private function getPhoneByResume(array $resume): ?string
    {
        return $resume['contact'][0]['value']['formatted'] ?? null;
    }

    /**
     * @param array $resume
     * @return string|null
     */
    private function getNameByResume(array $resume): ?string
    {
        return $resume['first_name'] ?? null;
    }

    /**
     * @param string $resumeId
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getResumeDataById(string $resumeId)
    {
        return $this->client->getResumeById($resumeId);
    }
}


//error_reporting(E_ERROR | E_PARSE);
//
//$CSV_DIR = "../CSVFiles/";
//
///*error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);*/
//
//$TOKENHASH = '0067f86d4ebc07eb22c45d0ab2f4949cccf0ec1a';
//
//if (hash('sha1', $_GET['token']) != $TOKENHASH) {
//    die();
//}
//
//function getNameByPhone($phone)
//{
//    global $CSV_DIR;
//
//    $dicts = array();
//    foreach (glob($CSV_DIR . '*.[cC][sS][vV]') as $filename) {
//        try {
//            $csv = new SplFileObject($filename);
//            $csv->setFlags(SplFileObject::READ_CSV);
//
//            $csv_phone_index = 0;
//            $csv_name_index = 0;
//
//            foreach ($csv as $row) {
//                foreach ($row as $key => $value) {
//                    if ($value == 'phone') {
//                        $csv_phone_index = $key;
//                    }
//                    if ($value == 'name') {
//                        $csv_name_index = $key;
//                    }
//                }
//                break;
//            }
//
//            $dict = array(
//                "csv" => $csv,
//                "csv_phone_index" => $csv_phone_index,
//                "csv_name_index" => $csv_name_index
//            );
//
//            array_push($dicts, $dict);
//        } catch (Exception $e) {
//            continue;
//        }
//    }
//
//    if (count($dicts) == 0) {
//        return "FromZvonok_" . uniqid();
//    }
//
//    foreach ($dicts as $dict) {
//        foreach ($dict['csv'] as $row) {
//            if ($row[$dict['csv_phone_index']] == $phone || '+' . $row[$dict['csv_phone_index']] == $phone) {
//                return $row[$dict['csv_name_index']];
//            }
//        }
//    }
//
//    return "FromZvonok_" . uniqid();
//}
//
//function requestPOST(string $url, array $data)
//{
//    $options = array(
//        'http' => array(
//            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
//            'method' => 'POST',
//            'content' => http_build_query($data)
//        )
//    );
//    $context = stream_context_create($options);
//    return file_get_contents($url, false, $context);
//}
//
//function getScorozvonKey()
//{
//    $last_try = file_get_contents("../system/token.last.time");
//    $last_token = file_get_contents("../system/token.last");
//
//    $cur_time = time();
//
//    if ($last_token !== false && $last_try !== false) {
//        if ($last_token != "" && $last_try != "") {
//            if (($cur_time - intval($last_try)) < 500) {
//                return $last_token;
//            }
//        }
//    }
//
//    $login_data = array(
//        "grant_type" => "password",
//        "username" => "nikoligurjanov@yandex.ru",
//        "api_key" => "121de10d53de42fe1aa13999c0133d2e8d7ba0e33b553a52f899e1f5e4de33d4",
//        "client_id" => "29055bf486467ffb99159edf3c21881d8ec4349ee1eb61c0b172364bbcc623b7",
//        "client_secret" => "172f48c27f7eb1c2322526b8f92d5b25dcc9cbc8785f137a428795b3f4a4cb2a"
//    );
//
//    $login_response = requestPOST("https://app.skorozvon.ru/oauth/token", $login_data);
//
//    $login_data = json_decode($login_response, true);
//
//    file_put_contents("../system/token.last.time", $cur_time);
//    file_put_contents("../system/token.last", $login_data['access_token']);
//
//    return $login_data['access_token'];
//}
//
//function addLeadToScorozvon($phone, $project)
//{
//    if ($project != "") {
//        $data = array(
//            "name" => getNameByPhone($phone),
//            "phones" => $phone,
//            "call_project_id" => $project
//        );
//    } else {
//        $data = array(
//            "name" => getNameByPhone($phone),
//            "phones" => $phone
//        );
//    }
//
//    $key = getScorozvonKey();
//
//    $options = array(
//        'http' => array(
//            'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "Authorization: Bearer " . $key . "\r\n",
//            'method' => 'POST',
//            'content' => http_build_query($data),
//        )
//    );
//
//    $context = stream_context_create($options);
//    $res = file_get_contents("https://app.skorozvon.ru/api/v2/leads", false, $context);
//}
//
//if (isset($_GET['phone'])) {
//    if (isset($_GET['project'])) {
//        addLeadToScorozvon($_GET['phone'], $_GET['project']);
//    } else {
//        addLeadToScorozvon($_GET['phone'], "");
//    }
//}