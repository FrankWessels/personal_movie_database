# personal_movie_database
A little program which finds all movies from a folder, collect IMDB data of those movies using http://www.omdbapi.com/ and stores the data and file location in a text file which can be loaded in MySQL using LOAD DATA LOCAL INFILE 'moviedata.txt' INTO TABLE moviedata.

Dependencies:
sh (pip install sh) works with 1.11 https://amoffat.github.io/sh/
