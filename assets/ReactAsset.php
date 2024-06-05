<?php

namespace app\assets;

class ReactAsset extends \yii\web\AssetBundle
{
    public $jsOptions = ["position" => \yii\web\View::POS_HEAD];
    public $js = [
        "https://unpkg.com/react@18/umd/react.development.js",
        "https://unpkg.com/react-dom@18/umd/react-dom.development.js",
        "https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js",
        "https://unpkg.com/@babel/standalone/babel.min.js",
    ];
}
