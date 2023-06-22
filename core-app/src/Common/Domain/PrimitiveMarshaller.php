<?php

namespace Core\Common\Domain;
/**
 * Интерфейс, который определяет методы для создания классов из массивов и сериализации классов в массивы в PHP.
 * Он предоставляет общий контракт для маршалинга (преобразования) простых типов данных в объекты и обратно.
 */
interface PrimitiveMarshaller
{
    /**
     * Создает экземпляр класса на основе массива данных.
     *
     * @param array $data Массив данных для создания класса.
     * @return object Созданный экземпляр класса.
     */
    public static function fromArray(array $data): object;

    /**
     * Сериализует экземпляр класса в массив данных.
     *
     * @param object $object Экземпляр класса для сериализации.
     * @return array Массив данных, представляющий сериализованный класс.
     */
    public function toArray(object $object): array;
}
