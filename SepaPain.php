<?php
/**
 * 	INNODYN SEPA PAIN LIBRARY
 *  
 *	Copyright 2013 Innodyn (www.innodyn.nl)
 *
 *    This library is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as published
 *    by the Free Software Foundationeither version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *	@author Leon Gilles Faber
 *  For more information about this software visit http://innodyn.nl
 */
abstract class SepaPain{
	/**
	 * Add instance's XML nodes to parent node $node
	 * 
	 * @param object SimpleXMLElement $node: Node to add subnodes to. Is passed by reference
	 */
	abstract protected function addXML(SimpleXMLElement &$node);

	/**
	 * Initial string for XML document string
	 * @var string
	 */
	const INITIAL_STRING = '<?xml version="1.0" encoding="UTF-8"?><Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02" xmlns:xsi="http://www.w3.org/2001/XMLSchema-intance"></Document>';
	
	/**
	 * Instance's options
	 * 
	 * @access protected
	 * @var array mixed
	 */
	protected $options = array();
	
	/**
	 * Array of ISO3166 country codes and country names
	 * 
	 * @access public
	 * @static
	 * @var array string
	 */
	public static $ISO3166 = array(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe'
	);
        
        /**
	 * Array of IBAN lengths for ISO3166 country codes
	 * 
	 * @access public
	 * @static
	 * @var array int
	 */
        public static $ibanLengths = array(
                'AL' => 28,
                'AD' => 24,
                'AT' => 20,
                'BE' => 16,
                'BA' => 20,
                'BG' => 22,
                'HR' => 21,
                'CY' => 28,
                'CZ' => 24,
                'DK' => 18,
                'EE' => 20,
                'FO' => 18,
                'FI' => 18,
                'FR' => 27,
                'GE' => 22,
                'DE' => 22,
                'GI' => 23,
                'GR' => 27,
                'GL' => 18,
                'HU' => 28,
                'IS' => 26,
                'IE' => 22,
                'IT' => 27,
                'LV' => 21,
                'LI' => 21,
                'LT' => 20,
                'LU' => 20,
                'MK' => 19,
                'MT' => 31,
                'MC' => 27,
                'ME' => 22,
                'NL' => 18,
                'NO' => 15,
                'PL' => 28,
                'PT' => 25,
                'RO' => 24,
                'SM' => 27,
                'RS' => 22,
                'SK' => 24,
                'SI' => 19,
                'ES' => 24,
                'SE' => 24,
                'CH' => 21,
                'UA' => 29,
                'GB' => 22,
                'DZ' => 24,
                'AO' => 25,
                'AZ' => 28,
                'BH' => 22,
                'BJ' => 28,
                'BR' => 29,
                'VG' => 24,
                'BF' => 27,
                'BI' => 16,
                'CM' => 27,
                'CV' => 25,
                'FR' => 27,
                'CG' => 27,
                'CR' => 21,
                'DO' => 28,
                'EG' => 27,
                'GA' => 27,
                'GT' => 28,
                'IR' => 26,
                'IL' => 23,
                'CI' => 28,
                'JO' => 30,
                'KZ' => 20,
                'KW' => 30,
                'LB' => 28,
                'MG' => 27,
                'ML' => 28,
                'MR' => 27,
                'MU' => 30,
                'MZ' => 25,
                'PK' => 24,
                'PS' => 29,
                'QA' => 29,
                'PT' => 25,
                'SA' => 24,
                'SN' => 28,
                'TN' => 24,
                'TR' => 26,
                'AE' => 23
        );
	
	/**
	 * Constructor
	 * Checks whether required options are set and puts them in $options property
	 * 
         * @access protected
	 * @param array mixed $options
         * @param array int $maxLengths
	 */
	protected function __construct($options, $maxLengths = null){
		$this->checkRequiredOptions($options);
		$this->options = $this->cleanOptions($options, $maxLengths);	
	}
	
	/**
	 * Magic setter function for instance's options
	 * 
	 * @access public
	 * @param string $key
	 * @param multitype $value
	 */
	public function __set($key, $value){
		$this->options[$key] = $value;
	}
	
	/**
	 * Magic getter function for instance's options
	 * 
	 * @param string $key
	 * @return multitype:|NULL
	 */
	public function __get($key){
		if(array_key_exists($key, $this->options)) return $this->options[$key];
//		throw new Exception("Property $key does not exist.");
		return null;
	}
	
