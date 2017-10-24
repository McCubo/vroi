<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class UploadFile {

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload a file.")
     * @Assert\File(mimeTypes = {"application/pdf", "application/x-pdf"})
     */
    private $fileDoc;

    function getFileDoc() {
        return $this->fileDoc;
    }

    function setFileDoc($fileDoc) {
        $this->fileDoc = $fileDoc;
    }

}
