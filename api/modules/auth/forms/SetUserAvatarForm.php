<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use api\modules\auth\resources\UserResource;
use api\modules\common\resources\FileResource;
use common\enums\StatusEnum;
use common\models\File;
use common\models\User;
use Yii;
use yii\base\Exception;

/**
 * Password reset form
 */
class SetUserAvatarForm extends BaseRequest
{
    public FileResource $model;
    public $file;

    public function __construct(FileResource $model, $params = [])
    {
        $this->model = $model;

        parent::__construct($params);
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function getResult()
    {
        $user = User::findOne(Yii::$app->user->id);
        $file = \yii\web\UploadedFile::getInstanceByName('file');
        $this->file = $file;
        if ($file) {
            if (!$this->validate()) {
                return false;
            }
            $file_filename = '/uploads/' . str_replace('.' . $file->extension, '', $file->name) . '_' . (int)microtime(true) . '.' . $file->extension;
            $file->saveAs(\Yii::getAlias('@api') . '/web' . $file_filename);
            $this->model->path = $file_filename;
            $this->model->title = $file->name;
            $this->model->size = $file->size;
            $this->model->fileable_id = Yii::$app->user->id;
            $this->model->fileable_type =User::class;
            $this->model->type =  File::TYPE_AVATAR_IMAGE;
            $this->model->created_by = Yii::$app->user->id;
            $this->model->created_at= date("Y-m-d H:i:s");
        } else {
            throw new Exception("Fayl yuborilmagan");
        }
        $this->model->status = StatusEnum::STATUS_ACTIVE;
        if (!$this->model->save()) {
            unlink($file_filename);
            return false;
        }
        if ($user->userProfile){
            $user->userProfile->updateAttributes(['avatar_base_url'=>$this->model->path]);
        }
        return $this->model->id;
    }

}
