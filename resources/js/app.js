import './bootstrap';
import $ from 'jquery';
window.$ = $;
window.jQuery = $;
import 'select2';
import 'select2/dist/css/select2.min.css';

$(document).ready(function() {
    $('.my-select').select2();
});

window.sendMessage = function() {
    const message = document.getElementById('message').value;

    fetch("/send-message", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message })
    });
};

window.Echo.channel('chat')
    .listen('MessageSent', (e) => {
        let messages = document.getElementById('messages');
        messages.innerHTML += `<p><strong>${e.user}:</strong> ${e.message}</p>`;
    });
