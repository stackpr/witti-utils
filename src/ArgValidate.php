<?php
/*
 * This file is part of the Witti Utils package.
 *
 * (c) Greg Payne
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Witti\Utils;

class ArgValidate {
  static public function getNumericCsv($csv, $positive = FALSE, $decimals = -1, $autocorrect = TRUE) {
    return \Witti\Utils\ArgValidate\ArgValidateText::getNumericCsv($csv, $positive, $decimals, $autocorrect);
  }

  static public function getRegexPattern($regex, $mode = 'PCRE') {
    return \Witti\Utils\ArgValidate\ArgValidateText::getRegexPattern($regex, $mode);
  }

}
