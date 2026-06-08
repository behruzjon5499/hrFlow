<?php
/**
 * @author Eugine Terentev <eugine@terentev.net>
 * @author Victor Gonzalez <victor@vgr.cl>
 * @var yii\web\View $this
 * @var string $content
 */

use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginContent('@backend/views/layouts/common.php'); ?>
    <div class="box">
        <div class="box-body">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumb'], // Optional: You can customize the container class
                'itemTemplate' => '<li>{link} /</li>', // Add the slash after each breadcrumb item
                'homeLink' => [
                    'label' => 'Home',
                    'url' => Yii::$app->homeUrl,
                ],
            ]) ?>
            <?= Alert::widget() ?>
            <?php echo $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>
