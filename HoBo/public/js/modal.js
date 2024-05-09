class Modal {
    constructor() {
        this.modal = document.getElementById('popup');
        this.closebutton = document.getElementById('closebutton');
        this.loginButton = document.getElementById('login');

        this.closebutton.addEventListener('click', () => {
            this.closeModal();
        });

        this.loginButton.addEventListener('click', () => {
            this.openModal();
        });
    }

    openModal() {
        this.modal.style.display = 'flex';
    }

    closeModal() {
        this.modal.style.display = 'none';
    }
}

const modal = new Modal();