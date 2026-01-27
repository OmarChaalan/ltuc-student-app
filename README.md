# 🎓 LTUC Student Information System

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![AWS](https://img.shields.io/badge/AWS-Cloud-FF9900?style=for-the-badge&logo=amazon-aws&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**A full-stack web application for managing student records with complete CRUD operations, deployed on AWS cloud infrastructure.**

[Live Demo](http://44.199.254.148) • [Documentation](#-deployment-instructions) • [Report Issue](https://github.com/OmarChaalan/ltuc-student-app/issues)

</div>

---

## 🌐 Live Demo

**🔗 URL:** http://44.199.254.148

> ⚠️ **Note:** This application is hosted on AWS Academy Learner Lab. The public IP address may change when the lab environment is restarted. If the link doesn't work, the lab session may have ended.

---

## 📸 Screenshots

### Main Registration Form
Modern, responsive design with real-time validation

### Student Dashboard
View all students with statistics and quick actions

### Edit Interface
Intuitive form for updating student information

---

## 🛠️ Tech Stack

<table>
<tr>
<td>

**Frontend**
- HTML5
- CSS3 (Custom Gradients)
- JavaScript (ES6+)
- Responsive Design

</td>
<td>

**Backend**
- PHP 8.x
- MySQL 8.0
- Server-side Validation
- Prepared Statements

</td>
<td>

**Infrastructure**
- AWS EC2
- AWS RDS
- AWS VPC
- Security Groups

</td>
</tr>
</table>

---

## ✨ Key Features

### 🔐 Security
- ✅ SQL Injection prevention (Prepared Statements)
- ✅ XSS protection (Input sanitization)
- ✅ Server-side validation
- ✅ Secure database connections
- ✅ Private subnet for RDS

### 📊 Functionality
- ✅ **Full CRUD Operations**
  - **CREATE:** Add new student records with validation
  - **READ:** View all students with sorting and statistics
  - **UPDATE:** Edit existing student information
  - **DELETE:** Remove records with confirmation
- ✅ Real-time form validation (client-side)
- ✅ Calculate statistics (Total students, Average GPA)
- ✅ Prevent duplicate student IDs
- ✅ GPA performance categorization (Excellent, Very Good, Good, Pass)
- ✅ Confirmation prompts for destructive actions

### 🎨 User Experience
- ✅ Modern gradient UI design
- ✅ Fully responsive (Mobile, Tablet, Desktop)
- ✅ Smooth animations and transitions
- ✅ Intuitive navigation
- ✅ Clear success/error messaging

---

## 📁 Project Structure

```
LTUC-STUDENT-APP/
├── 📄 index.html              # Main registration form (CREATE)
├── 🎨 style.css               # Styling with gradients & responsive design
├── ⚡ script.js               # Client-side form validation & animations
├── 🔧 config.example.php      # Database configuration template
├── ➕ process.php             # Process new student submissions (CREATE)
├── 👁️ view_students.php       # Display all students with actions (READ)
├── ✏️ edit_student.php        # Edit student form (UPDATE)
├── 🔄 update_student.php      # Process student updates (UPDATE)
├── 🗑️ delete_student.php      # Delete student records (DELETE)
├── 📖 README.md               # Project documentation
└── 🚫 .gitignore              # Git ignore rules (excludes config.php)
```

---

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_student_id (student_id),
    INDEX idx_created_at (created_at)
);
```

**Supported Majors:**
- Computer Science
- Software Engineering
- Cloud Computing
- Cyber Security
- Data Science
- Network Engineering

---

## 🏗️ AWS Cloud Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        AWS Cloud (us-east-1)                    │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │              VPC: ltuc-vpc (10.0.0.0/16)                  │  │
│  │                                                            │  │
│  │  ┌─────────────────────┐    ┌────────────────────────┐   │  │
│  │  │  Public Subnet      │    │  Private Subnet #1     │   │  │
│  │  │  (10.0.1.0/24)      │    │  (10.0.2.0/24)         │   │  │
│  │  │  ┌──────────────┐   │    │  ┌──────────────────┐  │   │  │
│  │  │  │   EC2        │   │    │  │   RDS MySQL      │  │   │  │
│  │  │  │   Ubuntu     │───┼────┼─▶│   Primary        │  │   │  │
│  │  │  │   Apache+PHP │   │    │  │   Instance       │  │   │  │
│  │  │  └──────────────┘   │    │  └──────────────────┘  │   │  │
│  │  └─────────────────────┘    └────────────────────────┘   │  │
│  │           │                           │                    │  │
│  │           │                  ┌────────────────────────┐   │  │
│  │           │                  │  Private Subnet #2     │   │  │
│  │           │                  │  (10.0.3.0/24)         │   │  │
│  │           │                  │  ┌──────────────────┐  │   │  │
│  │           │                  │  │   RDS MySQL      │  │   │  │
│  │           │                  │  │   Standby AZ     │  │   │  │
│  │           │                  │  └──────────────────┘  │   │  │
│  │           │                  └────────────────────────┘   │  │
│  └───────────┼──────────────────────────────────────────────┘  │
│              │                                                  │
│         Internet Gateway                                        │
└──────────────┼──────────────────────────────────────────────────┘
               │
         [Internet Users]
```

### Network Configuration

| Component | CIDR Block | Purpose | Internet Access |
|-----------|------------|---------|-----------------|
| **VPC** | 10.0.0.0/16 | Main network | - |
| **Public Subnet** | 10.0.1.0/24 | Hosts EC2 | ✅ Yes (via IGW) |
| **Private Subnet 1** | 10.0.2.0/24 | Primary RDS | ❌ No |
| **Private Subnet 2** | 10.0.3.0/24 | RDS Multi-AZ | ❌ No |

### Security Groups

#### EC2 Security Group (`ltuc-ec2-sg`)
| Type | Protocol | Port | Source | Description |
|------|----------|------|--------|-------------|
| HTTP | TCP | 80 | 0.0.0.0/0 | Public web access |
| SSH | TCP | 22 | Admin IP | Secure shell access |

#### RDS Security Group (`ltuc-rds-sg`)
| Type | Protocol | Port | Source | Description |
|------|----------|------|--------|-------------|
| MySQL | TCP | 3306 | ltuc-ec2-sg | Database access from EC2 only |

### Infrastructure Components

| Service | Configuration | Purpose |
|---------|---------------|---------|
| **EC2** | t2.micro, Ubuntu 22.04 | Web server hosting Apache 2.4 + PHP 8.x |
| **RDS** | db.t3.micro, MySQL 8.0 (Sandbox) | Managed database service |
| **VPC** | 1 public + 2 private subnets | Network isolation |
| **IGW** | Attached to VPC | Internet connectivity |
| **Route Tables** | Public & Private | Traffic routing |

---

## 💰 Cost Estimation

### AWS Academy Learner Lab (FREE)
This project uses AWS Academy resources which are **completely free** for students.

### Standard AWS Account (Estimated Monthly Cost)

| Service | Configuration | Monthly Cost (USD) |
|---------|--------------|-------------------|
| **EC2 t2.micro** | 750 hours (Free Tier) | $0.00 - $8.50 |
| **RDS db.t3.micro** | 750 hours (Free Tier) | $0.00 - $12.41 |
| **EBS Storage** | 20 GB gp3 | $1.60 |
| **RDS Storage** | 20 GB gp2 | $2.30 |
| **Data Transfer** | ~10 GB/month | $0.90 |
| **Elastic IP** | If using static IP | $3.60 |
| | **Total (Free Tier):** | **~$0.00** |
| | **Total (After Free Tier):** | **~$29.31/month** |

> 💡 **Free Tier Eligible:** For the first 12 months with a new AWS account
> 
> 🎓 **AWS Academy:** Completely free for educational purposes

### Cost Optimization Tips
- ✅ Stop EC2 instances when not in use
- ✅ Use RDS Single-AZ for development
- ✅ Delete unused snapshots and volumes
- ✅ Monitor usage with AWS Cost Explorer
- ✅ Set up billing alerts

---

## 🚀 Quick Start

### Prerequisites

```bash
✅ AWS Account (AWS Academy Learner Lab or standard account)
✅ SSH key pair for EC2 access
✅ Git installed locally
✅ Basic knowledge of AWS console
```

### Installation

1️⃣ **Clone the repository:**
```bash
git clone https://github.com/OmarChaalan/ltuc-student-app.git
cd ltuc-student-app
```

2️⃣ **Configure database:**
```bash
cp config.example.php config.php
nano config.php  # Edit with your RDS credentials
```

3️⃣ **Set up EC2 Instance:**

**Connect to EC2:**
```bash
ssh -i your-key.pem ubuntu@YOUR-EC2-IP
```

**Install required dependencies:**
```bash
# Update system packages
sudo apt update

# Install Apache web server
sudo apt install apache2 -y

# Install PHP and required extensions
sudo apt install php libapache2-mod-php php-mysql -y

# Install MySQL client (for database testing)
sudo apt install mysql-client -y

# Verify installations
php -v                    # Check PHP version
apache2 -v                # Check Apache version
mysql --version           # Check MySQL client version

# Start and enable Apache
sudo systemctl start apache2
sudo systemctl enable apache2

# Check Apache status
sudo systemctl status apache2
```

**Set proper permissions for web directory:**
```bash
# Set ownership to current user and Apache group
sudo chown -R $USER:www-data /var/www/html

# Set directory permissions (755)
sudo chmod -R 755 /var/www/html

# Ensure Apache can read files
sudo chmod -R 644 /var/www/html/*.{html,css,js,php}
```

4️⃣ **Deploy application files:**

**From your local machine:**
```bash
# Navigate to project directory
cd ltuc-student-app

# Upload all files to EC2
scp -i your-key.pem *.html *.css *.js *.php ubuntu@YOUR-EC2-IP:/home/ubuntu/
```

**Back on EC2 (SSH session):**
```bash
# Move files to web directory
sudo mv /home/ubuntu/*.html /var/www/html/
sudo mv /home/ubuntu/*.css /var/www/html/
sudo mv /home/ubuntu/*.js /var/www/html/
sudo mv /home/ubuntu/*.php /var/www/html/

# Remove default Apache page
sudo rm -f /var/www/html/index.html

# Set correct ownership and permissions
sudo chown www-data:www-data /var/www/html/*
sudo chmod 644 /var/www/html/*

# Restart Apache to apply changes
sudo systemctl restart apache2
```

5️⃣ **Test database connection (Optional):**
```bash
# Create a simple test file
sudo nano /var/www/html/test_db.php

# Add this content:
# <?php
# require_once 'config.php';
# $conn = getDBConnection();
# echo "Database connected successfully!";
# $conn->close();
# ?>

# Visit: http://YOUR-EC2-IP/test_db.php
# If successful, delete the test file:
sudo rm /var/www/html/test_db.php
```

6️⃣ **Access the application:**
```
http://YOUR-EC2-PUBLIC-IP
```

### Installed Software Versions

| Software | Version | Purpose |
|----------|---------|---------|
| **Ubuntu** | 22.04 LTS | Operating System |
| **Apache** | 2.4.58 | Web Server |
| **PHP** | 8.1.x | Backend Language |
| **MySQL Client** | 8.0.x | Database Client |
| **php-mysql** | 8.1.x | PHP MySQL Extension |

---

## 📊 Application Pages

| Page | Route | Method | Description |
|------|-------|--------|-------------|
| 🏠 Main Form | `/` or `/index.html` | GET | Student registration form |
| 📋 View Students | `/view_students.php` | GET | List all students with statistics |
| ✏️ Edit Student | `/edit_student.php?id={id}` | GET | Edit form for specific student |
| 🔄 Update Student | `/update_student.php` | POST | Process student updates |
| 🗑️ Delete Student | `/delete_student.php?id={id}` | GET | Delete student record |
| ➕ Process Form | `/process.php` | POST | Create new student record |

---

## 🧪 Testing

### Manual Testing Checklist

- [ ] **CREATE:** Add a new student with valid data
- [ ] **CREATE:** Try adding duplicate student ID (should fail)
- [ ] **CREATE:** Test form validation (invalid email, GPA > 4)
- [ ] **READ:** View all students page loads correctly
- [ ] **READ:** Statistics (total students, average GPA) display
- [ ] **UPDATE:** Edit a student's information
- [ ] **UPDATE:** Verify changes persist in database
- [ ] **DELETE:** Delete a student with confirmation
- [ ] **DELETE:** Verify student removed from list
- [ ] **UI:** Test on mobile device (responsive design)
- [ ] **SECURITY:** SQL injection attempts blocked
- [ ] **SECURITY:** XSS attempts sanitized

### Sample Test Data

```
Student ID: TEST001
Name: John Doe
Email: john.doe@ltuc.edu.jo
Phone: 0791234567
Major: Computer Science
Year: Second Year
GPA: 3.75
```

---

## 🔒 Security Features

- **SQL Injection Prevention:** All database queries use prepared statements with bound parameters
- **XSS Protection:** All user inputs sanitized with `htmlspecialchars()`
- **CSRF Protection:** Form submissions validated for proper request methods
- **Database Security:** RDS in private subnet, accessible only from EC2
- **Secure Credentials:** Database credentials excluded from Git via `.gitignore`
- **HTTPS Ready:** Application can be configured with SSL/TLS certificates

---

## 🎯 Future Enhancements

- [ ] Add user authentication and authorization
- [ ] Implement student profile pictures
- [ ] Export data to CSV/PDF
- [ ] Advanced search and filtering
- [ ] Email notifications for CRUD operations
- [ ] RESTful API for mobile app integration
- [ ] Multi-language support (Arabic/English)
- [ ] Batch student import from Excel
- [ ] Course enrollment tracking
- [ ] Grade management system

---

## 🐛 Troubleshooting

### Common Issues

**Problem:** Can't connect to database
```bash
# Check RDS security group allows EC2 connection
# Verify config.php has correct credentials
# Test connection: php -r "new mysqli('HOST', 'USER', 'PASS', 'DB');"
```

**Problem:** 500 Internal Server Error
```bash
# Check Apache error logs
sudo tail -f /var/log/apache2/error.log
```

**Problem:** Permission denied
```bash
# Fix file permissions
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

---

## 👨‍💻 Development

This project was developed as part of a cloud computing course assignment, demonstrating:

- ✅ Full-stack web development with PHP and MySQL
- ✅ AWS cloud infrastructure design and deployment
- ✅ Database design and optimization
- ✅ Security best practices (input validation, prepared statements)
- ✅ Complete CRUD operations implementation
- ✅ Responsive web design principles
- ✅ Version control with Git
- ✅ Professional documentation

---

## 📝 License

This is an educational project developed for **Luminus Technical University College (LTUC)**. 

For academic and learning purposes only.

---

## 🤝 Contributing

This is an academic project. However, suggestions and feedback are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📧 Contact

**Omar Chaalan**

📧 Email: [Your Email]  
🔗 GitHub: [@OmarChaalan](https://github.com/OmarChaalan)  
🎓 Institution: Luminus Technical University College (LTUC)

---

## ⚠️ AWS Academy Learner Lab Notes

This project is deployed on **AWS Academy Learner Lab**, which has specific limitations:

| Limitation | Description | Workaround |
|------------|-------------|------------|
| ⏰ **Session Time** | 4-hour time limit | Restart lab session when needed |
| 🔄 **Dynamic IP** | EC2 IP changes on restart | Use Elastic IP in production |
| 🚫 **RDS Restrictions** | Must use Sandbox template | Sufficient for this project |
| 💾 **Resource Limits** | Limited instance types | t2.micro/t3.micro adequate |
| 🔒 **IAM Restrictions** | Limited service permissions | Documented workarounds applied |

**For Production Deployment:** Consider using a standard AWS account with:
- Elastic IP for EC2
- Multi-AZ RDS deployment
- CloudFront CDN
- Route 53 for DNS
- AWS Certificate Manager for SSL

---

<div align="center">

### ⭐ Star this repository if you found it helpful!

**Developed with ❤️ by Omar Chaalan**

**Course:** Cloud Computing - Public and Private Cloud  
**Institution:** Luminus Technical University College (LTUC)  
**Year:** 2024-2025

---

![Visitors](https://visitor-badge.laobi.icu/badge?page_id=OmarChaalan.ltuc-student-app)
![GitHub stars](https://img.shields.io/github/stars/OmarChaalan/ltuc-student-app?style=social)
![GitHub forks](https://img.shields.io/github/forks/OmarChaalan/ltuc-student-app?style=social)

</div>
