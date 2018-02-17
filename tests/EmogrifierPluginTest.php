<?php

namespace Bummzack\SilverStripeEmogrify\Tests;

use Bummzack\SilverStripeEmogrify\EmogrifierPlugin;
use Pelago\Emogrifier;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Path;
use SilverStripe\Dev\SapphireTest;

class EmogrifierPluginTest extends SapphireTest
{
    public function setUp()
    {
        parent::setUp();

        Config::modify()->remove(EmogrifierPlugin::class, 'css_file');
    }

    public function testLoadCssFromConfig()
    {
        $file = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'EmogrifierPluginTest.css';
        Config::modify()->set(EmogrifierPlugin::class, 'css_file', $file);

        new EmogrifierPlugin($this->createMockEmogrifier());
    }

    public function testLoadCssFromFile()
    {
        $file = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'EmogrifierPluginTest.css';

        $plugin = new EmogrifierPlugin($this->createMockEmogrifier());
        $plugin->loadCssFromFile($file);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File "' . __FILE__ . '" does not have .css extension.');
        $plugin->loadCssFromFile(__FILE__);
    }

    public function testLoadNonExistantCssFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File at "'. Path::join(BASE_PATH, 'testDummy.css') .'" does not exist');
        $plugin = new EmogrifierPlugin();
        $plugin->loadCssFromFile('testDummy.css');
    }

    /**
     * Create a mock emogrifier instance to ensure the CSS that is being set will match the code from the test file.
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createMockEmogrifier()
    {
        $css = <<<EOT
.test {
  color: green;
}

EOT;

        $emogrifier = $this->getMockBuilder(Emogrifier::class)
            ->disableOriginalConstructor()
            ->getMock();

        $emogrifier->expects($this->once())
            ->method('setCss')
            ->with(
                $this->equalTo($css)
            );

        return $emogrifier;
    }
}
