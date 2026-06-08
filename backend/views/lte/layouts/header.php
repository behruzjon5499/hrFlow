<?php


use backend\models\Functions;
use backend\modules\system\models\SystemLog;
use backend\widgets\MainSidebarMenu;
use rmrevin\yii\fontawesome\FAR;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$keyStorage = Yii::$app->keyStorage;
/* @var $this View */
/* @var $content string */
$user = \common\models\User::findOne(Yii::$app->user->id);
?>
<style>
    .nav-link {
        padding: 0 !important;
        text-align: center;

    }

</style>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu" style="display: inline">
                <li class="nav-header" style="text-align: center;display: block;width: 100%">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/img/profile_small.jpg"
                                 tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/img/profile_small.jpg"/>
                             </span>

                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"
                                                                                 style="color: white"><?= $user->username ?></strong>

                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/evalue-goal/index'])?>" tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/layouts.html"><i
                                class="fa fa-diamond"></i> <span
                                class="nav-label"><?= Yii::t('main', 'Baholash maqsadi') ?></span></a>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/repair-state/index'])?>" tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/layouts.html"><i
                                class="fa fa-diamond"></i> <span
                                class="nav-label"><?= Yii::t('main', 'Holati') ?></span></a>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/has-detail/index'])?>" tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/layouts.html"><i
                                class="fa fa-diamond"></i> <span
                                class="nav-label"><?= Yii::t('main', "Qo'shimchalar") ?></span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?=t("Ko'chmas mulk")?></span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?= Url::to(['/building-material/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Qurilish materiali")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/home-plan/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Rejasi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/facade/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Fasad")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/communication/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Kommunikatsiyalar")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/located-nearby/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Yaqinida nimalar joylashgan")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/home-property-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Bino turlari")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/home-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Foydalanish maqsadi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/home-sub-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Turarjoy turi")?></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?=t("Avtotransport")?></span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        <li><a href="<?= Url::to(['/auto-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Avtotransport turi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/auto-marka/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Avtotransport marka")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/auto-model/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Avtotransport model")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/gearbox/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Uzatmalar qutusi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/body-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Kuzov turi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/fuel-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Yoqilg`i turi")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/engine-size/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Dvigatel hajmi")?></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?=t("Uskunalar")?></span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        <li><a href="<?= Url::to(['/equipment-type/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Uskuna turi")?></a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?=t("Regions")?></span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        <li><a href="<?= Url::to(['/region/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Viloyat")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/district/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Tuman")?></a>
                        </li>
                        <li><a href="<?= Url::to(['/neighborhood/index'])?>"
                               tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/form_basic.html"><?=t("Maxalla")?></a>
                        </li>
                    </ul>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/bank/index'])?>" tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/layouts.html"><i
                                class="fa fa-diamond"></i> <span
                                class="nav-label"><?= Yii::t('main', "Bank") ?></span></a>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/evalue-generate/index'])?>" tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/layouts.html"><i
                                class="fa fa-diamond"></i> <span
                                class="nav-label"><?= Yii::t('main', 'Generate') ?></span></a>
                </li>
                <li style="width: 100%">
                    <a href="<?= Url::to(['/map-polygon/index'])?>"><i
                                class="fa fa-map-marker"></i> <span
                                class="nav-label"><?= Yii::t('main', 'Map') ?></span></a>
                </li>
            </ul>


        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom" style="display: inline ">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;display: inline;padding: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>

                </div>
                <ul class="nav navbar-top-links navbar-right" style="padding: 0 ">

                    <li>
                        <!--                            <span class="m-r-sm text-muted welcome-message"> -->
                        <? //=Yii::t('yii','Добро пожаловать в нашу систему ЕФС.')?><!--</span>-->
                    </li>
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" style="padding: 0 10px;"
                           aria-expanded="false">
                            <?= Yii::t('main', 'Language') ?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                            <?php
                                                            foreach (Yii::$app->params['languages'] as $url_key => $lang) {

                                                                if ($url_key != Yii::$app->language) { ?>
                                                                    <li>
                                                                        <a href="<?= Functions::changeUrlLang($url_key) ?>"><?= $lang ?></a>
                                                                     </li>
                                                                <?php }
                                                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a href="/sign-in/logout" style="padding: 0 10px"
                           tppabs="http://webapplayers.com/inspinia_admin-v2.7.1/login.html">
                            <i class="fa fa-sign-out"></i> <?= Yii::t('main', 'Log out') ?>
                        </a>
                    </li>

                </ul>

            </nav>


