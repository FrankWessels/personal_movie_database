import os
import sh
import re

def make_record_omdb(path, title, f):
    if title[0:2] == "tt":
        url = "http://www.omdbapi.com/?i=" + title.replace(" ", "%20")
    else:
        url = "http://www.omdbapi.com/?t=" + title.replace(" ", "%20")
    tarcmd = sh.Command("curl")
    data = str(tarcmd(url))
    
    #Columns
    columns = ["Title", "Year", "Rated", "Released", "Runtime", "Genre", "Director", "Writer", "Actors", "Plot", "Language", "Country", "Awards", "Poster", "Metascore", "imdbRating", "imdbVotes", "imdbID", "Type", "Response"]
    
    #process data
    data = data[2:-2]

    data = re.split('":"|","', data)
    output = path + "\t"
    for column in columns:
        try:
            pos = data.index(column)
        except ValueError:
            pos = -1
        if pos > -1:
            output = output + data[pos + 1] + "\t"
        else:
            output = output + "NA" + "\t"
    f.write(output+"\n")

def search_omdb(title):
    #Find exact match
    if title[0:2] == "tt":
        url = "http://www.omdbapi.com/?i=" + title.replace(" ", "%20")
    else:
        url = "http://www.omdbapi.com/?t=" + title.replace(" ", "%20")
    tarcmd = sh.Command("curl")
    data = str(tarcmd(url))
    
    #If exact match is not find, find closest match
    if data.find('"False"') > -1:
        url = "http://www.omdbapi.com/?s=" + title.replace(" ", "%20")
        tarcmd = sh.Command("curl")
        data = str(tarcmd(url))
    
    #Recover official title from data
    if data.find('"False"') > -1:
        return "False"
    else:
        pos1 = data.find('":"')
        pos2 = data.find('","')
        if pos1<0 or pos2<0:
            return "Something went wrong"
        else:
            return data[pos1+3:pos2]

def compare_to_imdb():
    paths_from_file = []
    titles = []
    changed_titles = []
    unknown_titles = []
    f = open('movies.txt', 'r')   
    for line in f:
        paths_from_file.append(str(line)[:-1])
    f.close()
    f = open('table.txt', 'w')   
    for path in paths_from_file:
        pos1 = path.rfind('/')
        pos2 = path.rfind('\\')
        pos = max(pos1, pos2)
        title = path[pos+1:-4]
    
        o_title = search_omdb(title)
        if o_title == "False":
            unknown_titles.append(title)
            titles.append(title)
        elif title != o_title:
            changed_titles.append(title)
            titles.append(o_title)
            if title[0:2] == "tt":
                make_record_omdb(path, title, f)
            else:
                make_record_omdb(path, o_title, f)
        else:
            titles.append(o_title)
            make_record_omdb(path, o_title, f)
            
    f.close()        
    print "Titles which did not have an exact match\n"
    for title in changed_titles:
        print title + "\n"
    
    
    print "Titles which did not have a match"
    for title in unknown_titles:
        print title + "\n"
    
    
def update_list():

    paths = []
    paths_from_folder = []
    paths_from_file = []
    movie_folder = "Movies/"

    #Get all paths of movies from folder
    tree = os.walk(movie_folder)
    extensions = [".mp4", ".mkv", ".avi", ".mpg"]
    for root, dirs, files in tree:
        for file in files:
            for extension in extensions:
                if file.endswith(extension):
                    paths_from_folder.append(str(os.path.join(root, file)))

    #Get all paths of movies from file
    f = open('movies.txt', 'r')   
    for line in f:
        paths_from_file.append(str(line)[:-1])
    f.close()

    #Define the new paths
    paths = paths_from_folder[:]

    #Collect all different paths, this can be faster, but this method is easy
    i = 0
    while i < len(paths_from_folder):
        j = 0
        while j < len(paths_from_file):
            if paths_from_folder[i] == paths_from_file[j]:
                del paths_from_folder[i]
                del paths_from_file[j]
                j = len(paths_from_file)
                i = i - 1
            j = j + 1
        i = i + 1


    #Print paths that do not exist anymore
    print "Paths that do not exist anymore:\n"
    for path in paths_from_file:
        print path
    print "\n"

    #Print paths that are new
    print "Paths that are new:\n"
    for path in paths_from_folder:
        print path
    print "\n"

    #Store paths in file
    f = open('movies.txt', 'w')   
    for path in paths:
        f.write(path + "\n")
    f.close()
    
update_list()
compare_to_imdb()
