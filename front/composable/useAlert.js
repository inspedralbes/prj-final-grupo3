import Swal from 'sweetalert2';

export function useAlert() {
    const customAlert = (text, color, icon, position, time) => {
        Swal.fire({
            text: text,
            icon: icon, // Icon (info, success, warning, error, question)
            position: position, // Positionalert ('top', 'top-start', 'center', etc.)
            timer: time,
            showConfirmButton: false, // Hideen confirm button
            toast: position !== 'center',
            background: color,
            timerProgressBar: true,
        });
    };

    return {
        customAlert
    }
}