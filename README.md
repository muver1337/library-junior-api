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
    <strong>С помощью вашей IDE перейдите в директорию проекта: library-junior-api</strong><br>
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
  <strong>Выполните миграции и заполните БД сидерами:</strong><br>
  <code>php artisan migrate:fresh --seed</code><br>
  После выполнения этой команды в базу будут добавлены тестовые пользователи:<br>
  <ul>
    <li><strong>Автор:</strong> email: <code>author@gmail.com</code>, пароль: <code>author</code></li>
    <li><strong>Админ:</strong> email: <code>admin@gmail.com</code>, пароль: <code>admin</code></li>
  </ul>
</li>
  <li>Проверьте работу API в Postman:
    <a href="https://www.postman.com/interstellar-eclipse-410947/workspace/library/collection/26700924-292505a5-06a3-40c8-aab9-d76b96df7676?action=share&creator=26700924">Коллекция Postman</a>
  </li>
</ol>

<hr>

<h2>API endpoints</h2>
<p>Базовый префикс — <code>/api</code>. Авторизация через Laravel Sanctum.</p>
<p>Пример запроса <code> GET http://localhost/library-junior-api/public/api/books </code> </p>

<h3>Публичная часть</h3>
<table>
<thead><tr><th>Метод</th><th>URL</th><th>Описание</th></tr></thead>
<tbody>
<tr>
  <td>GET</td>
  <td>/api/books</td>
  <td>
    Список книг с автором, жанром, типом книги и пагинацией.<br>
    Параметры:<br>
    <code>?page=</code> — номер страницы (по умолчанию 1)<br>
    <code>?per_page=</code> — количество элементов на странице (по умолчанию 10)<br>
    <code>?title=</code> — поиск по названию книги<br>
    <code>?user_id=</code> — фильтр по ID автора<br>
    <code>?genre_id=</code> — фильтр по ID жанра<br>
    <code>?created_from=</code> — фильтр по дате создания (от)<br>
    <code>?created_to=</code> — фильтр по дате создания (до)<br>
    <code>?sort_by=</code> — сортировка по названию (asc или desc)
  </td>
</tr>
<tr><td>GET</td><td>/api/books/{id}</td><td>Детали книги</td></tr>
<tr><td>GET</td><td>/api/authors</td><td>Список авторов с количеством книг, пагинацией</td></tr>
<tr><td>GET</td><td>/api/authors/{id}</td><td>Детали автора и его книги</td></tr>
<tr><td>GET</td><td>/api/genres</td><td>Список жанров с количеством книг, пагинацией</td></tr>
<tr><td>GET</td><td>/api/genres/{id}</td><td>Детали жанра и книги в нём</td></tr>
</tbody>
</table>

<h3>Авторская часть (требуется токен)</h3>
<table>
<thead><tr><th>Метод</th><th>URL</th><th>Описание</th></tr></thead>
<tbody>
<tr><td>PATCH</td><td>/api/profile/{id}</td><td>Обновление своих данных</td></tr>
<tr><td>PATCH</td><td>/api/books/{id}</td><td>Обновление своей книги</td></tr>
<tr><td>DELETE</td><td>/api/books/{id}</td><td>Удаление своей книги</td></tr>
</tbody>
</table>

<h3>Административная часть (роль admin)</h3>
<table>
<thead><tr><th>Метод</th><th>URL</th><th>Описание</th></tr></thead>
<tbody>
<tr><td>POST</td><td>/api/books</td><td>Создание книги (проверка уникальности по названию)</td></tr>
<tr><td>PATCH</td><td>/api/books/{id}</td><td>Обновление книги</td></tr>
<tr><td>DELETE</td><td>/api/books/{id}</td><td>Удаление книги</td></tr>
<tr><td>POST</td><td>/api/authors</td><td>Создание автора</td></tr>
<tr><td>PATCH</td><td>/api/authors/{id}</td><td>Обновление автора</td></tr>
<tr><td>DELETE</td><td>/api/authors/{id}</td><td>Удаление автора</td></tr>
<tr><td>POST</td><td>/api/genres</td><td>Создание жанра</td></tr>
<tr><td>PATCH</td><td>/api/genres/{id}</td><td>Обновление жанра</td></tr>
<tr><td>DELETE</td><td>/api/genres/{id}</td><td>Удаление жанра</td></tr>
</tbody>
</table>

<h3>Авторизация</h3>
<table>
<thead><tr><th>Метод</th><th>URL</th><th>Описание</th></tr></thead>
<tbody>
<tr><td>POST</td><td>/api/login</td><td>Вход, получение Bearer токена</td></tr>
</tbody>
</table>

<pre>
{
  "email": "admin@gmail.com",
  "password": "admin"
}
</pre>
<p>Использовать в заголовке: <code>Authorization: Bearer &lt;token&gt;</code></p>
