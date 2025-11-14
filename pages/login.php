<?php include __DIR__ . '/../includes/db.php'; ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <style>
        :root {
            --primary: #0b94886e;
            --secondary: #06706a;
            --dark: #044c47;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: #fff; /* پس‌زمینه سفید */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #ffffffee;
            padding: 35px;
            width: 340px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.5s ease-in-out;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--dark);
            letter-spacing: 1px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: var(--dark);
        }

        input {
            width: 100%;
            padding: 10px;
            border: 2px solid var(--primary);
            border-radius: 8px;
            margin-bottom: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: var(--dark);
            box-shadow: 0 0 6px rgba(11,148,136,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .error {
            width: 100%;
            padding: 10px;
            background: #ff4d4d;
            color: white;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>
<body>

    <div class="card">
        <h2>KHAWAR BRIDGE</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = $_POST['username'] ?? '';
            $p = $_POST['password'] ?? '';
            
            // SQL Injection vulnerability for practice/testing
            $sql = "SELECT id, username, password, role FROM users WHERE username = '$u' AND password = '$p' LIMIT 1";
            $res = $mysqli->query($sql);
            
            if ($res && $row = $res->fetch_assoc()) {
                $_SESSION['user'] = $row;
                header('Location: index.php?p=dashboard');
                exit;
            } else {
                $err = 'Wrong credentials';
            }
        }

        if (!empty($err)) {
            echo '<div class="error">' . htmlspecialchars($err) . '</div>';
        }
        ?>

        <form method="post" autocomplete="off">
            <label>Username</label>
            <input name="username">

            <label>Password</label>
            <input name="password" type="password">

            <button>Login</button>
        </form>
    </div>

</body>
</html>
