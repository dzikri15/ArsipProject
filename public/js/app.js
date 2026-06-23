// ── MODAL ──────────────────────────────────────────────────
let modalFormAction = '';
let modalType = '';

function openModal(title = '📤 Tambah Baru', type = '', action = '') {
  if (!action) {
    console.error('Error: Form action tidak terset');
    alert('Error: Action tidak terset!');
    return;
  }
  
  const form = document.getElementById('modalForm');
  const modalOverlay = document.getElementById('modalOverlay');
  
  if (!form || !modalOverlay) {
    console.error('Modal elements not found');
    return;
  }
  
  // Update modal title
  const titleEl = document.getElementById('modalTitle');
  if (titleEl) {
    titleEl.textContent = title;
  }
  modalType = type;
  modalFormAction = action;
  
  // Set form action with proper path
  const fullAction = action.startsWith('/') ? action : '/' + action;
  form.action = fullAction;
  form.method = 'POST';
  form.enctype = 'multipart/form-data';
  
  console.log('✅ Modal opened:', { title, type, action: fullAction });
  
  // Reset form completely
  form.reset();
  
  // Reset all file drops and inputs
  document.querySelectorAll('.file-drop').forEach(drop => {
    drop.style.backgroundColor = 'transparent';
    drop.style.borderColor = 'var(--border)';
  });
  
  // Re-setup file handlers
  setupFileDrops();
  
  // Show modal with delay to ensure styles apply
  setTimeout(() => {
    modalOverlay.classList.add('open');
  }, 10);
}

function closeModal() {
  const overlay = document.getElementById('modalOverlay');
  if (overlay) {
    overlay.classList.remove('open');
  }
  
  const form = document.getElementById('modalForm');
  if (form) {
    form.reset();
    form.action = '';
    form.method = 'POST';
  }
  
  console.log('❌ Modal closed');
}

// Close modal on overlay click
document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.getElementById('modalOverlay');
  if (overlay) {
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closeModal();
    });
  }

  // Handle modal form submission with validation
  const modalForm = document.getElementById('modalForm');
  if (modalForm) {
    modalForm.addEventListener('submit', function (e) {
      // Validasi action sudah diset
      if (!this.action || this.action.trim() === '') {
        e.preventDefault();
        console.error('Form action not set');
        alert('Error: Form action tidak terset. Silakan tutup dan buka modal lagi.');
        return false;
      }
      
      // Check if any required file input exists
      const fileInputs = this.querySelectorAll('input[type="file"][required]');
      let hasFile = false;
      fileInputs.forEach(input => {
        if (input.files && input.files.length > 0) {
          hasFile = true;
        }
      });
      
      if (fileInputs.length > 0 && !hasFile) {
        e.preventDefault();
        alert('Silakan pilih file terlebih dahulu');
        return false;
      }
      
      console.log('✅ Form submitting to:', this.action);
      // Let form submit normally
    });
  }
  
  // Setup file drop handlers for existing inputs
  setupFileDrops();
});

