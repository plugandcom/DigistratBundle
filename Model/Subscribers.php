<?php

namespace Plugandcom\Bundle\DigistratBundle\Model;


class Subscribers
{
    private $items = [];

    public function addSubscriber(Subscriber $subscriber): void
    {
        $this->items[] = $subscriber->jsonSerialize();
    }

    public function getArrayItems(): array
    {
        return $this->items;
    }

    public static function convertArray(array $array): Subscribers
    {
        $res = new self();

        foreach ($array as $el) {
            $subscriber = new Subscriber();
            $subscriber->setEmail($el['email']);
            $subscriber->setPhone($el['phone']);
            $subscriber->setLastname($el['lastname']);
            $subscriber->setFirstname($el['firstname']);
            $res->addSubscriber($subscriber);
        }

        return $res;
    }

}