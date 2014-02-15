<?php
namespace Witti\Utils\ArgValidate\Tests;
use Witti\Utils\ArgValidate;
class GetNumericCsvTest extends \PHPUnit_Framework_TestCase {
  public function getValidCsv() {
    return array(
      array(
        "1,2,3,4",
        TRUE,
        1,
        "1,2,3,4",
      ),
      array(
        "1, 2, 3 , 4",
        TRUE,
        1,
        "1,2,3,4",
      ),
    );
  }

  public function getInvalidCsv() {
    return array(
      array(
        "-1",
        TRUE,
        1
      ),
    );
  }

  /**
   * @expectedException InvalidArgumentException
   * @dataProvider getInvalidCsv
   */
  public function testInvalidCsv($csv, $positive, $decimals) {
    ArgValidate::getNumericCsv($csv, $positive, $decimals);
  }

  /**
   * @dataProvider getValidCsv
   */
  public function testValidCsv($csv, $positive, $decimals, $new_csv) {
    $test = ArgValidate::getNumericCsv($csv, $positive, $decimals);
    $this->assertEquals($new_csv, $test);
  }
}