<?php

use app\models\form\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model LoginForm
 */

echo Html::beginTag('div', ['class' => 'row']);
echo Html::tag('div', '', ['class' => 'col-3']);
$form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'col-6']]);
echo $form->field($model, 'username')->textInput();
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'rememberMe')->checkbox();
echo Html::tag(
    'p',
    Html::submitButton(Yii::t('app', 'Sign In'), ['class' => ['btn', 'btn-primary', 'w-50']]),
    ['class' => 'text-center']);
echo Html::tag(
    'p',
    Yii::t('app', 'Don`t have account? <a href="/user/registration">Sign In</a>'),
    ['class' => 'text-center']);
echo Html::tag(
    'p',
    Yii::t('app', 'Forgot password? <a href="/user/reset-password">Reset It</a>'),
    ['class' => 'text-center']);
ActiveForm::end();

echo Html::endTag('div');