	/**
	 * Checks whether all required options are set
	 * 
	 * @param array mixed $options
	 * @throws Exception
	 */
	protected function checkRequiredOptions($options){
		foreach(static::$requiredOptions as $key){
			if(!array_key_exists($key, $options)){
				throw new Exception("Required option $key missing during construction of class " . get_class($this));
			}
		}
	}
	
	/**
	 * Cleans all the strings in the $options array.
         * If $maxLengths is an array and has the key of the option set, the option string is cut off at
         * that the set length. If $maxLengts has an int value, all option strings are cut of at that length.
	 * 
	 * @access protected
	 * @param array mixed $options
         * @param array int | int $maxLengths
	 * @return array mixed
	 */
	protected function cleanOptions(&$options, &$maxLengths = null){
		foreach($options as $key => &$value){
			if(is_string($value) && !is_numeric($value)){
				$value = $this->cleanString($value);
                                if(is_array($maxLengths)){
                                    if(array_key_exists($key, $maxLengths) && strlen($value) > $maxLengths[$key]){
                                        $value = substr($value, 0, $maxLengths[$key]);
                                    }
                                }elseif(is_int($maxLengths) && strlen($value) > $maxLengths){
                                    $value = substr($value, 0, $maxLengths);
                                }
			}elseif(is_array($value)){
                                $subMaxLengths = (is_array($maxLengths) && array_key_exists($key, $maxLengths)) ? $maxLengths['$key'] : null;
				$value = $this->cleanOptions($value, $subMaxLengths);
			}
		}
		return $options;
	}
	
	/**
	 * Converts amount of cents to currency string
	 * 
	 * @access protected
	 * @param int $value
	 * @return string
	 */
	protected function centsToCurrency($value){
		return sprintf("%01.2f", ($value / 100));
	}
	
	/**
	 * Checks whether a currency code (e.g. EUR) is valid
	 * @param string $value
	 * @throws Exception
	 * @return string
	 */
	protected function validateCurrency($value){
		if($value !== 'EUR') throw new Exception("Invalid ISO currency code: $value");
		return $value;
	}
	
	/**
	 * Converts variable into string 'true' or 'false' if it's a boolean. Strings are returned as they are
	 * @param multitype $value
	 * @return string
	 */
	protected function boolToString($value){
		if(is_string($value)) return strtolower($value);
		return $value ? 'true' : 'false';
	}
	
	/**
	 * Checks whether at least one of option(s) is set
	 * 
	 * @example if($this->optionIsSet('optionA', 'optionB')) echo "One of options was set
	 * @access protected
	 * @param string $option1
	 * @return boolean
	 */
	protected function optionIsSet(){
		foreach(func_get_args() as $key){
			if(array_key_exists($key, $this->options)) return true;
		}
		return false;
	}
	
	/**
	 * Adds element $nodeName to $node with value from instance's options with key $optionKey
	 * 
	 * @access protected
	 * @param SimpleXMLElement $node
	 * @param string $nodeName
	 * @param string $optionKey
	 */
	protected function setOptionalElement(SimpleXMLElement &$node, $nodeName, $optionKey){
		if(array_key_exists($optionKey, $this->options)){
			$value = $this->options[$optionKey];
			try{
				if(is_object($value)){
					switch(get_class($value)){
						case 'DateTime':
							$value = $value->format('Y-m-d');
							break;
						default :
							throw new Exception("Option $optionKey is of unsupported class");
					}
					$node->addChild($nodeName, (string)$value);
				}elseif(is_array($value)){
					foreach($value as $subValue){
						$node->addChild($nodeName, (string)$subValue);
					}
				}elseif(is_string($value)){
					$node->addChild($nodeName, (string)$this->cleanString($value));
				}else{
					$node->addChild($nodeName, (string)$value);
				}
			}catch(Exception $e){
				throw new Exception("Option $optionKey could not be converted into a string");
			}
		}
	}
	
