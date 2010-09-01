<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Class for extending i18n support
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.i18n
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class dinI18n extends sfI18N
{

    /**
     * Gets the message format
     * 
     * @return  dinMessageFormat
     */
    public function getMessageFormat()
    {

        if ( !isset( $this->messageFormat ) )
        {

            $this->messageFormat = new dinMessageFormat(
                $this->getMessageSource(), sfConfig::get( 'sf_charset' )
            );

            if ( $this->options['debug'] )
            {
                $this->messageFormat->setUntranslatedPS( array(
                    $this->options['untranslated_prefix'], $this->options['untranslated_suffix']
                ) );
            }

        }

        return $this->messageFormat;

    } // dinI18n::getMessageFormat()

} // dinI18n

//EOF