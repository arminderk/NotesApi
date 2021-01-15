# NotesApi

A JSON API created using Laravel to allow users the ability to perform CRUD operations on notes.

# Running the API

Install dependencies by running:

```
composer install
```

Create the `.env` file and update the credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notesapi
DB_USERNAME=root
DB_PASSWORD=
```

Run database commands:

```
php artisan migrate
php artisan db:seed
```

Run the laravel server:

```
php artisan serve
```

Now you can make API calls to [localhost:8000/api](http://localhost:8000/api).

| HTTP Verb | Endpoint             | Description                                        |
|-----------|----------------------|----------------------------------------------------|
| POST      | /api/login           | Provide email and password to receive auth token.  |
| GET       | /api/user/notes      | Retrieve all of the user's notes.                  |
| GET       | /api/user/notes/{id} | Retrieve a specific user note by note_id.          |
| POST      | /api/user/notes      | Create a new note.                                 |
| PUT       | /api/user/notes/{id} | Update a specific note.                            |
| DELETE    | /api/user/notes/{id} | Delete a note.                                     |
| GET       | /api/user/logout     | Logout the authenticated user.                     |

&nbsp;

## Demonstration:

**API Login:**

```
curl -d "email=hettinger.zelda@example.net&password=password" -X POST http://localhost:8000/api/login
```

Response

```json
{"token":"6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1"}
```

**Get All Notes:**

```
curl -H 'Accept: application/json' -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" http://localhost:8000/api/user/notes
```

Response

```json
[{"id":11,"user_id":2,"title":"Second Post for Zelda","note":"This is my second post","created_at":"2021-01-14T20:17:43.000000Z","updated_at":"2021-01-14T20:17:43.000000Z"},{"id":12,"user_id":2,"title":"Third Post for Zelda","note":"This is my third post","created_at":"2021-01-14T20:17:55.000000Z","updated_at":"2021-01-14T20:17:55.000000Z"},{"id":13,"user_id":2,"title":"Another amazing post!","note":"This is another post for me!","created_at":"2021-01-14T20:58:18.000000Z","updated_at":"2021-01-14T20:58:18.000000Z"},{"id":14,"user_id":2,"title":"This is another great post","note":"Body of my post","created_at":"2021-01-14T22:34:53.000000Z","updated_at":"2021-01-14T22:34:53.000000Z"}]
```

**Get a Specific Note:**

```
curl -H 'Accept: application/json' -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" http://localhost:8000/api/user/notes/11
```

Response

```json
{"id":11,"user_id":2,"title":"Second Post for Zelda","note":"This is my second post","created_at":"2021-01-14T20:17:43.000000Z","updated_at":"2021-01-14T20:17:43.000000Z"}
```

**Create a New Note:**

```
curl -H 'Content-Type: application/json' -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" -d '{"title":"This is another great post","note":"Body of my post"}' http://localhost:8000/api/user/notes
```

Response

```json
{"title":"This is another great post","note":"Body of my post","user_id":2,"updated_at":"2021-01-15T02:26:20.000000Z","created_at":"2021-01-15T02:26:20.000000Z","id":15}
```

**Update a Note:**

```
curl -H 'Content-Type: application/json' -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" -X PUT -d '{"title":"Changed my note title","note":"Also change the body of the note!"}' http://localhost:8000/api/user/notes/11
```

Response

```json
{"id":11,"user_id":2,"title":"Changed my note title","note":"Also change the body of the note!","created_at":"2021-01-14T20:17:43.000000Z","updated_at":"2021-01-15T02:27:53.000000Z"}
```

**Delete a Note:**

```
curl -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" -X DELETE http://localhost:8000/api/user/notes/11
```

Response

```json
{"id":11,"user_id":2,"title":"Changed my note title","note":"Also change the body of the note!","created_at":"2021-01-14T20:17:43.000000Z","updated_at":"2021-01-15T02:27:53.000000Z"}
```

**Logout User:**

```
curl -H 'Accept: application/json' -H "Authorization: Bearer 6|TGXvRqvEIUkjcic1dyXEbdWmjIwVqLO5GxnW5Sz1" http://localhost:8000/api/user/logout
```

Response

```json
{"message":"User successfully logged out."}
```

