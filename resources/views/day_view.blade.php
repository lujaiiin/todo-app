@extends('layouts.app')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dai1.css') }}"> 
</head>
<div class="container">
    
    <h1>ToDay story</h1>


    <!-- Form for writing new entries -->
<form action="/day/{{ $day_id }}" method="POST">  
    @csrf
    @method('PUT')
    <textarea id="new_entry" name="updated_entry" class="form-control" rows="5" placeholder="Write something...">@if(isset($latestEntry)){{ $latestEntry->content }}
    @endif
    </textarea>
    <button type="submit" class="btn btn-primary mt-3">{{ isset($latestEntry)? 'Update Entry' : 'Save Entry' }}</button>
    <a href="/dailay" class="btn btn-primary mt-3">Back </a>
    <button id="publishBtn" class="btn">Publish</button>
    <div id="screenshotContainer" style="display:none;"></div>

</form>


    
</div>
<script>

    /**publish */

    document.getElementById('publishBtn').addEventListener('click', function() {
        html2canvas(document.body).then(canvas => {
            // Convert canvas to data URL
            let imgURL = canvas.toDataURL("image/png");

            // Display the screenshot
            document.getElementById('screenshotContainer').innerHTML = `
                <img src="${imgURL}" />
                <div id="annotations"></div>
            `;
            
            // Show the screenshot container
            document.getElementById('screenshotContainer').style.display = 'block';
        });

        // Add download link
        let downloadLink = document.createElement('a');
        downloadLink.href = imgURL;
        downloadLink.download = 'screenshot.png';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink); // Clean up
    });

    // Simple annotation system
    document.getElementById('screenshotContainer').addEventListener('click', function(event) {
        event.preventDefault();
        let pos = getCursorPosition(event);
        let annotation = prompt("Enter your annotation:");
        if (annotation) {
            let annotationElement = document.createElement('div');
            annotationElement.textContent = annotation;
            annotationElement.style.position = 'absolute';
            annotationElement.style.left = `${pos.x}px`;
            annotationElement.style.top = `${pos.y}px`;
            annotationElement.style.backgroundColor = 'yellow';
            annotationElement.style.padding = '5px';
            document.getElementById('annotations').appendChild(annotationElement);
        }
    });

    function getCursorPosition(event) {
        let rect = event.target.getBoundingClientRect();
        let x = event.clientX - rect.left;
        let y = event.clientY - rect.top;
        return { x, y };
    }


    /**func */
// Function to fetch and display existing content in the textarea
function displayExistingContent(dayId) {
    fetch(`/day/${dayId}`)
       .then(response => response.json())
       .then(data => {
            if (data.content) {
                document.getElementById('new_entry').value = data.content;
            }
        })
       .catch(error => console.error('Error fetching existing content:', error));
}


</script>

@endsection
