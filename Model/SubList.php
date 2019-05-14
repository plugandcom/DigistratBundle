<?php

namespace Plugandcom\Bundle\DigistratBundle\Model;


class SubList
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var int
     */
    private $nbSubscribers;

    /**
     * @var int
     */
    private $nbSms;

    /**
     * @var int
     */
    private $nbMails;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getNbSubscribers(): ?int
    {
        return $this->nbSubscribers;
    }

    public function setNbSubscribers(?int $nbSubscribers): void
    {
        $this->nbSubscribers = $nbSubscribers;
    }

    public function getNbSms(): ?int
    {
        return $this->nbSms;
    }

    public function setNbSms(?int $nbSms): void
    {
        $this->nbSms = $nbSms;
    }

    public function getNbMails(): ?int
    {
        return $this->nbMails;
    }

    public function setNbMails(?int $nbMails): void
    {
        $this->nbMails = $nbMails;
    }

}