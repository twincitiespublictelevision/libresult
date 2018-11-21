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