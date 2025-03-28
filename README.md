Votezz - Election and Voting Database Management System

📌 Project Overview

Votezz is a web-based Election and Voting Database Management System that allows users to cast votes securely and enables admins to manage elections efficiently. Built using PHP and MySQL (XAMPP), it provides an intuitive and user-friendly interface for both voters and administrators.

🎯 Features

User Features

📝 User Registration – New users can register with their details.

🔐 Login System – Secure login authentication for voters.

🗳 Voting Page – Users can cast their vote 

Admin Features

👤 Admin Login – Admins can log in using predefined credentials.

📋 Manage Candidates – Add or remove candidates for elections.

📊 Live Vote Count – Displays results with a bar diagram.

🛠 Tech Stack

Frontend: HTML, CSS

Backend: PHP

Database: MySQL (XAMPP)

⚙️ Installation and Setup

Follow these steps to set up Votezz on your local system:

Clone the Repository

git clone https://github.com/yourusername/votezz.git

Move to the Project Directory

cd votezz

Start XAMPP Server

Open XAMPP Control Panel and start Apache and MySQL.

Import Database

Open phpMyAdmin and create a database named votezz_db.

Import the votezz_db.sql file from the project directory.

Update Database Configuration

Ensure db_connect.php contains the correct database credentials:

$conn = mysqli_connect("localhost", "root", "", "votezz_db");

Run the Project

Open a web browser and go to:

http://localhost/votezz/

📌 Admin Credentials

Username: Naveen

Password: 123


🤝 Contributing

Contributions are welcome! Feel free to fork this repository and submit a pull request.

📜 License

This project is open-source and free to use.

📩 Contact

📧 Email: naveenkumarp2094@gmail.com

💻 LinkedIn: https://www.linkedin.com/in/naveenkumarp20/



Give a ⭐ if you like this project!
