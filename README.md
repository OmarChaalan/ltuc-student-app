# LTUC Student Information System

Full-stack web application for managing LTUC student records with AWS RDS database integration.

## 🌐 Live Demo
**URL:** http://44.199.254.148

> ⚠️ **Note:** This application is hosted on AWS Academy Learner Lab. The public IP address may change when the lab environment is restarted. If the link doesn't work, the lab session may have ended.

## 🛠️ Technologies Used

### Frontend
- HTML5
- CSS3 (Custom styling with gradients)
- JavaScript (Form validation)

### Backend
- PHP 8.x
- MySQL (AWS RDS)

### Infrastructure
- **AWS EC2** - Ubuntu Server hosting Apache + PHP
- **AWS RDS** - MySQL database (Sandbox template)
- **AWS VPC** - Custom VPC with public and private subnets
- **Security Groups** - Configured for EC2 (HTTP/SSH) and RDS (MySQL)

## ✨ Features

- ✅ Student registration form with validation
- ✅ Real-time form validation (client-side)
- ✅ Server-side validation and sanitization
- ✅ Database integration with RDS MySQL
- ✅ View all registered students
- ✅ Calculate statistics (Total students, Average GPA)
- ✅ Prevent duplicate student IDs
- ✅ Responsive design
- ✅ GPA performance categorization

## 📁 Project Structure
```
LTUC-STUDENT-APP/
├── index.html           # Main registration form
├── style.css            # Styling and responsive design
├── script.js            # Client-side form validation
├── config.example.php   # Database configuration template
├── process.php          # Form processing and database insertion
├── view_students.php    # Display all students with statistics
└── README.md            # Project documentation
```

## 🗄️ Database Schema
```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    major VARCHAR(100) NOT NULL,
    year VARCHAR(50) NOT NULL,
    gpa DECIMAL(3,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🏗️ AWS Architecture

### Network Configuration
- **VPC:** `ltuc-vpc` (10.0.0.0/16)
- **Public Subnet:** `ltuc-public-subnet` (10.0.1.0/24) - Hosts EC2
- **Private Subnets:** `ltuc-private-subnet` (10.0.2.0/24), `ltuc-private-subnet-2` (10.0.3.0/24) - Host RDS

### Security Groups
- **EC2 Security Group (`ltuc-ec2-sg`):**
  - Port 80 (HTTP) - 0.0.0.0/0
  - Port 22 (SSH) - Restricted to admin IP

- **RDS Security Group (`ltuc-rds-sg`):**
  - Port 3306 (MySQL) - Source: EC2 Security Group only

### Components
- **EC2 Instance:** Ubuntu 22.04 with Apache 2.4 + PHP 8.x
- **RDS Instance:** MySQL 8.0 (Sandbox template for AWS Academy)

## 🚀 Deployment Instructions

### Prerequisites
- AWS Account (AWS Academy Learner Lab)
- SSH key pair for EC2 access
- Git installed locally

### Setup Steps

1. **Clone the repository:**
```bash
git clone https://github.com/YOUR-USERNAME/ltuc-student-app.git
cd ltuc-student-app
```

2. **Configure database:**
```bash
cp config.example.php config.php
# Edit config.php with your RDS credentials
```

3. **Deploy to EC2:**
```bash
scp -i your-key.pem *.html *.css *.js *.php ubuntu@YOUR-EC2-IP:/home/ubuntu/
ssh -i your-key.pem ubuntu@YOUR-EC2-IP
sudo mv /home/ubuntu/*.{html,css,js,php} /var/www/html/
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

## 📊 Application Pages

1. **Main Form** - `/` or `/index.html`
2. **View Students** - `/view_students.php`
3. **Process Form** - `/process.php` (POST only)

## 👨‍💻 Development

This project was developed as part of a cloud computing course assignment, demonstrating:
- Full-stack web development
- AWS infrastructure setup
- Database integration
- Security best practices

## 📝 License

Educational project for LTUC - Luminus Technical University College

## 🤝 Contributing

This is an academic project. For questions or suggestions, contact me.

---

## ⚠️ AWS Academy Learner Lab Notes

This project is deployed on AWS Academy Learner Lab, which has the following limitations:
- Lab sessions are time-limited (typically 4 hours)
- EC2 public IP changes when lab is restarted
- Resources must be manually started each session
- RDS creation requires "Sandbox" template due to permission restrictions

For persistent deployment, consider using a standard AWS account with an Elastic IP address.

**Developed by:** Omar Chaalan  
**Course:** Cloud Computing - Public and Private Cloud
**Institution:** Luminus Technical University College (LTUC)
