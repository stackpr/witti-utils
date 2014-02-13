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
  static public function getNumericCsv($csv, $positive = FALSE, $decimals = -1) {
    $decimals = (int) $decimals;
    $positive = (bool) $positive;

    // Eliminate spaces around commas.
    $csv = preg_replace('@["\s]*,["\s]*@s', ',', trim($csv));
    $csv = preg_replace('@,,+@', ',', trim($csv, ','));
    if ($csv === '') {
      return $csv;
    }

    // Test for special characters.
    $chars = '0-9\\.';
    if (!$positive) {
      $chars .= '\\-';
    }
    if (preg_match('@[^' . $chars . ']@', $csv)) {
      throw new \InvalidArgumentException("Invalid characters detected.");
    }

    // Test remaining parts of the CSV
    $parts = array();
    foreach (explode(',', $csv) as $part) {
      if (!is_numeric($part)) {
        throw new \InvalidArgumentException("Non-numeric data detected in value list.");
      }
      if ($decimals != -1) {
        $part = round($part, $decimals);
        $parts[] = $part;
      }
    }
    if ($decimals != -1) {
      $csv = join(',', $parts);
    }
    return $csv;
  }

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
      $escapes = strlen($part) - strlen(rtrim($part, '\\'));
      if ($escapes % 2 == 0) {
        throw new \InvalidArgumentException("The regular expression delimiter is not escaped properly.");
      }
    }

    return $regex;
  }
}