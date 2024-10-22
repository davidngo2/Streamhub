import requests
import os

# Define the base URL and authorization token
base_url = "https://api.themoviedb.org/3"
headers = {
    "Authorization": "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmMTYxMGMwN2I1NTViMzFkY2FiMzkzMTNhY2E4M2IwYyIsIm5iZiI6MTcyNjIzMTg4MC4xNjA1MTgsInN1YiI6IjY1NDIxM2QzNmJlYWVhMDEwYjMwZDIzZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.0RJGqAGKP4_cPyUagR6VMmmUsoYNdWWZV3ReGRAeyRk"
}

# API URLs
discover_url = "https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=en-US&sort_by=vote_average.desc&without_genres=99,10755&vote_count.gte=200&page=1"

# Fetch the genre dictionary (id -> name)
def get_genre_dict():
    movie_genres_url = f"{base_url}/genre/movie/list?language=en-US"
    genre_dict = {}
    movie_genres_response = requests.get(movie_genres_url, headers=headers)
    movie_genres_data = movie_genres_response.json()
    for genre in movie_genres_data['genres']:
        genre_dict[genre['id']] = genre['name']
    return genre_dict

# Fetch the genre dictionary (id -> name)
genre_dict = get_genre_dict()

# Convert genre IDs to genre names
def get_genre_names(genre_ids):
    genre_names = [genre_dict.get(genre_id, 'Unknown') for genre_id in genre_ids]
    return ','.join(genre_names)

# Function to fetch the video key for a movie
def get_video_key(movie_id):
    video_url = f"{base_url}/movie/{movie_id}/videos?language=en-US"
    video_response = requests.get(video_url, headers=headers)
    video_data = video_response.json()
    if video_data['results']:
        return video_data['results'][0].get('key', 'NULL')
    return 'NULL'

# Function to convert movie data to SQL INSERT statements with video key and genre names
def insert_movie_data_sql(movies):
    sql_insertions = []
    for movie in movies:
        title = movie.get('title', '').replace("'", "''")  # Escape single quotes
        release_date = movie.get('release_date', 'NULL')
        id = movie.get('id', 'NULL')
        original_language = movie.get('original_language', 'NULL')
        popularity = movie.get('popularity', 'NULL')
        vote_average = movie.get('vote_average', 'NULL')
        vote_count = movie.get('vote_count', 'NULL')
        
        genre_ids = movie.get('genre_ids', [])
        genre_names = get_genre_names(genre_ids)  # Get genre names from genre_dict
        overview = movie.get('overview', '').replace("'", "''")  # Escape single quotes in overview
        poster_path = movie.get('poster_path', 'NULL')
        
        video_key = get_video_key(id)
        sql = f"""
        INSERT INTO discovered_movies (id, title, release_date, original_language, popularity, vote_average, vote_count, genre_names, overview, poster_path, video_key)
        VALUES ({id}, '{title}', '{release_date}', '{original_language}', {popularity}, {vote_average}, {vote_count}, '{genre_names}', '{overview}', '{poster_path}', '{video_key}');
        """
        sql_insertions.append(sql)
    return sql_insertions

# Function to fetch movies from the discover API (limit to 10 movies)
def fetch_movies():
    response = requests.get(discover_url, headers=headers)
    data = response.json()
    if 'results' in data:
        return data['results'][:10]  # Limit to first 10 movies
    return []

# Fetch and generate SQL for discovered movies
movies = fetch_movies()

# Generate SQL insert commands for the fetched movies
sql_commands = insert_movie_data_sql(movies)

# Print the first few SQL commands as a sample
for command in sql_commands[:5]:
    print(command)

# Optionally, save SQL commands to a file with UTF-8 encoding
with open('discovered_movies.sql', 'w', encoding='utf-8') as f:
    for command in sql_commands:
        f.write(command + '\n')
