<?php
/**
 * @package    SugiPHP
 * @subpackage Encoder
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Encoder;

class HexEncoder implements EncoderInterface
{
	public function encode($data)
	{
		return strtoupper(bin2hex($data));
	}

	public function decode($data)
	{
		$data = preg_replace("~[^0-9a-f]~i", "", $data);

		return hex2bin($data);
	}
}
