<?php

class Upload
{
    public static $phpFileUploadErrors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
        // Internos
        10 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified by the Upload Class Validation',
        11 => 'The mime type of the uploaded file was not validated by the Upload Class Validation',
        12 => 'The mime type of the uploaded file was not validated by the Upload Class Validation',
        13 => 'The uploaded file was not moved to destination folder',
    ];
    const DEFAULT_SIZE = 300000;

    /**
     * @param string $InputNameProp
     * @return Upload
     */
    public static function instance($InputNameProp) { return new static($InputNameProp); }

    private $uploadObrigatorio;
    private $uploaded;
    private $movedFilename;
    private $filename;
    private $tipo;
    private $tmp_name;
    private $error;
    private $size;
    private $validTypes;
    private $maxSize;

    /**
     * @param string $InputNameProp
     */
    private function __construct($InputNameProp) {

        $this->uploaded = false;
        $this->uploadObrigatorio = false;
        $this->filename = '';
        $this->movedFilename = '';
        $this->tipo = '';
        $this->tmp_name = '';
        $this->error = 0;
        $this->size = 0;
        $this->validTypes = ['image/png', 'image/jpeg', 'image/gif', 'application/pdf'];
        $this->maxSize = self::DEFAULT_SIZE;

        if (isset($_FILES[$InputNameProp])) {
            // TODO: para os mais interessados
            // Tipos de ficheiros:
            // http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
            $this->uploaded = true;
            $this->filename = filter_var($_FILES['foto']['name'], FILTER_SANITIZE_STRING);
            $this->movedFilename = (!empty($this->filename) ? date("d-m-Y-H-i-s-") . basename($this->filename) : '');
            $this->tipo = $_FILES['foto']['type'];
            $this->tmp_name = $_FILES['foto']['tmp_name'];
            $this->size = $_FILES['foto']['size'];
            $this->error = $_FILES['foto']['error'];
            if ( !$this->error) {
                if ($this->size > $this->getMaxSize())
                    $this->error = 10;
                elseif ( !in_array($this->tipo, $this->getValidTypes()))
                    $this->error = 11;
            }
        }
    }

    public function getValidTypes(): array { return $this->validTypes; }

    public function setTmageTypes($types) {
        if (is_array($types)) $this->validTypes = $types;
        return $this;
    }

    public function getMaxSize(): int { return $this->maxSize; }

    public function setMaxSize($size) {
        $this->maxSize = intval($size) ?? self::DEFAULT_SIZE;
        return $this;
    }

    public function isUploaded(): bool { return $this->uploaded; }

    public function getUploadedFilename(): string { return $this->filename; }

    public function getTipo(): string { return $this->tipo; }

    public function getTmpName(): string { return $this->tmp_name; }

    public function hasError(): int { return $this->isValid(); }

    public function getError(): int { return $this->error; }

    public function getErrorStr(): string { return self::$phpFileUploadErrors[$this->error]; }

    public function getSize(): int { return $this->size; }

    public function isValid(): bool {

        return ($this->isUploadObrigatorio() && !$this->error)
            || ( !$this->isUploadObrigatorio() && ( !$this->error || $this->error == 4));
    }

    public function pathExists($folder) {
        $path = realpath($folder);

        return ($path !== false && is_dir($path)) ? $path : false;
    }

    public function moveTo($folder) {
        $folder = $this->pathExists($folder);

        if ($folder) {

            $uploadfile = $folder . DIRECTORY_SEPARATOR . $this->getMovedFilename();
            if (move_uploaded_file($this->getTmpName(), $uploadfile))
                return true;
            else
                $this->error = 13;
        }
        return false;
    }

    public function hasFileToMove() { return !empty($this->movedFilename); }

    public function getMovedFilename() { return $this->movedFilename; }

    public function isUploadObrigatorio() { return $this->uploadObrigatorio; }

    public function setUploadObrigatorio($tf) {
        $this->uploadObrigatorio = ! !$tf;
        return $this;
    }
}
