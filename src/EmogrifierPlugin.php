<?php

namespace Bummzack\SilverStripeEmogrify;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Path;

/**
 * A plugin that can be configured by the SilverStripe configuration API.
 * Wraps the emogrifier-plugin.
 *
 * @package Bummzack\SilverStripeEmogrify
 */
class EmogrifierPlugin extends \Bummzack\SwiftMailer\EmogrifyPlugin\EmogrifierPlugin
{
    use Configurable;

    /**
     * The default CSS file that should be used for styling Emails.
     * Can be set via config YAML and overridden individually via `CssFile` prop.
     *
     * @config
     * @var string
     */
    private static $css_file = null;

    /**
     * @var string
     */
    private $cssFile = null;

    public function __construct()
    {
        parent::__construct();

        if ($file = $this->config()->css_file) {
            $this->setCssFile($file);
        }
    }

    /**
     * Get the CSS file path that should be used to style emails
     * @return string
     */
    public function getCssFile()
    {
        return $this->cssFile;
    }

    /**
     * Set the CSS file to use
     * @param string $file the path to the CSS file to load, relative to `BASE_PATH`
     * @return $this
     */
    public function setCssFile($file)
    {
        $path = Path::join(BASE_PATH, $file);
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('CSS file at "' . $path . '" does not exist');
        }

        $this->getEmogrifier()->setCss(file_get_contents($path));

        $this->cssFile = $file;
        return $this;
    }
}
