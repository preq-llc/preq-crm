    // Auto logout user inactivity  --------------------------------------------------------
    
    var inactivityTime = 3600000;
    // var inactivityTime = 3000;

    var timeout;

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(logoutUser, inactivityTime);
    }

    function logoutUser() {
        
        console.log("User is inactive. Logging out...");
        window.location.href="logout.php?autologout";
    }

    // Reset the timer on user activity
    $(document).on('mousemove keydown scroll', function() {
        resetTimer();
    });

    // Initialize timer
    resetTimer();