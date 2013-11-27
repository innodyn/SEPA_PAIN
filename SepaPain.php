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
	 * Constructor
	 * Checks whether required options are set and puts them in $options property
	 * 
	 * @param array mixed $options
	 */
	protected function __construct($options){
		$this->checkRequiredOptions($options);
		$this->options = $this->cleanOptions($options);	
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
	 * Cleans all the strings in the $options array
	 * 
	 * @access protected
	 * @param array mixed $options
	 * @return array mixed
	 */
	protected function cleanOptions(&$options){
		foreach($options as &$value){
			if(is_string($value) && !is_numeric($value)){
				$value = $this->cleanString($value);
			}elseif(is_array($value)){
				$value = $this->cleanOptions($value);
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
	 * @return string
	 */
	public static function cleanString($s){
		$o = $s;
		$s = strtr(utf8_decode($s),
				utf8_decode(
				'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),
				'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
		for($i = 0; $i < strlen($o); $i++){ // Question marks are replaced by some other character.
			if(substr($o, $i, 1) == '?'){
				$s = substr_replace($s, '?', $i, 1); // Put question mark back
			}
		}
		return preg_replace('/[^ a-z0-9\/\-?:\(\)\.,\'\+]/i', '', $s);
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
		try{
			$iban = self::splitIbanParts(self::cleanIban($iban));
		}catch(Exception $e){
			return false;
		}
		if(!preg_match('/^[A-Z]{2}$/', $iban->country) || !array_key_exists($iban->country, self::$ISO3166)) return false; // Country code should consist of two alphanumeric characters
		if(!preg_match('/^[0-9]{2}$/', $iban->checksum)) return false; // Checksum should consist of two digits
		if(!preg_match('/^[A-Z0-9]+$/', $iban->identifier)) return false; // Identifier should consist of multiple alphanumeric characters and digits
		if(!$iban->checksum == self::calculateIbanChecksum($iban->identifier, $iban->country)) return false; // Invalid checksum
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
		if(substr($iban, 0, 4) == 'IBAN') $iban = substr($iban, 4);
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
		return (string)(98 - intval(bcmod($fullNumber, 97)));
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
		$splitIban->country = substr($iban, 0, 2);
		$splitIban->checksum = substr($iban, 2, 2);
		$splitIban->identifier = substr($iban, 4);
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
	
}