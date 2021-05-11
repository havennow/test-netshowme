<?php

declare(strict_types=1);

namespace App\Email\Service;

use App\Email\Domain\Entity\Email;
use App\Email\Domain\Exceptions\RecordNotFoundException;
use App\Email\Domain\Repository\EmailRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as EmailComponent;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class EmailService
 * @package App\Email\Infrastructure\Service
 */
class EmailService
{
    public CONST PREFIX_UPLOAD_FILE_NAME = 'emailFile_';
    public CONST FILE_OVERSIZE_LIMIT = 500000;
    public CONST FILE_MIME_ALLOWED = ['pdf', 'doc', 'docx', 'odt', 'txt'];

    /**
     * @var EmailRepository
     */
    private $emailRepository;

    /**
     * @var \Symfony\Component\Mailer\MailerInterface
     */
    private $emailTransport;

    /**
     * @var string
     */
    private $uploadPath = '#KERNEL#/var/email_uploads';

    /**
     * EmailService constructor.
     * @param EmailRepository $emailRepository
     */
    public function __construct(EmailRepository $emailRepository, MailerInterface $mailer, ParameterBagInterface $parameterBag)
    {
        $this->emailRepository = $emailRepository;
        $this->emailTransport = $mailer;
        $this->uploadPath = str_replace('#KERNEL#', $parameterBag->get('kernel.project_dir'), $this->uploadPath);
    }

    /**
     * @param array $data
     * @param \Symfony\Component\HttpFoundation\FileBag $files
     * @return Email
     */
    public function create(array $data, FileBag $files) : Email
    {
        $this->validateData($data, $files);
        $entity = new Email();
        $fileAttach = $this->moveFiles($files);
        $entity->setName($data['name'])
            ->setEmail($data['email'])
            ->setPhone($data['phone'])
            ->setFileAttach($fileAttach)
            ->setIp($data['ip'] ?? null)
            ->setMessage($data['message'] ?? null)
            ->setCreateAt(new \DateTime());

        $flag = $this->emailRepository->save($entity);

        if ($flag) {
            $this->sendEmail($data, $fileAttach);
        }

        return $entity;
    }

    private function moveFiles(FileBag $files) : ?string
    {
        foreach ($files as $key => $file) {
            $size = $file->getSize();
            $ext = $file->guessExtension();
            Assert::keyNotExists(self::FILE_MIME_ALLOWED, $ext);
            Assert::greaterThan(self::FILE_OVERSIZE_LIMIT, $size, '"file_attach" is oversize');
            $newFilename = self::PREFIX_UPLOAD_FILE_NAME . '_' . uniqid() . "_{$key}_." . $ext;
            $file->move($this->uploadPath, $newFilename);

            return $this->uploadPath.'/'.$newFilename;
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws RecordNotFoundException
     */
    public function find(int $id)
    {
        $email = $this->emailRepository->find($id);

        if (is_null($email)) {
            throw new RecordNotFoundException;
        }

        return [
            'id'           => $email->getId(),
            'name'         => $email->getName(),
            'email'        => $email->getEmail(),
            'phone'        => $email->getPhone(),
            'message'      => $email->getMessage(),
            'file_attach'  => $email->getFileAttach(),
            'ip'           => $email->getIp(),
            'create_at'    => $email->getCreateAt()
        ];
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters): array
    {
        return $this->emailRepository->findBy($filters);
    }

    /**
     * @param $data
     * @param \Symfony\Component\HttpFoundation\FileBag $files
     */
    private function validateData(&$data, FileBag $files): void
    {
        $file = $files->count();

        Assert::notEmpty($data['name'], '"name" is required.');
        Assert::notEmpty($data['email'],  '"e-mail" is required.');
        Assert::email($data['email'], '"e-mail" invalid.');
        Assert::notEmpty($data['phone'],  '"phone" is required.');
        Assert::notEmpty($data['message'], '"message" is required.');
        Assert::greaterThanEq($file, 1, '"file_attach is required"');
    }

    public function sendEmail(?array $data, ?string $fileAttach)
    {
        if (empty($data)) {
            return null;
        }

        $sender = $data['email'];
        try {
            $message = $data['message'] ?? '';
            $message.= "\nPhone : ".$data['phone'];

            $compose = (new EmailComponent())
                ->from('test@mobly.test')
                ->to($sender)
                ->subject($data['name']. ' Send email')
                ->attachFromPath($fileAttach)
                ->text($message)
                ->html(nl2br($message));

            $this->emailTransport->send($compose);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}