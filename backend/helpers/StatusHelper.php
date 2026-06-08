<?php

namespace backend\helpers;


use common\enums\CompanyTransactionEnum;
use common\enums\ProductEnum;
use common\enums\ShopEnum;
use common\models\Record;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class StatusHelper
{

    public static function statusList()
    {
        return [
            ProductEnum::SHOP_STATE_NEW => 'Moderator tekshiruvida',
            ProductEnum::SHOP_STATE_RETURN_MODERATOR =>  'Moderator tomondan qaytarilgan',
            ProductEnum::SHOP_STATE_ACTIVE =>  'Sotuvda',
            ProductEnum::SHOP_STATE_NO_MONEY=>  "Mablug' yetarli emas",
        ];
    }
    public static function refundsStatusList()
    {
        return [
            CompanyTransactionEnum::REFUNDS_STATUS_NEW => 'Moderator tekshiruvida',
            CompanyTransactionEnum::REFUNDS_STATUS_REJECTED =>  'Moderator tomondan qaytarilgan',
            CompanyTransactionEnum::REFUNDS_STATUS_ACCEPT =>  'Moderator tasdiqlagan',
        ];
    }
    public static function recordStatusList()
    {
        return [
            Record::STATUS_REJECT => t('Rad etilgan'),
            Record::STATUS_NEW =>   t('Jarayonda'),
            Record::STATUS_ACCEPT =>  t('Qabul qilingam'),
        ];
    }
    public static function statusLabel($state)
    {
        switch ($state) {
            case ProductEnum::SHOP_STATE_NEW:
                $class = 'label label-primary';
                break;
            case ProductEnum::SHOP_STATE_RETURN_MODERATOR:
                $class = 'label label-danger';
                break;
            case ProductEnum::SHOP_STATE_NO_MONEY:
                $class = 'label label-info';
                break;
            case ProductEnum::SHOP_STATE_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $state), [
            'class' => $class,
        ]);
    }
    public static function refundsStatusLabel($state)
    {
        switch ($state) {
            case CompanyTransactionEnum::REFUNDS_STATUS_NEW:
                $class = 'label label-info';
                break;
            case CompanyTransactionEnum::REFUNDS_STATUS_REJECTED:
                $class = 'label label-danger';
                break;
            case CompanyTransactionEnum::REFUNDS_STATUS_ACCEPT:
                $class = 'label label-primary';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::refundsStatusList(), $state), [
            'class' => $class,
        ]);
    }
    public static function recordStatusLabel($state)
    {
        switch ($state) {
            case Record::STATUS_REJECT:
                $class = 'label label-danger';
                break;
            case Record::STATUS_NEW:
                $class = 'label label-primary';
                break;
            case Record::STATUS_ACCEPT:
                $class = 'label label-success';
                break;

            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::recordStatusList(), $state), [
            'class' => $class,
        ]);
    }
}