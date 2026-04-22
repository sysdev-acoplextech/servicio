<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
              [['file'], 'safe'],
            [['file'], 'file', 'extensions'=>'txt,csv'],
            [['file'], 'file', 'maxSize'=>'1000000'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'file' =>  'Subir Archivo' 
        ];
    }
}

?>