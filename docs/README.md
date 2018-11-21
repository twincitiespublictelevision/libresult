# libresult

## Table of Contents

* [Result](#result)
    * [ok](#ok)
    * [err](#err)
    * [isError](#iserror)
    * [isOk](#isok)
    * [value](#value)
    * [getErr](#geterr)
    * [valueOr](#valueor)

## Result

Class Result

A successful or failure to perform some operation. Used as an alternative
to raising exceptions when needing to propagate errors.

* Full name: \Result\Result


### ok

Constructs a successful result of some type T.

```php
Result::ok( mixed $value ): \Result\Result
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** | The success value |




---

### err

Constructs a failure result of some error type E. To construct a failure
an exception must be supplied.

```php
Result::err( \Exception $err ): \Result\Result
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$err` | **\Exception** | The failure error |




---

### isError

Returns true if the result is a failure

```php
Result::isError(  ): boolean
```







---

### isOk

Returns true if the result is a success

```php
Result::isOk(  ): boolean
```







---

### value

Attempts to extract and return the success value.

```php
Result::value(  ): mixed
```

If the result was a success then the value is returned. If the result was
a failure then calling this method will throw the exception that is stored.

```php
$resultA = Result::ok("foo");
echo $resultA->value(); // foo

$resultB = Result::err(new \Exception("Bar error");
echo $resultB->value(); // PHP Fatal error:  Uncaught exception ...
```

To safely handle a result and extract its value the caller can use either
conditionals or try / catch syntax

```php
$resultA = Result::ok("foo");

if ($resultA->isOk()) {
  echo $result->value(); // foo
} else {
  // ...
}

$resultB = Result::err(new \Exception("Bar error");

try {
  echo $resultB->value();
} catch (\Exception $e) {
  echo $e->getMessage(); // Bar error
}
```





---

### getErr

Returns the inner error of a failure. This returns null if the result is
a success.

```php
Result::getErr(  ): \Exception|null
```







---

### valueOr

Returns the success value if the result was a success. If the result was a
failure, then instead of throwing the inner error the fallback value is
returned.

```php
Result::valueOr( mixed $fallback ): mixed
```

```php
$resultA = Result::ok("alpha");
echo $resultA->valueOr("beta"); // alpha

$resultB = Result::err(new \Exception("delta error");
echo $resultB->valueOr("gamma"); // gamma
```


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fallback` | **mixed** |  |




---



--------
> This document was automatically generated from source code comments on 2018-11-21 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
