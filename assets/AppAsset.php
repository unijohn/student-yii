<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    //public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        [
            'href' => 'images/favicons/favicon-32x32.png',
            'rel'   => 'icon',
            'sizes' => '32x32',
        ],    
        [
            'href' => 'images/favicons/favicon-16x16.png',
            'rel'   => 'icon',
            'sizes' => '16x16',
        ],            
        [
            'href' => 'images/favicons/apple-touch-icon.png',
            'rel'   => 'icon',
        ],

        'css/site.css',
        '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function init()
    {
        parent::init();
        

        if( YII_ENV == "dev" ){
            $this->css[0]['href'] = 'images/favicons/favicon-32x32-DEV.png';
            $this->css[1]['href'] = 'images/favicons/favicon-16x16-DEV.png';
            $this->css[2]['href'] = 'images/favicons/apple-touch-icon-DEV.png';
        }
    }    
}