	/**
	 * Cleans SEPA string to conform ISO 2022
	 *
	 * @access public
	 * @static
	 * @param string $s
         * @param int $maxLength (optional)
	 * @return string
	 */
	public static function cleanString($s, $maxLength = null){
		$original = $s;
		$s = strtr(utf8_decode($s),
				utf8_decode(
				'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),
				'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
		for($i = 0; $i < strlen($original); $i++){ // Question marks are replaced by some other character.
			if(substr($original, $i, 1) == '?'){
				$s = substr_replace($s, '?', $i, 1); // Put question mark back
			}
		}
		$s = preg_replace('/[^ a-z0-9\/\-?:\(\)\.,\'\+]/i', '', $s);
                if(isset($maxLength) && strlen($s) > $maxLength){
                    return substr($s, 0, $maxLength);
                }
                return $s;
	}
	
	/**
	 * Performs a validation whether $iban is a valid IBAN code
	 *
	 * @static
	 * @access public
	 * @param string $iban: IBAN code
	 * @return boolean: $iban is valid IBAN
	 */
	public static function validateIban($iban){
                $iban = self::cleanIban($iban);
 		try{
                        $ibanParts = self::splitIbanParts($iban);
		}catch(Exception $e){
			return false;
		}
                if(array_key_exists($ibanParts->country, self::$ibanLengths) && (strlen($iban) != self::$ibanLengths[$ibanParts->country])) return false; // Invalid IBAN length
		if(!preg_match('/^[A-Z]{2}$/', $ibanParts->country) || !array_key_exists($ibanParts->country, self::$ISO3166)) return false; // Country code should consist of two alphanumeric characters
		if(!preg_match('/^[0-9]{2}$/', $ibanParts->checksum)) return false; // Checksum should consist of two digits
		if(!preg_match('/^[A-Z0-9]+$/', $ibanParts->identifier)) return false; // Identifier should consist of multiple alphanumeric characters and digits
		if($ibanParts->checksum != self::calculateIbanChecksum($ibanParts->identifier, $ibanParts->country)) return false; // Invalid checksum
		return true;
	}

	/**
	 * Cleans up an IBAN code
	 *
	 * @param string $iban
	 * @return string
	 */
	public static function cleanIban($iban){
		$iban = strtoupper($iban);
		$iban = preg_replace('/\s/', '', $iban);
		if(substr($iban, 0, 4) == 'IBAN'){
                    $iban = substr($iban, 4);
                }
		return $iban;
	}
	
	
	/**
	 * Calculates an IBAN checksum
	 *
	 * @static
	 * @access private
	 * @param string $accountIdentifier
	 * @param string $countryCode
	 * @return string
	 */
	private static function calculateIbanChecksum($accountIdentifier, $countryCode){
		$fullNumber = self::convertIbanLettersToNumbers($accountIdentifier . $countryCode . '00');
		return (string)str_pad((98 - intval(bcmod($fullNumber, 97))), 2, '0', STR_PAD_LEFT);
	}
	
	/**
	 * Returns string $code in which letter characters have been replaced with numeric substrings
	 * (A -> 10, B -> 11, Z -> 35)
	 *
	 * @example IbanHelper::convertLettersToNumbers('123Z') returns '12335'
	 *
	 * @static
	 * @access private
	 * @param string $code
	 * @throws Exception
	 * @return string
	 */
	private static function convertIbanLettersToNumbers($code){
		$code = strtoupper($code);
		$fullNumber = '';
		for($i = 0; $i < strlen($code); $i++){
			$char = substr($code, $i, 1);
			if(is_numeric($char)){
				$fullNumber .= (string)$char;
			}else{
				$subCode = ord($char) - 55;
				if($subCode < 10 || $subCode > 35){
					throw new Exception('IbanHelper::convertLettersToNumbers: Invalid character');
				}
				$fullNumber .= (string)$subCode;
			}
		}
		return (string)$fullNumber;
	}
	
	/**
	 * Splits IBAN code into a stdClass with it's parts
	 *
	 * @access public
	 * @static
	 * @param string $iban
	 * @return stdClass
	 */
	public static function splitIbanParts($iban){
		$splitIban = new stdClass();
		$splitIban->country = (string)substr($iban, 0, 2);
		$splitIban->checksum = (string)substr($iban, 2, 2);
		$splitIban->identifier = (string)substr($iban, 4);
		return $splitIban;
	}
	
	/**
	 * Checks whether $bic is a valid BIC code
	 * 
	 * @static
	 * @access public
	 * @param type $bic
	 * @return type
	 */
	public static function validateBic($bic){
		return preg_match('/^[A-Z]{6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3})?$/', $bic)  && array_key_exists(substr($bic, 4, 2), self::$ISO3166);
	}
        
        /**
         * Checks whether dates are correctly formatted for SEPA purposes
         * 
         * @static
         * @access protected
         * @param string $dateString
         * @return boolean
         */
        protected static function validateDateString($dateString){
             if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $dateString)){
                return false;
            }
            return DateTime::createFromFormat('Y-m-d', $dateString) !== false;
        }
        
        /**
         * Turns a DateTime instance into a string for SEPA PAIN purposes
         * 
         * @static
         * @access public
         * @param object DateTime $dateTime
         * @return type
         */
        public static function formatDate(DateTime $dateTime){
            return $dateTime->format('Y m d');
        }
	
}