<?php

namespace app\assets;

use yii\web\AssetBundle;

class PlayerAsset extends AssetBundle
{
    public $js = [
        ["/js/react/player.js", "type" => "text/babel"],
        ["/js/react/playlist.js", "type" => "text/babel"],
        ["/js/react/view.js", "type" => "text/babel"],
        ["/js/react/app.js", "type" => "text/babel"],
        ["/js/react/index.js", "type" => "text/babel"],
    ];
}
