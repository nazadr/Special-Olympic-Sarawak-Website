document.addEventListener('DOMContentLoaded', function() {
    const sponsorshipForm = document.getElementById('sponsorshipForm');
    const sponsorshipImageInput = document.getElementById('sponsorshipImage');
    const sponsorshipImagePreview = document.getElementById('sponsorshipImagePreview');
    const sponsorshipImageStatus = document.getElementById('sponsorshipImageStatus');
    const deleteSponsorshipImageBtn = document.getElementById('deleteSponsorshipImageBtn');
    const sponsorshipsContainer = document.getElementById('currentSponsorship');

    // Load Sponsorships
    function loadSponsorships() {
        sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">Loading sponsorships...</p>';
        fetch('handler/admin_sponsorship_handler.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                sponsorshipsContainer.innerHTML = '';
                if (data.success && data.sponsorships.length > 0) {
                    data.sponsorships.forEach(sponsor => {
                        const sponsorshipItem = document.createElement('div');
                        sponsorshipItem.classList.add('sponsorship-item-admin');
                        sponsorshipItem.innerHTML = `
                            <img src="${sponsor.image_path}" alt="${sponsor.type}" class="sponsorship-item-admin-image">
                            <div class="sponsorship-item-admin-content">
                                <h4 class="sponsorship-item-admin-title">${sponsor.type}</h4>
                            </div>
                            <div class="news-item-admin-actions">
                                <button class="edit-btn" data-id="${sponsor.id}"><i class="fa-solid fa-pencil"></i></button>
                                <button class="delete-btn" data-id="${sponsor.id}"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        `;
                        sponsorshipsContainer.appendChild(sponsorshipItem);
                    });

                    // Edit button (implement as needed)
                    document.querySelectorAll('#currentSponsorship .edit-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const sponsorshipId = this.getAttribute('data-id');
                            alert('Edit sponsorship with ID: ' + sponsorshipId);
                            // Implement edit logic here
                        });
                    });

                    // Delete button
                    document.querySelectorAll('#currentSponsorship .delete-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const sponsorshipId = this.getAttribute('data-id');
                            if (confirm('Are you sure you want to delete this sponsorship?')) {
                                fetch('handler/admin_sponsorship_handler.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `action=delete&id=${sponsorshipId}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Sponsorship deleted successfully!');
                                        loadSponsorships();
                                    } else {
                                        alert('Error deleting sponsorship: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            }
                        });
                    });

                } else {
                    sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #64748b;">No sponsorships found.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading sponsorships:', error);
                sponsorshipsContainer.innerHTML = '<p style="text-align: center; color: #ef4444;">Failed to load sponsorships.</p>';
            });
    }

    // Sponsorship Form Submission
    if (sponsorshipForm) {
        sponsorshipForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add');
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sponsorship added successfully!');
                    sponsorshipForm.reset();
                    loadSponsorships();
                } else {
                    alert('Error adding sponsorship: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Sponsorship image preview and delete functionality
    if (sponsorshipImageInput) {
        sponsorshipImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                sponsorshipImageStatus.textContent = this.files[0].name;
                sponsorshipImageStatus.style.display = '';
                const reader = new FileReader();
                reader.onload = function(e) {
                    sponsorshipImagePreview.src = e.target.result;
                    sponsorshipImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
                if (deleteSponsorshipImageBtn) deleteSponsorshipImageBtn.style.display = 'inline-block';
            } else {
                sponsorshipImageStatus.textContent = 'No file selected.';
                sponsorshipImagePreview.src = '';
                sponsorshipImagePreview.style.display = 'none';
                if (deleteSponsorshipImageBtn) deleteSponsorshipImageBtn.style.display = 'none';
            }
        });
    }

    if (deleteSponsorshipImageBtn) {
        deleteSponsorshipImageBtn.style.display = 'none';
        deleteSponsorshipImageBtn.addEventListener('click', function() {
            sponsorshipImageInput.value = '';
            sponsorshipImagePreview.src = '';
            sponsorshipImagePreview.style.display = 'none';
            sponsorshipImageStatus.textContent = 'No file selected.';
            sponsorshipImageStatus.style.display = '';
            deleteSponsorshipImageBtn.style.display = 'none';
        });
    }

    // Initial load
    loadSponsorships();
});