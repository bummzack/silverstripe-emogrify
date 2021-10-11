<?php

namespace Bummzack\SilverStripeEmogrify\Tests;

use Bummzack\SilverStripeEmogrify\EmogrifierPlugin;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Path;
use SilverStripe\Dev\SapphireTest;

class EmogrifierPluginTest extends SapphireTest
{
    protected $usesDatabase = false;

    public function setUp()
    {
        parent::setUp();

        Config::modify()->remove(EmogrifierPlugin::class, 'css_file');
    }

    public function testLoadCssFromConfig()
    {
        $file = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'EmogrifierPluginTest.css';
        Config::modify()->set(EmogrifierPlugin::class, 'css_file', $file);

        $plugin = new EmogrifierPlugin();
        $this->assertEquals($plugin->getCss(), file_get_contents($file));
    }

    public function testLoadCssFromFile()
    {
        $file = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'EmogrifierPluginTest.css';

        $plugin = new EmogrifierPlugin();
        $plugin->loadCssFromFile($file);
        $this->assertEquals($plugin->getCss(), file_get_contents($file));

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
}
