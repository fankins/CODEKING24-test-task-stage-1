<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2013 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUserTypeManager $USER_FIELD_MANAGER
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER_FIELD_MANAGER;

//silence is golden

$this->IncludeComponentTemplate();
