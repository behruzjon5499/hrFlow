<?php


namespace api\modules\common\forms;


use api\components\BaseRequest;
use api\modules\common\resources\FileResource;
use common\enums\StatusEnum;
use Yii;
use yii\base\Exception;

class FileForm extends BaseRequest
{
    public FileResource $model;

    public $title;
    public $file;

    public function __construct(FileResource $model, $params = [])
    {
        $this->model = $model;

        parent::__construct($params);
    }

    public $allowed_extension = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => t('{attribute} yuborish majburiy')],
//            [['file'], 'file', 'extensions' => 'jpg, jpeg, png, pdf, docx, doc', 'wrongExtension' => t("Yuklangan fayl formati noto'g'ri"),
//                'message' => t("Yuklangan fayl formati noto'g'ri")],
            [['file'], 'file', 'maxSize' => 1024 * 1024*100, 'tooBig' => t("100 mb dan katta fayl yukladingiz")],
            ['title', 'string']
        ];
    }

    //fayl yuklash kerak

    /**
     * @throws Exception
     */
    public function getResult()
    {

        $file = \yii\web\UploadedFile::getInstanceByName('file');
        $this->file = $file;

        if ($file) {

            if (!$this->validate()) {

                return false;
            }
            $file_filename = '/uploads/' . str_replace('.' . $file->extension, '', $file->name) . '_' . (int)microtime(true) . '.' . $file->extension;

            $file->saveAs(\Yii::getAlias('@api') . '/web' . $file_filename);

            $this->model->path = $file_filename;
            $this->model->title = $this->title;
            $this->model->size = $file->size;
            $this->model->type = $file->extension;
            $this->model->created_by = Yii::$app->user->id;
            $this->model->created_at= date("Y-m-d H:i:s");
        } else {
            throw new Exception("Fayl yuborilmagan");
        }

        $this->model->status = StatusEnum::STATUS_ACTIVE;
        if (!$this->model->save()) {
            unlink($file_filename);
            $this->addErrors($this->model->errors);
            return false;
        }
        return $this->model->id;
    }
}
