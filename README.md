# 🗳️ Votezz - Online Voting System

Votezz is a secure and dynamic web-based **Voting and Election Management System** created using **PHP** and **MySQL**, with a sleek red and black themed UI.

## 🎯 Project Objectives
- Allow users to register, log in, and vote securely.
- Admin can manage candidates and view vote counts.
- Prevent duplicate voting by restricting users to one vote.
- Display results visually with a bar chart.

---

## 🛠️ Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (via phpMyAdmin)
- **Tools**: XAMPP

---

## 🗄️ Database Structure

**Database Name**: `votezz2_db`

### 1. `users` Table

| Column      | Type          | Description            |
|-------------|---------------|------------------------|
| id          | int(11)       | Auto Increment (PK)    |
| name        | varchar(100)  | User's full name       |
| mobile      | varchar(10)   | Mobile number          |
| age         | int(11)       | Age of the user        |
| voter_id    | varchar(10)   | Unique Voter ID        |
| password    | varchar(255)  | Hashed password        |

---

### 2. `candidates` Table

| Column   | Type           | Description                     |
|----------|----------------|---------------------------------|
| id       | varchar(3)     | Candidate ID (PK)               |
| name     | varchar(100)   | Candidate Name                  |
| party    | varchar(100)   | Party Name                      |
| votes    | int(11)        | Vote count (default: 0)         |

---

### 3. `votes` Table

| Column       | Type         | Description                            |
|--------------|--------------|----------------------------------------|
| id           | int(11)      | Auto Increment (PK)                    |
| voter_id     | varchar(100) | ID of the voter (one vote per user)    |
| candidate_id | varchar(10)  | ID of the candidate voted for          |

---

## 🔐 Admin Credentials

- **Name**: Naveen
- **Voter ID**: CXSPN9373C
- **Password**: 54321

---

## 🔑 Features

✅ User Registration and Login  
✅ Secure Voting (One vote per user)  
✅ Admin can Add/Remove Candidates  
✅ Real-time Vote Counting  
✅ Bar Chart Visualization of Results  
✅ Fully Responsive Red-Black UI  
✅ Red glowing animations on vote and admin pages

---

## 🚀 How to Run

1. Download and install **XAMPP**.
2. Place the `votezz` folder inside `htdocs`.
3. Start **Apache** and **MySQL** via XAMPP.
4. Go to **phpMyAdmin**:
   - Create a database named `votezz2_db`.
   - Import or manually create the 3 tables above.
5. Access the app in your browser:  
   `http://localhost/votezz`
