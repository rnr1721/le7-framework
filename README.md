# rnr1721/le7-framework

LE7 фреймворк представляет собой легкий минималистичный MVC фреймворк написанный на PHP Требует PHP 8.1 или выше.

## Позволяет:

- Позволяет по умолчанию многоязычность. При этом страница может отображаться на любом языке из настроенных по разным ссылкам
- Использовать шаблонизатор Smarty или чистый PHP "из коробки" или любой другой
- Создавать маршруты Web, REST Api или запускать контроллеры из консоли (например для заданий cron)
- Использовать классы контроллеров в различных Namespace для разных типов маршрутов
- Обновлять ядро при помощи composer
- Использовать встроенные т.н. хэлперы (классы с разным полезным функционалом) или добавлять свои
- В качестве ORM используется RedbeanPHP
- В качестве DI контейнера использует PHP-DI
- Имеет простой диспетчер событий
- Еще всякое разное

## Установка:
Установить le7-framework возможно при помощи composer
В текущий каталог:
```
composer create-project rnr1721/le7-framework .
```
В определенный каталог:
```
composer create-project rnr1721/le7-framework ./myle7framework
```
Данная команда установит фреймворк и необходимые зависимости, такие как ядро и другие библиотеки
//Внутри есть каталог "htdocs" который должен быть в видимости веб-сервера. Вы можете использовать и другой каталог

## Структура каталогов:


- ./Api - здесь хранятся контроллеры для REST API пользователя. В данном каталоге есть подкаталоги, которые возможно называть версиями API - v1, v2 и так далее
- ./Cli - место для хранения контроллеров CLI которые смогут исполняться в консоли или через планировщик CRON
- ./Web - место для хранения контроллеров Web - для обычных HTML страниц
- ./classes - собственно где будут размещаться классы пользователя, модели и другой код вашего приложения.
- ./config - файлы конфигурации, настройки базы данных, пользовательский конфиг и подобное
    * ./config/config.ini - главный конфигурационный файл.
    * ./config/dbconfig.ini - настройки базы данных
    * ./config/user.ini - пользовательский файл конфигурации. Здесь возможно хранить свои параметры 
- ./controllers - здесь хранятся контроллеры, от которых необходимо наследовать свои контроллеры. Вы можете добавлять туда свой функционал, который будет доступен для всех наследующих контроллеров.
- ./custom - Различные классы для кастомизации фреймворка, добавления своих хэлперов, доступных из контроллера объектов с подсказками IDE и подобное.    
    * ./custom/di - здесь хранятся файлы конфигурации PHP-Di. Вы можете добавлять туда свои элементы контейнера и извлекать их. Это любые файлы *Deps.php - в данном каталоге уже лежит пустой файл для примера.
    * ./custom/libraries - здесь также лежат файлы, в которых возможно расширить своими методами стандартные библиотеки фреймворка - Environment, UserHelpersLibrary и UserGlobalLibrary - то есть добавить свои хэлперы и элементы
    * ./custom/smarty_plugins - сюда возможно положить свои плагины Smarty
    * ./custom/routes.php - здесь хранятся группы маршрутов. Каждая группа может иметь свой неймспейс для хранения контроллеров.
- ./locales - здесь хранятся файлы .po и .mo для gettext.
- ./Themes - место для хранения шаблонов Smarty или шаблонов на чистом PHP
- ./uploads - место для загруженных файлов с непубличным доступом
- ./htdocs - каталог, который должен быть в области видимости веб-сервера. Публичные файлы
    * ./htdocs/libs - место куда возможно положить свои библиотеки - bootstrap, jquery, vuejs, fontawesome и подобное
    * ./htdocs/themes - место для тем. Один каталог - одна тема. Текущая тема устанавливается в файле ./config/config.ini и должна совпадать с именем каталога.
    * ./htdocs/themes/{theme}/templates - здесь находятся шаблоны .tpl для Smarty или .phtml для чистого PHP
- ./var - каталог для хранения сессий, кэша, кэша Smarty, кэша маршрутов, временных файлов, логов и т.д.
- ./vendor - каталог для библиотек и зависимостей composer.

