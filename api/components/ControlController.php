<?php

namespace api\components;

use common\enums\RoleEnum;
use common\models\Token;
use Yii;
use yii\base\Arrayable;
use yii\base\Model;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

abstract class ControlController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter']['cors']['Origin'][] = 'http://localhost:3001';
        $behaviors['corsFilter']['cors']['Access-Control-Request-Method'][] = 'DELETE';
        // Remove strict HttpBearerAuth — control module handles auth manually
        unset($behaviors['bearerAuth']);
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest) {
            $this->resolveToken();
        }

        if ($action->id !== 'login' && Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('Autentifikatsiya talab qilinadi');
        }

        if (!Yii::$app->user->isGuest && !Yii::$app->authManager->checkAccess(Yii::$app->user->id, RoleEnum::ADMIN)) {
            throw new ForbiddenHttpException('Admin huquqi talab qilinadi');
        }

        return true;
    }

    private function resolveToken(): void
    {
        $authHeader = Yii::$app->request->headers->get('Authorization');
        if (!$authHeader) {
            return;
        }

        // Support both "Bearer <token>" and bare "<token>"
        $raw = preg_match('/^Bearer\s+(.+)$/i', $authHeader, $m) ? $m[1] : $authHeader;

        $tokenRecord = Token::find()
            ->andWhere(['token' => $raw])
            ->andWhere(['status' => Token::STATUS_ACTIVE])
            ->andWhere(['>=', 'expired_at', time()])
            ->one();

        if ($tokenRecord && $tokenRecord->user) {
            Yii::$app->user->login($tokenRecord->user);
        }
    }

    private function getExpandFields(): array
    {
        $expand = Yii::$app->request->get('expand', '');
        return $expand ? array_values(array_filter(explode(',', $expand))) : [];
    }

    protected function sendResponse(Model $model, $params = [])
    {
        $model->load($params, '');

        if (!$model->validate()) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'data' => null,
                'errors' => $model->errors,
            ];
        }

        $result = $model->getResult();

        if ($result === false) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'data' => null,
                'errors' => $model->errors,
            ];
        }

        $expand = $this->getExpandFields();
        if (!empty($expand) && is_array($result) && isset($result['data']) && is_array($result['data'])) {
            $result['data'] = array_map(function ($item) use ($expand) {
                return ($item instanceof Arrayable) ? $item->toArray([], $expand) : $item;
            }, $result['data']);
        }

        return [
            'success' => true,
            'data' => $result,
            'errors' => null,
        ];
    }

    protected function sendModel($model)
    {
        $expand = $this->getExpandFields();
        $data = ($model instanceof Arrayable && !empty($expand))
            ? $model->toArray([], $expand)
            : $model;

        return [
            'success' => true,
            'data' => $data,
            'errors' => null,
        ];
    }
}
