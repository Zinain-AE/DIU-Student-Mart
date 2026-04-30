<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DIU Student Mart</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Hind Siliguri', sans-serif; min-height: 100vh; background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 20px; }
        
        :root { --primary: #1e3a8a; --accent: #ea580c; }

        .register-card { background: white; border-radius: 24px; padding: 40px; width: 100%; max-width: 650px; box-shadow: 0 20px 50px rgba(30,58,138,0.1); border: 1px solid #f1f5f9; }
        .register-header { text-align: center; margin-bottom: 30px; }
        .register-header .logo { font-size: 45px; margin-bottom: 5px; }
        .register-header h2 { font-size: 28px; font-weight: 900; color: var(--primary); text-transform: uppercase; letter-spacing: -1px; }
        .register-header h2 span { color: var(--accent); }
        .register-header p { color: #94a3b8; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group.full { grid-column: 1 / -1; }
        
        .form-label { display: block; font-size: 11px; font-weight: 800; margin-bottom: 6px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
        .form-control {
            width: 100%; padding: 12px 16px;
            border: 2px solid #f1f5f9; border-radius: 12px;
            font-size: 14px; font-weight: 600; color: var(--primary); transition: all .2s; background: #f8fafc;
        }
        .form-control:focus { outline: none; border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(30,58,138,0.05); }
        
        /* Role Selector Updates */
        .role-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .role-option { display: none; }
        .role-label {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px; border: 2px solid #f1f5f9; border-radius: 14px;
            cursor: pointer; font-size: 14px; font-weight: 700; transition: all .2s; color: #64748b;
        }
        .role-option:checked + .role-label { border-color: var(--primary); background: #eff6ff; color: var(--primary); }
        
        .btn-register {
            width: 100%; padding: 16px; background: var(--primary); color: white;
            border: none; border-radius: 14px; font-size: 14px; font-weight: 800;
            cursor: pointer; text-transform: uppercase; letter-spacing: 2px;
            margin-top: 20px; transition: all .3s; box-shadow: 0 10px 20px rgba(30,58,138,0.2);
        }
        .btn-register:hover { background: var(--accent); transform: translateY(-2px); box-shadow: 0 12px 25px rgba(234,88,12,0.2); }
        
        .error-msg { background: #fff1f2; color: #be123c; padding: 12px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 15px; border: 1px solid #ffe4e6; }
        .auth-link { text-align: center; margin-top: 20px; font-size: 13px; font-weight: 600; color: #94a3b8; }
        .auth-link a { color: var(--primary); font-weight: 800; text-decoration: none; border-bottom: 2px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <div class="logo">🛒</div>
            <h2>DIU STUDENT <span>MART</span></h2>
            <p>Join the Campus Marketplace</p>
        </div>

        @if($errors->any())
        <div class="error-msg">
            @foreach($errors->all() as $e)
            <div>• {{ $e }}</div>
            @endforeach
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <label class="form-label">Are you a Buyer or Seller?</label>
            <div class="role-selector">
                <div>
                    <input type="radio" name="is_seller" value="0" id="role_user" class="role-option" {{ old('is_seller','0')==='0'?'checked':'' }}>
                    <label for="role_user" class="role-label"><i class="fas fa-shopping-bag"></i> Customer</label>
                </div>
                <div>
                    <input type="radio" name="is_seller" value="1" id="role_seller" class="role-option" {{ old('is_seller')==='1'?'checked':'' }}>
                    <label for="role_seller" class="role-label"><i class="fas fa-store"></i> Seller</label>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your name" required>
                </div>
                
                <div class="form-group full">
                    <label class="form-label">DIU Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="yourname@diu.edu.bd" required pattern=".+@diu\.edu\.bd" title="Please use @diu.edu.bd only">
                </div>

                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-control" value="{{ old('student_id') }}" placeholder="232-35-XXXX" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-control" required>
                        <option value="">Choose Dept.</option>
                        <option value="CSE" {{ old('department')==='CSE'?'selected':'' }}>CSE</option>
                        <option value="SWE" {{ old('department')==='SWE'?'selected':'' }}>SWE</option>
                        <option value="EEE" {{ old('department')==='EEE'?'selected':'' }}>EEE</option>
                        <option value="BBA" {{ old('department')==='BBA'?'selected':'' }}>BBA</option>
                        <option value="CIS" {{ old('department')==='CIS'?'selected':'' }}>CIS</option>
                        <option value="English" {{ old('department')==='English'?'selected':'' }}>English</option>
                        <option value="MCT" {{ old('department')==='MCT'?'selected':'' }}>MCT</option>
                        <option value="ITM" {{ old('department')==='ITM,'?'selected':'' }}>ITM</option>
                        <option value="Agriculture" {{ old('department')==='Agriculture'?'selected':'' }}>Agriculture</option>
                        <option value="NFE" {{ old('department')==='NFE'?'selected':'' }}>NFE</option>
                        <option value="TE" {{ old('department')==='TE'?'selected':'' }}>TE</option>
                        <option value="CE" {{ old('department')==='CE'?'selected':'' }}>CE</option>
                        <option value="Architecture" {{ old('department')==='Architecture'?'selected':'' }}>Architecture</option>
                        <option value="JMC" {{ old('department')==='JMC'?'selected':'' }}>JMC</option>
                        <option value="ESDM" {{ old('department')==='ESDM'?'selected':'' }}>ESDM</option>
                        <option value="THM" {{ old('department')==='THM'?'selected':'' }}>THM</option>
                        <option value="Innovation" {{ old('department')==='Innovation'?'selected':'' }}>Innovation</option>
                        <option value="Real-Estate" {{ old('department')==='Real-Estate'?'selected':'' }}>Real-Estate</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Semester</label>
                    <input type="text" name="semester" class="form-control" value="{{ old('semester') }}" placeholder="e.g.Spring-2023" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Batch</label>
                    <input type="text" name="batch" class="form-control" value="{{ old('batch') }}" placeholder="e.g. 6th" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 chars" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-rocket"></i> Create Account
            </button>
        </form>

        <div class="auth-link">Already a member? <a href="{{ route('login') }}">Log in here</a></div>
    </div>
</body>
</html>