## Языки

Данный фреймворк многоязычен "из коробки", и список доступных языков доступен в файле конфигурации:

```
[locales]
defaultLanguage = "en"
locales[ru] = "ru_RU|Русский"
locales[en] = "en_US|English"
locales[es] = "es-ES|Español"
```
Здесь пользователь может добавить свои языки и названия локалей с которыми они связаны, а также указать язык по умолчанию.
В данном примере язык по умолчанию английский, а в системе доступны три языка. Кроме локали важно через символ | указывать человекочитаемое название языка.

## Маршрутизация

Фреймворк может принимать URL в следующих форматах, в зависимости от того что установлено в файле конфигурации:
```
Многоязычный вариант:
https://site.com/{language}/{controller}/{action}/другие_параметры_url
Одноязычные варианты:
https://site.com/{controller}/{action}/другие_параметры_url
https://site.com/{action}/другие_параметры_url
```
Соответственно, в файле конфигурации за это отвечают следующие параметры:
```
; Web routing rules. Default is {language}/{controller}/{action}
; but possible is {controller}/{action} or {action}
; in multilanguage mode please leave default value
webRouting = "{language}/{controller}/{action}"
apiRouting = "{controller}/{action}"
```
Для маршрутов API и WEB они настраиваются по отдельности. Следует заметить, что в случае с маршрутами API язык может устанавливаться не только в URL но и при помощи заголовка в запросе Content-Language. Например:
```
Content-Language: ru;
```
Важное уточнение: в случае шаблона URL {language}/{controller}/{action} при переходе на главную страницу на языке по умолчанию (например https://site.com/ru если язык по умолчанию русский) выдаст ошибку 404, но если указать другой язык, из разрешенных в файле конфигурации (например https://site.com/en) страница отобразится. Это сделано для того, чтобы не было дублей страниц.

Для настройки маршрутов возможно использовать файл ./Custom/routes.php. Ниже приведет стандартный вид этого файла:

```php
return array(
    'admin' => [
        'key' => 'admin',
        'type' => 'web',
        'address' => 'admin',
        'namespace' => 'le7\Web\Admin',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ],
    'apiv1' => [
        'key' => 'apiv1',
        'type' => 'api',
        'address' => 'api/v1',
        'namespace' => 'le7\Api\v1',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ]
);
```
Также есть системный маршрут, который указан в самом ядре и менять его не следует:
```php
return array(
    'web' => [
        'key' => 'web',
        'type' => 'web',
        'address' => '',
        'namespace' => 'le7\Web',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ],
);
```
Параметры следующие:

- key - уникальный ключ маршрута
- type - тип маршрута. Доступно два - api и web
- address - адрес маршрута. Например admin для https://site.com/admin/ru
- namespace - Namespace, в котором будет произведет поиск класса контроллера и метода экшн
- paramCount - количество допустимых параметров адреса https://site.com/admin/ru/param1/param2/param3
- namespaceSystem namespace, в котором фреймворк будет искать контроллер, если он не был найден в основном namespace. Если не указан, будет поиск в системном namespace контроллеров, которые находятся в ядре и их всего два - IndexController и NotfoundController

## Контроллеры
Мы можем создавать свои контроллеры, чтобы были доступны новые странице на сайте. Например, возможно создать в каталоге ./ControllerWeb класс с именем TestController.php и следующим содержимым:

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWebSmarty;

class TestController extends ControllerWebSmarty {
    
    public function indexAction() {
        echo 'test page';
    }
    
}

```

Если всё сделано правильно, то при переходе по адресу https://site.com/ru/test (в данном случае указан русский) появится содержимое "страницы":
```
test page
```
Также мы можем захотеть использовать не Smarty а обычную шаблонизацию PHP. Тогда необходим немного другой класс контроллера:

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWebPhp;

class TestController extends ControllerWebPhp {
    
    public function indexAction() {
        echo 'test page';
    }
    
}

```

Обратите внимание, что если не ввести имя экшн, то будет по умолчанию искать метод с именем indexAction. То же самое с контроллером - если не указать в URL контроллер то будет искать контроллер IndexController.php

Теперь, например, необходимо воспользоваться шаблонизатором Smarty. Необходимо чтобы по адресу https://site.com/en/test/test выводилось сообщение "Hello World!"

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWebSmarty;

class TestController extends ControllerWebSmarty {
    
    public function indexAction() {
        echo 'test page';
    }

    public function testAction() {
        $this->assign('myGreatVar','Hello World');
        $this->render('mytemplate.tpl');
    }
    
}

```
Также, чтобы это работало, необходимо создать шаблон Smarty ./htdocs/themes/main/mytemplate.tpl имеющий следующее содержимое:
```
Первое сообщение {$myGreatVar}
```
Теперь, если перейдем по адресу https://site.com/ru/test/test то увидим следующее сообщение:
```
Первое сообщение Hello World!
```

А теперь попробуем принять какие-то параметры из URL в контроллере по адресу https://site.ru/ru/product
С параметрами это будет выглядеть примерно так: https://site.ru/ru/product/5, то есть мы хотим открыть страницу товара с ID 5
Данный контроллер должен быть расположен в файле ./ControllerWeb/ProductController.php

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWebSmarty;

class ProductController extends ControllerWebSmarty {
    
    #[Params(wlp:1)]
    public function indexAction($params) {
        print_r($params);
        echo 'Товар с ID ' . $params['p3'];
    }
    
}
```
В данном случае при помощи #[Params(wlp:1)] и передачи аргумента $params в метод мы сделали доступным один параметр и можем его вывести. Результат работы данного контроллера (если перейти на https://site.ru/ru/product/id555) будет следующим:

```
Array
(
    [p3] => id555
)
Товар с ID id555
```

Конечто же, мы можем сделать доступными и более одного параметра. Но их не должно быть сильно много, это может быть ограничено маршрутом.

Если же мы собираемся делать AJAX запрос, то экшн (метод класса контроллера) необходимо называть не productAction а productAjax. Когда фреймворк определяет что используется xmlhttprequest, он ищет метод с суффиксом Ajax.

Естественно, есть возможность принимать GET и POST запросы. Например хотим принять параметр из GET запроса http://site.ru/ru/product?id=334

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class ProductController extends ControllerWeb {
    
    public function indexAction() {
        echo 'параметр ' . $this->request->wg('id','');
    }
    
}
```
Результат будет следующим:
```
параметр 334
```
Второй аргумент функции wg - значение, которое вернет, если параметр не передан.

Таким же образом мы можем принимать и POST параметры:

```php
echo 'параметр ' . $this->request->wp('id',null);

```

В случае с использованием контроллеров API ситуация похожая, но стоит обращать внимание, какой формат URL используется в настройках.
По умолчанию настройка URL для методов API имеет следующий формат:
Единственное отличие в том, что методы (экшн) класса называются не indexAction, productAction, testAction и т.д. а indexGetAction, indexPostAction, indexPutAction и т.д. в зависимости от метода, который используем при вызове.

Например создадим класс ProductController.php в каталоге ./Api/v2 имеющий следующее содержимое:

```php
<?php

namespace le7\Api\v1;

use le7\controllers\ControllerApi;

class ProductController extends ControllerApi {

    #[Params(wlp:1)]
    public function indexGetAction($params) {
        $result = array(
            'response' => 'Тестовый вызов GET метода API https://site.ru/api/v1/product/555',
            'params' => $params
        );
        $this->response->inJSON($result, 200);
    }
    
}
```
После перехода по https://site.ru/api/v1/product/555 получим ответ с кодом 200 и следующим телом:
```json
{
	"response" : "\u0422\u0435\u0441\u0442\u043e\u0432\u044b\u0439 \u0432\u044b\u0437\u043e\u0432 GET \u043c\u0435\u0442\u043e\u0434\u0430 API https:\/\/site.ru\/api\/v1\/product\/555",
	"params" : {
		"p2" : "555"
		},
	"response_code":200,
	"rtime":"0.0033 sec."
}
```
Здесь мы тоже можем принимать параметры GET и POST/PUT/DELETE:
```php
echo 'параметр ' . $this->request->wg('id',null);
echo 'параметр ' . $this->request->wp('name','Василий'); //Вернет "Василий" если параметр не передан
```
## Хэлперы

Во фреймворк встроено несколько классов с полезными функциями, которые называются "хэлперы". Пользователь может как использовать встроенные хэлперы, так и добавлять свои, и извлекать их в коде, используя подсказки IDE. Но, конечно, никто не мешает использовать свои классы при помощи контейнера PHP-DI.
Например попробуем использовать хэлпер validator в контроллере ./ControllerWeb/TestController.php по адресу https://site.com/en/test:
```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class TestController extends ControllerWeb {
    
    public function indexAction() {
        $validator = $this->helpers->getValidator();
        $validator->setFullRule('age', 60,'email','My age','min:30|max:50');
        if ($validator->validate()) {
            echo 'Yesss!!!';
        } else {
            print_r($validator->getMessages());
        }
    }
    
}
```
Здесь происходит проверка на корректность email. Но email некорректный, потому мы получаем ошибки:
```
Array
(
    [0] => My email: not correct email:admingoogle.com
)
```
Теперь попробуем провести валидацию числа по правилам (не меньше 30 и не больше 50)

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class TestController extends ControllerWeb {
    
    public function indexAction() {
        $validator = $this->helpers->getValidator();
        $validator->setFullRule('age', 10,'min:30,max:50','Age');
        if ($validator->validate()) {
            echo 'Yesss!!!';
        } else {
            print_r($validator->getMessages());
        }
    }
    
}
```
И снова получаем ошибку:
```
Array
(
    [0] => Age: minimal value is 30
)

```

А теперь попробуем добавить какой-нибудь свой хэлпер. Для этого отредактируем ./custom/libraries/UserHelpersLibrary.php.
По умолчанию он выглядит так:

```php
<?php

namespace le7\custom\libraries;

use le7\Core\ClassLibraries\LibraryHelpers;

class UserHelpersLibrary extends LibraryHelpers {
    
}
```
Добавим в него наш метод calculate, который будет например, складывать два числовых аргумента:
```php
<?php

namespace le7\custom\libraries;

use le7\Core\ClassLibraries\LibraryHelpers;

class UserHelpersLibrary extends LibraryHelpers {
    
    public function getCalculateHelper(int $arg1,int $arg2) : int {
        return $arg1 + $arg2;
    }
    
}
```
Теперь мы можем его вызвать в любом контроллере или модели, используя подсказки IDE:
```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class TestController extends ControllerWeb {
    
    public function indexAction() {
        echo $this->helpers->getCalculateHelper(2, 2);
    }
    
}
```

То есть всё что мы туда добавим, мы получим при помощи подсказок IDE, что может быть удобно в работе.

## Контейнеры

Но того же эффекта мы можем добиться используя контейнеры. Давайте попробуем вызвать метод валидатора при помощи контейнера PHP-DI:

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class TestController extends ControllerWeb {
    
    public function indexAction() {
        $validator = $this->env->getContainer()->get('helper.validator');
        
        // Делаем что то с валидатором
        
    }
    
}
```
Также, мы можем положить что-то в контейнер а потом извлечь, не создавая новый экземпляр.

Посмотрим как выглядит файл ./custom/di/UserDeps.php:

```php
<?php

use Psr\Container\ContainerInterface;
use function DI\factory;

return array(
    
);
```

Добавим что-нибудь в контейнер(Предполагаю, что есть класс MyClass который требует в конструкторе Validator):

```php 
<?php

use le7\classes\MyClass;
use Psr\Container\ContainerInterface;
use function DI\factory;

return array(
    'user.myclass' => factory(function ($c) {
        return new MyClass($c->get('helper.validator'));
    })
);
```
Теперь мы в любом месте кода можем извлечь объект и использовать его:

```php
<?php

namespace le7\Web;

use le7\controllers\ControllerWeb;

class TestController extends ControllerWeb {
    
    public function indexAction() {
        $userClass = $this->env->getContainer()->get('user.myclass');
        
        // Делаем что то с классом
        
    }
    
}
