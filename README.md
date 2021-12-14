# BitArray

## What is this BitArray thing for?

BitArray is a pseudo data structure intended to store option sets
in a more efficient manner than "normal", such as a many-to-one 
relationship in a database (multiple rows), or as an imploded, serialized, 
etc. data strings

By manipulating and storing options sets as an array of bits, it's possible
to reduce storage space on option heavy datasets, and perform bitwise operations
when seeking and setting data, which should increase performance.

## What do you mean by "option sets"?

Option sets in this case refers to attributes that can be set for a given 
object. As an example, let's take a look at a configuration use case.

Normally, you might have a table called `config` which has any number of flags
which can be set to indicate that the configuration is "on" or "off".

| id | config_value     | enabled |
|----|------------------|---------|
| 1  | maintenance_mode | 0       |
| 2  | use_cache        | 1       |
| 3  | debug_mode       | 1       |

Using the BitArray data structure, we can instead represent this data in the following manner.

1. We can parse the **set** configuration options into a BitArray:
```php
$bitArray = new BitArray();
$bitArray->parse([2, 3]);
```
2. Once parsed, we can get a binary or integer representation of the enabled 
configuration values.

```php
$int = $bitArray->int(); // int(6)
$bin = $bitArray->binary(); // 011 (bits are shifted left)
```
3. We can now, for example, create store all three config values in a single `int` type
field in our DB. Or, in a `binary` type field.

## Should I use BitArray?

It depends. The example above is likely too simple to require the use of this library, and 
would likely be considered an early optimization or over optimization. 

However, one sites where you may persist large option sets for each user, this
data struct may be beneficial.