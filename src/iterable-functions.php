<?php

declare(strict_types=1);

namespace BenTools\IterableFunctions;

use ArrayIterator;
use EmptyIterator;
use Traversable;

use function array_values;
use function is_array;
use function iterator_to_array;

/**
 * Maps a callable to an iterable.
 *
 * @param iterable<mixed> $iterable
 *
 * @return iterable<mixed>
 */
function iterable_map(iterable $iterable, callable $map): iterable
{
    $mapped = iterable($iterable)->map($map);

    return is_array($iterable) ? $mapped->asArray() : $mapped;
}

/**
 * Copy the iterable into an array.
 *
 * @param iterable<array-key, TValue> $iterable
 * @param bool $preserveKeys [optional] Whether to use the iterator element keys as index.
 *
 * @return array<array-key, TValue>
 *
 * @psalm-return ($preserveKeys is true ? array<TKey, TValue> : array<int, TValue>)
 * @psalm-template TKey as array-key
 * @phpstan-template TKey
 * @template TValue
 */
function iterable_to_array(iterable $iterable, bool $preserveKeys = true): array
{
    if ($iterable instanceof Traversable) {
        return iterator_to_array($iterable, $preserveKeys);
    }

    return $preserveKeys ? $iterable : array_values($iterable);
}

/**
 * If the iterable is not instance of Traversable, it is an array => convert it to an ArrayIterator.
 *
 * @param iterable<TKey, TValue> $iterable
 *
 * @return Traversable<TKey, TValue>
 *
 * @template TKey
 * @template TValue
 */
function iterable_to_traversable(iterable $iterable): Traversable
{
    if ($iterable instanceof Traversable) {
        return $iterable;
    }

    return new ArrayIterator($iterable);
}

/**
 * Filters an iterable.
 *
 * @param iterable<mixed> $iterable
 *
 * @return iterable<mixed>
 */
function iterable_filter(iterable $iterable, ?callable $filter = null): iterable
{
    $filtered = iterable($iterable)->filter($filter);

    return is_array($iterable) ? $filtered->asArray() : $filtered;
}

/**
 * Reduces an iterable.
 *
 * @param iterable<TValue> $iterable
 * @param callable(TResult|null, TValue):TResult $reduce
 * @param TResult|null $initial
 *
 * @return TResult|null
 *
 * @template TValue
 * @template TResult
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
 */
function iterable_reduce(iterable $iterable, callable $reduce, $initial = null)
{
    foreach ($iterable as $item) {
        $initial = $reduce($initial, $item);
    }

    return $initial;
}

/**
 * @param iterable<mixed> $iterable
 */
function iterable(?iterable $iterable): IterableObject
{
    return new IterableObject($iterable ?? new EmptyIterator());
}
