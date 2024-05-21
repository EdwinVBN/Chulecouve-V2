class Modal {
    constructor() {
        this.modal = document.getElementById('popup');
        this.closebutton = document.getElementById('closebutton');
        this.loginButton = document.getElementById('login');

        this.switchLogin = document.getElementById('login_switch');
        this.switchregister = document.getElementById('register_switch');
        this.loginForm = document.getElementById('loginForm');
        this.registerForm = document.getElementById('registerForm');



        this.closebutton.addEventListener('click', () => {
            this.closeModal();
        });

        window.addEventListener('load', () => {
            this.openLogin();
        });

        this.loginButton.addEventListener('click', () => {
            this.openModal();
        });

        this.switchregister.addEventListener('click', () => {
            this.openRegister();
        });

        this.switchLogin.addEventListener('click', () => {
            this.openLogin();
        });

    }

    openRegister() {
        this.registerForm.style.display = 'flex';
        // this.registerForm.style.flexDirection = 'column';
        // this.registerForm.style.alignItems = 'center';

        this.loginForm.style.display = 'none';
    }

    openLogin() {
        this.registerForm.style.display = 'none';
        
        this.loginForm.style.display = 'flex';
        // this.loginForm.style.flexDirection = 'column';
        // this.loginForm.style.alignItems = 'center';
    }

    openModal() {
        this.modal.style.display = 'flex';
    }

    closeModal() {
        this.modal.style.display = 'none';
    }
}

const modal = new Modal();