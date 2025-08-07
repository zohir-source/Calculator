<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        input { font-size: 24px; text-align: right; width: 100%; }
        button { width: 60px; height: 60px; font-size: 20px; margin: 5px; }
        .container { max-width: 300px; margin: auto; }
    </style>
</head>
<body>
    <div class="container">
        <input type="text" id="display" readonly value="0">
        <div id="buttons">
            <!-- Baris angka dan operator -->
            <div>
                <button onclick="press('7')">7</button>
                <button onclick="press('8')">8</button>
                <button onclick="press('9')">9</button>
                <button onclick="press('/')">/</button>
            </div>
            <div>
                <button onclick="press('4')">4</button>
                <button onclick="press('5')">5</button>
                <button onclick="press('6')">6</button>
                <button onclick="press('-')">-</button>
            </div>
            <div>
                <button onclick="press('1')">1</button>
                <button onclick="press('2')">2</button>
                <button onclick="press('3')">3</button>
                <button onclick="press('+')">+</button>
            </div>
            <div>
                <button onclick="clearOne()">C</button>
                <button onclick="press('0')">0</button>
                <button onclick="calculate()">=</button>
                <button onclick="clearAll()">AC</button>
            </div>
        </div>
    </div>

    <script>
        let display = document.getElementById('display');

        function press(value) {
            if (display.value === '0' || display.value === 'ERR') {
                display.value = value;
            } else if (display.value.length < 8) {
                display.value += value;
            }
        }

        function clearOne() {
            display.value = display.value.slice(0, -1) || '0';
        }

        function clearAll() {
            display.value = '0';
        }

        function calculate() {
            fetch('{{ route('calculate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ display: display.value })
            })
            .then(res => res.json())
            .then(data => display.value = data.result);
        }
    </script>
</body>
</html> 