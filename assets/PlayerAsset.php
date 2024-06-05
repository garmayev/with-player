<?php

namespace app\assets;

use yii\web\AssetBundle;

class PlayerAsset extends AssetBundle
{
    public $jsOptions = ["position" => \yii\web\View::POS_HEAD];
    public $js = [
        ["/js/react/player.js", "type" => "text/babel", "data-presets" => "react", "data-type" => "module", "data-plugins" => "transform-modules-umd"],
        ["/js/react/playlist.js", "type" => "text/babel", "data-presets" => "react", "data-type" => "module", "data-plugins" => "transform-modules-umd"],
        ["/js/react/view.js", "type" => "text/babel", "data-presets" => "react", "data-type" => "module", "data-plugins" => "transform-modules-umd"],
        ["/js/react/app.js", "type" => "text/babel", "data-presets" => "react", "data-type" => "module", "data-plugins" => "transform-modules-umd"],
//        ["/js/react/index.js", "type" => "text/babel"],
    ];
}
