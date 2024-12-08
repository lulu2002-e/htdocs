document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const conflictStatus = document.getElementById('conflict-status');
    
    // Check for conflicts when date or time changes
    ['date', 'start_time', 'end_time'].forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('change', checkConflicts);
    });

    function checkConflicts() {
        const formData = new FormData(bookingForm);
        if (!formData.get('date') || !formData.get('start_time') || !formData.get('end_time')) return;

        fetch('check_conflicts.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.hasConflict) {
                conflictStatus.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> 
                        There is a booking conflict at this time.
                    </div>`;
            } else {
                conflictStatus.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        This time slot is available!
                    </div>`;
            }
        });
    }

    // Form submission handler
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if there's a conflict (you'll need to implement the actual conflict checking logic)
        const hasConflict = checkForConflict(); // This is a placeholder function
        const messageDiv = document.getElementById('booking-message');
        
        if (!hasConflict) {
            messageDiv.className = 'alert alert-success';
            messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> Booking confirmed successfully!';
            messageDiv.classList.remove('d-none');
            
            // Optional: Disable the confirm button after successful booking
            document.getElementById('confirmBtn').disabled = true;
        } else {
            messageDiv.className = 'alert alert-danger';
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Cannot confirm booking due to conflict!';
            messageDiv.classList.remove('d-none');
        }
    });

    // Add modify button listener
    document.getElementById('modifyBtn').addEventListener('click', function() {
        window.location.href = 'rooms-view.html';
    });

    // Add cancel button listener
    document.getElementById('cancelBtn').addEventListener('click', function() {
        window.location.href = 'homepage.html';
    });

    // Placeholder function - implement actual conflict checking logic
    function checkForConflict() {
        // This should be replaced with your actual conflict checking logic
        // For now, it returns a random boolean
        return Math.random() < 0.5;
    }

    document.querySelectorAll('.room-image img').forEach(img => {
        img.addEventListener('click', function() {
            const modal = document.querySelector('.modal');
            const modalImg = modal.querySelector('img');
            const roomId = this.getAttribute('data-room-id');
            
            // Fetch and display room number and description
            fetch(`get_room_details.php?room_id=${roomId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('room-number').textContent = data.room_number;
                        document.getElementById('room-description').textContent = data.description;
                    }
                })
                .catch(error => console.error('Error:', error));

            modal.classList.add('active');
            modalImg.src = this.src;
        });
    });

    document.querySelector('.modal-close').addEventListener('click', function() {
        document.querySelector('.modal').classList.remove('active');
    });

    document.querySelector('.modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
