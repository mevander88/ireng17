{{-- Komponen Popup Alert Responsive untuk Mobile dan Desktop --}}
@php
    // Kumpulkan semua error dari validation
    $allErrors = [];
    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            $allErrors[] = $error;
        }
    }
    $errorMessage = session('error');
    if (!empty($allErrors)) {
        $errorMessage = !empty($errorMessage) ? $errorMessage . '<br>' . implode('<br>', $allErrors) : implode('<br>', $allErrors);
    }
@endphp

@if(session('error') || session('success') || session('warning') || session('info') || $errors->any())
<script>
    $(document).ready(function() {
        @if(!empty($errorMessage))
            showAlertPopup('{{ addslashes($errorMessage) }}', 'error', 'Error');
        @elseif(session('success'))
            showAlertPopup('{{ addslashes(session('success')) }}', 'success', 'Berhasil');
        @elseif(session('warning'))
            showAlertPopup('{{ addslashes(session('warning')) }}', 'warning', 'Peringatan');
        @elseif(session('info'))
            showAlertPopup('{{ addslashes(session('info')) }}', 'info', 'Informasi');
        @endif
    });

    function showAlertPopup(message, type, title) {
        // Tentukan icon berdasarkan type
        let icon = 'error';
        if (type === 'success') icon = 'success';
        else if (type === 'warning') icon = 'warning';
        else if (type === 'info') icon = 'info';
        
        // Tentukan warna button berdasarkan type
        let buttonColor = '#d33'; // default error
        if (type === 'success') buttonColor = '#28a745';
        else if (type === 'warning') buttonColor = '#ffc107';
        else if (type === 'info') buttonColor = '#17a2b8';
        
        // Gunakan SweetAlert2 yang sudah ada di aplikasi
        if (typeof Swal !== 'undefined') {
            // Replace <br> dengan newline untuk text, atau gunakan html jika perlu
            const displayMessage = message.replace(/<br\s*\/?>/gi, '\n');
            
            Swal.fire({
                title: title || 'Pemberitahuan',
                text: displayMessage, // Gunakan text untuk auto-escape HTML
                icon: icon,
                confirmButtonText: 'OK',
                confirmButtonColor: buttonColor,
                allowOutsideClick: true,
                allowEscapeKey: true,
                // Responsive settings
                width: window.innerWidth < 768 ? '90%' : '500px',
                padding: window.innerWidth < 768 ? '1rem' : '1.5rem',
                customClass: {
                    container: 'swal-responsive-container',
                    popup: 'swal-responsive-popup',
                    title: 'swal-responsive-title',
                    htmlContainer: 'swal-responsive-content',
                    confirmButton: 'swal-responsive-button'
                }
            });
        } else {
            // Fallback jika SweetAlert tidak tersedia
            alert(message.replace(/<br\s*\/?>/gi, '\n'));
        }
    }
</script>

<style>
    /* Responsive Popup Styles */
    .swal-responsive-container {
        padding: 10px !important;
    }
    
    .swal-responsive-popup {
        max-width: 100% !important;
        margin: 20px auto !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
    }
    
    @media (max-width: 768px) {
        .swal-responsive-popup {
            width: 90% !important;
            margin: 10px auto !important;
            padding: 1rem !important;
        }
        
        .swal-responsive-title {
            font-size: 1.2rem !important;
            margin-bottom: 0.8rem !important;
        }
        
        .swal-responsive-content {
            font-size: 0.9rem !important;
            line-height: 1.5 !important;
        }
        
        .swal-responsive-button {
            width: 100% !important;
            padding: 12px !important;
            font-size: 1rem !important;
            margin-top: 1rem !important;
        }
    }
    
    @media (min-width: 769px) {
        .swal-responsive-popup {
            width: 500px !important;
            padding: 1.5rem !important;
        }
        
        .swal-responsive-title {
            font-size: 1.5rem !important;
        }
        
        .swal-responsive-content {
            font-size: 1rem !important;
        }
    }
</style>
@endif
