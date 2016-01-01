# personal_movie_database
A little program which finds all movies from a folder, collect IMDB data of those movies using http://www.omdbapi.com/ and stores the data and file location in a text file which can be loaded in MySQL using LOAD DATA LOCAL INFILE 'moviedata.txt' INTO TABLE moviedata;

+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| path       | varchar(128) | YES  |     | NULL    |       |
| Title      | varchar(128) | YES  |     | NULL    |       |
| Year       | varchar(128) | YES  |     | NULL    |       |
| Rated      | varchar(128) | YES  |     | NULL    |       |
| Released   | varchar(128) | YES  |     | NULL    |       |
| Runtime    | varchar(128) | YES  |     | NULL    |       |
| Genre      | varchar(128) | YES  |     | NULL    |       |
| Director   | varchar(128) | YES  |     | NULL    |       |
| Writer     | varchar(128) | YES  |     | NULL    |       |
| Actors     | varchar(128) | YES  |     | NULL    |       |
| Plot       | varchar(500) | YES  |     | NULL    |       |
| Language   | varchar(128) | YES  |     | NULL    |       |
| Country    | varchar(128) | YES  |     | NULL    |       |
| Awards     | varchar(128) | YES  |     | NULL    |       |
| Poster     | varchar(500) | YES  |     | NULL    |       |
| Metascore  | varchar(500) | YES  |     | NULL    |       |
| imdbRating | varchar(128) | YES  |     | NULL    |       |
| imdbVotes  | varchar(128) | YES  |     | NULL    |       |
| imdbID     | varchar(128) | YES  |     | NULL    |       |
| Type       | varchar(128) | YES  |     | NULL    |       |
| Response   | varchar(128) | YES  |     | NULL    |       |
+------------+--------------+------+-----+---------+-------+


Dependencies:
sh (pip install sh) works with 1.11 https://amoffat.github.io/sh/
