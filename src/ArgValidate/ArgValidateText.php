<?php
/*
 * This file is part of the Witti Utils package.
 *
 * (c) Greg Payne
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Witti\Utils\ArgValidate;

class ArgValidateText {
  static public function getRegexPattern($regex, $mode = 'PCRE') {
    if (!is_string($regex) || strlen($regex) < 3) {
      throw new \InvalidArgumentException("Regular expressions must be at least 3 characters long.");
    }

    // Match the modifiers that are supported by PCRE.
    // @link http://us1.php.net/manual/en/reference.pcre.pattern.modifiers.php
    $modifiers = "@^[imsxADSUXu]*$@s";

    // Parse the regex
    $delim = $regex{0};
    $parts = explode($delim, $regex);
    if (sizeof($parts) < 3) {
      throw new \InvalidArgumentException("The regular expression is missing a closing delimiter.");
    }
    if (!preg_match($modifiers, array_pop($parts))) {
      throw new \InvalidArgumentException("The regular expression uses an invalid modifier.");
    }
    // Remove the first (empty) and last (no escape required) parts
    array_pop($parts);
    array_shift($parts);

    foreach ($parts as $part) {
      if (!preg_match('@(?:\\\\)*\\$@s', $part)) {
        throw new \InvalidArgumentException("The regular expression delimiter is not escaped properly.");
      }
    }

    return $regex;
  }
}