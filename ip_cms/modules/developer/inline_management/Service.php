<?php
    /**
     * @package ImpressPages
     * @copyright   Copyright (C) 2011 ImpressPages LTD.
     * @license see ip_license.html
     */

    namespace Modules\developer\inline_management;


class Service
{
    private $dao;

    public function __construct()
    {
        $this->dao = new Dao();
    }

    public function generateManagedLogo($defaultText = null, $defaultImage = null, $cssClass = null)
    {
        global $site;
        $logoStr = $this->dao->getGlobalValue(Dao::PREFIX_LOGO, '');
        $logo = new Entity\Logo($logoStr);

        $data = array (
            'type' => $logo->getType(),
            'link' => $site->generateUrl(),
            'text' => $logo->getText() ? $logo->getText() : $defaultText,
            'image' => $logo->getImage() ? BASE_URL.IMAGE_DIR.$logo->getImage() : $defaultImage,
            'font' => $logo->getFont(),
            'color' => $logo->getColor(),
            'cssClass' => $cssClass,
        );




        if ($site->managementState()) {
            $data['type'] = Entity\Logo::TYPE_TEXT;
            $logoTextHtml = \Ip\View::create('view/display/logo.php', $data)->render();
            $data['type'] = Entity\Logo::TYPE_IMAGE;
            $logoImageHtml = \Ip\View::create('view/display/logo.php', $data)->render();

            $managementData = array(
                'type' => $logo->getType(),
                'logoTextHtml' => $logoTextHtml,
                'logoImageHtml' => $logoImageHtml
            );
            return \Ip\View::create('view/management/logo.php', $managementData)->render();
        } else {
            $logoHtml = \Ip\View::create('view/display/logo.php', $data)->render();
            return $logoHtml;
        }

    }

    public function generateManagedString($key, $defaultValue = null, $cssClass = null)
    {
        global $site;
        $curValue = $this->dao->getValueString($key);
        if ($curValue === false) {
            $curValue = $defaultValue;
        }

        $data = array (
            'value' => $curValue,
            'key' => $key,
            'cssClass' => $cssClass
        );

        if ($site->managementState()) {
            $view = \Ip\View::create('view/management/string.php', $data);
        } else {
            $view = \Ip\View::create('view/display/string.php', $data);
        }
        return $view->render();
    }

    public function generateManagedText($key, $defaultValue = null, $cssClass = null)
    {
        global $site;
        $curValue = $this->dao->getValueString($key);
        if ($curValue === false) {
            $curValue = $defaultValue;
        }

        $data = array (
            'value' => $curValue,
            'key' => $key,
            'cssClass' => $cssClass
        );

        if ($site->managementState()) {
            $view = \Ip\View::create('view/management/text.php', $data);
        } else {
            $view = \Ip\View::create('view/display/text.php', $data);
        }
        return $view->render();
    }

    public function generateManagedImage($key, $defaultValue = null, $cssClass = null)
    {
        global $site;
        $curValue = $this->dao->getValueString($key);
        if ($curValue === false) {
            $curValue = $defaultValue;
        }

        $data = array (
            'value' => $curValue,
            'key' => $key,
            'cssClass' => $cssClass
        );

        if ($site->managementState()) {
            $view = \Ip\View::create('view/management/image.php', $data);
        } else {
            $view = \Ip\View::create('view/display/image.php', $data);
        }
        return $view->render();
    }


}