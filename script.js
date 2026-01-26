// Form validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    const studentId = document.getElementById('studentId').value;
    const phone = document.getElementById('phone').value;
    const gpa = document.getElementById('gpa').value;
    
    // Validate Student ID format (e.g., numbers only or specific pattern)
    if (studentId.length < 5) {
        e.preventDefault();
        alert('Student ID must be at least 5 characters long');
        return false;
    }
    
    // Validate phone number (basic validation)
    const phonePattern = /^[0-9]{10,}$/;
    if (!phonePattern.test(phone.replace(/[\s-]/g, ''))) {
        e.preventDefault();
        alert('Please enter a valid phone number (at least 10 digits)');
        return false;
    }
    
    // Validate GPA range
    if (gpa < 0 || gpa > 4) {
        e.preventDefault();
        alert('GPA must be between 0 and 4');
        return false;
    }
    
    return true;
});

// Real-time GPA validation
document.getElementById('gpa').addEventListener('input', function(e) {
    const value = parseFloat(e.target.value);
    if (value > 4) {
        e.target.value = 4;
    } else if (value < 0) {
        e.target.value = 0;
    }
});

// Add animation to form inputs
const inputs = document.querySelectorAll('input, select');
inputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.style.transform = 'scale(1.02)';
    });
    
    input.addEventListener('blur', function() {
        this.style.transform = 'scale(1)';
    });
});