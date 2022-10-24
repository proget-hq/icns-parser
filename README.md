# ICNS parser

Library for parsing Apple [ICNS](https://en.wikipedia.org/wiki/Apple_Icon_Image_format) files.

## Install

```
composer require proget-hq/icns-parser
```

## Usage example

The following code will parse icns files, display the formats found inside and extract all readable images to png files.

```
/**
 * composer require intervention/image
 */

require_once('vendor/autoload.php');

use Proget\IcnsParser\IcnsParser;
use Intervention\Image\ImageManager;
use Intervention\Image\Exception\NotReadableException;

$parser = new IcnsParser();
$manager = new ImageManager([/*'driver' => 'imagick'*/]);

$iconFiles = ['AppIcon.icns'];

foreach ($iconFile as $iconFile) {
	echo '# Parsing '.$iconFile.''.PHP_EOL;
	$r = $parser->parse($iconFile);

	$elements = $r->elements();
	echo 'Found '.count($elements).' elements:'.PHP_EOL;

	usort($elements, fn($a, $b) => $a->type() <=> $b->type());
	foreach ($elements as $element) {
		echo ' - '.$element->type().''.PHP_EOL;

		try {
			$img = $manager->make($element->data());
			echo '   read '.$img->mime().' '.$img->width().'x'.$img->width().PHP_EOL;

			$img->save($iconFile.'-'.$element->type().'.png');
			echo '   wrote to '.$iconFile.'-'.$element->type().'.png'.PHP_EOL;
		} catch (NotReadableException $e) {
			echo '   could not read'.PHP_EOL;
		}
	}
}

```

## License

MIT
