<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var $arResult;
 * @var $arParams;
 */
?>

<fieldset>

    <legend>
        Регистрация ебаная
    </legend>

    <form id="reg" method="post">

        <?= bitrix_sessid_post(); ?>

        <label for="username">Логин:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>
        <fieldset>

            <legend>
                Продрись доп.полей
            </legend>
            <? foreach ($arResult['PROPS'] as $prop){ ?>

                <label for="<?=$prop['CODE']?>"><?=$prop['NAME']?>:</label>
                <input type="text" id="<?=$prop['CODE']?>" name="<?=$prop['CODE']?>" <?=($prop['REQUIED']=='Y') ? "required" : ""?>><br><br>

            <? } ?>
        </fieldset>

        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

        <div class="bx-authform-formgroup-container">
            <div class="bx-authform-label-container">
                <span class="bx-authform-starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>
            </div>
            <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
            <div class="bx-authform-input-container">
                <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
            </div>
        </div>

        <br>
        <input type="submit" value="Войти">
    </form>

</fieldset>