# README

## What is Compalex?
Compalex is a lightweight script to compare two database schemas. It supports MySQL, MS SQL Server and PostgreSQL.

Try [demo](http://demo.compalex.net/) or visit [http://compalex.net/](http://compalex.net/)


## Requirements
Compalex is only supported by PHP 5.4 and up with PDO extension.

## Installation
	$ git clone https://github.com/dlevsha/compalex.git
	$ cd compalex
	
Open `.environment`. You'll see configuration params

```ini
[ Main settings ]
; Possible DATABASE_DRIVER: 'mysql', 'pgsql', 'dblib'.
; Please use 'dblib' for Microsoft SQL Server
DATABASE_DRIVER = mysql
DATABASE_ENCODING = utf8
SAMPLE_DATA_LENGTH = 100

[ Primary connection params ]
DATABASE_HOST = localhost
DATABASE_PORT = 3306
DATABASE_NAME = compalex_dev
DATABASE_USER = root
DATABASE_PASSWORD =
DATABASE_DESCRIPTION = Developer database

[ Secondary connection params ]
DATABASE_HOST_SECONDARY = localhost
DATABASE_PORT_SECONDARY = 3306
DATABASE_NAME_SECONDARY = compalex_prod
DATABASE_USER_SECONDARY = root
DATABASE_PASSWORD_SECONDARY =
DATABASE_DESCRIPTION_SECONDARY = Production database
```

where 

`DATABASE_DRIVER` - database driver, possible value

- `mysql` - for MySQL database
- `pgsql` - for PostgreSQL database
- `dblib` - for Microsoft SQL Server database

`[ Primary connection params ]` and `[ Secondary connection params ]`sections describes settings for first and second databases.

Where

- `DATABASE_HOST` and `DATABASE_HOST_SECONDARY`  - database host name or IP for first and second server

- `DATABASE_PORT` and `DATABASE_PORT_SECONDARY` - database port for first and second server

- `DATABASE_NAME` and `DATABASE_NAME_SECONDARY` - first and second database name

- `DATABASE_USER` / `DATABASE_PASSWORD`  and `DATABASE_USER_SECONDARY` / `DATABASE_PASSWORD_SECONDARY` - login and password to access your databases 

- `DATABASE_DESCRIPTION` and `DATABASE_DESCRIPTION_SECONDARY` - server description (not necessary). For information only. These names will display as a database name.

Inside `compalex` directory run  

	$ php -S localhost:8000
	
Now open your browser and type `http://localhost:8000/`

You'll see database schema of two compared databases.

-
![Database Compare Panel](https://cloud.githubusercontent.com/assets/1639576/9703302/1327b858-5488-11e5-856a-96b139c7b938.png)	
-

You can run this script in terminal (for example, if you don't have direct connection to database).

I recommend [eLinks](https://en.wikipedia.org/wiki/ELinks) (free text-based console web browser) because it supports HTML-formatting and colors.

Install the script and run web-server as described above on your server. 

Then run:

	$ elinks http://localhost:8000

You'll see database schema in your terminal

![Database schema in terminal](https://cloud.githubusercontent.com/assets/1639576/10304652/248de29e-6c24-11e5-863b-c94bf337f47d.png)

LICENSE
-------

Copyright (c) 2015, Levsha Dmitry

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
	