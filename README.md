<h1>Установка и запуск Laravel-проекта с использованием XAMPP</h1>

<ol>
  <li>
    <strong>Убедитесь, что XAMPP запущен:</strong><br>
    Запустите <code>Apache</code> и <code>MySQL</code> в панели управления XAMPP.
  </li>

  <li>
    <strong>Клонируйте репозиторий в папку XAMPP: C:/xampp/htdocs</strong><br>
    <code>git clone https://github.com/muver1337/library-junior-api.git</code>
  </li>

  <li>
    <strong>С помощью вашей IDE перейдите в директорию проекта: php-test-project</strong><br>
  </li>

  <li>
    <strong>Установите зависимости Composer:</strong><br>
    <code>composer install</code>
  </li>

  <li>
    <strong>Создайте <code>.env</code> файл:</strong><br>
    <code>cp .env.example .env</code>
  </li>

  <li>
    <strong>Сгенерируйте ключ приложения:</strong><br>
    <code>php artisan key:generate</code>
  </li>

  <li>
    <strong>Создайте базу данных в phpMyAdmin:</strong><br>
    Откройте <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a> и создайте новую БД (например, <code>laravel_app</code>).
  </li>

  <li>
    <strong>Настройте подключение к БД в файле <code>.env</code>:</strong><br>
    <pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_app
DB_USERNAME=root
DB_PASSWORD=
    </pre>
  </li>

  <li>
    <strong>Выполните миграции и заполните БД сидерами </strong><br>
    <code>php artisan migrate:fresh --seed</code>
  </li>

  <li>
    Затем проверьте работу серверной части в Postman.
  </li>

  <li>
      <a href="https://www.postman.com/interstellar-eclipse-410947/workspace/library/collection/26700924-292505a5-06a3-40c8-aab9-d76b96df7676?action=share&creator=26700924"> Ссылка на коллекцию Postman
  </li>
          
  <li>
      По всем вопросам обращаться в telegram: @mvr_back или в чате hh.ru
  </li>
</ol>
