<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="m-0 p-0 bg-black overflow-hidden flex items-center justify-center min-h-screen">

    {{-- Alert if user tries to bypass scan --}}
    @if (session('error'))
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded shadow-lg text-center">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- QR Reader --}}
    <div class="w-full h-full max-w-screen-sm">
        <div id="reader" class="w-full h-full rounded-lg border-4 border-white shadow-2xl"></div>
    </div>

    <script>
        const html5QrCode = new Html5Qrcode("reader");

        const config = {
            fps: 10,
            qrbox: { width: 300, height: 300 },
            aspectRatio: 1.777,
        };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText, decodedResult) => {
                console.log("Scanned QR:", decodedText);

                // Redirect only if QR contains specific keyword
                if (decodedText.includes("/offices")) {
                    html5QrCode.stop().then(() => {
                        window.location.href = "/redirect-after-scan";
                    }).catch(err => console.error("Failed to stop scanner:", err));
                } else {
                    alert("Invalid QR code: " + decodedText);
                }
            },
            (errorMessage) => {
                // You can handle scanning errors here if needed
                console.warn("QR Code scan error:", errorMessage);
            }
        ).catch(err => {
            console.error("Unable to start camera:", err);
            alert("Camera error: " + err);
        });
    </script>

</body>
</html>
