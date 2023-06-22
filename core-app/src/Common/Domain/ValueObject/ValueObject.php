<?php

namespace Core\Common\Domain\ValueObject;

/**
 * Абстрактный класс для Value Object
 *
 * @see README.md
 * @todo интерфейс
 */
abstract class ValueObject
{
    /**
     * Примитивное значение
     * @var mixed
     */
    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * Возвращает примитивное значение value object.
     * Можно использовать для сериализации и десериализации.
     *
     * @return mixed
     */
    public function valueOf() : mixed
    {
        return $this->value;
    }

    /**
     * Сравнивает 2 экземпляра value object
     * по значению примитива
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other) : bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return "{getClassName()}[value={$this->value}]";
    }

}
