<?php
/**
 * @package    SugiPHP
 * @subpackage Encoder
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\Encoder;

interface EncoderInterface
{
	public function encode($data);

	public function decode($data);
}
