# SilverStripe Emogrify

_Work in Progress_

Easily integrate Emogrifier into SilverStripe and send Emails with inlined CSS automatically.

## Installation and Requirements

 - Requires the [EmogrifierPlugin](https://github.com/bummzack/swiftmailer-emogrifyplugin) and its dependencies.
 - SilverStripe 4.1+

Install via composer:

    composer require bummzack/silverstripe-emogrify
    
## Usage

The module will already register the `EmogrifierPlugin` as a plugin on SwiftMailer. By default it will only pick up 
styles that are part of your HTML (eg. in a `<style>` tag).

To supply your own CSS file, add something like this to your `config.yml`:

```yml
Bummzack\SilverStripeEmogrify\EmogrifierPlugin:
  css_file: 'mysite/css/email.css'
```

Please note, that the path to the CSS file should be *relative* to the `BASE_PATH`!

