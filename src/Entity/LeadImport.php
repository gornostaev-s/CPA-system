<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\LeadImportRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadImportRepository::class)]
#[ORM\Table(name: 'lead_import')]
class LeadImport
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\Column(name: 'flow_id_field')]
    private string $flowIdField;

    #[ORM\Column(name: 'name_field')]
    private string $nameField;

    #[ORM\Column(name: 'phone_field')]
    private string $phoneField;

    #[ORM\Column(name: 'region_field')]
    private string $regionField;

    #[ORM\Column(name: 'comment_field')]
    private string $commentField;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
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
        return '';
    }
}