function showError(message) {
    var errorDiv = document.createElement('div');
    errorDiv.innerHTML = message;
    errorDiv.className = 'error-message'; // Add a class for styling
    document.body.appendChild(errorDiv);
    setTimeout(function() {
        errorDiv.parentNode.removeChild(errorDiv);
    }, 1500);
}
