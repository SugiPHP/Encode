<?php
/**
 * @package    SugiPHP
 * @subpackage Encoder
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Encoder;

class Base32Encoder implements EncoderInterface
{
	protected static $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";

	public function encode($data)
	{
		// stringify
		$data = (string) $data;
		if ($data === "") {
			return "";
		}

		$binary = "";
		foreach (str_split($data) as $char) {
			$binary .= str_pad(decbin(ord($char)), 8, 0, STR_PAD_LEFT);
		}

		$result = "";
		foreach (str_split($binary, 5) as $chunk) {
			$chunk = str_pad($chunk, 5, 0, STR_PAD_RIGHT);
			$result .= static::$alphabet[bindec($chunk)];
		}

		if (strlen($result) % 8) {
			$result .= str_repeat("=", 8 - (strlen($result) % 8));
		}

		return $result;
	}

	public function decode($data)
	{
		// stringify
		$data = (string) $data;
		if ($data === "") {
			return "";
		}
		// using only uppercase letters
		$data = strtoupper($data);
		// removing trailing "="
		$data = rtrim($data, "=");
		// removing everything that is not part of the alphabet
		$alphabet = static::$alphabet;
		$data = preg_replace("~[^{$alphabet}]~", "", $data);

		$binary = "";
		foreach (str_split($data) as $char) {
			$binary .= str_pad(decbin(strpos(static::$alphabet, $char)), 5, 0, STR_PAD_LEFT);
		}
		$binary = substr($binary, 0, (floor(strlen($binary) / 8) * 8));

		$result = "";
		foreach (str_split($binary, 8) as $chunk) {
			$chunk = str_pad($chunk, 8, 0, STR_PAD_RIGHT);
			$result .= chr(bindec($chunk));
		}

		return $result;
	}
}
