let activeForm = null;

const modal = document.getElementById('modal');
const modalTitle = modal.querySelector('.modal-title')
const modalBody =  modal.querySelector('.modal-body');
const modalconfirmButton = modal.querySelector('.confirmation-button'); 

const deleteForms = document.querySelectorAll('.destroy-form-messagge');


deleteForms.forEach(form => {
    form.addEventListener('submit' , e => {
        e.preventDefault();

        modalconfirmButton.innerText = 'Conferma';
        modalconfirmButton.classList.add('btn-danger');
        modalTitle.innerText = 'Attenzione';
        modalBody.innerText = 'Sei sicuro di voler archiviare questo messaggio?';

        activeForm = form;
    })

})

modalconfirmButton.addEventListener('click' , () => {
    if(activeForm) activeForm.submit();
});

modal.addEventListener('hidden.bs.modal' , () => {
    activeForm = null;
});