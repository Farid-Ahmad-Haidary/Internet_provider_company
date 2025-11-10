VULNERABLE Internet ISP MIS (for offline educational use ONLY)

WARNING:
- This project is intentionally insecure: SQL injection, plaintext passwords, missing CSRF, weak access control, XSS surfaces.
- Run only in an isolated local machine (VM or disconnected PC). DO NOT expose to network or internet.
- After testing, remove the project and DB.

Setup (XAMPP on Windows):
1. Copy the extracted folder into C:\xampp\htdocs\internet_isp
2. Import SQL: open phpMyAdmin and run the SQL from sql/init.sql OR run:
   "C:\xampp\mysql\bin\mysql.exe" -u root < "C:\path\to\internet_isp_vuln_ready\sql\init.sql"
3. Open in browser: http://localhost/internet_isp/index.php?p=setup  (run once)
   It will create:
    - admin / admin123
    - worker login like worker{ID} / worker123
    - customer login like customer{ID} / cust123
   After running setup, DELETE pages/setup.php for safety.
4. Login at: http://localhost/internet_isp/index.php?p=login

Notes:
- Admin can create/edit/delete workers and customers. When admin creates a worker/customer the system also creates a users login with username = worker{ID} or customer{ID}.
- Workers can log in (their username is worker{ID}) and edit their profile except salary which is readonly.
- Customers can log in (username customer{ID}) and view only their details.
- This app is for learning how to test and fix common web vulnerabilities. I will NOT provide exploit payloads, but I can help you secure the app after your testing if you ask 'secure-me'.
