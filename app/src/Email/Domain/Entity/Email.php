<?php

declare(strict_types=1);

namespace App\Email\Domain\Entity;

/**
 * Class Email
 * @package App\Email\Domain\Entity
 */
class Email
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $file_attach;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var \DateTime|null
     */
    private $create_at;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileAttach(): ?string
    {
        return $this->file_attach;
    }

    /**
     * @param string|null $file_attach
     * @return $this
     */
    public function setFileAttach(?string $file_attach): self
    {
        $this->file_attach = $file_attach;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return $this
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreateAt(): ?\DateTime
    {
        return $this->create_at;
    }

    /**
     * @param \DateTime|null $create_at
     * @return $this
     */
    public function setCreateAt(?\DateTime $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return $this
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
