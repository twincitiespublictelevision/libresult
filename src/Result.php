<?php

namespace Result;

/**
 * @param $value
 * @return Result
 */
function ok($value): Result {
  return Result::ok($value);
}

/**
 * @param \Exception $e
 * @return Result
 */
function err(\Exception $e): Result {
  return Result::err($e);
}

/**
 * Class Result
 *
 * A successful or failure to perform some operation. Used as an alternative
 * to raising exceptions when needing to propagate errors.
 *
 * @package Result
 */
class Result {

  /**
   * @var mixed|null
   */
  protected $_value;

  /**
   * @var \Exception|null
   */
  protected $_e;

  /**
   * Result constructor.
   * @param mixed|null $value
   * @param \Exception|null $e
   */
  private function __construct($value = null, \Exception $e = null) {
    $this->_value = $value;
    $this->_e = $e;
  }

  /**
   * Constructs a successful result of some type T.
   *
   * @param mixed $value The success value
   * @return Result
   */
  public static function ok($value): Result {
    return new Result($value, null);
  }

  /**
   * Constructs a failure result of some error type E. To construct a failure
   * an exception must be supplied.
   *
   * @param \Exception $err The failure error
   * @return Result
   */
  public static function err(\Exception $err): Result {
    return new Result(null, $err);
  }

  /**
   * Returns true if the result is a failure
   *
   * @return bool
   */
  public function isError(): bool {
    return $this->_e !== null;
  }

  /**
   * Returns true if the result is a success
   *
   * @return bool
   */
  public function isOk(): bool {
    return !$this->isError();
  }

  /**
   * Attempts to extract and return the success value.
   *
   * If the result was a success then the value is returned. If the result was
   * a failure then calling this method will throw the exception that is stored.
   *
   * ```php
   * $resultA = Result::ok("foo");
   * echo $resultA->value(); // foo
   *
   * $resultB = Result::err(new \Exception("Bar error");
   * echo $resultB->value(); // PHP Fatal error:  Uncaught exception ...
   * ```
   *
   * To safely handle a result and extract its value the caller can use either
   * conditionals or try / catch syntax
   *
   * ```php
   * $resultA = Result::ok("foo");
   *
   * if ($resultA->isOk()) {
   *   echo $result->value(); // foo
   * } else {
   *   // ...
   * }
   *
   * $resultB = Result::err(new \Exception("Bar error");
   *
   * try {
   *   echo $resultB->value();
   * } catch (\Exception $e) {
   *   echo $e->getMessage(); // Bar error
   * }
   * ```
   *
   * @return mixed
   * @throws \Exception
   */
  public function value() {
    if ($this->isError()) {
      throw $this->_e;
    }

    return $this->_value;
  }

  /**
   * Returns the inner error of a failure. This returns null if the result is
   * a success.
   *
   * @return \Exception|null
   */
  public function getErr() {
    return $this->_e;
  }

  /**
   * Returns the success value if the result was a success. If the result was a
   * failure, then instead of throwing the inner error the fallback value is
   * returned.
   *
   * ```php
   * $resultA = Result::ok("alpha");
   * echo $resultA->valueOr("beta"); // alpha
   *
   * $resultB = Result::err(new \Exception("delta error");
   * echo $resultB->valueOr("gamma"); // gamma
   * ```
   *
   * @param mixed $fallback
   * @return mixed
   */
  public function valueOr($fallback) {
    if ($this->isError()) {
      return $fallback;
    }

    return $this->_value;
  }
}