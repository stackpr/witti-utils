<?php
/*
 * This file is part of the Witti Utils package.
 *
 * (c) Greg Payne
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Witti\Utils\ArgValidate\Tests;
use Witti\Utils\ArgValidate;
class GetNumericCsvTest extends \PHPUnit_Framework_TestCase {
  public function getValidCsv() {
    return array(
      array(
        "1,2,3,4",
        TRUE,
        0,
        TRUE,
        "1,2,3,4",
      ),
      array(
        "1.1,1.9,3.13444,4.0",
        TRUE,
        0,
        TRUE,
        "1,2,3,4",
      ),
      array(
        "1, 2, 3 ,\t4",
        TRUE,
        0,
        TRUE,
        "1,2,3,4",
      ),
    );
  }

  public function getInvalidCsv() {
    return array(
      array(
        "-1",
        TRUE,
        0,
        TRUE,
      ),
      array(
        "1.1",
        TRUE,
        0,
        FALSE,
      ),
      array(
        "1 2",
        TRUE,
        0,
        FALSE,
      ),
    );
  }

  /**
   * @expectedException InvalidArgumentException
   * @dataProvider getInvalidCsv
   */
  public function testInvalidCsv($csv, $positive, $decimals, $autocorrect) {
    ArgValidate::getNumericCsv($csv, $positive, $decimals, $autocorrect);
  }

  /**
   * @dataProvider getValidCsv
   */
  public function testValidCsv($csv, $positive, $decimals, $autocorrect, $new_csv) {
    $test = ArgValidate::getNumericCsv($csv, $positive, $decimals, $autocorrect);
    $this->assertEquals($new_csv, $test);
  }
}