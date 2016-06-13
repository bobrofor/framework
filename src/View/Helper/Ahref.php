<?php
/**
 * Bluz Framework Component
 *
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\View\Helper;

use Bluz\View\View;
use Bluz\Proxy\Request;
use Bluz\Proxy\Translator;

return
    /**
     * Generate HTML for <a> element
     *
     * @author ErgallM
     *
     * @var    View         $this
     * @param  string       $text
     * @param  string|array $href
     * @param  array        $attributes HTML attributes
     * @return string
     */
    function ($text, $href, array $attributes = []) {
        // if href is settings for url helper
        if (is_array($href)) {
            $href = $this->url(...$href);
        }

        // href can be null, if access is denied
        if (null === $href) {
            return '';
        }

        $current = Request::getUri()->getPath();

        if (Request::getUri()->getQuery()) {
            $current .= sprintf('?%s', Request::getUri()->getQuery());
        }

        if ($href == $current) {
            if (isset($attributes['class'])) {
                $attributes['class'] .= ' active';
            } else {
                $attributes['class'] = 'active';
            }
        }

        $attributes = $this->attributes($attributes);

        return '<a href="' . $href . '" ' . $attributes . '>' . Translator::translate($text) . '</a>';
    };
