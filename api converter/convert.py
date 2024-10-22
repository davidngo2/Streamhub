import requests
import random
import os

# Define the base URL and authorization token
base_url = "https://api.themoviedb.org/3"
headers = {
    "Authorization": "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmMTYxMGMwN2I1NTViMzFkY2FiMzkzMTNhY2E4M2IwYyIsIm5iZiI6MTcyNjIzMTg4MC4xNjA1MTgsInN1YiI6IjY1NDIxM2QzNmJlYWVhMDEwYjMwZDIzZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.0RJGqAGKP4_cPyUagR6VMmmUsoYNdWWZV3ReGRAeyRk"
}

# API URLs
movie_genres_url = f"{base_url}/genre/movie/list?language=en-US"
tv_genres_url = f"{base_url}/genre/tv/list?language=en-US"
now_playing_url_template = f"{base_url}/discover/movie?include_adult=false&include_video=false&language=en-US&page=1&sort_by=vote_average.desc&without_genres=99,10755&vote_count.gte=200"  # Template for page

# Fetch genres from both the movie and TV genre APIs
def get_genre_dict():
    genre_dict = {}
    movie_genres_response = requests.get(movie_genres_url, headers=headers)
    movie_genres_data = movie_genres_response.json()
    for genre in movie_genres_data['genres']:
        genre_dict[genre['id']] = genre['name']
    tv_genres_response = requests.get(tv_genres_url, headers=headers)
    tv_genres_data = tv_genres_response.json()
    for genre in tv_genres_data['genres']:
        genre_dict[genre['id']] = genre['name']
    return genre_dict

# Fetch the genre dictionary (id -> name)
genre_dict = get_genre_dict()

# Function to fetch the video key for a movie
def get_video_key(movie_id):
    video_url = f"{base_url}/movie/{movie_id}/videos?language=en-US"
    video_response = requests.get(video_url, headers=headers)
    video_data = video_response.json()
    if video_data['results']:
        return video_data['results'][0].get('key', 'NULL')
    return 'NULL'

# Convert genre IDs to genre names
def get_genre_names(genre_ids):
    genre_names = [genre_dict.get(genre_id, 'Unknown') for genre_id in genre_ids]
    return ','.join(genre_names)

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
        INSERT INTO now_playing_movies (id, title, release_date, original_language, popularity, vote_average, vote_count, genre_names, overview, poster_path, video_key)
        VALUES ({id}, '{title}', '{release_date}', '{original_language}', {popularity}, {vote_average}, {vote_count}, '{genre_names}', '{overview}', '{poster_path}', '{video_key}');
        """
        sql_insertions.append(sql)
    return sql_insertions

# Function to fetch movie data from a specific page
def fetch_movies_from_page(page_num):
    now_playing_url = now_playing_url_template + str(page_num)
    response = requests.get(now_playing_url, headers=headers)
    return response.json()

# Get the last fetched page number
def get_last_fetched_page():
    if os.path.exists('last_page.txt'):
        with open('last_page.txt', 'r') as f:
            return int(f.read())
    return 1  # Default to page 1 if not found

# Save the last fetched page number
def save_last_fetched_page(page_num):
    with open('last_page.txt', 'w') as f:
        f.write(str(page_num))

# Fetch movies and save the last page fetched
def fetch_movies_and_save_last_page(max_pages=5):
    last_page = get_last_fetched_page()
    print(f"Last fetched page: {last_page}")
    movies = []
    for page in range(last_page, last_page + 5):  # Fetch the next 5 pages
        data = fetch_movies_from_page(page)
        if 'results' in data:
            movies.extend(data['results'])
            print(f"Fetched page {page}")
        else:
            break  # Stop if no results
    save_last_fetched_page(last_page + 5)  # Update last page
    return movies

# Fetch and generate SQL for movies from new pages
movies = fetch_movies_and_save_last_page(max_pages=5)

# Generate SQL insert commands for the fetched movies
sql_commands = insert_movie_data_sql(movies)

# Print the first few SQL commands as a sample
for command in sql_commands[:5]:
    print(command)

# Optionally, save SQL commands to a file with UTF-8 encoding
with open('movies_with_videos_and_genres_multiple_pages.sql', 'w', encoding='utf-8') as f:
    for command in sql_commands:
        f.write(command + '\n')
