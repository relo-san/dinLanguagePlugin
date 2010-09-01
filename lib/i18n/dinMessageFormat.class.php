<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Extend class for formatting i18n messages
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.i18n
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class dinMessageFormat extends sfMessageFormat
{

    /**
     * Using encoding for keys and translations
     * @var boolean
     */
    protected $transcode = false;


    /**
     * Update source (add new dictionaries and keys)
     * @var boolean
     */
    protected $update = false;


    /**
     * Constructor.
     * 
     * @param   sfMessageSource $source Source of translation messages
     * @param   string  $charset    Charset for the message output [optional]
     * @return  void
     */
    public function __construct( sfIMessageSource $source, $charset = 'UTF-8' )
    {

        $this->transcode = sfConfig::get( 'app_i18n_always_transcode_charset', false );
        $this->update = sfConfig::get( 'app_i18n_update_dictionaries', false );
        parent::__construct( $source, $charset );

    } // dinMessageFormat::__construct()


    /**
     * Formats the string
     * 
     * @param   string  $key        Key to translate
     * @param   array   $args       A list of string to substitute [optional]
     * @param   string  $catalogue  Dictionary name [optional]
     * @param   string  $charset    Input AND output charset [optional]
     * @return  string  Translated string
     */
    public function format( $key, $args = array(), $catalogue = null, $charset = null )
    {

        if ( $catalogue === 'null' )
        {
            return $key;
        }

        if ( !$this->transcode )
        {
            return $this->formatString( $key, $args, $catalogue );
        }

        if ( empty( $charset ) )
        {
            $charset = $this->getCharset();
        }

        $s = $this->formatString( sfToolkit::I18N_toUTF8( $key, $charset ), $args, $catalogue );

        return sfToolkit::I18N_toEncoding( $s, $charset );

    } // dinMessageFormat::format()


    /**
     * Do string translation
     * 
     * @param   string  $key        Key to translate
     * @param   array   $args       A list of string to substitute [optional]
     * @param   string  $catalogue  Dictionary name [optional]
     * @return  string  Translated string
     */
    protected function formatString( $key, $args = array(), $catalogue = null )
    {

        if ( empty( $args ) )
        {
            $args = array();
        }

        if ( empty( $catalogue ) )
        {
            $catalogue = $this->catalogue;
        }

        $this->loadCatalogue( $catalogue );

        foreach ( $this->messages[$catalogue] as $variant )
        {
            // we found it, so return the target translation
            if ( isset( $variant[$key] ) )
            {
                $target = $variant[$key];

                // found, but untranslated
                if ( empty( $target[0] ) )
                {
                    return $this->postscript[0] . $key . $this->postscript[1];
                }
                return $this->replaceArgs( $target[0], $args );
            }
        }

        if ( $this->update )
        {
            $this->source->addKey( $key, $catalogue );
        }

        return $this->postscript[0] . $key . $this->postscript[1];

    } // dinMessageFormat::formatString()

} // dinMessageFormat

//EOF