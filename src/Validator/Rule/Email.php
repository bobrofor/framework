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
namespace Bluz\Validator\Rule;

/**
 * Check for email
 *
 * @package Bluz\Validator\Rule
 */
class Email extends AbstractRule
{
    /**
     * @var string error template
     */
    protected $template = '{{name}} must be a valid email address';

    /**
     * @var bool check DNS record flag
     */
    protected $checkDns;

    /**
     * Setup validation rule
     *
     * @param bool $checkDns
     */
    public function __construct($checkDns = false)
    {
        $this->checkDns = $checkDns;
    }

    /**
     * Check input data
     *
     * @param  mixed $input
     * @return bool
     */
    public function validate($input) : bool
    {
        if (is_string($input) && filter_var($input, FILTER_VALIDATE_EMAIL)) {
            list(, $domain) = explode("@", $input, 2);
            if ($this->checkDns) {
                return checkdnsrr($domain, "MX") || checkdnsrr($domain, "A");
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
