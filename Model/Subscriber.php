<?php

namespace Plugandcom\Bundle\DigistratBundle\Model;


class Subscriber implements \JsonSerializable
{

    public const STATUS_SUBSCRIBED = 0;
    public const STATUS_BLACKLISTED = 1;
    public const STATUS_UNASSIGNED = 2;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var int
     */
    private $status = self::STATUS_SUBSCRIBED;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function jsonSerialize()
    {
        return [$this->email, $this->phone, $this->lastname, $this->firstname, $this->status];
    }

}