<?php

namespace Plugandcom\Bundle\DigistratBundle\Service;

use Exception;
use GuzzleHttp\Client;
use Plugandcom\Bundle\DigistratBundle\Model\SubList;
use Plugandcom\Bundle\DigistratBundle\Model\Subscriber;
use Plugandcom\Bundle\DigistratBundle\Model\Subscribers;
use Symfony\Component\HttpFoundation\RequestStack;

class DigistratService
{
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
            $subList = new SubList($id);
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
    public function newList(string $name, bool $oneShot = true): int
    {
        $request = $this->client->post('list', [
            'body' => json_encode([
                'name' => $name,
                'oneShot' => $oneShot
            ])
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

    /**
     * @throws Exception
     */
    public function addSubscribers(int $listId, Subscribers $subscribers): void
    {
        $data = $subscribers->getArrayItems();
        array_unshift($data, ['email', 'phone', 'lastname', 'firstname']);

        $req = $this->client->post('subscribers/' . $listId, [
            'body' => json_encode($data)
        ]);
    }

    /**
     * @param int $listId
     * @param Subscriber $subscriber
     * @return int ADDED|UPDATED
     */
    public function addSubscriber(int $listId, Subscriber $subscriber): int
    {
        $emailValid = !empty($subscriber->getEmail());

        $phoneValid = !empty($subscriber->getPhone());

        if ($emailValid || $phoneValid) {
            if ($emailValid) {
                if (!filter_var($subscriber->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException("Email {$subscriber->getEmail()} invalide.");
                }
            }
        } else {
            throw new \InvalidArgumentException("Veuillez renseigner au moins l'email ou le téléphone");
        }

        $req = $this->client->post('subscriber/' . $listId, [
            'body' => json_encode([
                'email' => $subscriber->getEmail(),
                'phone' => $subscriber->getPhone(),
                'firstname' => $subscriber->getFirstname(),
                'lastname' => $subscriber->getLastname(),
            ])
        ]);

        return (int) json_decode($req->getBody()->getContents(), false)->status;
    }

}
