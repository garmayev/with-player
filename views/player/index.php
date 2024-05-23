<?php
/**
 * @var $this \yii\web\View
 * @var $track \app\models\Track[]
 * @var $playlists \app\models\Playlist[]
 * @var $collection \app\models\Track[]
 */
$this->registerJsVar("playlists", $playlists);
$this->registerJsVar("allTracks", $track);
$this->registerJsVar("collection", $collection);
$this->registerCssFile("/css/player.css");
$this->registerJsFile("https://kit.fontawesome.com/aa23fe1476.js");
$this->registerJsFile("https://unpkg.com/react@18/umd/react.development.js");
$this->registerJsFile("https://unpkg.com/react-dom@18/umd/react-dom.development.js");
$this->registerJsFile("https://unpkg.com/@babel/standalone/babel.min.js");

$this->registerJsFile("/js/react/app.js", ["type" => "text/babel"]);
$this->registerJsFile("/js/react/player.js", ["type" => "text/babel"]);
$this->registerJsFile("/js/react/playlist.js", ["type" => "text/babel"]);
$this->registerJsFile("/js/react/view.js", ["type" => "text/babel"]);
$this->registerJsFile("/js/react/index.js", ["type" => "text/babel"]);
?>
<div id="container"></div>
