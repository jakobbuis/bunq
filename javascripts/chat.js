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

    },
};

// Run app on page load
if (document.readyState != 'loading'){
    App.init();
}
else {
    document.addEventListener('DOMContentLoaded', App.init);
}
