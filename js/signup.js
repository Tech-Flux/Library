(() => {
          'use strict'
  
          const forms = document.querySelectorAll('.needs-validation')
  
          Array.from(forms).forEach(form => {
              form.addEventListener('submit', event => {
                  if (!form.checkValidity()) {
                      event.preventDefault()
                      event.stopPropagation()
                  }
  
                  form.classList.add('was-validated')
              }, false)
          })
  
          const successAlert = document.querySelector('.alert-success');
          const errorAlert = document.querySelector('.alert-danger');
          if (successAlert && successAlert.textContent.trim()) {
              successAlert.style.display = 'block';
          }
          if (errorAlert && errorAlert.textContent.trim()) {
              errorAlert.style.display = 'block';
          }
      })()