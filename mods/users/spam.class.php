<?php
/**
 * Spam Klasse
 * 
 * Check if User no Spammer by Registration
 * 
 * Max. Requests per Day: 20.000
 * 
 * PHP Version 5
 *
 * @category Spam
 * @package  ClanSphere
 * @author   Patrick "Fr33z3m4n" Jaskulski <fr33z3m4n@csphere.eu>
 * @license  License http://www.csphere.eu/index/clansphere/about
 * @version  SVN: $Id$
 * @link 	 http://www.csphere.eu
 */

/**
 * Spam Klasse
 *
 * PHP Version 5
 *
 * @category Spam
 * @package  ClanSphere
 * @author   Patrick "Fr33z3m4n" Jaskulski <fr33z3m4n@csphere.eu>
 * @license  License http://www.csphere.eu/index/clansphere/about
 * @link 	 http://www.csphere.eu
 */
class Spam
{

    /**
     * $_intance
     * 
     * Class-Instance
     * 
     * @var object class
     */
    private static $_intance = null;

    /**
     * spamBlocker
     * 
     * Kontruktor
     * 
     * @access public
     * @return void
     */
    public function Spam()
    {
        // nothing to do
    }

    /**
     * getInstance
     *
     * Create Instance if is not possible. Single Pattern
     *
     * @access public
     * @return object Instance
     */
    public static function getInstance()
    {
        if (self::$_intance == null) {
            self::$_intance = new self;
        }
        return self::$_intance;
    }

    /**
     * checkUser
     * 
     * Check if User are registered as Spam
     * 
     * @param String $email Mail-Adress
     * 
     * @return Boolean
     */
    public static function checkUser($email)
    {
        $xml_string = file_get_contents('http://www.stopforumspam.com/api?email=' . $email);
        $xml = new SimpleXMLElement($xml_string);
        if ($xml->appears == 'yes') {
            return true;
        } elseif ($spambot != true) {
            // e-mail not found, now check the ip
            $xml_string = file_get_contents('http://www.stopforumspam.com/api?ip=' . $_SERVER['REMOTE_ADDR']);
            $xml = new SimpleXMLElement($xml_string);
            if ($xml->appears == 'yes') {
                return true;
            }
        }
        return false;
    }
}
