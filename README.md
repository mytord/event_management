Управление событиями
================

Объект для учета событий - `App\EventManager`

Основной принцип
---------------

В целях повышения отказоустойчивости при большом количестве чтений и записей применена следующая модель:

- Регистрация новых событий осуществляется асинхронно, через очередь, например `RabbitMQ` или `Gaerman`. Конкретная реализация должна реализовать интерфейс `App\EventRegistryInterface`, а так же использовать `App\EventRegistry\Handler\CreateEventHandler::handle()` в качестве callback.
- Счетчики количества событий размещены в NoSQL-хранилище. Конкретная реализация хранилища должна реализовать интерфейс `App\Cache\CacheStorageInterface`. В случаи когда данные не доступны из хранилища - используем прямые данные из БД (поиск по индексу created_at).

Абстракция слоя, отвечающего за запросы к БД - `App\Repository\EventRepositoryInterface`