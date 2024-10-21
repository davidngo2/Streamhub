DROP DATABASE IF EXISTS streamhub;

CREATE DATABASE streamhub;

USE streamhub;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    gebruikernaam VARCHAR(255) NOT NULL,
    wachtwoord VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    subscribsie VARCHAR(255) NOT NULL,
    eind_date DATE NOT NULL
);
-- Tabel voor gebruikers (User Accounts & Authenticatie)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT 0,
    -- Gebruiker is admin als dit op TRUE staat
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel voor video's (Video Library)
CREATE TABLE videos (
    video_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    genre VARCHAR(100),
    category VARCHAR(100),
    release_year YEAR,
    popularity_score INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel voor favorieten (User Favorieten)
CREATE TABLE favorites (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    video_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(video_id) ON DELETE CASCADE
);

-- Tabel voor afspeellijsten (Custom Playlists)
CREATE TABLE playlists (
    playlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Tabel voor video's in afspeellijsten (Videos in Playlists) - n-op-n relatie
CREATE TABLE playlist_videos (
    playlist_video_id INT AUTO_INCREMENT PRIMARY KEY,
    playlist_id INT,
    video_id INT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (playlist_id) REFERENCES playlists(playlist_id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(video_id) ON DELETE CASCADE
);

-- Tabel voor video's bekeken door gebruikers (User Watch History)
CREATE TABLE watch_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    video_id INT,
    watched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(video_id) ON DELETE CASCADE
);

-- Tabel voor admin acties (Admin Video Management)
CREATE TABLE admin_actions (
    action_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    action_type VARCHAR(50),
    -- Bijvoorbeeld 'add', 'edit', 'delete'
    video_id INT,
    action_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(video_id) ON DELETE CASCADE
);

-- Optionele tabel voor aanbevelingen (Recommendation System) - n-op-n relatie
CREATE TABLE recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    video_id INT,
    recommended_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(video_id) ON DELETE CASCADE
);