// ── FILE UPLOAD HANDLER ────────────────────────────────
function setupFileDrops() {
  document.querySelectorAll('.file-drop').forEach(fileDrop => {
    // Remove old listeners to prevent duplicates
    const newDrop = fileDrop.cloneNode(true);
    fileDrop.parentNode.replaceChild(newDrop, fileDrop);
    
    newDrop.addEventListener('click', function() {
      const fileInput = this.nextElementSibling;
      if (fileInput && fileInput.type === 'file') {
        fileInput.click();
      }
    });

    newDrop.addEventListener('dragover', (e) => {
      e.preventDefault();
      e.stopPropagation();
      newDrop.style.backgroundColor = 'var(--bg2)';
      newDrop.style.borderColor = 'var(--accent)';
    });

    newDrop.addEventListener('dragleave', (e) => {
      e.preventDefault();
      e.stopPropagation();
      newDrop.style.backgroundColor = 'transparent';
      newDrop.style.borderColor = 'var(--border)';
    });

    newDrop.addEventListener('drop', (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      const fileInput = newDrop.nextElementSibling;
      if (fileInput && fileInput.type === 'file') {
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
      }
      
      newDrop.style.backgroundColor = 'transparent';
      newDrop.style.borderColor = 'var(--border)';
    });
  });

  // Setup file input change handlers
  document.querySelectorAll('input[type="file"]').forEach(fileInput => {
    // Remove old handler
    fileInput.onchange = null;
    
    fileInput.addEventListener('change', function(e) {
      if (this.files.length > 0) {
        const fileDrop = this.previousElementSibling;
        if (fileDrop && fileDrop.classList.contains('file-drop')) {
          const file = this.files[0];
          const fileName = file.name;
          const fileSize = (file.size / 1024 / 1024).toFixed(2);
          
          fileDrop.innerHTML = `
            <div style="padding:16px; text-align:center;">
              <div style="font-size:32px; margin-bottom:8px;">✓</div>
              <p style="font-weight:600; font-size:14px; margin:0; word-break:break-all;">${fileName}</p>
              <p style="font-size:12px; color:var(--text3); margin:8px 0 0 0;">${fileSize} MB</p>
            </div>
          `;
          console.log('✓ File selected:', { name: fileName, size: fileSize + ' MB' });
        }
      }
    });
  });
}

// Call setup on page load
document.addEventListener('DOMContentLoaded', setupFileDrops);

// ── NOTIFIKASI ─────────────────────────────────────────────
function toggleNotification() {
  const dropdown = document.getElementById('notifDropdown');
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

function showNotification(message, type = 'info') {
  // Close dropdown first
  document.getElementById('notifDropdown').style.display = 'none';
  
  // Show toast notification
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <div style="display:flex; align-items:center; gap:12px;">
      <span style="font-size:18px;">
        ${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}
      </span>
      <span>${message}</span>
    </div>
  `;
  
  const container = document.body;
  container.appendChild(toast);
  
  // Auto remove after 4s
  setTimeout(() => toast.remove(), 4000);
}

// Display alert from session (server-side)
document.addEventListener('DOMContentLoaded', function () {
  const alertError = document.querySelector('.alert-error');
  if (alertError) {
    showNotification(alertError.textContent, 'error');
  }
});

// ── ACTIONS ────────────────────────────────────────────────
/**
 * View item detail
 * @param {number} id - Item ID
 * @param {string} type - Item type (dokumen, foto, video, link, users)
 */
function viewItem(id, type) {
  const url = `/${type}/${id}`;
  window.location.href = url;
}

/**
 * Edit item
 * @param {number} id - Item ID
 * @param {string} type - Item type
 */
function editItem(id, type) {
  const url = `/${type}/${id}/edit`;
  window.location.href = url;
}

/**
 * Delete item dengan confirmation
 * @param {number} id - Item ID
 * @param {string} type - Item type
 * @param {string} name - Item name untuk confirmation message
 */
function deleteItem(id, type, name = 'item ini') {
  if (confirm(`Anda yakin ingin menghapus ${name}?`)) {
    // Create form untuk POST delete (menggunakan method spoofing)
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/${type}/${id}`;
    
    // Add CSRF token
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = '_token';
      input.value = token.getAttribute('content');
      form.appendChild(input);
    }
    
    // Add method spoofing
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    form.submit();
  }
}

/**
 * Download file
 * @param {number} id - Item ID
 * @param {string} type - Item type (dokumen)
 */
function downloadItem(id, type) {
  window.location.href = `/${type}/${id}/download`;
}

/**
 * Export data
 * @param {string} type - Export type (csv, pdf, etc)
 */
function exportData(type = 'csv') {
  window.location.href = `/log/export?type=${type}`;
}

/**
 * Redirect ke create page
 * @param {string} type - Item type
 */
function createNew(type) {
  window.location.href = `/${type}/create`;
}
