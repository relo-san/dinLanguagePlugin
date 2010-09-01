<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * dinLangDictionaryPairAdmin module helper
 * 
 * @package     dinLanguagePlugin
 * @subpackage  modules.dinLangDictionaryPairAdmin.lib
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class dinLangDictionaryPairAdminGeneratorHelper extends BaseDinLangDictionaryPairAdminGeneratorHelper
{

    /**
     * Get dictionary name
     * 
     * @return  
     */
    public function getDictionaryName()
    {

        return DinLanguageDictionaryTable::getInstance()->find(
            sfContext::getInstance()->getRequest()->getParameter( 'dictionary_id', 1 )
        )->getTitle();

    } // dinLangDictionaryPairAdminGeneratorHelper::getDictionaryName()

} // dinLangDictionaryPairAdminGeneratorHelper

//EOF