<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $filePath;
    public $fileName;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if($this->fileName == NULL)
            {
                $this->fileName = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            }
            $this->imageFile->saveAs($this->filePath . $this->fileName);
            return true;
        } else {
            return false;
        }
    }
}