<?php
namespace common\widgets;

use yii\helpers\ArrayHelper;

use iutbay\yii2kcfinder\KCFinderAsset;
use iutbay\yii2kcfinder\KCFinder;
use Yii;

class CKEditor extends \dosamigos\ckeditor\CKEditor
{

    public $enableKCFinder = true;

    /**
     * Registers CKEditor plugin
     */
    protected function registerPlugin()
    {

        if ($this->enableKCFinder)
        {
            $this->registerKCFinder();
        }

        parent::registerPlugin();
    }

    /**
     * Registers KCFinder
     */
    protected function registerKCFinder()
    {
        $register = KCFinderAsset::register($this->view);
        $this->prepareSession();

        $kcfinderUrl = $register->baseUrl;

        $browseOptions = [
            'filebrowserBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=files',
            'filebrowserUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=files',
        ];

        $this->clientOptions = ArrayHelper::merge($browseOptions, $this->clientOptions);
    }

    /**
     * Load prepared file into asset
     * Required for custom session management
     * For example, if you have specified custom session name in config file, this function will let KCFinder know about it.
     * SessionSaveHandler reads session name and id from cookie saved by Yii2, then it's served to KCFinder.
     */

    public function prepareSession(){
        $session_file = __DIR__.'/SessionSaveHandler.php';
        $session_file = file_get_contents($session_file);
        /* Replace asset file, so original bootstrap.php file won't be touched */
        $new_bootstrap_file = Yii::$app->assetManager->getPublishedPath((new KCFinderAsset)->sourcePath);
        $new_bootstrap_file .= '/core/bootstrap.php';

        $search = ['$this->sessionName = "";', '$this->cookieName = "";'];
        $replace = ['$this->sessionName = "'.Yii::$app->session->getName().'";', '$this->cookieName = "'.Yii::$app->session->getName().'";'];
        $session_file = str_replace($search,$replace,$session_file);

        file_put_contents($new_bootstrap_file, $session_file);
    }

}