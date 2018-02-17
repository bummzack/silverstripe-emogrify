<?php

namespace Bummzack\SilverStripeEmogrify;

use Pelago\Emogrifier;
use SilverStripe\Assets\File;
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
     * Can be set via config YAML.
     *
     * @config
     * @var string
     */
    private static $css_file = null;

    /**
     * EmogrifierPlugin constructor.
     * @param Emogrifier|null $emogrifier
     */
    public function __construct(Emogrifier $emogrifier = null)
    {
        parent::__construct($emogrifier);

        if ($file = $this->config()->css_file) {
            $this->loadCssFromFile($file);
        }
    }

    /**
     * Load CSS styles from file and apply them to the current emogrifier instance.
     * _Attention:_ loaded styles will be lost if the emogrifier instance is set to a different one!
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

        $this->getEmogrifier()->setCss(file_get_contents($path));

        return $this;
    }
}
