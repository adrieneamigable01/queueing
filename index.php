
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queueing System</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffff; /* Soft light gray background */
            padding-top: 30px;
        }
        
        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        h4 {
            font-weight: 500;
            color: #2c3e50; /* Darker shade for headings */
        }

        .queue-item {
            border: 1px solid #e0e0e0; /* Light gray border */
            border-radius: 8px;
            padding: 10px 30px 10px 30px;
            background-color: #ffffff;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .queue-item:hover {
            transform: translateY(-5px);
        }

        .queue-counter{
            text-align: center;  /* For centering inline content */
            font-size: 1.5rem;
        }
        .queue-counter > .queue-teller-number{
            color: #ED1C16;
            font-weight: 900;
        }

        .pending {
            display: flex;
            justify-content: space-between; /* Align content to both sides */
            align-items: center;     /* Centers content vertically */
        }

        .onqueue {
            border: 1px solid #e0e0e0; /* Light gray border */
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .onqueue > .queue-name {
            font-size: 1rem;
            color: #000000; /* Darker shade for text */
        }

        .queue-name {
            font-size: 2rem;
            font-weight: bolder;
        }

        .teller-section {
            text-align: left; /* Align left */
            margin-bottom: 30px;
        }

        .teller {
            border: 2px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            font-size: 1.5rem;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .teller:hover {
            transform: translateY(-5px);
        }

        /* Flexbox Layout */
        .row {
            display: flex;
            justify-content: space-between; /* Align content to both sides */
        }

        /* Styling for the left column */
        .left-column {
            text-align: left; /* Align to left */
            padding: 20px;
            width: 25%; /* Left column set to 25% */
        }

        /* Styling for the right column */
        .right-column {
            text-align: left;
            font-size: 1.25rem;
            height: auto;
            overflow-y: auto;
            padding-left: 30px;
            width: 70%; /* Right column set to 70% */
        }

        .video-ad {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 400px; /* Increased height for the video ad */
        }

        /* Style for the ads in the running message */
        .running-message p {
            white-space: nowrap;  /* Ensure the message doesn't wrap */
            overflow: hidden;     /* Hide overflow */
            position: relative;
            display: inline-block;
            width: 100%;
        }

        /* Add the scrolling animation */
        @keyframes scroll-left {
            0% {
                transform: translateX(100%);  /* Start from the right side */
            }
            100% {
                transform: translateX(-100%); /* Scroll to the left side */
            }
        }

        .ad {
            display: inline-block;
            margin-right: 50px;  /* Add spacing between ads */
            font-size: 1.25rem;   /* Set font size */
            color: #333;          /* Set color */
        }


        .logo {
            position: fixed;
            bottom: 20px; /* Adjust the distance from the bottom */
            right: 20px; /* Adjust the distance from the right */
            margin-bottom: 0;
            z-index: 1000; /* Ensures the logo stays on top */
        }

        .logo img {
            max-width: 200px;
            height: auto;
        }


        #queue-list {
 
        }
        .ns {
            font-size: 45px;
            color: #ED1C16;
        }
        .ns > .now{
            font-weight: 100;
        }
        .ns > .serving{
            font-weight: bolder;
        }
    </style>
</head>
<body>

<div class="container mt-5">
     <!-- Date and Time Section -->
     <div id="date-time" class="mt-3" style="font-size: 2.25rem; color: #333;font-weight: bolder;">
        <!-- Date and Time will be populated here by JS -->
    </div>
    <!-- Logo Section -->
    <div class="logo">
        <img src="bplc-ogo2.png" alt="Logo">
    </div>
    <div class="running-message">
        <p>
           
        </p>
    </div>
    <div class="teller-section">
        <div class="row">
            <!-- Left Column: Queue Items -->
            <div class="col-lg-7 left-column">
                <div class="ns">
                    <span class="now">NOW</span> <span class="serving">SERVING</span>
                </div>
                <div style="height: auto;min-height: 60%;">
                    <div id="teller1"></div>
                    <div id="teller2"></div>
                </div>  

                <div  style="height: auto;">
                    <div class="ns">
                        <span class="now">WAITING</span> <span class="serving">LIST</span>
                    </div>
                    <div id="queue-list"></div>
                </div>
            </div>

            <!-- Right Column: Video Ad -->
            <div class="col-lg-5 right-column">
                <div class="row">
                    <div class="col-12">
                        <div class="video-ad">
                            <!-- Placeholder for a single video ad -->
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/gqI9MB221kw?autoplay=1&mute=1" title="He Have No Fear | Just For Laughs Gags" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                    
                </div>
               
            </div>
        </div>

        <!-- Running Message Below -->
        
    </div>
</div>

<!-- Bootstrap 4 JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<!-- AJAX Script to pull the queue data -->
<script>
    function fetchQueueData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'https://queue.doitcebu.com/get_queue.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    // Clear current data
                    $('#queue-list').empty();
                    $('#teller1').empty();
                    $('#teller2').empty();
                    let queueItemClassPending = 'queue-item pending';
                    // Variables to store Teller 1 and Teller 2 data and count
                   
                    let pendingCount = 0;
                    let count = 1;
                    let width = 60;
                    let teller1Data = "";
                    let teller2Data = "";
                    // Loop through each item in the data
                    if (Object.keys(data).length > 0) {
                    
                        $.each(data, function(k, item) {
                            // Check if the status is 'Pending'
                        
                            if (item.status === 'Pending') {

                                let isPrioClass = item.queue_type == "Priority" ? 'fa fa-person-walking-with-cane' : 'fa fa-user';

                            
                                const queueItemPending = `<div class="${queueItemClassPending}">
                                                            <p class="queue-name">${item.name}</p>
                                                            <strong class="pending">
                                                                <i class="${isPrioClass} mr-5" style="font-size:2rem"></i>
                                                                <div class="queue-counter">
                                                                    <p>Teller</p> 
                                                                    <p class="queue-teller-number">${item.teller_number}</p> 
                                                                </div>
                                                            </strong>
                                                        </div>`;

                                // Assign the first two "Pending" items to Teller 1 and Teller 2
                                if (item.teller_number == 1) {
                                    teller1Data = queueItemPending;
                                } else if (item.teller_number == 2) {
                                    teller2Data = queueItemPending;
                                }

                                // If the item has not been announced yet, announce it
                                if (item.isAnnounce == 0) {
                                    announceServing(item);
                                }

                                // Append the pending item to the main queue list
                                appendQueueItem(queueItemPending);
                            } else if (item.status === null) {
                                let queueItemClass = 'queue-item onqueue';
                            
                                width = width - 10;
                                
                                let isPrioClass = item.queue_type == "Priority" ? 'fa fa-person-walking-with-cane' : 'fa fa-user';

                                if(count <= 3){
                                    const queueItem = `<div class="${queueItemClass} pending " style="width:${width}%">
                                                            <p class="queue-name">${item.name}</p>
                                                            <i class="${isPrioClass}" style="font-size:1.5rem"></i>
                                                        </div>`;
                                    $('#queue-list').append(queueItem);
                                }

                                count++;
                                
                            }else{

                            }
                            
                            if (Object.keys(data).length - 1 == k) {
                                resolve(true);
                            }
                        });

                        // Display the pending queue items for Teller 1 and Teller 2
                        $('#teller1').html(teller1Data);
                        $('#teller2').html(teller2Data);
                    }else{
                        resolve(true);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }).then(() => {
            setTimeout(() => {
                fetchQueueData();
            }, 1000);
        });
    }


    function appendQueueItem(queueItem) {
        // Append the queue item to the main queue list (the element with ID 'queue-list')
        // $('#queue-list').append(queueItem);
    }

    function updateAnnouncement(serving_id, isAnnounce) {
        $.ajax({
            url: 'https://queue.doitcebu.com/update_announcement.php',
            method: 'POST',
            data: {
                serving_id: serving_id,
                isAnnounce: isAnnounce
            },
            success: function(response) {
                let result = JSON.parse(response);
                if (result.status === 'success') {
                    console.log(result.message);
                } else {
                    console.log(result.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    function announceServing(queue) {
        const speech = new SpeechSynthesisUtterance();
        speech.text = `Now serving queue number ${queue.queue_number}, ${queue.name}.`;
        speech.lang = 'en-US'; // You can change the language if needed
        window.speechSynthesis.speak(speech);

        setTimeout(() => {
            updateAnnouncement(queue.serving_id,1)
        }, 1000);
    }

    function updateDateTime() {
        const dateTimeElement = document.getElementById('date-time');
        const currentDate = new Date();

        // Format date and time (e.g., Feb 07, 2025 03:25 PM)
        const formattedDateTime = currentDate.toLocaleString('en-US', {
            weekday: 'long', // Full weekday name
            year: 'numeric',
            month: 'short', // Abbreviated month
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true // 12-hour clock format
        });

        // Update the content of the date-time div
        dateTimeElement.textContent = formattedDateTime;
    }

    function fetchAds() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'https://queue.doitcebu.com/get_ads.php',  // The PHP file that fetches the ads from the database
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.isError === false) {
                        resolve(response.data);  // Return the ad data array
                    } else {
                        console.log("No ads found.");
                        resolve([]);  // Resolve with an empty array if no ads are found
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    resolve([]);  // Resolve with an empty array in case of an error
                }
            });
        });
    }

    async function displayAds(ads) {
    const runningMessageElement = document.querySelector('.running-message p');
    let currentAdIndex = 0;
    let adsDisplay = 0;

    // Function to create the running message HTML
    function createAdElement(adText) {
        const adElement = document.createElement('span');
        adElement.classList.add('ad');
        adElement.textContent = adText;
        return adElement;
    }

    // Function to handle scrolling and animation
    async function scrollAds() {
        for (let index = 0; index < ads.length; index++) {
            const element = ads[index];
            const currentAd = element.queue_ads;

            // Clear the previous ad and append the new one
            runningMessageElement.innerHTML = ''; // Clear previous content
            const adElement = createAdElement(currentAd);
            runningMessageElement.appendChild(adElement);

            // Add the animation
            adElement.style.animation = "scroll-left 15s linear forwards";  // 15s for scroll duration

            // Wait for the animation to end before moving to the next ad
            await new Promise(resolve => {
                adElement.addEventListener('animationend', resolve);
            });

            // Move to the next ad
            currentAdIndex = (currentAdIndex + 1) % ads.length;  // Loop back to the first ad if last is reached
        }

        // After all ads are done, re-fetch ads after 5 seconds
        setTimeout(async () => {
            const newAds = await fetchAds();
            if (newAds.length > 0) {
                displayAds(newAds);  // Display new ads
            } else {
                runningMessageElement.textContent = "No ads available.";
            }
        }, 5000);  // Wait 5 seconds before re-fetching the ads
    }

    // Start the ad scrolling
    scrollAds();
}

   
    


    $(document).ready(function() {
        fetchQueueData();
        fetchAds().then(ads => {
            displayAds(ads);
        });

        setInterval(updateDateTime, 1000);
    });
</script>
</body>
</html>
