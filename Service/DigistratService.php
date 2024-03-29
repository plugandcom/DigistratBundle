<?php

namespace Plugandcom\Bundle\DigistratBundle\Service;

use Exception;
use GuzzleHttp\Client;
use Plugandcom\Bundle\DigistratBundle\Model\SubList;
use Plugandcom\Bundle\DigistratBundle\Model\Subscriber;
use Plugandcom\Bundle\DigistratBundle\Model\Subscribers;

class DigistratService
{
    public const ADDED = 1;
    public const UPDATED = 2;

    /**
     * @var Client
     */
    private $client;

    public function __construct(string $endpoint, string $token)
    {
        $this->client = new Client([
            'base_uri' => $endpoint,
            'headers' => ['X-AUTH-TOKEN' => $token]
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

        return (int)$request->getBody()->getContents();
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
                'extra_fields' => $subscriber->getExtraFields(),
                'status' => $subscriber->getStatus(),
            ])
        ]);

        return (int)json_decode($req->getBody()->getContents(), false)->status;
    }

    /**
     * @param int $listId
     * @param Subscriber $subscriber
     * @return int Subscriber::STATUS_SUBSCRIBED|Subscriber::STATUS_BLACKLISTED|Subscriber::STATUS_UNASSIGNED
     */
    public function getSubscriberEmailSubscriptionStatus(int $listId, string $email): int
    {
        $req = $this->client->get("subscriber/$listId/email/$email/subscription");

        return (int)json_decode($req->getBody()->getContents(), false)->msg;
    }

}
