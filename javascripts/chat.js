/**
 * Main front-end scoping object
 * @type {Object}
 */
var App = {

    /**
     * Bootstrap the front-end code
     * @return {undefined}
     */
    init: function() {
        // Bind event handler for chat message submission
        document.querySelector('#client').addEventListener('submit', App.send);

        // Start polling for updates
        App.poll();
    },

    /**
     * Sends a chat message to the server
     * if all required fields are filled
     * @param  {Event} event
     * @return {undefined}
     */
    send: function(event) {
        event.preventDefault();

        // Check for required parameters
        var name = document.querySelector('#name').value;
        if (! name) {
            alert('Please add your name to send messages');
            return;
        }

        var message = document.querySelector('#message').value;
        if (! message) {
            alert('You cannot send empty messages');
            return;
        }

        // Send message to server
        var request = new XMLHttpRequest();
        request.open('POST', '/chat', true);
        request.setRequestHeader('Content-Type', 'application/json;charset=utf-8');
        request.send(JSON.stringify({message: message, name: name}));
    },

    /**
     * Poll for updates to chat
     * @return {undefined}
     */
    poll: function() {
        var request = new XMLHttpRequest();
        request.open('GET', '/chat', true);

        request.onload = function(){
            if (request.status >= 200 && request.status < 400) {
                App.renderNewMessages(JSON.parse(request.responseText));
                setTimeout(App.poll, 1000);
            }
            else {
                App.fatalError();
            }
        };
        request.onerror = App.fatalError;

        request.send();
    },

    /**
     * Notify the user a fatal error has occured
     * @return {undefined}
     */
    fatalError: function() {
        alert('A unknown fatal error happened. Reload and try again, or contact support');
    },

    /**
     * Renders new messages in the UI
     * @param  {Array} messages
     * @return {undefined}
     */
    renderNewMessages: function(messages) {
        var chat = document.querySelector('#chat');
        for (var i = 0; i <= messages.length; i++) {
            var line = document.createElement('li');
            line.innerHTML = '<strong>' + messages[i].name + ':</strong> ' + messages[i].message;
            chat.appendChild(line);
        }
    }
};

// Run app on page load
if (document.readyState != 'loading'){
    App.init();
}
else {
    document.addEventListener('DOMContentLoaded', App.init);
}
