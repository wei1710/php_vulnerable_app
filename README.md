# Vulnerable web app

## Installation
1. Run the script movies.sql on localhost. It will create the database **movies** with the tables **movies** and **votes**
2. Move the folder **poll** to the document root of the web server

## Operation

__SQL Injection__
On the *movie* textbox:
- Try an existing movie: 4 ('The Avengers'). It should work
- Try a non-existing movie: 12. It should work
- Try `4 OR 1 = 1; --`
All movies are retrieved. Check out the console to see the returned array

__XSS__
On the *name* textbox:
- Try `<script>alert("Hi");</script>`. The script executes

Click on "New movie". Then, on the movie textbox:
- Insert the movie `<script>alert('Hi');</script>`, then find its ID in the database and search for it. The script executes

__CSRF__
On the name textbox:
- Try `<a href="https://en.wikipedia.org">Learn</a>` and click in the **Learn** link. The link is active
- Then try `<script>fetch('src/api.php?action=get_movie&movie_id=4').then(response=>response.json()).then(data=>alert(data));</script>`. The script retrieves information from the database

Check out `localhost/poll` in the browser, then on the name textbox:
- Try `<img src="http://localhost/poll?vote=YES">`
- Now reload `localhost/poll`. The number of votes has increased

## Tools
MariaDB / PHP8 / JQuery / JavaScript / CSS3 / HTML5

## Author
Arturo Mora-Rioja