@if (session('message'))
    <div id="custom-swal" class="swal2-container swal2-center swal2-backdrop-show" style="overflow-y: auto;">
        <div aria-labelledby="swal2-title" aria-describedby="swal2-html-container" class="swal2-popup swal2-modal swal2-icon-success swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: grid;">
            <button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
            <ul class="swal2-progress-steps" style="display: none;"></ul>
            <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                <span class="swal2-success-line-tip"></span>
                <span class="swal2-success-line-long"></span>
                <div class="swal2-success-ring"></div>
                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
            </div>
            <img class="swal2-image" style="display: none;">
            <h2 class="swal2-title" id="swal2-title" style="display: none;"></h2>
            <div class="swal2-html-container" id="swal2-html-container" style="display: block;">{{ session('message') }}</div>
            <div class="swal2-actions" style="display: flex;">
                <div class="swal2-loader"></div>
                <button type="button" id="ok-btn" class="swal2-confirm btn btn-primary" aria-label="" style="display: inline-block;">Ok</button>
            </div>
            <div class="swal2-footer" style="display: none;"></div>
            <div class="swal2-timer-progress-bar-container">
                <div class="swal2-timer-progress-bar" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
        // OK tugmasini bosganda xabarni yo'q qilish
        document.getElementById('ok-btn').addEventListener('click', function() {
            document.getElementById('custom-swal').style.display = 'none';
        });

        // 5 sekunddan keyin xabarni avtomatik yo'q qilish
        setTimeout(function() {
            document.getElementById('custom-swal').style.display = 'none';
        }, 5000); // 5000 millisekund = 5 sekund
    </script>
@endif
