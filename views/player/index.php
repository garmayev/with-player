<?php
/**
 * @var $this \yii\web\View
 */

\app\assets\ReactAsset::register($this);
\app\assets\FontawesomeAsset::register($this);
\app\assets\PlayerAsset::register($this);

$this->registerCssFile("/css/player.css");
$this->registerJsVar("authKey", \Yii::$app->user->identity->auth_key);

?>
<div id="container"></div>
