<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\LeadImportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadImportRepository::class)]
#[ORM\Table(name: 'lead_import')]

class LeadImport
{
    use IdTrait;
}