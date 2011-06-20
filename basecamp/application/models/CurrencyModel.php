<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 4/9/11
 * Time: 1:29 AM
 * To change this template use File | Settings | File Templates.
 */

class CurrencyModel extends ActiveRecord\Model {
    static $table_name = 'currency';

    public static function getDefaultCurrency() {
        $defaultCurrency = CurrencyModel::find_by_default("y");
        return $defaultCurrency;
    }

    public static function getCurrencyForLanguage($language_id) {
        $currency = CurrencyModel::find_by_language_id($language_id);
        if ($currency == null) { // fallback to default...
            return CurrencyModel::getDefaultCurrency();
        }
        return $currency;
    }
}
