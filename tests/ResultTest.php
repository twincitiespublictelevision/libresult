<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use function Result\err;
use function Result\ok;
use Result\Result;

class ResultTest extends TestCase {
  public function testCreatesOk() {
    $this->assertTrue(Result::ok(23)->isOk());
  }

  public function testCreatesErr() {
    $this->assertTrue(Result::err(new \Exception('32'))->isError());
  }

  public function testChecksOk() {
    $this->assertTrue(Result::ok(23)->isOk());
    $this->assertFalse(Result::err(new \Exception('32'))->isOk());
  }

  public function testChecksErr() {
    $this->assertFalse(Result::ok(23)->isError());
    $this->assertTrue(Result::err(new \Exception('32'))->isError());
  }

  public function testGetsValue() {
    $this->assertEquals(23, Result::ok(23)->value());
  }

  public function testGetValueThrowsIfError() {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('32');
    Result::err(new \Exception('32'))->value();
  }

  public function testGetsError() {
    $err = Result::err(new \Exception('32'))->getErr();
    $this->assertInstanceOf(\Exception::class, $err);
    $this->assertEquals('32', $err->getMessage());
  }

  public function testFallbackOnError() {
    $this->assertEquals(64, Result::err(new \Exception('32'))->valueOr(64));
  }

  public function testOkHelperCreatesOkWithValue() {
    $res = ok(23);
    $this->assertTrue($res->isOk());
    $this->assertEquals(23, $res->value());
  }

  public function testErrHelperCreatesErrorWithError() {
    $res = err(new \Exception('32'));
    $this->assertTrue($res->isError());
    $this->assertInstanceOf(\Exception::class, $res->getErr());
    $this->assertEquals('32', $res->getErr()->getMessage());
  }
}