[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

# Скрипты для интеграции чат-бота Joker с сервисом [API.AI](https://api.ai/)
Структура:
  - [index.php](index.php) - вывод результатов. Возможно использование параметров:
    - `site` - имя сайта, указанное в конфиге в качестве названия блока параметров;
    - `format` - формат вывода результата (по умолчанию - HTML-вид). На данный момент возможны варианты: `html` , `json`;
  - [rss/rss.class.php](rss/rss.class.php) - самописный класс для работы с RSS-лентой;
  - [rss/sites.ini](rss/sites.ini) - конфиг-файл с описанием сайтов, с которыми будет работать скрипт;