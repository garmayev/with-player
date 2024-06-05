<?php
/**
 * @var $this \yii\web\View
 */

\app\assets\ReactAsset::register($this);
\app\assets\FontawesomeAsset::register($this);
\app\assets\PlayerAsset::register($this);

$this->registerCssFile("/css/player.css");
if ( !\Yii::$app->user->isGuest ) {
    $this->registerJsVar("authKey", \Yii::$app->user->identity->auth_key);
}

?>
<div id="container"></div>
<script type="text/babel" data-plugins="transform-modules-umd" data-presets="react" data-type="module">
import App from "../js/react/app.js"

const container = document.getElementById('container');
const root = ReactDOM.createRoot(container);
window.audio = new Audio()
root.render(<App />)

</script>