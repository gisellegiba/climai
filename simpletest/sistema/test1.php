<?php
require_once('../unit_tester.php');
require_once('../reporter.php');
require_once('index.php');

class TestOfLogging extends UnitTestCase {
    
    function testCreatingNewFile() {
        @unlink('/temp/index.log');
        $log = new Log('/temp/index.log');
        $this->assertFalse(file_exists('/temp/index.log'));
    }
}
$test = &new TestOfLogging();
$test->run(new HtmlReporter());
?>