<?php

namespace Bummzack\SilverStripeEmogrify;

use Bummzack\SwiftMailer\EmogrifyPlugin\EmogrifierPlugin as SwiftmailerEmogrifierPlugin;
use Pelago\Emogrifier\CssInliner;
use SilverStripe\Assets\File;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Path;

/**
 * A plugin that can be configured by the SilverStripe configuration API.
 * Wraps the emogrifier-plugin.
 *
 * @package Bummzack\SilverStripeEmogrify
 */
class EmogrifierPlugin extends SwiftmailerEmogrifierPlugin
{
    use Configurable;

    /**
     * The default CSS file that should be used for styling Emails.
     * Can be set via config YAML.
     *
     * @config
     * @var string
     */
    private static $css_file = null;

    /**
     * @return string CSS styles
     */
    public function getCSSContent()
    {
        if ($file = $this->config()->css_file) {
            $this->loadCssFromFile($file);
        }

        return parent::getCSSContent();
    }

    /**
     * Load CSS styles from file and apply them to the current emogrifier instance.
     * @param string $file the path to the CSS file to load,
     * if the file path isn't absolute, it's assumed to be relative to `BASE_PATH`
     * @return $this
     */
    public function loadCssFromFile($file)
    {
        if (file_exists($file)) {
            $path = $file;
        } else {
            $path = Path::join(BASE_PATH, $file);
            if (!file_exists($path)) {
                throw new \InvalidArgumentException('File at "' . $path . '" does not exist');
            }
        }

        if (strtolower(File::get_file_extension($path)) !== 'css') {
            throw new \InvalidArgumentException('File "' . $path . '" does not have .css extension.');
        }

        $this->setCSSContent(file_get_contents($path));

        return $this;
    }
}
