<?php
/**
 * @package    SugiPHP
 * @subpackage Encoder
 * @category   tests
 * @author     Plamen Popov <tzappa@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php (MIT License)
 */

use SugiPHP\Encoder\EncoderInterface;
use SugiPHP\Encoder\HexEncoder;
use SugiPHP\Encoder\Base32Encoder;
use SugiPHP\Encoder\Base64Encoder;

class EncoderTest extends PHPUnit_Framework_TestCase
{
	public $strings = array(
		"",
		0,
		true,
		false,
		null,
		"foo",
		"1234567890",
		123456,
		"John is ill!",
		"Иван е болен!",
		"
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed libero gravida, viverra risus eget, dignissim augue. Sed nec egestas ligula. Aenean varius id lacus et imperdiet. Quisque venenatis rhoncus ultricies. In imperdiet tincidunt tortor ac fringilla. Aliquam sed hendrerit erat. Cras a egestas massa. Suspendisse iaculis arcu interdum erat vulputate pulvinar.
Nam pretium at magna hendrerit lobortis. Donec dapibus eu ipsum eu fermentum. Sed eros lacus, consectetur at eleifend non, tristique vitae neque. Etiam a luctus orci. Suspendisse quis sodales sapien. Cras ut augue non turpis suscipit dapibus ut quis erat. In vel aliquam nisi. Proin blandit ante a vulputate facilisis. Vestibulum at dui felis. Nullam dui libero, accumsan vel euismod nec, rutrum vitae urna. Vestibulum vitae erat metus.
		",
	);

	public $strings64 = array(
		// source: http://tools.ietf.org/html/rfc4648#section-10
		"" => "",
		"f" => "Zg==",
		"fo" => "Zm8=",
		"foo" => "Zm9v",
		"foob" => "Zm9vYg==",
		"fooba" => "Zm9vYmE=",
		"foobar" => "Zm9vYmFy",
		// source: http://en.wikipedia.org/wiki/Base64
		"Man is distinguished, not only by his reason, but by this singular passion from other animals, which is a lust of the mind, that by a perseverance of delight in the continued and indefatigable generation of knowledge, exceeds the short vehemence of any carnal pleasure." => "TWFuIGlzIGRpc3Rpbmd1aXNoZWQsIG5vdCBvbmx5IGJ5IGhpcyByZWFzb24sIGJ1dCBieSB0aGlzIHNpbmd1bGFyIHBhc3Npb24gZnJvbSBvdGhlciBhbmltYWxzLCB3aGljaCBpcyBhIGx1c3Qgb2YgdGhlIG1pbmQsIHRoYXQgYnkgYSBwZXJzZXZlcmFuY2Ugb2YgZGVsaWdodCBpbiB0aGUgY29udGludWVkIGFuZCBpbmRlZmF0aWdhYmxlIGdlbmVyYXRpb24gb2Yga25vd2xlZGdlLCBleGNlZWRzIHRoZSBzaG9ydCB2ZWhlbWVuY2Ugb2YgYW55IGNhcm5hbCBwbGVhc3VyZS4=",
	);

	public $strings32 = array(
		// source: http://tools.ietf.org/html/rfc4648#section-10
		"" => "",
		"f" => "MY======",
		"fo" => "MZXQ====",
		"foo" => "MZXW6===",
		"foob" => "MZXW6YQ=",
		"fooba" => "MZXW6YTB",
		"foobar" => "MZXW6YTBOI======",
	);

	public $strings16 = array(
		// source: http://tools.ietf.org/html/rfc4648#section-10
		"" => "",
		"f" => "66",
		"fo" => "666F",
		"foo" => "666F6F",
		"foob" => "666F6F62",
		"fooba" => "666F6F6261",
		"foobar" => "666F6F626172",
	);

	public function testEncodersImplementsEncoderInterface()
	{
		$base16 = new HexEncoder();
		$this->assertTrue($base16 instanceof EncoderInterface);
		$base32 = new Base32Encoder();
		$this->assertTrue($base32 instanceof EncoderInterface);
		$base64 = new Base64Encoder();
		$this->assertTrue($base64 instanceof EncoderInterface);
	}

	public function testHexEncoderEncodeAndDecodeAreSymetric()
	{
		$base16 = new HexEncoder();

		foreach ($this->strings as $data) {
			$this->assertEquals($data, $base16->decode($base16->encode($data)));
		}
	}

	public function testBase64EncoderEncodeAndDecodeAreSymetric()
	{
		$base64 = new Base64Encoder();

		foreach ($this->strings as $data) {
			$this->assertEquals($data, $base64->decode($base64->encode($data)));
		}
	}

	public function testBase32EncoderEncodeAndDecodeAreSymetric()
	{
		$base32 = new Base32Encoder();

		foreach ($this->strings as $data) {
			$this->assertEquals($data, $base32->decode($base32->encode($data)));
		}
	}


	public function testBase64Encode()
	{
		$base64 = new Base64Encoder();

		foreach ($this->strings64 as $decoded => $encoded) {
			$this->assertEquals($encoded, $base64->encode($decoded));
			$this->assertEquals($decoded, $base64->decode($encoded));
		}
	}

	public function testBase32Encode()
	{
		$base32 = new Base32Encoder();

		foreach ($this->strings32 as $decoded => $encoded) {
			$this->assertEquals($encoded, $base32->encode($decoded));
			$this->assertEquals($decoded, $base32->decode($encoded));
		}
	}

	public function testHexEncode()
	{
		$base16 = new HexEncoder();

		foreach ($this->strings16 as $decoded => $encoded) {
			$this->assertEquals($encoded, $base16->encode($decoded));
			$this->assertEquals($decoded, $base16->decode($encoded));
		}
	}

}
