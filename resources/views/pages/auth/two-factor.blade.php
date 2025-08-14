<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .otp-inputs input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #ccc;
            border-radius: 8px;
        }
        button {
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            background: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Verifikasi OTP</h2>
    <p>Masukkan 6 digit kode OTP yang telah dikirim ke email Anda</p>

    @if ($errors->any())
        <div style="color: red;">
            {{ $errors->first() }}
        </div>
    @endif
    <p>Kode OTP (debug): {{ session('two_factor_code') }}</p>
    <form method="POST" action="{{ route('two-factor.verify') }}">
        @csrf
        <div class="otp-inputs">
            <input type="text" maxlength="1" name="otp1" required>
            <input type="text" maxlength="1" name="otp2" required>
            <input type="text" maxlength="1" name="otp3" required>
            <input type="text" maxlength="1" name="otp4" required>
            <input type="text" maxlength="1" name="otp5" required>
            <input type="text" maxlength="1" name="otp6" required>
        </div>
        <input type="hidden" name="otp" id="otp">
        <button type="submit">Verifikasi</button>
    </form>
</div>

<script>
    const inputs = document.querySelectorAll('.otp-inputs input');
    const hiddenOtp = document.getElementById('otp');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            updateOtpValue();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && index > 0 && !input.value) {
                inputs[index - 1].focus();
            }
        });
    });

    function updateOtpValue() {
        hiddenOtp.value = Array.from(inputs).map(i => i.value).join('');
    }
</script>

</body>
</html>
