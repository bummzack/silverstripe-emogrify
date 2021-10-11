# SilverStripe Emogrify

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bummzack/silverstripe-emogrify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bummzack/silverstripe-emogrify/?branch=master)
[![Code Coverage](https://codecov.io/gh/bummzack/silverstripe-emogrify/branch/master/graph/badge.svg)](https://codecov.io/gh/bummzack/silverstripe-emogrify)
[![Build Status](https://travis-ci.org/bummzack/silverstripe-emogrify.svg?branch=master)](https://travis-ci.org/bummzack/silverstripe-emogrify)
[![Latest Stable Version](https://poser.pugx.org/bummzack/silverstripe-emogrify/v/stable)](https://packagist.org/packages/bummzack/silverstripe-emogrify)

Easily integrate Emogrifier into SilverStripe and send Emails with inlined CSS automatically.

## Installation and Requirements

 - Requires the [EmogrifierPlugin](https://github.com/bummzack/swiftmailer-emogrifyplugin) and its dependencies.
 - SilverStripe 4.9+

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

Please note, that if the path to the CSS file is not absolute, 
it will be considered to be *relative* to the `BASE_PATH`!

