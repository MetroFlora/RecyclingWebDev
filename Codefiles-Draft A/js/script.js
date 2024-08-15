// script.js

document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('nav ul li a');

    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const target = e.target.getAttribute('href').substring(1);
            fetchPage(target);
        });
    });

    const fetchPage = (page) => {
        fetch(`${page}.html`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('main').innerHTML = data;
                window.history.pushState({page: page}, '', `${page}.html`);
            })
            .catch(err => console.error('Error loading page:', err));
    };

    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.page) {
            fetchPage(e.state.page);
        }
    });

    // Load the home page by default
    fetchPage('home');
});

// Existing JavaScript content

const chatBox = document.getElementById('chat-box');
const chatInput = document.getElementById('chat-input');

function sendMessage() {
    const userMessage = chatInput.value;
    if (userMessage.trim() !== '') {
        appendMessage('user-message', userMessage);
        chatInput.value = '';
        getBotResponse(userMessage);
    }
}

function appendMessage(type, message) {
    const messageElement = document.createElement('div');
    messageElement.className = `chat-message ${type}`;
    messageElement.innerText = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function getBotResponse(message) {
    // For demonstration, using a static response. Replace this with API call to a chatbot model.
    let botResponse = "I'm here to help you with recycling! Could you please specify your question?";

    if (message.toLowerCase().includes('recycling')) {
        botResponse = "Recycling helps to reduce waste and conserve natural resources. Do you need information on how to recycle specific items?";
    }

    setTimeout(() => {
        appendMessage('bot-message', botResponse);
    }, 1000);
}

function checkEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

