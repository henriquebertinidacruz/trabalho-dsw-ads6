document.addEventListener("DOMContentLoaded", function() {
    var session = "<?php echo $_SESSION; ?>"; 
    
    function hideButtons(visibility) {
        var buttons = document.querySelectorAll('.btn.btn-primary');
        buttons.forEach(function(button) {
            button.style.display = visibility;
        });
    }
    
    if (session === "Producao") {
        hideButtons('none');
    } else {
        hideButtons('block');
    }
});
