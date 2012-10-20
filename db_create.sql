CREATE TABLE projects(
p_id INT AUTO_INCREMENT, 
project_name TEXT NOT NULL, 
focus TEXT NOT NULL, 
image_url TEXT,
image_style TEXT,
video TEXT,
date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
PRIMARY KEY(p_id)
);

CREATE TABLE fields(
f_id INT AUTO_INCREMENT, 
field_name TEXT NOT NULL,
for_key_p_id INT NOT NULL,
PRIMARY KEY(f_id),
FOREIGN KEY(for_key_p_id) REFERENCES projects(p_id)
);

CREATE TABLE details(
d_id INT AUTO_INCREMENT, 
detail_name TEXT NOT NULL,
for_key_f_id INT NOT NULL,
PRIMARY KEY(d_id),
FOREIGN KEY(for_key_f_id) REFERENCES fields(f_id)
);