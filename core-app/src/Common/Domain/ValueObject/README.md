### Value Object
Value Object (значимый объект) - это объект, который представляет некоторое значение или концепцию
и не имеет собственной идентичности. Он определяется только через свои атрибуты или свойства
и неизменяемый в своей природе.

Value Object определяется только через свои атрибуты или свойства,
и его идентичность определяется содержимым этих атрибутов.
Два объекта Value Object с одинаковыми значениями считаются эквивалентными.

Неизменность в контексте агрегата: Внутри агрегата (концепция в DDD) Value Object также должен быть неизменным.
Любые изменения значения Value Object в контексте агрегата должны быть выполнены путем создания нового объекта Value Object.

Для чего они нужны:
1. Отражение концепций предметной области: Value Object позволяет моделировать 
и представлять важные концепции предметной области в виде объектов.
Они позволяют вам выразить и работать с более высокоуровневыми абстракциями,
которые соответствуют реальным предметам или концепциям в вашей предметной области.

2. Безопасность и инкапсуляция: Value Object обычно являются неизменяемыми объектами,
что означает, что их состояние не может быть изменено после создания.
Это способствует безопасности и предотвращает нежелательные изменения.
Кроме того, Value Object обеспечивает инкапсуляцию данных и логики, позволяя контролировать доступ и изменение своих свойств.

3. Эквивалентность и уникальность: Value Object сравниваются по значениям своих атрибутов,
а не по идентификаторам. Это позволяет сравнивать объекты на основе их содержимого,
что особенно полезно для сравнения и поиска в коллекциях объектов.
Важно отметить, что Value Object могут быть эквивалентными, даже если они не являются одним и тем же объектом.

4. Повторное использование: Value Object могут быть повторно использованы в различных частях приложения и предметных областях,
поскольку они являются автономными и независимыми от контекста. Они могут быть использованы для моделирования и работы с общими концепциями,
такими как дата, время, координаты, валюта и т. д.

5. Упрощение кода и снижение сложности: Использование Value Object позволяет упростить код и снизить сложность приложения.
Они предоставляют ясные и самодостаточные абстракции, которые улучшают понимание и поддержку кода. Кроме того,
Value Object могут быть использованы для описания и передачи параметров методов, что делает код более понятным и читаемым.
