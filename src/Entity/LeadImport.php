<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Enum\LeadImportStatusEnum;
use App\Repository\LeadImportRepository;
use App\Validator\FileFormatValidator;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Constraint as AcmeAssert;

#[ORM\Entity(repositoryClass: LeadImportRepository::class)]
#[ORM\Table(name: 'lead_import')]
class LeadImport
{
    use IdTrait;
    use CreatedAtTrait;

    #[Assert\NotBlank(message: 'Заполните поле ID потока')]
    #[ORM\Column(name: 'flow_id_field')]
    private string $flowIdField;

    #[Assert\NotBlank(message: 'Заполните поле имя')]
    #[ORM\Column(name: 'name_field')]
    private string $nameField;

    #[Assert\NotBlank(message: 'Заполните поле телефон')]
    #[ORM\Column(name: 'phone_field')]
    private string $phoneField;

    #[Assert\NotBlank(message: 'Заполните поле регион')]
    #[ORM\Column(name: 'region_field')]
    private string $regionField;

    #[Assert\NotBlank(message: 'Заполните поле комментарий')]
    #[ORM\Column(name: 'comment_field')]
    private string $commentField;

    #[ORM\Column]
    private int $status;

    #[AcmeAssert\FileFormat(mode: AcmeAssert\FileFormat::TABLE_MODE)]
    #[ORM\ManyToOne(targetEntity: Attachment::class,fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'file_id', referencedColumnName: 'id')]
    private Attachment $file;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setStatus(LeadImportStatusEnum::created);
    }

    public static function make(
        string $flowId,
        string $name,
        string $phone,
        string $region,
        string $comment,
    ): LeadImport
    {
        $m = new self;
        $m->flowIdField = $flowId;
        $m->nameField = $name;
        $m->phoneField = $phone;
        $m->regionField = $region;
        $m->commentField = $comment;

        return $m;
    }

    /**
     * @param string $flowIdField
     */
    public function setFlowIdField(string $flowIdField): void
    {
        $this->flowIdField = $flowIdField;
    }

    /**
     * @return string
     */
    public function getFlowIdField(): string
    {
        return $this->flowIdField;
    }

    /**
     * @param string $nameField
     */
    public function setNameField(string $nameField): void
    {
        $this->nameField = $nameField;
    }

    /**
     * @return string
     */
    public function getNameField(): string
    {
        return $this->nameField;
    }

    /**
     * @param string $phoneField
     */
    public function setPhoneField(string $phoneField): void
    {
        $this->phoneField = $phoneField;
    }

    /**
     * @return string
     */
    public function getPhoneField(): string
    {
        return $this->phoneField;
    }

    /**
     * @param string $regionField
     */
    public function setRegionField(string $regionField): void
    {
        $this->regionField = $regionField;
    }

    /**
     * @return string
     */
    public function getRegionField(): string
    {
        return $this->regionField;
    }

    /**
     * @param string $commentField
     */
    public function setCommentField(string $commentField): void
    {
        $this->commentField = $commentField;
    }

    /**
     * @return string
     */
    public function getCommentField(): string
    {
        return $this->commentField;
    }

    /**
     * @return string
     */
    public function getStatusLabel(): string
    {
        return LeadImportStatusEnum::getLabelById($this->status);
    }

    /**
     * @param LeadImportStatusEnum $status
     */
    public function setStatus(LeadImportStatusEnum $status): void
    {
        $this->status = $status->value;
    }

    /**
     * @return LeadImportStatusEnum
     */
    public function getStatus(): LeadImportStatusEnum
    {
        return LeadImportStatusEnum::getEnumById($this->status);
    }

    /**
     * @param Attachment $file
     */
    public function setFile(Attachment $file): void
    {
        $this->file = $file;
    }

    /**
     * @return Attachment
     */
    public function getFile(): Attachment
    {
        return $this->file;
    }
}
