@extends('layouts.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
</head>
<body>

<div class="image" style="background-image: url('{{ asset('images/blue.jpg') }}');"></div>
<div class="row mt-4">
    <div class="col-md-12">
        
        <!-- Add New Task Button -->
        

        <!-- Initially Hidden Create Task Form -->
        <div id="createTaskForm" style="display:none;">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <!-- Deadline Input -->
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                </div>
                <button type="submit" class="btn">Save</button><button type="button" class="btn" id="cancelBtn">Cancel</button>
            </form>
        </div>

        <!-- Existing Tasks Table and Other Content -->
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-12 table-container">
                    <table class="table table-striped">
                    <h2>All Tasks</h2> <button id="addTaskBtn" class="btn">Add New Task</button>
                    
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Deadline</th>
                                <th>Complete?</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @if($task->deadline)
                                        <span id="deadline-{{ $task->id }}" class="countdown">{{ $task->deadline->diffForHumans() }}</span>
                                    @else
                                        No Deadline
                                    @endif
                                </td>
                                <td>
                                    <div class="checkbox-wrapper-11">
                                     <input type="checkbox" id="taskCheckbox-{{ $task->id }}" data-task-id="{{ $task->id }}" {{ $task->is_completed? 'checked' : '' }} onchange="updateTaskCompletion(this, {{ $task->id }})">
                                     <label for="02-11">Done</label>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    
                    <a href="/todo" class="btn">Back </a>
                </div>
                
            </div>
        </div>
    </div>
</div>
<button id="publishBtn" class="btn">Publish</button>
<div id="screenshotContainer" style="display:none;"></div>

<script>
    /**save screen */

    document.getElementById('publishBtn').addEventListener('click', function() {
        html2canvas(document.body).then(canvas => {
            let imgURL = canvas.toDataURL("image/png");
            fetch('/save-screenshot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/octet-stream',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: imgURL
            }).then(response => {
                if (response.ok) {
                    alert('Screenshot saved successfully.');
                } else {
                    alert('Failed to save screenshot.');
                }
            });
        });
    });

    /**screanshot */

   document.getElementById('publishBtn').addEventListener('click', function() {
        html2canvas(document.body).then(canvas => {
            // Convert canvas to data URL
            let imgURL = canvas.toDataURL("images/screenshots");

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


    /**move */

document.querySelectorAll('.table tr').forEach(function(row) {
  row.addEventListener('mouseover', function() {
    this.style.transform = 'scale(1.05)';
  });

  row.addEventListener('mouseout', function() {
    this.style.transform = 'scale(1)';
  });
});



    /**form */
    document.getElementById('addTaskBtn').addEventListener('click', function() {
    var form = document.getElementById('createTaskForm');
    form.style.transform = 'translateY(0)'; // Move the form into view
});
document.getElementById('cancelBtn').addEventListener('click', function() {
    var form = document.getElementById('createTaskForm');
    form.style.transform = 'translateY(100%)'; // Move the form off-screen
});


    document.getElementById('addTaskBtn').addEventListener('click', function() {
    var form = document.getElementById('createTaskForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    }
});

/**buttons */

document.getElementById('addTaskBtn').addEventListener('click', function() {
    document.getElementById('createTaskForm').style.display = 'block';
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('createTaskForm').style.display = 'none';
});


   
    
    /**check */


function updateTaskCompletion(checkbox, taskId) {
    const isCompleted = checkbox.checked;
    const url = `/tasks/${taskId}/toggle-completion`; 

    fetch(url, {
        method: 'PUT', // or 'PATCH'
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Ensure CSRF token is sent for security
        },
        body: JSON.stringify({
            is_completed: isCompleted,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert('Task completion status updated successfully!');
             // Reload the page to reflect the change
        } else {
           // alert('Failed to update task completion status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


/*count down*/
document.addEventListener("DOMContentLoaded", function() {
    // Iterate over each task
    @foreach($tasks as $task)
    var countdownElement = document.getElementById('deadline-{{ $task->id }}');
    var deadline = new Date('{{ $task->deadline->toDateTimeString() }}');
    
    var update = setInterval(function() {
        var now = new Date().getTime();
        var distance = deadline - now;
        
        if (distance <= 0) {
            clearInterval(update);
            countdownElement.innerHTML = "EXPIRED";
            return;
        }
    
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    }, 1000);

    @endforeach
});

document.getElementById('viewScreenshotsBtn').addEventListener('click', function() {
        window.location.href = '/view-screenshots'; // Redirect to a page that displays saved screenshots
    });

</script>

