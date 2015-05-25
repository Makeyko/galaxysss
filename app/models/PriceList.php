<?php


namespace cs\models;


class PriceList
{
    /** @const CREATE_ORDER_TO_BANK списание за подачу заявки в банк */
    const CREATE_ORDER_TO_BANK = 30;

    /** @const CREATE_ORDER_TO_BANK списание за подачу заявки в банк */
    const CREATE_ORDER_TO_LOMBARD = 30;

    /** @const  списание за подачу заявки в банк на микрокредит */
    const CREATE_ORDER_TO_BANK_MICROCREDIT = 10;

    /** @const  списание за подачу заявки в банк на потребительский кредит */
    const CREATE_ORDER_TO_BANK_CONSUMER = 20;

    /** @const  списание за подачу заявки в банк на ипотеку */
    const CREATE_ORDER_TO_BANK_IPOTEKA = 30;

    /** @const FILTER_VIEW_BANK_IN_ADD_ORDER количество средств которое должно находиться у банка чтобы быть показанным пользователю перед добавлением заявки */
    const FILTER_VIEW_BANK_IN_ADD_ORDER = 30;
}