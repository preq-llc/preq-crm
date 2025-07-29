<?php

// Get the client's public IP address
$client_ip = $_SERVER['REMOTE_ADDR'];

// Get the server's IP address
$server_ip = $_SERVER['SERVER_ADDR'];
$remoteserver = $_SERVER['REMOTE_USER'];

// Compare the two IP addresses
if ($client_ip != $server_ip) {
    // Client is behind a NAT router, local IP address is not directly accessible
    $local_ip = null;
} else {
    // Client is on the same local network as the server, local IP address is the same as the server's IP address
    $local_ip = $client_ip;
}

echo "Client's public IP address: $client_ip<br>";
echo "Server's IP address: $server_ip<br>";
echo "Client's local IP address: $local_ip";
echo "Client's remoete serber: $remoteserver";

?>
<script>
    // Function to get local IP address
    function getLocalIPAddress() {
        // Create a new RTCPeerConnection
        const pc = new RTCPeerConnection();
        // Create a callback function to handle ICE candidate events
        pc.onicecandidate = (e) => {
            // Extract the IP address from the candidate
            const ip = e.candidate?.candidate.split(' ')[4];
            // Display the IP address
            console.log("Local IP Address:", ip);
            // Close the RTCPeerConnection
            pc.close();
        };
        // Create a dummy data channel to trigger ICE candidate gathering
        pc.createDataChannel('');
        // Return a promise resolved after gathering ICE candidates
        return pc.createOffer()
            .then(() => pc.setLocalDescription({ type: 'offer' }))
            .catch((err) => console.error("Error:", err));
    }

    // Call the function to get the local IP address
    getLocalIPAddress();
</script>
