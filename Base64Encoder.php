<?php
/**
 * @package    SugiPHP
 * @subpackage Encoder
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Encoder;

class Base64Encoder implements EncoderInterface
{
	public function encode($data)
	{
		return base64_encode($data);
	}

	public function decode($data)
	{
		return base64_decode($data);
	}
}
