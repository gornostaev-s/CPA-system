<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\isNewTrait;
use App\Repository\AttachmentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Класс для работы с загружаемыми в систему файлами
 *
 * @property int $id
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 * @property File|null $imageFile
 */
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
#[ORM\Table(name: 'attachments')]
class Attachment
{
    const EXCEL_UPLOAD_DIR = '/var/www/docs';

    use IdTrait;
    use CreatedAtTrait;
    use isNewTrait;

    #[Vich\UploadableField(
        mapping: 'attachments',
        fileNameProperty: 'name',
        size: 'size',
        mimeType: 'mimeType',
        originalName: 'originalName',
        dimensions: 'dimensions'
    )]
    private ?File $imageFile;

    #[ORM\Column(name: 'image_name', type: 'text')]
    private string $name;

    #[ORM\Column(name: 'image_mime_type', type: 'text')]
    private string $mimeType;

    #[ORM\Column(name: 'image_original_name', type: 'text')]
    private string $originalName;

    #[ORM\Column(name: 'image_dimensions', type: 'json', nullable: true)]
    private array $dimensions;

    #[ORM\Column(name: 'image_size', type: 'integer', nullable: true)]
    private int $size;

    #[ORM\Column(type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $updatedAt;

    /**
     * @var string
     */
    private string $path;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
        $this->path = '';
    }

    /**
     * @param File $imageFile
     * @return Attachment
     */
    public static function make(File $imageFile): Attachment
    {
        $e = new self;
        $e->imageFile = $imageFile;
        $e->isNew = true;

        return $e;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param array $dimensions
     */
    public function setDimensions(array $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    /**
     * @return array
     */
    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    public function getUrl(): string
    {
        return getenv('BASE_URI') . "/uploads/attachments/$this->name";
    }

    public function getPath(): string
    {
        return "/var/www/public/uploads/attachments/$this->name";
    }
}