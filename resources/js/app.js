import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

function escapeHtml(value) {
    const element = document.createElement('div');
    element.textContent = value;
    return element.innerHTML;
}

function initializeNotifications() {
    const notificationElement =
        document.getElementById('app-notifications');

    if (notificationElement) {
        const successMessage =
            notificationElement.dataset.success || '';

        const errorMessage =
            notificationElement.dataset.error || '';

        const validationMessages = Array.from(
            notificationElement.querySelectorAll(
                '[data-validation-error]'
            )
        ).map((element) => element.textContent.trim());

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: successMessage,
                confirmButtonText: 'Oke',
                confirmButtonColor: '#4f46e5',
            });
        } else if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: errorMessage,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#dc2626',
            });
        } else if (validationMessages.length > 0) {
            const errorList = validationMessages
                .map((message) => {
                    return `
                        <li style="margin-bottom: 8px;">
                            ${escapeHtml(message)}
                        </li>
                    `;
                })
                .join('');

            Swal.fire({
                icon: 'warning',
                title: 'Periksa kembali data',
                html: `
                    <ul style="text-align: left; padding-left: 20px;">
                        ${errorList}
                    </ul>
                `,
                confirmButtonText: 'Perbaiki',
                confirmButtonColor: '#d97706',
            });
        }
    }

    document.querySelectorAll('.delete-form').forEach((form) => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const dataName =
                this.dataset.name || 'Data ini';

            Swal.fire({
                icon: 'warning',
                title: 'Hapus data?',
                text: `${dataName} akan dihapus secara permanen.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initializeNotifications
    );
} else {
    initializeNotifications();
}

const themeToggle = document.getElementById('theme-toggle');

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');

        if (document.documentElement.classList.contains('dark')) {
            localStorage.theme = 'dark';
        } else {
            localStorage.theme = 'light';
        }
    });
}