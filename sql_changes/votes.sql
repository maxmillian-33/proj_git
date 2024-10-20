CREATE TABLE votes (
    vote_id INT AUTO_INCREMENT PRIMARY KEY,
    election_id INT NOT NULL,
    user_id INT NOT NULL,
    candidate_id INT NOT NULL
);
