<?php

namespace Plugandcom\Bundle\DigistratBundle\Service;

use Exception;
use GuzzleHttp\Client;
use Plugandcom\Bundle\DigistratBundle\Model\SubList;
use Symfony\Component\HttpFoundation\RequestStack;

class DigistratService
{
    public const ERROR = 0;
    public const ADDED = 1;
    public const UPDATED = 2;

//    private const API_URL = 'https://digistrat.net/api/v2/';
    private const ENDPOINT = 'http://digistrat.test/app_dev.php/api/v2/';

    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::ENDPOINT,
            'headers' => ['X-AUTH-TOKEN' => 'aaa']
        ]);
    }

    /**
     * @return SubList[]
     * @throws Exception
     */
    public function getLists(): array
    {
        $rawLists = json_decode($this->client->get('lists')->getBody()->getContents(), false);

        $res = [];
        foreach ($rawLists as $id => $list) {
            $subList = new SubList();
            $subList->setId($id);
            $subList->setName($list->nom);
            $subList->setUpdatedAt(new \DateTime($list->updated_at));
            $subList->setNbSubscribers($list->nb_abonnes);
            $subList->setNbSms($list->nb_sms);
            $subList->setNbMails($list->nb_mails);
            $res[] = $subList;
        }

        return $res;
    }

    /**
     * @return int Id de la nouvelle liste créée
     * @throws Exception
     */
    public function newList(string $name): int
    {
        $request = $this->client->post('list', [
            'body' => $name
        ]);

        return (int) $request->getBody()->getContents();
    }

    /**
     * @throws Exception
     */
    public function editList(int $id, string $name): void
    {
        $this->client->put('list/' . $id, [
            'body' => $name
        ]);
    }

    /**
     * @throws Exception
     */
    public function deleteList(int $id): void
    {
        $this->client->delete('list/' . $id);
    }

}
