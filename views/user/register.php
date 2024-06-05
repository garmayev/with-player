<?php

use app\models\form\RegisterForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $model RegisterForm
 * @var $this View
 */
?>
<div class="row">
    <div class="col-3"></div>
    <?php
    $form = ActiveForm::begin(['options' => ['class' => 'col-6']]);
    echo $form->field($model, 'username')->textInput();
    echo $form->field($model, 'email')->textInput();
    echo $form->field($model, 'password')->passwordInput();
    echo $form->field($model, 'confirm')->passwordInput();
    echo \yii\helpers\Html::tag(
        'p',
        \yii\helpers\Html::submitButton(Yii::t('app', 'Sign up'), ['class' => ['btn', 'btn-primary', 'w-50']]),
        ['class' => 'text-center']
    );
    ActiveForm::end();
    ?>
</div>
