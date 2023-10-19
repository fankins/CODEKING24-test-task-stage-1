<?php

namespace Fankins;

use Bitrix\Main\Loader;
use Bitrix\Main\Context;

use Bitrix\Main\Engine\Contract\Controllerable;

class Reg extends \CBitrixComponent implements Controllerable
{
    public $USER;

    public $arParams;
    public $app;

    public function configureActions()
    {
        return [
            'sendForm' => [
                'prefilters' => [],
            ],
        ];
    }

    public function sendFormAction($post)
    {
        parse_str($post, $arData);

        if (check_bitrix_sessid())
        {
            global $USER;
            $arResult = $USER->Register($arData['username'], "", "", $arData['password'], $arData['password'], $arData['email'], false, $arData['captcha_word'],$arData['captcha_sid']);

            if ($arResult['TYPE'] == 'OK')
            {
                $obProp = new \CSaleOrderUserProps();
                $profId = $obProp->Add([
                    'PERSON_TYPE_ID' => 1,
                    'USER_ID' => $arResult['ID'],
                    'NAME' => $arData['email'],
                ]);

                $props = $this->getProps();
                foreach ($props as $arProp)
                {
                    if (isset($arData[$arProp['CODE']]))
                    {
                        \CSaleOrderUserPropsValue::Add(
                            [
                                "USER_PROPS_ID" => $profId,
                                "ORDER_PROPS_ID" => $arProp['ID'],
                                "VALUE" => $arData[$arProp['CODE']]
                            ]
                        );
                    }
                }

                $arResult['PROFILE_ID'] = $profId;
            }
            return $arResult;
        }
    }

    private function getProps()
    {
        $arProps = [];
        $rawProps = \CSaleOrderProps::GetList(
            array("SORT" => "ASC"),
            array(
                "PROPS_GROUP_ID" => $this->arParams['GROUP_ID']??1,
                "UTIL" => "N",
                "ACTIVE" => "Y"
            ),
            false,
            false,
            array()
        );

        while($props = $rawProps->Fetch())
        {
            $arProps[] = $props;
        }
        return $arProps;
    }

    public function __construct($component = null)
    {
        Loader::includeModule("iblock");
        Loader::includeModule("sale");
        Loader::includeModule("catalog");

        parent::__construct($component);
    }

    public function onPrepareComponentParams($arParams)
    {
        global $APPLICATION;

        $this->arParams = $arParams;
        $this->arResult["CAPTCHA_CODE"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

        $this->arResult['PROPS'] = $this->getProps();
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

}
